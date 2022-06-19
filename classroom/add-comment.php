<?php

    var_dump($_POST);
    var_dump($_GET);
    

    if(isset($_POST) and isset($_GET)){
        $comment = $_POST["comment"];
        $username = $_POST["username"];
        $share_id = $_GET["id"];
        $time = date("d-m-Y",time());
        
        require_once("connect2.php");

        $stmt = $con->prepare("INSERT INTO comment(share_id, username, comment, time) VALUES (?, ?, ?, ?)");
        
        $stmt->bind_param("ssss", $share_id, $username, $comment, $time);
        
        
        $sql = "SELECT classcode FROM `share_something` WHERE id = $share_id ";
        $result = $con->query($sql);
        $result = $result->fetch_assoc();
        $classcode = $result["classcode"];

        
        if ($stmt->execute() === TRUE) {
            header("Location: class-home.php?classcode=$classcode");
          } else {
            
            header("Location: home.php");
          }  

    }else{
        echo "NOTHING";exit;
    }


?>