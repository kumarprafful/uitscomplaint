<?php
include 'core/init.php';
include 'core/connect.php';
	$username = mysqli_real_escape_string($connect, $_POST['username']); 
	$password = mysqli_real_escape_string($connect, $_POST['password']); 
	$password = md5($password);
	$first_name = mysqli_real_escape_string($connect, $_POST['first_name']); 
	$last_name = mysqli_real_escape_string($connect, $_POST['last_name']); 
	$email = mysqli_real_escape_string($connect, $_POST['email']); 
	

	//$connect = mysqli_connect('localhost','root','','comp_sys');
	
	/*$chk_user = mysqli_query($connect, "SELECT `username` FROM `user` WHERE `username`='".$username."' ");
	$res = mysqli_result($chk_user);
	if (isset($res)) {
		header("Location:user_register.php");
	}
	else{
*/
	$sql = "INSERT INTO `user` (`username`, `password`, `first_name`, `last_name`, `email`) VALUES ('".$username."','".$password."','".$first_name."','".$last_name."','".$email."')";
	$q = mysqli_query($connect,$sql) or die(mysqli_error($connect));











if ($q) {
		header("Location:index.php");
	}  //}
 
?>
