<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: home.php');
        exit();
    }

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
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <title>Đăng ký</title>
</head>
<body>
<?php
    $error = '';
    $user = '';
    $email = '';
    $fullname = '';
    $birthday = '';
    $phone = '' ;
    $pass = '';
    $pass_confirm = '';

    if (isset($_POST['FullName1']) && isset($_POST['BirthDay1']) && isset($_POST['EmailAddress1'])
    && isset($_POST['UserName1']) && isset($_POST['CreatePassword1']) && isset($_POST['ConfirmPassWord']))
    {
        $fullname = $_POST['FullName1'];
        $birthday = $_POST['BirthDay1'];
        $email = $_POST['EmailAddress1'];
        $user = $_POST['UserName1'];
        $phone = $_POST['Phone1'];
        $pass = $_POST['CreatePassword1'];
        $pass_confirm = $_POST['ConfirmPassWord'];

        if (empty($fullname)) {
            $error = 'Vui lòng nhập họ tên';
        }
        else if (empty($birthday)) {
            $error = 'Vui lòng chọn ngày sinh';
        }
        else if (empty($email)) {
            $error = 'Vui lòng nhập email';
        }
        else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $error = 'Đây không phải là địa chỉ email hợp lệ';
        }else if (empty($phone)) {
            $error = 'Vui lòng nhập số điện thoại';
        }
        else if (empty($user)) {
            $error = 'Vui lòng nhập tên đăng nhập';
        }
        else if (empty($pass)) {
            $error = 'Vui lòng nhập mật khẩu';
        }
        else if (strlen($pass) < 6) {
            $error = 'Mật khẩu phải có hơn 6 kí tự';
        }
        else if ($pass != $pass_confirm) {
            $error = 'Mật khẩu không khớp';
        }
        else {
            // register a new account
            $result = register($user,$email, $fullname,$birthday,$phone,$pass);
            if($result['code'] == 0){

            }else if($result['code'] == 1) {
                $error = 'Email này đã tồn tại';
            }else {
                $error = 'Đã xảy ra lỗi. Vui lòng nhập lại';
            }
        }
    }
?>
    <div class="main">
        <div class="main-login">
            <div class="img-login">
                <img src="./img/4.jpg">
            </div>
            <div class="form-login">
                <form method="post" action="" novalidate>
                    <h2>Đăng ký</h2>
                    <input type="text" value="<?= $user?>" name="UserName1"  placeholder="Tên đăng nhập" id="username">
                    <input type="email" value="<?= $email?>" name="EmailAddress1"  placeholder="Email">
                    <input type="text" value="<?= $fullname?>" name="FullName1"  placeholder="Họ và tên">
                    <input type="date" value="<?= $birthday?>" name="BirthDay1"  placeholder="Ngày sinh">
                    <input type="tel" value="<?= $phone?>" name="Phone1"  placeholder="Số điện thoại">
                    <input type="password" value="<?= $pass?>" name="CreatePassword1"  placeholder="Mật khẩu" id="cpw">
                    <input type="password" value="<?= $pass_confirm?>" name="ConfirmPassWord"  placeholder="Nhập lại mật khẩu" id="cfpw">
                    <?php
                            if (!empty($error)) {
                                echo "<p style='color:red;'>$error</p>";
                            }
                        ?>
                    <input type="submit" name="signup-btn" value="Đăng ký">
                    <p class="q-signup">Bạn đã có tài khoản rồi? <a href="login.php">Đăng nhập</a></p>
                </form>
            </div>
        </div>
    </div>
    
    
</body>
</html>