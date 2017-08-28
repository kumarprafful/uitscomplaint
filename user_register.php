<?php 
include 'core/init.php';
include 'includes/header.php'; 
include 'includes/navbar.php';

  if (isset($_SESSION["sess_user"])) {
    header("Location: index.php");
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
<form  action="user_register_process.php" method="post">
<input class="form-control form-text-input" id="name_input" type="text" name="username" onblur="check_username()" placeholder="Username" autocomplete="false" required onkeydown="noSpace(this,event)"><br>
<input class="form-control form-text-input" type="password" name="password" id="pwd1" placeholder="Password" required autocomplete="false" onkeydown="noSpace(this,event)"><br>

<input class="form-control form-text-input" type="password" name="password" id="pwd2" onblur="check_pwd()" placeholder="Confirm Password" required autocomplete="false" onkeydown="noSpace(this,event)"><br><span id="message"></span> <br>


<input class="form-control form-text-input" type="text" name="first_name" placeholder="First Name" autocomplete="false" required onkeydown="noSpace(this,event)"><br>
<input class="form-control form-text-input" type="text" name="last_name" placeholder="Last Name" autocomplete="false" required onkeydown="noSpace(this,event)"><br>
<input class="form-control form-text-input" type="email" name="email" placeholder="Email" required onkeydown="noSpace(this,event)"><br>
<br>
<button name="submit" class="btn btn-block btn-submit btn-primary">Sign Up</button><br><br>
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