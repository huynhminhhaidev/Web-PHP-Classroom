<?php
require "connect2.php";

$username = $_GET["username"];
$sql = "DELETE FROM account WHERE username = '$username'";
if ($con->query($sql) === TRUE) {
	header("Location: Manager-Account.php");
}
?>