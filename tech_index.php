<?php 
ob_start();
 include'core/init.php'; 
 include'includes/header.php';
 include 'core/connect.php';
 ?>

 <body id="index">
 <div class="container-fluid">
 <div class="main-container-tech">
 

<header>
  <div class="header">
     <h1>Welcome To UITS Complaint Portal</h1><br><br>
  </div>
</header>
 <?php
 if (!isset($_SESSION["sess_user"]) || $_SESSION['designation'] == "user") {
   
 ?>

<br><br>
<div class="container">
  <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" action="" method="post">
            <div class="form-group">
              <label style="color:#1f2533" for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" onkeydown="noSpace(this,event)" placeholder="Enter Username" name="username"><br>
            </div>
            <div class="form-group">
              <label style="color:#1f2533" for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" onkeydown="noSpace(this,event)" name="password"><br>
            </div>
              <input type="submit" name="submit" value="Log in" class="log-in-btn btn btn-success btn-block">
          </form>
        </div>
        <div class="modal-footer">
          <p>Not a member? <a href="user_register.php">Sign Up</a></p>

        </div>
      </div>
      
    </div>
  </div> 
</div>

<h3>OR</h3><br>
<a href="tech_register.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Register</button></a><br>

</div>
</div>
<script>
  $(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>
</body>

<?php 


if (isset($_POST["submit"])){
  if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    //$username = strtolower($username);
    $password1 = mysqli_real_escape_string($connect, $_POST['password']);
    $password = md5($password1);
    //$connect = mysqli_connect('localhost','root','','comp_sys');
    $query = mysqli_query($connect, "SELECT * FROM technician WHERE username = '".$username."' AND password='".$password."' ");
    $numrows = mysqli_num_rows($query);
    if ($numrows!=0) {
      while($row = mysqli_fetch_assoc($query)){
        $dbusername = $row['username'];
        $dbpassword = $row['password'];
        $dbdesignation = $row['designation'];
        $dbactive = $row['active'];
      }
      if ($dbactive != 1) {
        ?>
          <h1 style="color: #fff; text-align: center;" class="deactivat-msg">Your account is deactivated! Kindly contact UITS office.</h1>
          
        <?php
      }
      else if ($username == $dbusername && $password == $dbpassword) {
        //session_start();
        $_SESSION['sess_user'] = $username;
        $_SESSION['designation'] = $dbdesignation;
        $_SESSION['active'] = $dbactive;
        //redirect
        if($dbdesignation == 'superuser'){
          header("Location: superuser.php");
          exit();
        }
        else
  header("Location: tech_index.php");
  exit();
        }
  }
      else{?>
          <h1 style="color:#fff; text-align: center;" class="deactivat-msg">Wrong username and password combination! Please try again.</h1>
        
  <?php }
  }
    else{
      echo "Required all fields";
  }
}


}

else {
?>
<br><br><br>  

<?php
  $desig= $_SESSION['designation'];
  //pending complaints
  $pc = mysqli_query($connect,"SELECT count(*) FROM `complaint` WHERE `comp_type` = '".$desig."' AND `active` = 1 AND `feed_active` = 1 AND `feedback` IS NULL ");
  $a = mysqli_result($pc);
  //rebound complaints
  $rc = mysqli_query($connect,"SELECT count(*) FROM `complaint` WHERE `comp_type` = '".$desig."' AND `active` = 1 AND `feed_active` = 1 AND `feedback` IS NOT NULL ");
  $b = mysqli_result($rc);
  //waitlist
  $wl = mysqli_query($connect,"SELECT count(*) FROM `complaint` WHERE `comp_type` = '".$desig."' AND `active` = 0 AND `feed_active` = 1 ");
  $w = mysqli_result($wl);
  //solved complaints
  $sc = mysqli_query($connect,"SELECT count(*) FROM `complaint` WHERE `comp_type` = '".$desig."' AND `active` = 0 AND `feed_active` = 0 ");
  $c = mysqli_result($sc);

?>

<div class="container">
     <h3>Hello <?php echo $_SESSION['sess_user']; ?> </h3>

  <a href="tech_dashboard.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Pending Complaint</button></a>
  <div class="superscript"><?php echo $a; ?></div>

  <a href="rebound_complaints.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Rebound Complaint</button></a>
  <div class="superscript"><?php echo $b; ?></div>

  <a href="waitlist.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Waitlist</button></a>
  <div class="superscript"><?php echo $w; ?></div>


  <a href="solved_complaints.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Solved Complaints</button></a>
  <div class="superscript"><?php echo $c; ?></div>


  <a href="tech_logout.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Logout</button></a>
</div>





<?php } ?>
</html>
<script type="text/javascript">
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