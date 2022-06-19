
<?php
    session_start();
    if (isset($_SESSION['UserName'])) {
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
    <title>Đăng nhập</title>
</head>
<body>
<?php

$error = '';
$user = '';
$pass = '';

if (isset($_POST['UserName']) && isset($_POST['Password'])) {
    $user = $_POST['UserName'];
    $pass = $_POST['Password'];

    if (empty($user)) {
        $error = 'Vui lòng đăng nhập tên tài khoản';
    }
    else if (empty($pass)) {
        $error = 'Vui lòng nhập mật khẩu';
    }
    else{
        $result = login($user, $pass);
        if ($result['code'] == 0) {
            $data = $result['data'];
            $_SESSION['UserName'] = $user;
            $_SESSION['name'] = $data['fullname'];
            include("connect2.php");
            $user_current = $result['data']['username'];
            $userPrivileges = mysqli_query($con, "SELECT * FROM `user_privileges` INNER JOIN `privi` ON user_privileges.privileges = privi.id WHERE user_privileges.user = '$user_current'");
            
            $userPrivileges = mysqli_fetch_all($userPrivileges,MYSQLI_ASSOC);
           
            if(!empty($userPrivileges)){
                $result['privileges'] = array();
                foreach($userPrivileges as $privilege){
                    $result['privileges'][] = $privilege['uri_match'];
                }
            }else{
                $result['privileges'] = array();
                $result['privileges'][] = "home\.php?";
            }
            
            
            $_SESSION['current_user'] = $result;
            // var_dump($user);exit;
            header('Location: home.php');
            exit();
        } else {
            $error = $result['error'];
        }
    }
}
?>
    <div class="main">
        <div class="main-login">
            <div class="img-login">
                <img src="./img/4.jpg" alt="">
            </div>
            <div class="form-login">
                <form method="POST" >
                    <h2>Đăng nhập</h2>
                    <input type="text" value="<?= $user ?>" name="UserName"  placeholder="Tên đăng nhập">
                    <input type="password" value="<?= $pass ?>" name="Password"  placeholder="Mật khẩu">
                    <?php
                        if (!empty($error)) {
                            echo "<p style='color:red;'>$error</p>";
                        }
                    ?>
                    <input type="submit" name="signin-btn" value="Đăng nhập">
                    <p class="q-signup">Bạn có tài khoản đăng nhập không? <a href="signup.php">Đăng ký</a></p>
                    <p class="q-signup"><a href="forgotpw.php">Quên mật khẩu?</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>