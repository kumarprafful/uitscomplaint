<?php 
	include 'includes/header.php';
	include 'core/init.php';
	include 'core/connect.php';
	
	if (!isset($_SESSION["sess_user"])) {
		header("Location: no_entry.php");
	}
	elseif ($_SESSION['designation'] != "superuser") {
		header("Location: no_entry.php");
	}
else{
 ?>
<body id="index">
<div class="container-fluid">
<div class="main-container">
<header>
  <div class="header">
     <h1>Welcome To UITS Complaint Portal</h1><br>
  </div>
</header>
<h3 style="text-align: center">Hello, <?php echo $_SESSION['sess_user'] ?></h3><br>
<?php
	//pending complaints
	$query1 = mysqli_query($connect,"SELECT COUNT(*) FROM `complaint` WHERE `active` = 1 AND `feedback` IS NULL");
	$a = mysqli_result($query1);
	//rebound complaints
	$query2 = mysqli_query($connect,"SELECT count(*) FROM `complaint` WHERE `active` = 1 AND `feed_active` = 1 AND `feedback` IS NOT NULL ");
	$b = mysqli_result($query2);
	//waitlist :- complaints which are solved by technicians and are with users to give their feedback
	$queryw = mysqli_query($connect,"SELECT count(*) FROM `complaint` WHERE `active` = 0 AND `feed_active` = 1 ");
	$w = mysqli_result($queryw);
	//all solved complaints
	$query3 = mysqli_query($connect, "SELECT count(*) FROM `complaint` WHERE `active` = 0 AND `feed_active` = 0 ");
	$c = mysqli_result($query3);
	//all users which are deactivated
	$query4 = mysqli_query($connect,"SELECT count(*) FROM `user` WHERE `active`=0");
	$d = mysqli_result($query4);
	//all technicians which are deactivated
	$query5 = mysqli_query($connect,"SELECT count(*) FROM `technician`  WHERE `active`=0");
	$e = mysqli_result($query5);

?>


<a href="tech_dashboard.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">All Pending Complaints</button></a>
<div class="superscript"><?php echo $a;?></div>
<a href="rebound_complaints.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Rebound Complaints</button></a>
<div class="superscript"><?php echo $b; ?></div>
<a href="waitlist.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Waitlist</button></a>
<div class="superscript"><?php echo $w; ?></div>

<a href="solved_complaints.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">All Solved Complaints</button></a>
<div class="superscript"><?php echo $c; ?></div>
<br>
<a href="all_users.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">All Users</button></a>
<div class="superscript"><?php echo $d; ?></div>

<a href="all_technicians.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">All Technicians</button></a>
<div class="superscript"><?php echo $e; ?></div>

<a href="tech_logout.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Logout</button></a>


</div>
</div>
</body>

<?php } ?>

<script type="text/javascript">
	function time_machine(){
  alert("Hello world");
}


//setInterval(time_machine(),2000);
</script>