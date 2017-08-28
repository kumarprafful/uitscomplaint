<?php
 include 'core/init.php'; 
 	  include 'core/connect.php';

 include 'includes/header.php';
 include 'includes/navbar.php';
 
 if (!isset($_SESSION['sess_user'])) {
 	header("Location: index.php");
 }
 else{


 ?>
<link rel = "stylesheet"
   type = "text/css"
   href = "includes/css/main_form.css" >

   <div class="form-container">
		<div class="main-content form-padding">
			<div class="content inner" >
			<div class="form-padding">
			<h1 class="form-title center">Change Password</h1><br>
			<form role="form" action="" method="post" class="">
				<input class="form-text-input form-control" type="password" name="old_pwd" placeholder="Enter current password." onkeydown="noSpace(this,event)" required><br>
				<input class="form-text-input form-control" type="password" id="pwd1" name="new_pwd" placeholder="Enter new password." onkeydown="noSpace(this,event)" required><br>
				<input onblur="check_pwd()" class="form-text-input form-control" type="password" id="pwd2" name="cnfrm_pwd" placeholder="Confirm new password." required onkeydown="noSpace(this,event)"><br>
				<span id="message"></span>
				<br>
				<br>

				<input type="submit" name="submit" value="Submit" class="btn btn-block btn-primary"><br><br><br>
			</form>

			</div>
			</div>
		</div>
	</div>



<!-- php -->
<?php

	$username = $_SESSION['sess_user'];
	$q1 = mysqli_query($connect, "SELECT `password` FROM `technician` WHERE `username`='".$username."' ");
	$q2 = mysqli_query($connect, "SELECT `password` FROM `user` WHERE `username`='".$username."' ");

	$dbtechpassword = mysqli_result($q1);
	$dbuserpassword = mysqli_result($q2);

	if (isset($_POST['submit'])) {
		if ((!empty($_POST['old_pwd'])) && (!empty($_POST['new_pwd'])) && (!empty($_POST['cnfrm_pwd'])) ) {
			$old_pwd = mysqli_real_escape_string($connect, $_POST['old_pwd']);
			$old_pwd = md5($old_pwd);
			$new_pwd = mysqli_real_escape_string($connect, $_POST['new_pwd']);
			$new_pwd = md5($new_pwd);
			$new_cnf_pwd = mysqli_real_escape_string($connect, $_POST['cnfrm_pwd']);
			$new_cnf_pwd = md5($new_cnf_pwd);

			if (($old_pwd != $dbuserpassword) && ($old_pwd != $dbtechpassword)) { 
				echo '<h2 class="wrong_password">Your old password is wrong!</h2>';
				
			 }
			elseif ($new_pwd == $old_pwd) {
					echo '<h2 class="wrong_password">New password cannot be same as old password.</h2>';
				}
			elseif ($new_pwd != $new_cnf_pwd) {
					echo '<h2 class="wrong_password">Your new password and confirm password didn\'t matched.</h2>';
				}
			else{
					$query0 = mysqli_query($connect, "UPDATE `technician` SET `password`='".$new_pwd."' WHERE `username`='".$username."'  ");
					$query1 = mysqli_query($connect, "UPDATE `user` SET `password`='".$new_pwd."' WHERE `username`='".$username."'  ");

					echo '<h2 class="wrong_password">Your password is updated.</h2>';
			}
		 }

	}


 
} 



  ?>
<script type="text/javascript">

function check_pwd() {
  if (document.getElementById('pwd1').value ==
    document.getElementById('pwd2').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'These passwords don\'t match. Try again?';
    document.getElementById('pwd2').value = "";

  }
}
	function noSpace(el,event){
  if (el.value.length === 0 && event.which === 32){
    event.preventDefault();
  }
  if (el.value.length !=0  && event.which != 32) {
    el.nextElementSibling.classList.remove("disable");
  }
  if (el.value.length === 1) {
    el.nextElementSibling.classList.add("disable");
  }
}
</script>