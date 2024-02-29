<?php
session_start();
include('../define/KeySession.php');
include('../entity/UserSession.php');
include('../data/MemberRepository.php');
if (isset($_SESSION[KeySession::logged->value])){
    $currentUser = json_decode($_SESSION[KeySession::userLogin->value]);
    if ($currentUser && $currentUser->username) 
    {
        $context = new MemberRepository();
        $member = new Member();
        $member->id = $currentUser->id;
        $member->isOnline = false;
        $context->updateOnline($member);
    }
    $_SESSION[KeySession::logged->value] = false;
    $_SESSION[KeySession::userLogin->value] = null;
    header('Location: login.php');
    exit();
}