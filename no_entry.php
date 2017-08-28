
<?php 
include 'includes/header.php';
include 'includes/navbar.php';
if(isset($_SESSION["sess_user"])){
	session_destroy();
}
?>

<body style="background-color: red;">

<div class="center">
<h1>You don't have permission to access this page!!!</h1>
<h2>Will redirect you to <a href="index.php">homepage</a> in <div id="secs">5</div> seconds</h2>
</div>
</body>

<style type="text/css">
	.center{
		margin-top: 5%;
		color: white;
	}
	a:hover{
		color: orange;
		text-decoration: none;
	}
	#secs{
		display: inline;
	}
</style>

<script type="text/javascript">
	setTimeout(function(){
		window.location.href = $("a")[0].href;
	},5000);


	function timer(){
		s = 5;
		setInterval(function(){
			if(s!=0){
				var t = document.getElementById("secs");
				t.innerHTML = s;
				s=s-1;
			}
		},1000);
	}
timer();
</script>