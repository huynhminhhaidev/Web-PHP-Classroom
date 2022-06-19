<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./main.js">
    <link rel="stylesheet" href="./fontawesome-free-5.14.0-web/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <title>Forgot Password</title>
</head>
<body>
<?php

$error = '';
$email = '';
$post_error = '';
$pass = '';
$pass_confirm = '';
$succes = "";

$display_email = filter_input(INPUT_GET,'email', FILTER_SANITIZE_EMAIL);
// Tập tin này sẽ hiển thị email của người gửi tới nhưng không cho phép điều chỉnh

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    if (filter_var($email, FILTER_SANITIZE_EMAIL) == false) {
        $error = 'This is not a email address';
    } else if (strlen($token) != 32) {
        $error = 'This is not a valid reset token';
    } else {
        if (isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
            require_once('connection.php');
            $email = $_POST['email'];
            $pass = $_POST['password1'];
            $pass_confirm = $_POST['password2'];
    
            if (empty($email)) {
                $post_error = 'Vui lòng nhập email';
            }
            else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $post_error = 'Đây không phải là email hợp lệ';
            }
            else if (empty($pass)) {
                $post_error = 'Vui lòng nhập mật khẩu';
            }
            else if (strlen($pass) < 6) {
                $post_error = 'Mật khẩu phải có hơn 6 kí tự';
            }
            else if ($pass != $pass_confirm) {
                $post_error = 'Mật khẩu không trùng khớp';
            }
            else {
                // $sql = 'update account set password = ? where email = ?';

                $conn = mysqli_connect('localhost','root','');
                mysqli_select_db($conn,'classroom');
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $s = "UPDATE account SET password='$hash' WHERE email = '$email'";
                $result = mysqli_query($conn,$s);
                // header("location: login.php");
                $display_email = "";
                $pass = "";
                $pass_confirm = "";
                $succes = "Đổi mật khẩu thành công";
            }
        }
        else {
            // print_r($_POST);
        }
    }

}else {
    $error = 'Invalid email address or token';
}


?>
    <div class="main">
        <div class="main-forgot">
            <div class="form-forgot">
                <form method="POST">
                    <h2>Đổi mật khẩu mới</h2>
                    <input type="email" value="<?= $display_email ?>" id = "email" name="email" >
                    <input type="password" value="<?= $pass?>" id="password1" name="password1" placeholder="Mật khẩu mới">
                    <input type="password" value="<?= $pass_confirm?>" id="password2" name="password2" placeholder="Nhập lại mật khẩu">
                    <p style = "color: green"><?= $succes?></p>
                    <input type="submit" name="reset-pw-btn" value="Thay đổi">
                    <p class="q-signup"><a href="login.php">Đăng nhập</a> hoặc <a href="signup.php">Đăng ký</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
<?php include './main.js';?>
</script>
</html>