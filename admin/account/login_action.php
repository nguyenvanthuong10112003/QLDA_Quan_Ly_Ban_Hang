<?php
    session_start();
    include('../data/MemberRepository.php');
    include('../../helpers/function.php');
    include('../entity/UserSession.php');
    include('../define/KeySession.php');
    function headerTo($url, $message, $message_type) {
        if ($message) {
            $_SESSION[KeySession::message->value] = $message;
            $_SESSION[KeySession::messageType->value] = $message_type;
        }
        header('Location: ' . $url);
    };
    if (isset($_POST['login_btn'])){
        $connection = new ConnectDB();
        $urlLogin = "login.php";
        $urlSuccess = "../home/index.php";
        if (isset($_SESSION[KeySession::beforeUrl->value])) {
            $urlSuccess = $_SESSION[KeySession::beforeUrl->value] + "";
        }
        $asA = $_POST['asA'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        //$keepLogin = $_POST['keepLogin'];
        $password_hash = md5($password);
        $context = new MemberRepository();
        $row = $context->getByUsername($username);
        if ($row){
            if ($row->password_hash !== $password_hash) {
                headerTo($urlLogin, 'Mật khẩu không chính xác', 'error');
                exit(0);
            }
            if ($row->isLock){
                headerTo($urlLogin, 'Tài khoản đang bị khóa', 'error');
                exit(0);
            } 
            if ($asA === 'admin' && !$row->isAdmin)
            {
                headerTo($urlLogin, 'Bạn không phải là admin', 'error');
                exit(0);
            }
            else
            if ($asA === 'personnel' && !$row->isPersonnel)
            {
                headerTo($urlLogin, 'Bạn không phải là nhân viên', 'error');
                exit(0);
            }
            $_SESSION[KeySession::logged->value] = true;
            $_SESSION[KeySession::userLogin->value] = json_encode(new UserSession(
                $row->id,
                $row->username,
                $row->fullName,
                $row->urlAvatar
            ));
            $_SESSION[KeySession::permission->value] = $asA; 
            $row->isOnline = true;
            $context->updateOnline($row);
            headerTo($urlSuccess, null, null);
            exit(0);
        } else {
            headerTo($urlLogin, 'Tài khoản không tồn tại', 'error');
            exit(0);
        }
    } else {
        header("Location: login.php");
        exit(0);
    }