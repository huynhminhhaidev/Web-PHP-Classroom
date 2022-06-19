<?php

    // var_dump($_GET);

    if(isset($_GET['classcode']) and isset($_GET['username'])){

        $classcode = $_GET['classcode'];
        $username = $_GET['username'];
        // var_dump($classcode);
        // var_dump($username);
        // exit;

        require "connect2.php";

        $stmt = $con->prepare("INSERT INTO sv_class(classcode, username) VALUES (?, ?)");

        $stmt->bind_param("ss",$classcode, $username);
        
        if ($stmt->execute() === TRUE) {
            header("Location: home.php");
          } else {
            
            // header("Location: home.php");
          }  


    }else{
        echo"NOT FOR YOU!";exit;
    }

?>