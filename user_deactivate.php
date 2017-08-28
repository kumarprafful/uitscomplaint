<?php
include 'includes/header.php';
include 'core/init.php';
include 'core/connect.php';
if(!isset($_SESSION["sess_user"]) || $_SESSION['designation'] != 'superuser'){
	header("Location: no_entry.php");
}
else{
	$id = intval($_GET['q']);
	//$connect = mysqli_connect('localhost','root','','comp_sys');
	$query1 = mysqli_query($connect, "UPDATE `user` SET `active`=0 WHERE `user_id`='".$id."'");
}
?>