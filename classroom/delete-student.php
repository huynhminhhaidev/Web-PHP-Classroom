<?php
    require_once("connect2.php");
    $username = $_GET["username"];
    
    $sql1 = "SELECT * FROM `sv_class` WHERE username = '$username'";
    $result = $con->query($sql1);
    $result = $result->fetch_assoc();
    $classcode = $result["classcode"];
    // var_dump($classcode);exit;
    
    $sql = "DELETE FROM sv_class WHERE username = '$username' AND classcode = $classcode";

    

    if ($con->query($sql) === TRUE) {
        header("Location: class-classmate.php?classcode=$classcode");
    }

?>