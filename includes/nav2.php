<nav class="navbar navbar-inverse">
		<div class="navbar-header">
			<a href="#" class="navbar-brand" style="font-family: revalia;"><img src="images/ipu-logo.png" height="55px"></a>
		</div>

		

		<div class="navbar-header">
		<a href="#" class="navbar-brand"><h3 class="banner">UITS <br>Guru Gobind Singh Indraprastha University</h3></a>		      
		</div>
<?php
	   if ((!isset($_SESSION['sess_user'])) || ($_SESSION['designation'] != "user")) {

	 ?>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="tech_index.php" class="btn btn-default btn-lg baner-tech" style="background: #696969; color: white;margin-top: 10%"">Technicians</a></li>
		</ul>
	<?php
}
else{
	?>
	<ul class="nav navbar-nav navbar-right">
		<div class="dropdown">
		<?php if(isset($_SESSION['sess_user'])){?>
		    <button class="btn logout-btn dropdown-toggle" type="button"  style="background: #696969; color: white;margin-top: 10%" data-toggle="dropdown"><?php echo $_SESSION['sess_user'] ?>
		    <span class="caret"></span>

		    </button>
		    <ul class="dropdown-menu logout-drp">
		       <li><a href="chng_pwd.php">Change password</a></li> 
		      <li><a href="user_logout.php">Logout</a></li>
		      
		    </ul>

		 </div>
		 <?php }} ?>	
</nav>
