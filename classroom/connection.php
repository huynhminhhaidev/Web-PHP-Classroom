<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

    define('HOST','127.0.0.1');
    define('USER','root');
    define('PASS','');
    define('DB','classroom');


    // Kết nối với Mysql
    function open_database() {
        $conn = new mysqli(HOST,USER,PASS,DB);
        if ($conn -> connect_error) {
            die('Connect error: ' . $conn -> connect_error);
        }
        return $conn;
    }


    // Hàm Đăng nhập
    function login($user, $pass) {

        // Truy vấn username trong database
        $sql = "select * from account where username = ?";
        $conn = open_database();

        // prepare dùng để ẩn danh các tham số
        $stm = $conn->prepare($sql);

        //Kiểm tra tính hợp lệ khi truy vấn
        $stm->bind_param('s', $user);
        if (!$stm-> execute()) {
            return array('code' => 1, 'error' => 'Không thể thực hiện lệnh');
        }

        // Kiểm tra xem tên đăng nhập có tồn tại hay không
        $result = $stm-> get_result();
        if ($result -> num_rows ==0) {
            return array('code' => 1, 'error' => 'Tên đăng nhập không tồn tại');
        }

        $data = $result->fetch_assoc();

        $hashed_password = $data['password'];
        if(!password_verify($pass,$hashed_password)) {
            // Có user nhưng sai mật khẩu
            return array('code' => 2, 'error' => 'Sai mật khẩu');
        } else if ($data['activated'] == 0){
            // Tài khoản đăng ký rồi nhưng chưa được kích hoạt bằng mail (active = 0)
            return array('code' => 3, 'error'=> 'Tài khoản chưa được kích hoạt');
        } 
        else{
            // Đăng nhập hợp lệ
            return array('code' => 0, 'error'=> '', 'data' => $data);
        }
    }

    // Hàm kiểm tra email có tồn tại hay chưa(khi đăng ký)
    function is_email_exists($email) {
        $sql = 'select username from account where email = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$email);

        if(!$stm->execute()) {
            die('Query error: ' . $stm->error);
        }

        $result = $stm->get_result();
        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }
    }

    // Hàm đăng ký
    function register($user,$email, $fullname,$birthday,$phone,$pass) {

        if ( is_email_exists($email)) {
            return array('code' => 1, 'error' => 'Email đã tồn tại');
        }

        // Mã hóa password bằng hash
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $rand = random_int(0,1000);
        $token = md5($user . '+' . $rand);

        $sql = 'insert into account(username, email, fullname, birthday, phone, password,activate_token) values(?,?,?,?,?,?,?)';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssss',$user,$email,$fullname,$birthday,$phone,$hash,$token);
        
        if(!$stm->execute()) {
            return array('code' => 2, 'error' => 'Lệnh không thực hiện được');
        }

        sendActivationEmail($email,$token);

        return array('code'=> 0, 'error' => 'Đăng ký thành công');
    }

    // Hàm gửi mail để xác minh tài khoản
    function sendActivationEmail($email,$token){
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Charset = 'UTF-8';
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hmh551555@gmail.com';
            $mail->Password   = 'Hai123456789';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
        
            $mail->setFrom('hmh551555@gmail.com', 'Huynh Minh Hai');
            $mail->addAddress($email, 'Nguoi nhan');

            $mail->isHTML(true);
            $mail->Subject = 'Xac minh tai khoan cua ban';
            $mail->Body    = "Click <a href='http://localhost:8888/classroom/active.php?email=$email&token=$token'> vao day </a> de xac minh tai khoan cua ban";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
           return false;
        }     
    }

    // Hàm dùng để xác minh tài khoản (Chuyển active 0 sang 1, active = 1 thì mới đăng nhập được)
    function activeAccount($email,$token) {
        $sql = 'select username from account where email = ? and activate_token = ? and activated = 0';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $email, $token);

        if (!$stm->execute()) {
            return array('code' => 1, 'error'=> 'Không thực thi được dòng lệnh');
        }
        $result = $stm->get_result();
        if ($result->num_rows == 0) {
            return array('code' => 2, 'error'=> 'Email address or token not found');
        }

        $sql = "update account set activated = 1, activate_token = '' where email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$email);
        if (!$stm->execute()) {
            return array('code' => 1, 'error' => 'Không thực thi được dòng lệnh');
        }

        return array('code' => 0, 'error' => 'Tài khoản đã được xác minh');
    }

    // Hàm gửi mail để khôi phục mật khẩu
    function sendResetPasswordEmail($email,$token){
        $mail = new PHPMailer(true);
        
        try {
            $mail->Charset = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hmh551555@gmail.com';
            $mail->Password   = 'Hai123456789';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
        
            //Recipients
            $mail->setFrom('hmh551555@gmail.com', 'Huynh Minh Hai');
            $mail->addAddress($email, 'Nguoi nhan');

            $mail->isHTML(true);
            $mail->Subject = 'Khoi phuc mat khau';
            // Đường link này dẫn đến file resetpw.php
            $mail->Body    = "Click <a href='http://localhost:8888/classroom/resetpw.php?email=$email&token=$token'> vao day </a> de khoi phuc mat khau cua ban";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
           return false;
        }     
    }

    // Hàm đổi mật khẩu
    function resetpassword($email) {
        if (!is_email_exists($email)) {
            return array('code' => 1, 'error' => 'Email không tồn tại');
        }
        $token = md5($email . '+' . random_int(1000,2000));
        $sql = 'update reset_token set token = ? where email = ?';

        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $token, $email);

        if (!$stm->execute()) {
            return array('code' => 2, 'error' => 'Không thực hiện được câu lệnh');
        }

        if ($stm->affected_rows == 0) {
            // Chưa có dòng nào có email này ta thêm dòng mới
            $exp = time() + 3600 *24; //Hết hạn 24h

            $sql = 'insert into reset_token values(?,?,?)';
            $stm = $conn->prepare($sql);
            $stm->bind_param('ssi', $email,$token,$exp);

            if (!$stm->execute()) {
                return array('code' => 1, 'error' => 'Không thực hiện được câu lệnh');
            }

        }

        // Đi đến hàm gửi mail để khôi phục mật khẩu khi quên
        $success = sendResetPasswordEmail($email,$token);
        return array('code' => 0, 'success' => $success);

    }

    // Hàm kiểm tra phần quyền
    function CheckPrivilege($uri = false){
        $uri = $uri != false ? $uri : $_SERVER['REQUEST_URI'];

        // if(empty($_SESSION['current_user']['privileges'])){
        //     return false;
        // }

        $privileges = $_SESSION['current_user']['privileges'];
        $privileges = implode("|",$privileges);
        preg_match('/home\.php$|class-home\.php\?classcode=\d+$|class-home\.php\?id=\d+$|class-classmate\.php\?classcode=\d+$|class-classmate\.php$|' . $privileges . '/', $uri, $matches);
        return !empty($matches);
    }
?>