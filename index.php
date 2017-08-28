<?php
 include 'core/init.php'; 
 include 'includes/header.php';
 include 'core/connect.php';
?>
<body id="index">
<?php
   
   include 'includes/nav2.php';      # code...
    ?>


 <div class="container-fluid">
 <div class="main-container">
 


<?php
 if (!isset($_SESSION['sess_user']) || $_SESSION['designation'] != "user") {
  
 ?>

<header>
  <div class="header">
     <h1>Welcome To UITS Complaint Portal</h1><br>
  </div>
</header>
<h3>To file a complaint : </h3><br><br>
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
              <input type="password" class="form-control" id="psw" onkeydown="noSpace(this,event)" placeholder="Enter password" name="password"><br>
            </div>
              <input type="submit" name="submit" value="Login" class="log-in-btn btn btn-success btn-block">
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
<a href="user_register.php"><button type="button" class="btn btn-default btn-lg" id="myBtn">Register</button></a><br>

</div>
</div>
<script>
  $(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});

  function rldFunction(){
    //location.reload();
    window.location.replace("user_dashboard.php");
  }
</script>
<?php
if (isset($_POST["submit"])){
  if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password1 = mysqli_real_escape_string($connect, $_POST['password']);
    $password = md5($password1);
    //$connect = mysqli_connect('localhost','root','','comp_sys');
    $query = mysqli_query($connect, "SELECT * FROM user WHERE username = '".$username."' AND password='".$password."' ");
    $numrows = mysqli_num_rows($query);
    if ($numrows!=0) {
      while($row = mysqli_fetch_assoc($query)){
        $dbusername = $row['username'];
        $dbpassword = $row['password'];
        $dbactive = $row['active'];
      }
      if ($dbactive != 1) {
        
          echo '<h1 style="color: #fff; text-align: center;" class="deactivat-msg">Your account is deactivated! Kindly contact UITS office.</h1>';
        
      }
      else if ($username == $dbusername && $password == $dbpassword) {
        //redirect
        //header("Location:user_dashboard.php");
        $_SESSION['sess_user'] = $username;
        $_SESSION['designation'] = "user";
        $_SESSION['active'] = $dbactive;
        ?>
        <script type="text/javascript">
            document.body.innerHTML = "";
        </script>
        <?php
        include 'user_dashboard.php';
      }
    }
      else{
 
          echo '<h1 style="color:#fff; text-align: center;" class="deactivat-msg">Wrong username and password combination! Please try again.</h1>';
            }
  }
    else{
      echo "Required all fields";
  }
}


}

else {
  include 'user_dashboard.php';
}
?>

</body>

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

</html>