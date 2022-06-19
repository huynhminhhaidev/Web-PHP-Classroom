<?php

    require_once("connect2.php");
    $id = $_GET["id"];
    $sql1 = "SELECT share_id FROM comment WHERE id = $id";
    $result1 = $con->query($sql1);
    $result1 = $result1->fetch_assoc();

    $share_id = $result1["share_id"];
    $sql2 = "SELECT classcode FROM share_something WHERE id = $share_id";
    $result2 = $con->query($sql2);
    $result2 = $result2->fetch_assoc();
    $classcode = $result2["classcode"];

    $sql = "DELETE FROM comment WHERE id = $id";

    if ($con->query($sql) === TRUE) {
        header("Location: class-home.php?classcode=$classcode");
    }

?>