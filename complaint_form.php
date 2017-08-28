
<?php
 include 'core/init.php'; 
 	  include 'core/connect.php';

 include'includes/header.php';
 
 if (!isset($_SESSION['sess_user'])) {
 	header("Location: index.php");
 }
 else{


 ?>
<link rel = "stylesheet"
   type = "text/css"
   href = "includes/css/main_form.css" >
<body>
<div class="container-fluid">
<?php include 'includes/navbar.php' ?>


<div class="form-container">
<div class="main-content form-padding">
<div class="inner" >

<h1 class="form-title" >Fill this form to file the complaint</h1><br>


<!-- php code for taking out first name lastname and email from database. it would have had been better if we can seperate php code from html-->
<?php 
		$username = $_SESSION['sess_user'];
//$connect = mysqli_connect('localhost','root','','comp_sys');
$sql = mysqli_query($connect,"SELECT * FROM user WHERE `username`='".$username."'");
$numrows = mysqli_num_rows($sql);
if ($numrows!=0) {
	while ($row = mysqli_fetch_assoc($sql)) {
		$firstname = $row['first_name'];
		$lastname = $row['last_name'];
	 	$email = $row['email'];
	}
}
?>
<!-- html -->
<div class="form-padding">
<form id="form" action="process.php" method="post">
	<label class="form-text-label" for="User">Name   :</label>	<br>
	

	<p class="form-text-input"> <?php echo $firstname . ' '. $lastname; ?></p>
	<!--<input type="text" name="user" placeholder="" required id="User">--><br><br>


	<!--Check if mobile number is already saved. If so, then show it from database -->

	<?php 
		$q_mob=mysqli_query($connect, "SELECT `mobile_no` FROM `complaint` WHERE `user_name`='".$username."'");
		$mobile_no=mysqli_result($q_mob);
	 ?>

	<label class="form-text-label" for="mob">Mobile no. :</label><br>
	<!--Check if mobile number already exists-->
	

	<input id="mob_chng" type="number" value="<?php echo $mobile_no ?>" onkeydown="noSpace(this,event)" onkeypress="return check(event,value)" oninput="checkLength(10, this)" name="mob" class="form-text-input form-control" placeholder="" required id="mob"><br><br>


	<br><br>

	<label class="form-text-label" for="email">Email:</label><br>
	<p class="form-text-input"><?php echo $email; ?></p><br><br>

	<label class="form-text-label" for="block">Block &amp; Room No. :</label><br>
	<input type="text" name="block" onkeydown="noSpace(this,event)" onkeypress="return check(event,value)" oninput="checkLength(10, this)" required class="form-text-input form-control" placeholder="" id="block"><br><br>
	<label class="form-text-label">Complaint Type :</label><br>
			<label  for="1"><input type="radio" name="radio" value="Computer" id="1" required><p class="form-text-input-radio">Computer</p></label><br>
			<label  for="2"><input type="radio" name="radio" value="Printer" id="2"><p class="form-text-input-radio">Printer</p></label><br>
			<label  for="3"><input type="radio" name="radio" value="UPS" id="3"><p class="form-text-input-radio">UPS</p></label><br>
			<label  for="4"><input type="radio" name="radio" value="LCD/Projector" id="4"><p class="form-text-input-radio">LCD or Projector</p></label><br>
			<label  for="5"><input type="radio" name="radio" value="Internet/LAN" id="5"><p class="form-text-input-radio">Internet/LAN</p></label><br>
			<label  for="6"><input type="radio" name="radio" value="Wi-Fi" id="6"><p class="form-text-input-radio">Wi-Fi</p></label><br>
			<label  for="7"><input type="radio" name="radio" value="other" id="7" onclick="alert('Please specify in Details below')"><p class="form-text-input-radio">Any Other</p></label><br><br>
			

	<label class="form-text-label" for="details"><p>Details of the Issue :</p>
	<textarea cols="70" rows="7" id="details" name="text" onkeydown="noSpace(this,event)" class="form-text-input form-control form-control1" placeholder="Please Enter the issue description" required style="resize:none"></textarea></label><br><br>

	<label class="form-text-label" for="machine">Machine Name - Model No.</label>	
	<input type="text" name="machine" placeholder="" onkeydown="noSpace(this,event)" class="form-text-input form-control" id="machine"><br><br>
	<label class="form-text-label" for="time">Preferred Time</label>	
	<select id="Time" class="form-control" onchange="document.getElementById('pref_time').value=this.options[this.selectedIndex].text; document.index.submit();">
  		<optgroup>
  		<option selected="selected" disabled="disabled" hidden="hidden" value="">Working Hours</option>
 		<option value="9" >9:00 am</option>
  		<option value="10" >10:00 am</option>
  		<option value="11" >11:00 am</option>
  		<option value="12" >12:00 pm</option>
  		<option value="13" >1:00 pm</option>
  		<option value="14" >2:00 pm</option>
  		<option value="15" >3:00 pm</option>
  		<option value="16" >4:00 pm</option>
  		<option value="17" >5:00 pm</option>
  		<option value="18" >6:00 pm</option>
  		<option>Anytime</option>
  		</optgroup>
	</select>
	<input type="hidden" name="pref_time" id="pref_time" value=""><br><br><br>

	


	<input class="btn btn-block btn-primary btn-submit" type="submit" name="submit" id="btn" value="Submit">	
	<hr>

</form>
	</div>	
</div>
</div>
</div>
</div>
</body>
</html>



<?php } ?>

<script>
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