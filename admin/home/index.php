<?php
    session_start();
    include('../authen/checkLogin.php');
    if(isset($_SESSION[KeySession::logged->value]) && $_SESSION[KeySession::logged->value] === true) {
        $currentUser = $_SESSION[KeySession::userLogin->value];
    } else {
        header('Location: ../account/login.php');
        exit(0);
    }

    include('../../config/config.php');
    include('../includes/header.php');
    include('../includes/footer.php');