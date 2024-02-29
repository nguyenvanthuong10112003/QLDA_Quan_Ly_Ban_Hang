<?php 
include_once('../authen/checkLogin.php');
include_once('../data/MemberRepository.php');
include_once('../define/KeySession.php');    
include_once('../entity/SysRequest.php');
include_once('../entity/UserSession.php');
if (!$getUserLogin()) {
    echo json_encode(new SysRequest(0, 'Bạn cần đăng nhập', null), JSON_UNESCAPED_UNICODE);
    exit(0);
} 
if (!(isset($_POST['action']) && isset($_POST['username']))) {
    echo json_encode(new SysRequest(0, 'Không xác định được yêu cầu', null), JSON_UNESCAPED_UNICODE);
    exit(0);
}
if (!(isset($_SESSION[KeySession::permission->value]) && $_SESSION[KeySession::permission->value] == 'admin')) {
    echo json_encode(new SysRequest(0, "Không có quyền thực hiện chức năng này", null), JSON_UNESCAPED_UNICODE);
    exit(0);
}
$action = $_POST['action'];
$username = $_POST['username'];
$context = new MemberRepository();
$result = $context->getByUsername($username);
if (!$result) {
    echo json_encode(new SysRequest(0, "Người dùng này không tồn tại", null), JSON_UNESCAPED_UNICODE);
    exit(0);
}
if ($result->isAdmin) {
    echo json_encode(new SysRequest(0, "Không thể thực hiện chức năng này với admin", null), JSON_UNESCAPED_UNICODE);
    exit(0);
}
if ($action == 'lock') {
    $result->isLock = true;
} else if ($action == 'unlock') {
    $result->isLock = false;
}
$result = $context->updateLock($result);
echo json_encode(new SysRequest(1, ($action == 'lock' ? 'Khóa' : 'Mở khóa') . " thành công", null), JSON_UNESCAPED_UNICODE);

