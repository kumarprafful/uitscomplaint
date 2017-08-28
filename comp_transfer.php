<?php
	  include 'core/connect.php';

$id = intval($_GET['q']);
$specialisation = $_GET['sp'];

$query2 = mysqli_query($connect, "UPDATE `complaint` SET `comp_type` = '".$specialisation."' WHERE `comp_id` = '".$id."' ");
					 
?>