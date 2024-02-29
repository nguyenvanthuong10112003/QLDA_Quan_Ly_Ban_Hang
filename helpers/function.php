<?php
    function checkPrivilege($uri = false){
        $uri = $uri!=false ? $uri: $_SERVER['REQUEST_URI'];
        if (empty( $_SESSION['current_user']['privileges'])){
            return false;
        }
        $privileges = $_SESSION['current_user']['privileges'];
        $privileges = implode("|", $privileges);
        preg_match('/index\.php|'. $privileges . '/', $uri, $matches);
        return !empty($matches);
    } 
    function flash ($name, $text = ''){
        if (isset($_SESSION[$name])){
            $message = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $message;
        } else {
            $_SESSION[$name] = $text;
        }
        return '';
    } 
?>