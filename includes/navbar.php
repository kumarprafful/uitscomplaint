<nav class="navbar navbar-default">
		<div class="navbar-header">
			<?php if(!isset($_SESSION["sess_user"]) || $_SESSION['designation'] == 'user') {?>
			<a href="index.php" class="navbar-brand" style="font-family: revalia;">UITS - Online Complaint Portal</a>
			<?php }
			else if($_SESSION['designation'] == 'superuser'){ ?>
			<a href="superuser.php" class="navbar-brand" style="font-family: revalia;">UITS - Online Complaint Portal</a>
			<?php }
			else { ?>
			<a href="tech_index.php" class="navbar-brand" style="font-family: revalia;">UITS - Online Complaint Portal</a>
			<?php } ?>

		</div>


		<ul class="nav navbar-nav navbar-right">

		<div class="dropdown">
		<?php if(isset($_SESSION["sess_user"])){?>
		    <button class="btn logout-btn dropdown-toggle" type="button"  style="" data-toggle="dropdown"><?php echo $_SESSION['sess_user'] ?>
		    <span class="caret"></span>

		    </button>
		    <ul class="dropdown-menu logout-drp">
		       <li><a href="chng_pwd.php">Change password</a></li> 
		      <li><a href="user_logout.php">Logout</a></li>
		      
		    </ul>

		 </div>
		 <?php }
		 	else{
		 ?>
		<div class="none">
			<p>hola!!</p> <!-- if you have a better version, feel free to modify -->
		</div>

		<?php } ?>

		</ul>	
</nav>
