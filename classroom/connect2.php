<?php
// session_start();

$con = mysqli_connect('localhost','root','');

mysqli_select_db($con,'classroom');

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }
?>

<!-- file này kết nối vs mysql -->