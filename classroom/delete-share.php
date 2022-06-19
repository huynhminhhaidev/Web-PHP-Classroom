<?php

    require_once("connect2.php");
    $id = $_GET["id"];
    $sql1 = "SELECT classcode FROM share_something WHERE id = $id";
    $result1 = $con->query($sql1);
    $result1 = $result1->fetch_assoc();
    // var_dump($result1);exit;
    $classcode = $result1["classcode"];
    
    $sql = "DELETE FROM share_something WHERE id = $id";
    
    if ($con->query($sql) === TRUE) {
        header("Location: class-home.php?classcode=$classcode");
    }

?>