<?php

    require_once('connection.php');

?>
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
    $message = 'Vui lòng nhập email của bạn để tiếp tục';


    // Nếu người dùng nhập email và nhấn "Gửi" thì mới thực hiện dòng code dưới đây
    if (isset($_POST['EmailAddress2'])) {
        $email = $_POST['EmailAddress2'];

        //Nếu chưa nhập email thì báo lỗi 
        if (empty($email)) {
            $error = 'Vui lòng nhập email';
        }
        // Nếu nhập sai cú pháp eamil thì báo lỗi
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'Đây không phải là email hợp lệ';
        }
        // Nếu không có lỗi thì gửi mail để đổi mk
        else {
            resetpassword($email);
            $message = 'Đã gửi hướng dẫn đổi mật khẩu vào email của bạn';
        }
    }
?>
    <div class="main">
        <div class="main-forgot">
            <div class="form-forgot">
                <form method="POST" id="form-forgotpw-js">
                    <h2>Quên mật khẩu</h2>
                    <input type="email" name="EmailAddress2" placeholder="Email" id="EmailAddress2">
                    <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    ?>
                    <input type="submit" name="send-email-btn" value="Gửi">
                    <p class="q-signup"><a href="login.php">Đăng nhập</a> hoặc <a href="signup.php">Đăng ký</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>