<?php
session_start();
include_once('../includes/header.php');
include_once('../includes/navbar_top.php');
include_once('../includes/sidebar.php');
include_once('../define/KeySession.php');
include_once('../helper/FormatDateTime.php');
if (!(isset($_SESSION[KeySession::permission->value]) &&
$_SESSION[KeySession::permission->value] == 'admin'))
    header("Location: ../home/index.php");
if (isset($_SESSION[KeySession::sysrequest->value])) {
    $request = json_decode($_SESSION[KeySession::sysrequest->value]);
    if (isset($request->data))
        $entityRequest = $request->data;
    $_SESSION[KeySession::sysrequest->value] = null;
}
?>
<div class="container-fluid px-4">
    <ol class="breadcrumb mt-5">
        <li class="breadcrumb-item active">Người dùng</li>
        <li class="breadcrumb-item">Thêm nhân viên</li>
    </ol>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm nhân viên</h4>
                </div>
                <div class="card-body">
                    <form action="personnel_add_action.php" id="form-register" onsubmit="validate();" method="POST" autocomplete="off">
                        <?php 
                            if (isset($request) && $request->status === 0 && $request->message) 
                                echo '<span class="fw-bolder text-danger">' . $request->message . "</span>";
                        ?>
                        <div class="form-group">
                            <label>Tên đăng nhập</label>
                            <input required type="text" name="Username" class="form-control" 
                                value="<?= isset($entityRequest) ? $entityRequest->username : '' ?>">
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
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input required type="text" class="form-control" name="FullName"
                                value="<?= isset($entityRequest) ? $entityRequest->fullName : '' ?>">
                        </div>
                        <div class="form-group">
                            <label style="margin-right: 10px;">Giới tính</label>
                            <div class="form-control d-flex flex-row">
                                <div class="form-check me-3">
                                    <input required class="form-check-input" type="radio" name="Gender" id="male" value="1"
                                        <?= isset($entityRequest) ? ($entityRequest->gender == 1 ? 'checked' : '') : '' ?>>
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check">
                                    <input required class="form-check-input" type="radio" name="Gender" id="female" value="0"
                                        <?= isset($entityRequest) ? ($entityRequest->gender == 0 ? 'checked' : '') : '' ?>>
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input required type="date" class="form-control" name="DateOfBirth"
                                value="<?= isset($entityRequest) ? FormatDateHelper::getDateToInputHtml($entityRequest->dateOfBirth->date) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input required type="text" class="form-control" name="PhoneNumber" maxlength="10" minlength="10"
                                value="<?= isset($entityRequest) ? $entityRequest->phoneNumber : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input required type="email" class="form-control" name="Email"
                                value="<?= isset($entityRequest) ? $entityRequest->email : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Số căn cước công dân</label>
                            <input required type="text" class="form-control" name="SoCCCD" maxlength="12" minlength="12"
                                value="<?= isset($entityRequest) ? $entityRequest->soCCCD : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input required type="text" class="form-control" name="Address"
                                value="<?= isset($entityRequest) ? $entityRequest->address : '' ?>">
                        </div>
                        <input type="submit" name="btn-add-user" class="btn btn-primary mt-2" value="Xác nhận">
                        <a href="personnel_list.php" class="btn btn-secondary mt-2">Hủy bỏ</a>
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
?>