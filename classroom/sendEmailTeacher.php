<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

    if(isset($_POST['code'])){

        $classcode = $_POST['code'];
        $username = $_GET['username'];
        // var_dump($classcode);
        require_once("connect2.php");

        $sql2 = "SELECT * FROM `sv_class` WHERE username = '$username' AND classcode = $classcode";
        $result2 = $con->query($sql2);
        $result2 = $result2->fetch_assoc();
        if($result2 == NULL){
            $sql = "SELECT fullname FROM `account` WHERE username = '$username'";
            $result = $con->query($sql);
            $result = $result->fetch_assoc();
            $fullname = $result["fullname"];
    
            $sql1 = "SELECT email FROM `class`,`account` WHERE class.classcode = $classcode AND class.username = account.username";
            $result1 = $con->query($sql1);
            $result1 = $result1->fetch_assoc();
            $email = $result1["email"];
            // var_dump($result1);exit;
    
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
            
                $mail->setFrom('hmh551555@gmail.com', 'Classroom');
                $mail->addAddress($email, 'Nguoi nhan'); 
                $mail->isHTML(true);            
                $mail->Subject = 'Yeu cau tham gia vao lop hoc cua ban';
                $mail->Body    = "Click <a href='http://localhost:8888/classroom/addstudent.php?classcode=$classcode&username=$username'> vào đây </a> để thêm $fullname vào lớp học của bạn";
            
                $mail->send();
                header("location: home.php");
                return true;
            } catch (Exception $e) {
               return false;
            }                 
        }else{
            header("location: ans.php");
        }
        


    }else{
        echo"NOT FOR YOU!";exit;
    }

?>