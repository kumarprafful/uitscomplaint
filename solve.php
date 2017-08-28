<?php
	  include 'core/connect.php';


$id = intval($_GET['q']);
$uid =intval($_GET['w']);
$tid = intval($_GET['p']);
$remarks = $_GET['urem'];

//user happy
//$query = mysqli_query($connect, "UPDATE `complaint` SET `feed_active`=0 WHERE `comp_id`='".$id."' ");


//user angry
$query2 = mysqli_query($connect,"UPDATE `complaint` SET `feed_active`=1, `active`=1, `feedback`='".$remarks."' WHERE `comp_id`='".$uid."' ");

//time machine
$query3 = mysqli_query($connect, "UPDATE `complaint` SET `feed_active` = 0, `feedback` = 'user not responded' WHERE `comp_id` = '".$tid."' ");








?>