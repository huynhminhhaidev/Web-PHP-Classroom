<?php

var_dump($_POST);
var_dump($_GET);

    if(isset($_POST["content"]) and isset($_POST["classcode"]) and empty($_GET)){
        var_dump($_GET);
        // var_dump($_POST);exit;
        $classcode = $_POST["classcode"];
        $content = $_POST["content"];
        $code = $_POST["classcode"];
        $time = date("d-m-Y",time());

        if(basename($_FILES["fileToUpload"]["name"]) != ""){

            $target_file = "img/" . basename($_FILES["fileToUpload"]["name"]);

            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                
                die("Sorry, there was an error uploading your file.");
            }
        }else{
            $target_file = "";
        }
        
        
        // var_dump("class-home.php?classcode='$classcode'");exit;
        require_once("connect2.php");
        $stmt = $con->prepare("INSERT INTO share_something(classcode, content, file, time) VALUES (?, ?, ?, ?)");

        $stmt->bind_param("ssss",$classcode, $content, $target_file, $time);
        
        if ($stmt->execute() === TRUE) {
            // var_dump($classcode);exit;
            header("Location: class-home.php?classcode=$code");
          } else {
            
            header("Location: home.php");
          }  


    }
    
    
    else if(isset($_GET["id"]) and isset($_POST["content"]) and isset($_POST["classcode"])){
        // var_dump($_POST);exit;
        $id = $_GET["id"];
        // var_dump($_GET["id"]);
        require_once("connect2.php");
        $sql = "SELECT * FROM `share_something` WHERE id = $id" ;
        $result = $con->query($sql);
        $result = $result->fetch_assoc();
        // var_dump($result);

        $classcode = $result["classcode"];
        $content = $_POST["content"];
        $time = $result["time"];

        if(basename($_FILES["fileToUpload"]["name"]) != ""){

            $target_file = "img/" . basename($_FILES["fileToUpload"]["name"]);

            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                
                die("Sorry, there was an error uploading your file.");
            }
        }else{
            $target_file = "";
        }

        $stmt = $con->prepare("UPDATE share_something 
                                SET classcode=?, content=?, file=?, time=?
                                WHERE id=$id");
        $stmt->bind_param("ssss",$classcode, $content, $target_file, $time);
        if ($stmt->execute() === TRUE) {
            header("Location: class-home.php?classcode=$classcode");
          } else {
            
            header("Location: home.php");
          }  
    }else{
        echo"NOT FOR YOU!";exit;
    }


?>