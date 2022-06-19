<?php
    $classname = $_POST['classname'];
    $subject = $_POST['subject'];
    $classroom = $_POST['classroom'];
    $username = $_POST['username'];
    $teachername = $_POST['teachername'];
    $classcode = rand(1000,9999);

    $target_file = "img/" . $_FILES["imgToUpload"]["name"];

    if (!move_uploaded_file($_FILES["imgToUpload"]["tmp_name"], $target_file)){
        die("Sorry, there was an error uploading your file.");
    }

    require "connect2.php";

    if (empty($_POST["id"])){
        $stmt = $con->prepare("INSERT INTO class(classcode, classname, subject, classroom, teachername, avatar, username) VALUES (?, ?, ?, ?, ?, ?, ?)");
    } else{
        $id = $_POST["id"];
        $stmt = $con->prepare("UPDATE class 
                                SET classcode=?, classname=?, subject=?, classroom=?, teachername=?, avatar=?, username=?
                                WHERE id=$id");
    }
    
    $stmt->bind_param("sssssss",$classcode, $classname, $subject, $classroom, $teachername,  $target_file, $username);
    
    if ($stmt->execute() === TRUE) {
      header("Location: Manager-Class.php");
    } else {
      echo "Error: " . $sql . "<br>" . $con->error;
    }    


?>