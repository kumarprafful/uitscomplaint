<?php
include 'core/connect.php';

	$username = mysqli_real_escape_string($connect, $_POST['username']); 
	$password = mysqli_real_escape_string($connect, $_POST['password']); 
	$password = md5($password);
	$first_name = mysqli_real_escape_string($connect, $_POST['first_name']); 
	$last_name = mysqli_real_escape_string($connect, $_POST['last_name']); 
	$email = mysqli_real_escape_string($connect, $_POST['email']); 
	$designation = mysqli_real_escape_string($connect, $_POST['designation']); 

	//$connect = mysqli_connect('localhost','root','','comp_sys');

	$sql = "INSERT INTO `technician` (`username`, `password`, `first_name`, `last_name`, `email`, `designation`) VALUES ('".$username."','".$password."','".$first_name."','".$last_name."','".$email."','".$designation."')";
	$q = mysqli_query($connect,$sql) or die(mysqli_error($connect));


	if ($q) {
		header("Location:tech_index.php");
	}
?>