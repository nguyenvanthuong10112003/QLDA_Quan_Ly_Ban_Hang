<?php
session_start();
include_once('../define/KeySession.php');
include('../includes/header.php');
include('../helper/FormatDateTime.php');
include_once('../data/MemberRepository.php');
if (!(isset($_SESSION[KeySession::permission->value]) &&
$_SESSION[KeySession::permission->value] == 'admin'))
    header("Location: ../home/index.php");
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $context = new MemberRepository();
        // Xử lý Ajax request
    $search = isset($_GET["input_value"]) ? $_GET["input_value"] : '';
    include("../pagination/offset.php");
    $datas = $context->getAllPersonnel($search, $item_per_page, $offset);
    $totalRecords = $context->getCountPersonnel($search);
    // Tổng số trang = tổng số sản phẩm / tổng số sản phẩm một trang
    $totalPage = ceil($totalRecords / $item_per_page);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="container-fluid px-4">
    <div class="float-end">
    <form style="display: inline-flex;" method="get" action="">
        <input class="form-control txtSearch" name="input_value" type="text" style="margin-left:0;"  placeholder="Tìm kiếm..." value="<?= isset($search) ? $search : '' ?>"/>                          
    </form></div>
    <ol class="breadcrumb mt-5">
        <li class="breadcrumb-item active">Người dùng</li>
        <li class="breadcrumb-item">Danh sách nhân viên</li>
    </ol>
    <?php 
        if (isset($_SESSION[KeySession::sysrequest->value])) {
            $request = json_decode($_SESSION[KeySession::sysrequest->value]);
            if (isset($request) && $request->message) {
                echo '<span class="fw-bolder ' . ($request->status == 1 ? 'text-success' : 'text-danger') . "\">" . $request->message . "</span>";
            }
            $_SESSION[KeySession::sysrequest->value] = null;
        } 
    ?>
    <div class="Prod highlight" id="user_table" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách nhân viên</h4>
                    <a href="user_add.php" class="btn btn-primary float-start"><i class="fa-solid fa-plus" style="margin-right: 5px;"></i>Thêm</a>
                </div>
                <div class="card-body highlight" style="overflow: auto;">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ và Tên</th>
                            <th>Giới tính</th>
                            <th>Ngày sinh</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Số cccd</th>
                            <th>Địa chỉ</th>
                            <th>Thời gian tạo</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        <?php
                        if (sizeof($datas) > 0) {
                            foreach ($datas as $row) {
                        ?>
                            <tr>
                                <th scope="row"><?= $row->id; ?></th>
                                <td><?= $row->username; ?></td>
                                <td><?= $row->fullName; ?></td>
                                <td><?php
                                    if ($row->gender) {
                                    ?>
                                        <span>Nam</span>
                                    <?php
                                    } else {
                                    ?>
                                        <span>Nữ</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?= $row->dateOfBirth->format('d/m/Y'); ?></td>
                                <td><?= $row->phoneNumber; ?></td>
                                <td><?= $row->email; ?></td>
                                <td><?= $row->soCCCD; ?></td>
                                <td><?= $row->address; ?></td>
                                <td><?= $row->dateCreate->format('H:i:s d/m/Y'); ?></td>
                                <td><?= $row->isOnline ? 
                                    '<span class="text-success fw-bolder">Đang hoạt động</span>' : 
                                    '<span class="text-danger fw-bolder">Ngừng hoạt động</span>' ?>
                                </td>
                                <td id="TrangThaiKhoa-<?=$row->username;?>"><?= $row->isLock ? 
                                    '<button type="button" class="btn btn-secondary" onclick="lock(\'unlock\', \'' . $row->username . '\')">Mở khóa</button>' : 
                                    '<button type="button" class="btn btn-danger" onclick="lock(\'lock\', \'' . $row->username . '\')">Khóa</button>' ?>
                                    <a href="./change_pw.php?username=<?= $row->username; ?>" class="btn btn-primary">Đổi mật khẩu</a>
                                </td>
                            </tr>
                        <?php
                            }
                        }}
                        ?>
                    </table>
                    <?php include("../pagination/pagination.php") ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function lock(action, username) {
        let arr = (window.location.pathname).split('/');
        console.log(arr)
        console.log(arr.reduce((result, item, index) => (index == arr.length - 1) ? result : result + item + '/', '') + '/lock_action.php')
        $.ajax({
            type: "POST",
            url: arr.reduce((result, item, index) => (index == arr.length - 1) ? result : result + item + '/', '') + 'lock_action.php',
            async: false,
            data: { action: action, username: username },
            success: response => {
                if (JSON.parse(response).status == 1)
                    $('#TrangThaiKhoa-' + username).html((action === 'lock' ? 
                        '<button type="button" class="btn btn-secondary" onclick="lock(\'unlock\', \'' + username + '\')">Mở khóa</button>' : 
                        '<button type="button" class="btn btn-danger" onclick="lock(\'lock\', \'' + username + '\')">Khóa</button>')
                        + `<a href="./change_pw.php?username=${username}" class="btn btn-primary">Đổi mật khẩu</a>`
                        )
            },
            error: response => {
                console.log(response)
            }
        })
    }
</script>
<?php include('../includes/footer.php');
?>