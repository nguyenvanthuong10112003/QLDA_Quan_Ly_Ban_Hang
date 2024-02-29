<?php
enum KeySession: string {
    case logged = "logged-session";
    case userLogin = "user-login-session";
    case beforeUrl = "before-url-session";
    case message = "message-session";
    case messageType = "message-type-session";
    case permission = "permission-session";
    case sysrequest = "request-session";
}