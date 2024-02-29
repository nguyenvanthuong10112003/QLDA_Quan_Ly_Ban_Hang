<?php
include('../entity/UserSession.php');
include('../define/KeySession.php');
$getUserLogin = function() {
    session_start();
    if (isset($_SESSION[KeySession::logged->value]) && $_SESSION[KeySession::logged->value] === true)
    {
        if (isset($_SESSION[KeySession::userLogin->value]) && $_SESSION[KeySession::userLogin->value] !== null)
            return $_SESSION[KeySession::userLogin->value];
        $_SESSION[KeySession::logged->value] = false;
    }
};
