<?php 
session_start();
include_once('../define/KeySession.php');
include_once('../helper/FormatDateTime.php');
include_once('../entity/SysRequest.php');
include_once('../data/MemberRepository.php');
if (!(isset($_SESSION[KeySession::permission->value]) &&
$_SESSION[KeySession::permission->value] == 'admin'))
    header("Location: ../home/index.php");
function whenGet() {
    include_once('../includes/header.php');
    include_once('../includes/navbar_top.php');
    include_once('../includes/sidebar.php');
    if (isset($_SESSION[KeySession::sysrequest->value])) {
        $request = json_decode($_SESSION[KeySession::sysrequest->value]);
        $_SESSION[KeySession::sysrequest->value] = null;
    }
    if (!isset($_GET['username'])) 
    {
        header('Location: user_list.php');
        exit(0);
    }
    ?>
    <div class="container-fluid px-4">
        <ol class="breadcrumb mt-5">
            <li class="breadcrumb-item active">Người dùng</li>
            <li class="breadcrumb-item active">Nhân viên</li>
            <li class="breadcrumb-item">Đổi mật khẩu</li>
        </ol>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Đổi mật khẩu</h4>
                    </div>
                    <div class="card-body">
                        <form action="change_pw.php" id="form-register" onsubmit="validate();" method="POST" autocomplete="on">
                            <?php 
                                if (isset($request) && $request->status === 0 && $request->message) 
                                    echo '<span class="text-danger fw-bolder">' . $request->message . "</span>";
                            ?>
                            <div class="form-group">
                                <label>Tên đăng nhập: <b><?= $_GET['username'] ?></b> </label>
                                <input type="hidden" readonly name="Username" class="form-control" 
                                    value="<?= $_GET['username'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input required id="password" type="password" class="form-control" name="Password">
                            </div>
                            <div class="form-group">
                                <label>Xác nhận mật khẩu</label>
                                <input required id="confirm-password" type="password" class="form-control" name="ConfirmPassword">
                                <span id="errorPassword" class="text-danger d-none">Mật khẩu không trùng khớp</span>
                            </div>
                            <input type="submit" name="btn-change-pw" class="btn btn-primary mt-2" value="Xác nhận">
                            <a href="user_list.php" class="btn btn-secondary mt-2">Hủy bỏ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script>
        var password = $('#password');
        var confirmPassword = $('#confirm-password');
        confirmPassword.keyup(() => {
            if (password.val() == confirmPassword.val())
                $('#errorPassword').addClass('d-none');
            else 
                $('#errorPassword').removeClass('d-none');
        })
        password.keyup(() => {
            if (password.val() == confirmPassword.val())
                $('#errorPassword').addClass('d-none');
            else 
                $('#errorPassword').removeClass('d-none');
        })
        var validate = function () {
            return password.val() == confirmPassword.val();
        }
    </script>
    <?php include_once('../includes/footer.php');
}
function whenPost() {
    if (isset($_POST['btn-change-pw'])) {
        $member = new Member();
        $member->username = $_POST['Username'];
        $member->password_hash = $_POST['Password'];
        if (strpos($member->password_hash, ' ') !== false){
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    0, 
                    "Mật khẩu không thể chứa dấu cách", 
                    null
                )
            );
            header("Location: change_pw.php?username=" . $member->username);
            exit(0);
        }  
        $member->password_hash = md5($member->password_hash);
        $context = new MemberRepository();
        $result = $context->getByUsername($member->username);
        if ($result){
            $result = $context->updatePassword($member);
            if ($result) {
                $_SESSION[KeySession::sysrequest->value] = json_encode(
                    new SysRequest(
                        1, 
                        "Đổi mật khẩu thành công", 
                        null
                    )
                );
                header("Location: user_list.php");
            } else {
                $_SESSION[KeySession::sysrequest->value] = json_encode(
                    new SysRequest(
                        0, 
                        "Đã xảy ra sự cố", 
                        null
                    )
                );
                header("Location: change_pw.php?username=" . $member->username);
            }
        } else {
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    0, 
                    "Tài khoản này không tồn tại", 
                    null
                )
            );
            header('Location: user_list.php');
        }
        $context->__destruct();
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    whenGet();
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    whenPost();
}