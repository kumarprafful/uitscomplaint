<?php
 include'core/init.php'; 
 include'includes/header.php';
 include 'core/connect.php';

 ?>
<?php
if (!isset($_SESSION["sess_user"]) || $_SESSION["designation"] != "user") {
		header("Location: no_entry.php");
	}
else {
?>
<div class="container-fluid">
<?php include 'includes/navbar.php' ?>
<div class="content">
<?php 
	$log_user = $_SESSION['sess_user'];
	
	//$connect = mysqli_connect('localhost','root','','comp_sys');
	$query1 = mysqli_query($connect, 'SELECT * FROM `complaint`');
	$comp_data = array();
	$numrows = mysqli_num_rows($query1);
		if ($numrows!=0) {
			while($row = mysqli_fetch_assoc($query1)) {
				$comp_data[] = $row;
			}
		}
		?>
		<div class="container-fluid">
		<div class="table-container">

		<table class="table table-bordered" id="table">
			<thead>
				<tr>
					<th>S.NO.</th>
					<th>Date/Time</th>
					<th>Room NO.</th>
					<th>Details</th>
					<th>Type</th>
					<th>Machine Name</th>
					<th>Preferred Time</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
		<?php
		$i =0;
		foreach (array_reverse($comp_data) as $comp) {
			if($comp['user_name'] == $_SESSION["sess_user"]) {
				?>
				<tr>
				<td><?php echo ++$i ?></td>
				<td><?php $date = $comp['date'];  echo date('d/m/Y / h:i a' , strtotime($date));  ?></td>
				<td><?php echo $comp['block_room'].'<br>'; ?></td>
				<td><?php echo $comp['details'].'<br>'; ?></td>
				<td><?php echo $comp['comp_type'].'<br>'; ?></td>
				<td><?php echo $comp['mac_name'].'<br>'; ?></td>
				<td><?php echo $comp['preferred_time'].'<br>'; ?></td>
				<td><?php if ($comp['active']==1) {
					echo "In Process";
				}
				else{
					echo "Done";
				}
				 ?></td>
				
				</tr>
			<?php 
			}

		}

		?>
		</tbody>
		</table>
		</div>

		<div id="feedback-container" class="feedback-container">


		<?php
			$k=1;$j=1;
		 foreach ($comp_data as $key=>$comp) {

			
		if ($comp['active']==0 && $comp['feed_active']==1) { ?>
		<div id="feedback-section" class="feedback-section">
		<div id="hide">
			<h2>Your complaint about <div class="yellow"><?php echo $comp['comp_type'] ?></div> dated <div class="yellow"><?php echo date('d/m/Y', strtotime($date)); ?></div> has been solved.</h2>
			<button id="smile" value="<?php echo $comp['comp_id']; ?>"  onclick="user_happy(this)" class="smile feedback-button"><img src="images/smile_1-64.png" draggable="false"></button>
			
			<button id="angry" onclick="user_angry(this)" class="feedback-button"><img src="images/angry-64.png" draggable="false"></button>
			<div id="feedback_div" class="feedback_div">
					<form>
						<input id="remark_input" class="" type="text" name="feedback" placeholder="feedback" onkeydown="noSpace(this,event)">
						<input readonly class="disable btn btn-sm btn-success" id="remark_submit" alt="<?php echo $comp['comp_id'] ?>" value="Submit" onclick="user_remarks(this)" >
					</form>
			</div>

		</div>
		</div>



		<?php }} ?>
			



		</div>
	
<?php } ?>
<script type="text/javascript">

/*
function time_machine(el){
	xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var solved = document.getElementById(el.id);
           		el.parentNode.style.visibility = "hidden";
           		el.parentNode.parentNode.innerHTML="Your feedback has been recorded. KINDLY REFRESH THE PAGE.";
				el.id = "smile";
				//el.parentNode.parentNode.remove(el);

        	}
   		};
		xmlhttp.open("GET","solve.php?p="+el.value,true);
		xmlhttp.send();
	}

var s = document.getElementById("smile");

var now = new Date();
var millisTill3 = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 3, 0, 0, 0) - now;
if (millisTill3 < 0) {
     millisTill3 += 86400000; // 4 days 345600000
}
setTimeout(time_machine(s), 4000);
	

//setInterval(function(){ time_machine(s) } , 3000);
//setTimeout(function(){ alert("Hello"); }, 3000);
*/




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



function user_angry(el){
    el.nextElementSibling.style.visibility ="visible";

	}
function user_remarks(el){
		var arr = document.querySelectorAll("#remark_input");
		var user_remarks = "";
		var i;
		for(i=0; i < arr.length; i++){
			if(arr[i].value != ""){
				user_remarks = arr[i].value;
			}
		}
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var remark_submit = document.getElementById("el.id");
				var g = document.getElementById("hide");
           		var p = document.getElementById("feedback-section");
           		el.parentNode.parentNode.style.visibility = "hidden";
           		//p.style.display = "none";
           		el.parentNode.parentNode.parentNode.innerHTML="Your feedback has been recorded. KINDLY REFRESH THE PAGE.";
				
				el.id = "remark_submit";
        	}
   		};
		xmlhttp.open("GET","solve.php?w=" + el.alt + "&urem=" + user_remarks,true);
		//xmlhttp.open("GET","comp_solve.php?q="+el.value,true);

		xmlhttp.send();
	}
 

//user happy

function user_happy(el){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var solved = document.getElementById(el.id);
           		el.parentNode.style.visibility = "hidden";
           		el.parentNode.parentNode.innerHTML="Your feedback has been recorded. KINDLY REFRESH THE PAGE.";
				el.id = "smile";
        	}
   		};
		xmlhttp.open("GET","solve.php?q="+el.value,true);
		xmlhttp.send();
	}

	
/*pagination*/

// get the table element
var $table = document.getElementById("table"),
// number of rows per page
$n = 5,
// number of rows of the table
$rowCount = $table.rows.length,
// get the first cell's tag name (in the first row)
$firstRow = $table.rows[0].firstElementChild.tagName,
// boolean var to check if table has a head row
$hasHead = ($firstRow === "TH"),
// an array to hold each row
$tr = [],
// loop counters, to start count from rows[1] (2nd row) if the first row has a head tag
$i,$ii,$j = ($hasHead)?1:0,
// holds the first row if it has a (<TH>) & nothing if (<TD>)
$th = ($hasHead?$table.rows[(0)].outerHTML:"");
// count the number of pages
var $pageCount = Math.ceil($rowCount / $n);
// if we had one page only, then we have nothing to do ..
if ($pageCount > 1) {
    // assign each row outHTML (tag name & innerHTML) to the array
    for ($i = $j,$ii = 0; $i < $rowCount; $i++, $ii++)
        $tr[$ii] = $table.rows[$i].outerHTML;
    // create a div block to hold the buttons
    $table.insertAdjacentHTML("afterend","<div id='buttons'></div>");
    // the first sort, default page is the first one
    sort(1);
}

// ($p) is the selected page number. it will be generated when a user clicks a button
function sort($p) {
    /* create ($rows) a variable to hold the group of rows
    ** to be displayed on the selected page,
    ** ($s) the start point .. the first row in each page, Do The Math
    */
    var $rows = $th,$s = (($n * $p)-$n);
    for ($i = $s; $i < ($s+$n) && $i < $tr.length; $i++)
        $rows += $tr[$i];
    
    // now the table has a processed group of rows ..
    $table.innerHTML = $rows;
    // create the pagination buttons
    document.getElementById("buttons").innerHTML = pageButtons($pageCount,$p);
    // CSS Stuff
    document.getElementById("id"+$p).setAttribute("class","active");
}


// ($pCount) : number of pages,($cur) : current page, the selected one ..
function pageButtons($pCount,$cur) {
    /* this variables will disable the "Prev" button on 1st page
       and "next" button on the last one */
    var $prevDis = ($cur == 1)?"disabled":"",
        $nextDis = ($cur == $pCount)?"disabled":"",
        /* this ($buttons) will hold every single button needed
        ** it will creates each button and sets the onclick attribute
        ** to the "sort" function with a special ($p) number..
        */
       
        $buttons = "<input type='button1' value='&lt;&lt; Prev' onclick='sort("+($cur - 1)+")' "+$prevDis+" readonly>";
    for ($i=1; $i<=$pCount;$i++)
        $buttons += "<input type='button' id='id"+$i+"'value='"+$i+"' onclick='sort("+$i+")'>";
    $buttons += "<input type='button' value='Next &gt;&gt;' onclick='sort("+($cur + 1)+")' "+$nextDis+" readonly>";
    return $buttons;

}

</script>