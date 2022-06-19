<?php
require "connect2.php";

$id = $_GET["id"];
$sql = "DELETE FROM class WHERE id = $id";
if ($con->query($sql) === TRUE) {
	header("Location: Manager-Class.php");
}
?>
