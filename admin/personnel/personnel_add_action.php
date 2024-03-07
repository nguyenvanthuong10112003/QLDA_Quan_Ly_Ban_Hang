<?php
    include_once('../helper/ValidationStringHelper.php');
    include_once('../authen/checkLogin.php');
    include_once('../define/KeySession.php');
    include_once('../entity/SysRequest.php');
    include_once('../data/MemberRepository.php');
    if (!$getUserLogin())
    {
        header("Location: ../account/login.php");
        exit(0);
    }
    if (!(isset($_SESSION[KeySession::permission->value]) &&
    $_SESSION[KeySession::permission->value] == 'admin')) {
        header("Location: ../home/index.php");
        exit(0);
    }
    if (isset($_POST['btn-add-user'])) {
        $member = new Member();
        $member->username = $_POST['Username'];
        $member->password_hash = $_POST['Password'];
        $member->fullName = $_POST['FullName'];
        $member->gender = $_POST['Gender'];
        $member->dateOfBirth = new DateTime($_POST['DateOfBirth']);
        $member->phoneNumber = $_POST['PhoneNumber'];
        $member->email = $_POST['Email'];
        $member->soCCCD = $_POST['SoCCCD'];
        $member->address = $_POST['Address'];

        if (strpos($member->username, ' ') !== false || strpos($member->email, ' ') !== false || 
            strpos($member->password_hash, ' ') !== false || strpos($member->phoneNumber, ' ') !== false || 
            strpos($member->soCCCD, ' ') !== false
            ){
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    0, 
                    "Ký tự nhập vào tên đăng nhập, email, mật khẩu, số điện thoại, 
                    số cccd không được chứa khoảng trắng!", 
                    $member
                )
            );
            header("Location: personnel_add.php");
            exit(0);
        }  
        $member->password_hash = md5($member->password_hash);
        if (!(ValidationStringHelper::allIsNumber($member->phoneNumber) || 
            ValidationStringHelper::allIsNumber($member->soCCCD)
            ))
        {
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    0, 
                    "Ký tự nhập vào số điện thoại, 
                    số cccd chỉ chứa ký tự số!", 
                    $member
                )
            );
            header("Location: personnel_add.php");
            exit(0);
        }
        $context = new MemberRepository();
        $result = $context->getByUnique($member);
        if ($result){
            $_SESSION[KeySession::sysrequest->value] = json_encode(
                new SysRequest(
                    0, 
                    "Tên đăng nhập hoặc số điện thoại hoặc email hoặc số cccd đã tồn tại", 
                    $member
                )
            );
            header("Location: personnel_add.php");
        } else {
            if ($context->create($member)){
                $_SESSION[KeySession::sysrequest->value] = json_encode(
                    new SysRequest(
                        1, 
                        "Thêm thành công", 
                        null
                    )
                );
                header('Location: personnel_list.php');
            } else {
                $_SESSION[KeySession::sysrequest->value] = json_encode(
                    new SysRequest(
                        0, 
                        "Đã xảy ra sự cố", 
                        $member
                    )
                );
                header('Location: personnel_add.php');
            }
        }
        $context->__destruct();
    }