<?php
  require "connect2.php";
  $username = $_GET["username"];
  $data = $_POST;
  $insertString = "";

  // Khi thực hiện phân quyền cho tài khoản. Các quyền cũ sẽ được xóa
  $deletePrivileges = mysqli_query($con,"DELETE FROM `user_privileges` WHERE `user` = '$username' ");
  // Dùng để nối chuỗi
  foreach($data as $insertPrivileges){
    $insertString .= !empty($insertString) ? ",": "";  
    $insertString .= "(NULL, '$username', '$insertPrivileges')";
  }

  // Và thêm các quyền mới vào

  $insertPrivileges = mysqli_query($con,"INSERT INTO `user_privileges` (`id`, `user`, `privileges`) VALUES ".$insertString);
  $Privileges = mysqli_query($con,"SELECT `uri_match` FROM `privi`");
  $Privileges = mysqli_fetch_all($Privileges,MYSQLI_ASSOC);
  
  header("Location: Manager-Account.php");

?>