<?php

    // var_dump($_GET);
    // var_dump($_POST);
    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

    if(isset($_POST["inputstudent"]) and isset($_GET["classcode"])){
        $classcode = $_GET["classcode"];
        $email = $_POST["inputstudent"];

        require_once("connect2.php");

        $sql2 = "SELECT sv_class.username FROM `sv_class`,`account` WHERE account.email = '$email' AND sv_class.username = account.username AND sv_class.classcode = $classcode";
        $result2 = $con->query($sql2);
        $result2 = $result2->fetch_assoc();
        if($result2 == NULL){
            $sql = "SELECT * FROM `class` WHERE classcode = $classcode";
            $result = $con->query($sql);
            $result = $result->fetch_assoc();
            $teachername = $result["teachername"];
    
            $sql1 = "SELECT username FROM `account` WHERE email = '$email'";
            $result1 = $con->query($sql1);
            $result1 = $result1->fetch_assoc();
            $username = $result1["username"];
            // var_dump($username);exit;
    
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
                $mail->Subject = 'Yeu cau tham gia vao lop hoc';
                $mail->Body    = "Click <a href='http://localhost:8888/classroom/addstudent1.php?classcode=$classcode&username=$username'> vào đây </a> để tham gia vào lớp học của $teachername";
            
                $mail->send();
                header("location: class-classmate.php?classcode=$classcode");
                return true;
            } catch (Exception $e) {
               return false;
            }     
            
        }else{
            header("location: ans1.php?classcode=$classcode");
        }

    }else{
        echo"NOT FOR YOU!";exit;
    }

?>