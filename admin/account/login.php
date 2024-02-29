<?php
    include('../authen/checkLogin.php');
    include('../../helpers/function.php');
    if ($getUserLogin() !== null) {
        if (isset($_SESSION[KeySession::beforeUrl->value])) {
            $url = $_SESSION[KeySession::beforeUrl->value] + "";
            header("Location: " . $url);
            exit();
        } else {
            header("Location: ../home/index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="../assets/css/login.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/toastr.min.css">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="wrapper">
            <form method="post" action="login_action.php" autocomplete="off">
                <h1>Đăng nhập</h1>
                <?php
                    if (isset($_SESSION[KeySession::message->value]) && isset($_SESSION[KeySession::messageType->value])) {
                        echo '<span style="color: #DC4C64; font-weight: 600;">' . $_SESSION[KeySession::message->value] . '</span>';
                        $_SESSION[KeySession::message->value] = null;
                        $_SESSION[KeySession::messageType->value] = null;
                    } 
                ?>
                <div class="input-box" style="margin-top: 0px; transform: translateY(50%);">
                    <span style="display: flex; flex-direction: row; align-items: center; justify-content: space-around;">
                        <div style="display: flex; flex-direction: row; align-items: center;">
                            <input type="radio" name="asA" value="admin" id="admin" required="required">
                            <label for="admin" style="margin-left: 5px">Admin</label>
                        </div>
                        <div style="display: flex; flex-direction: row; text-wrap: nowrap; align-items: center;">
                            <input type="radio" name="asA" value="personnel" id="personnel" required="required">
                            <label for="personnel" style="margin-left: 5px">Nhân viên</label>
                        </div>
                    </span>
                </div>
                <div class="input-box">
                    <input required name="username" type="text" placeholder="Tên đăng nhập"/>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-box">
                    <input required name="password" type="password" placeholder="Mật khẩu"/>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" name="keepLogin" style="margin-right: 5px;">Duy trì đăng nhập</label>
                    <a href="#">Quên mật khẩu</a>
                </div>
                <button type="submit" class="btn" name="login_btn">Đăng nhập</button>
                <div class="register-link">
                    <p>Chưa có tài khoản?<a href="./register.php"> Đăng ký</a></p>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./../assets/js/scripts.js"></script>
        <script src="../assets/js/jquery-3.7.1.min.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/toastr.js"></script>
    </body>
</html>