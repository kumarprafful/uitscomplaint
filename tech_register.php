<?php 
include 'core/init.php';
include 'includes/header.php'; 
include 'includes/navbar.php';

  if (isset($_SESSION["sess_user"])) {
    header("Location: tech_index.php");
  }
  elseif ($_SESSION["designation"] == "user") {
    header("Location: no_entry.php");
  }
else{
?>

<link rel = "stylesheet"
   type = "text/css"
   href = "includes/css/main_form.css" >


<div class="form-container">
<div class="main-content form-padding">
<div class="content">
<div class="form-padding">
<h1 class="form-title center">Sign up for UITS-Complaint Portal</h1><br>
<form action="tech_register_process.php" method="post">
<input class="form-control form-text-input" id="name_input" type="text" name="username" onblur="check_username()" placeholder="Username" autocomplete="false" onkeydown="noSpace(this,event)" required ><br>
<input class="form-control form-text-input" type="password" name="password" id="pwd1" placeholder="Password" required autocomplete="false" onkeydown="noSpace(this,event)"><br>
<input class="form-control form-text-input" type="password" name="password" id="pwd2" onblur="check_pwd()" placeholder="Confirm Password" required autocomplete="false" onkeydown="noSpace(this,event)"><br><span id="message"></span> <br>

<input class="form-control form-text-input" type="text" name="first_name" placeholder="First Name" required autocomplete="false" onkeydown="noSpace(this,event)"><br>
<input class="form-control form-text-input" type="text" name="last_name" placeholder="Last Name" required autocomplete="false" onkeydown="noSpace(this,event)"><br>
<input class="form-control form-text-input" type="email" name="email" placeholder="Email" required autocomplete="false" onkeydown="noSpace(this,event)"><br>
<!--dropdown for designation-->
<select class="form-control form-text-input-dropdown" id="Time" onchange="document.getElementById('designation').value=this.options[this.selectedIndex].text; document.index.submit();" required>
		<option value="" disabled="disabled" selected="selected" hidden="hidden">Specialisation</option>
  	
 		<option value="computer" >Computer</option>
  		<option value="printer" >Printer</option>
  		<option value="ups" >UPS</option>
  		<option value="projector" >LCD/Projector</option>
  		<option value="internet" >Internet/LAN</option>
  		<option value="wifi" >Wi-Fi</option>
 </select><br>
<input type="hidden" name="designation" id="designation" value=""><br>
<button name="submit" class="btn btn-block btn-submit btn-primary">Submit</button><br><br>
</form>
</div>
</div>
</div>
</div>

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




document.getElementById("name_input").focus();

	function check_username(){
		var name = document.getElementById("name_input");
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200){
        		var result = xmlhttp.responseText;
        		if(result == 0){
        			alert("Username already exist");
        			name.value = "";
        		}
        	}
        };
        xmlhttp.open("GET","check_username.php?q="+name.value,true);
		xmlhttp.send();
	}
	


</script>



























<!--









/*

$que = mysql_query($connect, "SELECT `username` FROM `technician`");
	echo mysqli_result($que);	
if (isset($_POST["submit"])){
	$connect = mysqli_connect('localhost','root','','comp_sys');
	$que = mysql_query($connect, "SELECT `username` FROM `technician`");
	echo mysqli_result($que);	}
*/
/*
	$numrows = mysqli_num_rows($query);
		if ($numrows!=0) {
			while($row = mysqli_fetch_assoc($query)){
				$dbusername = $row['username'];
				$dbpassword = $row['password'];
				$dbfirstname = $row['first_name'];
				$dblastname = $row['last_name'];
				$dbemail = $row['email'];
				$dbdesignation = $row['']
			}
	
*/
			?>-->