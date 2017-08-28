<?php
	  include 'core/connect.php';

	  $username = $_GET['q'];

	  $query = mysqli_query($connect, "SELECT * FROM `user` WHERE `username` = '".$username."' ");
	  $query2 = mysqli_query($connect, "SELECT * FROM `technician` WHERE `username` = '".$username."' ");
	  if( mysqli_num_rows($query) == 0 && mysqli_num_rows($query2) == 0){
	    echo 1;
	  }

?>