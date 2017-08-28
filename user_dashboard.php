<?php 
include 'includes/header.php';
?>
<body id="index">

 <div class="container-fluid">
 <div class="main-container">
 
<header>
  <div class="header">
     <h1>Welcome To UITS Complaint Portal</h1><br>
  </div>
</header>

<br><br><br>  
<div class="container">
  <h3 style="text-align: center">Hello, <?php echo $_SESSION['sess_user'] ?></h3><br><br>
  <a href="complaint_form.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">New Complaint</button></a>
  <a href="prev_complaints.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Previous Complaints</button></a>
  <a href="user_logout.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Logout</button></a>
  <!-- <<h4><?php// echo $chk_username;   ?></h4> -->
</div>

</div>
</div>
</body>