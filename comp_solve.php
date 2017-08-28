<?php
	  include 'core/connect.php';
	  //include 'tech_dashboard.php';

$id = intval($_GET['q']);
$remarks = $_GET['rem'];
//$connect = mysqli_connect('localhost','root','','comp_sys');
//$query1 = mysqli_query($connect, "UPDATE `complaint` SET `active`=0 WHERE `comp_id`='".$id."'");

//$connect = mysqli_connect('localhost','root','','comp_sys');
 
//$remarks=$_SESSION['remarks'];
$query2 = mysqli_query($connect, "UPDATE `complaint` SET `active`=0, `tech_remark` = '".$remarks."' WHERE `comp_id` = '".$id."' ");
//$query2 = mysqli_query($connect, "UPDATE `complaint` SET `active`=0 WHERE `comp_id` = '".$id."'");


					 
?>