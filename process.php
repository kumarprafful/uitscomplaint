<?php include 'core/init.php';
	include 'includes/header.php'; 
		  include 'core/connect.php';



?>


<?php 
$user = $_SESSION["sess_user"];
$mob = mysqli_real_escape_string($connect, $_POST['mob']);
$block = mysqli_real_escape_string($connect, $_POST['block']);
$comp_type = mysqli_real_escape_string($connect, $_POST['radio']);
$text = mysqli_real_escape_string($connect, $_POST['text']);
$machine = mysqli_real_escape_string($connect, $_POST['machine']);
$time = mysqli_real_escape_string($connect, $_POST['pref_time']);

/*$sql = "INSERT INTO `complaint` (`user`) VALUES ('".$user."')";*/
$sql = "INSERT INTO `complaint` (`user_name`, `mobile_no`, `block_room`, `comp_type`, `details`, `mac_name`, `preferred_time`) VALUES ('".$user."', '".$mob."', '".$block."', '".$comp_type."', '".$text."', '".$machine."', '".$time."')";
//mysqli_query($connect, "INSERT INTO `complaint` (user_name) VALUES ('Vishal')")
$t = mysqli_query($connect, $sql) or die(mysqli_error($connect));

if($t){
	header("Location:index.php");
}

?>
