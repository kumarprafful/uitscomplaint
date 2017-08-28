<?php 
	include 'core/init.php';
	include 'includes/header.php';
	include 'core/connect.php';

	if (!isset($_SESSION["sess_user"])) {
		header("Location: tech_index.php");
	}
	elseif ($_SESSION['designation'] == "user") {
		header("Location: no_entry.php");
	}
else{
 ?>



 <style>
 	th{
 		text-align: center;
 	}
 </style>
 

 <?php include 'includes/navbar.php' ?>

 <style>
 	#myInput {
    background-image: url('images/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}
 </style>

<div class="content">
	<input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search For Complaint By/Type.." style="width: 30%;">

<?php 
	$log_user = $_SESSION['sess_user'];
	global $remarks;
	
	//$connect = mysqli_connect('localhost','root','','comp_sys');
	$query1 = mysqli_query($connect, 'SELECT * FROM `complaint`');
	
	
	//$count = mysqli_query($connect,'SELECT COUNT(comp_type) from `complaint` ');
	//$count_result = mysqli_result($count);


	$query2 = mysqli_query($connect,"SELECT `designation` FROM `technician` WHERE `username`='".$log_user."'");
	$t = mysqli_result($query2);
	$t=strtolower($t);

	$userdata = array();

//	echo $count_result;
	
	$numrows = mysqli_num_rows($query1);
		if ($numrows!=0) {
			while($row = mysqli_fetch_assoc($query1)) {
				

				 $userdata[] = $row;
			 				}
		}



		if($t == "superuser"){
			?>
			<div class="container-fluid">
			<table class="table table-bordered" id="table">
				<thead>
				<tr>
					<th onclick="sortTable(0)">S.NO.&#x25BC;</th>
					<th onclick="sortTable(1)">C. no&#x25BC;</th>
					<th onclick="sortTable(2)">Date/Time&#x25BC;</th>
					<th onclick="sortTable(3)">Complaint By&#x25BC;</th>
					<th onclick="sortTable(4)">Compaint Type&#x25BC;</th>
					<th>Room NO.</th>
					<th>Details</th>
					<th>Mobile No.</th>
					<th>Machine Name</th>
					<th>Preferred Time</th>
					<th>Mark As Solved</th>
					<th>Transfer</th>
				</tr>
				</thead>
				<tbody>
			<?php 
			$i = 1;
				foreach (array_reverse($userdata) as $user) {
					if($user['active'] == 1 && $user['feed_active'] == 1 && $user['feedback'] == NULL ){
					
					?>
					
					<tr>
						<td><?php echo $i;$i++; $_SESSION['i']=$i;?></td>
						<td><?php echo $user['comp_id']; ?></td>
						<td><?php $date = $user['date']; echo date('d/m/Y / h:i a' , strtotime($date)); ?></td>
						<td><?php $username = $user['user_name']; echo $username;  ?></td>
						<td><?php echo $user['comp_type']; ?></td>
						<td><?php echo $user['block_room']; ?></td>
						<td><?php echo $user['details']; ?></td>
						<td><?php echo $user['mobile_no']; ?></td>
						<td><?php echo $user['mac_name']; ?></td>
						<td><?php echo $user['preferred_time'];?></td>
						<td><button class="btn btn-default" data-target="#myModal" data-toggle="modal" onclick="getElementById('solvebtn').value = '<?=$user['comp_id']?>'">Solve</button>
						
					  <!-- REMARKS Modal -->
							  <div class="modal fade" id="myModal" role="dialog">
							    <div class="modal-dialog">
							    
							      <!-- REMARKS Modal content-->
							      <div class="modal-content">
							        <div class="modal-header" style="padding:35px 50px;">
							          <h4>Remarks</h4>
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							        </div>
							        <div class="modal-body" style="padding:40px 50px;">
							          <form role="form" action="" method="post" onsubmit="return validate()">
							            <input name="comp_id" type="hidden" required="false" value="<?php echo $user['comp_id'] ?>">
							              <input id="remark_input" name="remarks" class="form-control" style="width: 100% !important;" onkeydown="noSpace(this,event)" required="true">

							            
							               <!-- <button name="submit" id="solvebtn" value="<?php echo $user['comp_id'] ?>" class="disable log-in-btn btn btn-success btn-block">Done</button> -->
							                <input type="submit" id="solvebtn" value="solve" class="disable log-in-btn btn btn-success btn-block">
							          </form>
											
							        </div>

							        
							      </div>
							      
							    </div>
							  </div> </td>

						<td><button class="btn btn-default" data-target="#myModal2" data-toggle="modal" onclick="getElementById('solvebtn').value = '<?=$user['comp_id']?>'">Transfer</button>

						<!-- TRANSFER Modal -->
							  <div class="modal fade" id="myModal2" role="dialog">
							    <div class="modal-dialog">
							    
							      <!-- REMARKS Modal content-->
							      <div class="modal-content">
							        <div class="modal-header" style="padding:35px 50px;">
							          <h4>Transfer To</h4>
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							        </div>
							        <div class="modal-body" style="padding:40px 50px;">
							          <form role="form" action="" method="post">
							            <div class="form-group">
							              <select class="form-control form-text-input-dropdown" onchange="document.getElementById('transferInput').value=this.options[this.selectedIndex].text; document.index.submit();" required>
												<option value="" disabled="disabled" selected="selected" hidden="hidden">Specialisation</option>
										  	
										 		<option value="computer" >Computer</option>
										  		<option value="printer" >Printer</option>
										  		<option value="ups" >UPS</option>
										  		<option value="projector" >LCD/Projector</option>
										  		<option value="internet" >Internet/LAN</option>
										  		<option value="wifi" >Wi-Fi</option>
										 </select><br>
										 <input type="hidden" name="designation" id="transferInput" value=""><br>
							            </div>
							             <button name="submit" id="transferbtn" value="<?php echo $user['comp_id'] ?>"  onclick="transfer(this)"  class="log-in-btn btn btn-success btn-block">Done</button>
							          </form>
											
							        </div>

							        
							      </div>
							      
							    </div>
							  </div> </td>

					</tr>
					
					<?php 
				
				} 
			
			}
		?>
		</tbody>
		</table>
		 
		</div>
		<?php 
		}


		else {
		

		?>
		<div class="container-fluid">

		<table class="table table-bordered" id="table">
			<thead >
				<tr>
					<th onclick="sortTable(0)">S.NO.&#x25BC;</th>
					<th onclick="sortTable(1)">C. no&#x25BC;</th>
					<th onclick="sortTable(2)">Date/Time&#x25BC;</th>
					<th onclick="sortTable(3)">Complaint By&#x25BC;</th>
					<th onclick="sortTable(4)">Compaint Type&#x25BC;</th>
					<th>Room NO.</th>
					<th>Details</th>
					<th>Mobile No.</th>
					<th>Machine Name</th>
					<th>Preferred Time</th>
					<th>Mark As Solved</th>

				</tr>
			</thead>
			<tbody >
		



		<?php
		
		$i =1;


			//starts1
			foreach (array_reverse($userdata) as $user) {
				//echo $user[user_name].'<br>';
				//echo $user[comp_type].'<br>';

				if ( strtolower($user['comp_type'])==$t && $user['active'] == 1 && $user['feed_active'] == 1 && $user['feedback'] == NULL ) {
			
			?>
			
				<tr>
					<td><?php echo $i;$i++; ?></td>
					<td><?php echo $user['comp_id'];?></td>
					<td><?php $date = $user['date']; echo date('d/m/Y / h:i a' , strtotime($date)); ?></td>
					<td><?php $username =$user['user_name']; echo $username;  ?></td>
					<td><?php echo $user['comp_type']; ?></td>
					<td><?php echo $user['block_room']; ?></td>
					<td><?php echo $user['details']; ?></td>
					<td><?php echo $user['mobile_no']; ?></td>
					<td><?php echo $user['mac_name']; ?></td>
					<td><?php echo $user['preferred_time'];?></td>
					<td><button class="btn btn-default"  data-target="#myModal" data-toggle="modal" onclick="getElementById('solvebtn').value = '<?=$user['comp_id']?>'">Solve</button>
					  <!-- Modal -->
							  <div class="modal fade" id="myModal" role="dialog">
							    <div class="modal-dialog">
							    
							      <!-- Modal content-->
							      <div class="modal-content">
							        <div class="modal-header" style="padding:35px 50px;">
							          <h4>Remarks</h4>
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							        </div>
							        <div class="modal-body" style="padding:40px 50px;">
							          <form role="form" action="" method="post" id="c_solve">
							          	
							          	  <input name="comp_id" type="hidden" required="false" value="<?php echo $user['comp_id'] ?>">
							              <input id="remark_input" name="remarks" class="form-control" style="width: 100% !important;" onkeydown="noSpace(this,event)" required="true">

							            
							               <!-- <button name="submit" id="solvebtn" value="<?php echo $user['comp_id'] ?>" class="disable log-in-btn btn btn-success btn-block">Done</button> -->
							                <input type="submit" id="solvebtn" value="solve" class="disable log-in-btn btn btn-success btn-block">
							          </form>
							        </div>

							        
							      </div>
							      
							    </div>
							  </div> </td>
				</tr>
				<?php 
				}
			

			}//ends1
		
		?>
		</tbody>
		</table>


		</div>
		 					  
<?php } } ?>

</div>	



















<script>
function noSpace(el,event){
	var a = el.value;
	if (a[0] === " ") {
		alert("Spaces are not allowed as the first character");
		el.value="" ;
	}


  if (el.value.length === 0 && event.which === 32){
    event.preventDefault();
  }
  if (el.value.length != 0  && event.which != 32) {
    el.nextElementSibling.classList.remove("disable");
  }
  if (el.value.length === 1) {
    el.nextElementSibling.classList.add("disable");
  }
  if (el.value.length === 0 && event.which === 13){
  	event.preventDefault();
  }
}



	function solve(el){
		var arr = document.querySelectorAll("#remark_input");
		var remarks = "";
		var i;
		for(i=0; i < arr.length; i++){
			if(arr[i].value != ""){
				remarks = arr[i].value;
			}
		}
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var solvebtn = document.getElementById("el.id");
				/*var p = document.createElement("p");
				p.innerHTML = "Solved";*/
				//solvebtn.parentNode.replaceChild(solvebtn);
				document.getElementById("test");
				test.innerHTML = remarks.toString();
				el.id = "solvebtn";
        	}
   		};
		xmlhttp.open("GET","comp_solve.php?q=" + el.value + "&rem=" + remarks,true);
		//xmlhttp.open("GET","comp_solve.php?q="+el.value,true);

		xmlhttp.send();
	}

	$(document).ready(function(){
		$("#c_solve").submit(function(event){
			event.preventDefault();

			var $form = $(this);

			var serialized_data = $form.serialize();

			$.ajax({
				url: "/complaint/comp_solve.php",
				type: "post",
				data: serialized_data
			});

			location.reload();

		});
	});


	function transfer(el){
		var arr = document.querySelectorAll("#transferInput");
		var specialisation = "";
		var i;
		for(i=0; i < arr.length; i++){
			if(arr[i].value != ""){
				specialisation = arr[i].value;
			}
		}
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var solvebtn = document.getElementById("el.id");
				/*var p = document.createElement("p");
				p.innerHTML = "Solved";*/
				//solvebtn.parentNode.replaceChild(solvebtn);
				/*document.getElementById("test");
				test.innerHTML = remarks.toString();*/
				el.id = "transferbtn";
        	}
   		};
		xmlhttp.open("GET","comp_transfer.php?q=" + el.value + "&sp=" + specialisation,true);
		//xmlhttp.open("GET","comp_solve.php?q="+el.value,true);

		xmlhttp.send();
	}
/*
	function passRemarks(rm){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var remarks = document.getElementById("rm.id");
				var p = document.createElement("p");
				p.innerHTML = "Solved";
				//solvebtn.parentNode.replaceChild(solvebtn);
				rm.id = "remarks";
        	}
   		};
		xmlhttp.open("GET","comp_solve.php?r="+rm.value,true);
		xmlhttp.send();
	}
*/

	function filterTable() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("table");
	  tr = table.getElementsByTagName("tr");

	  for (i = 0; i < tr.length; i++) {
	  	td1 = tr[i].getElementsByTagName("td")[3];
	    td2 = tr[i].getElementsByTagName("td")[4];
	    if (td1 || td2) {
	      if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
	}


	function sortTable(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	  table = document.getElementById("table");
	  switching = true;
	  //Set the sorting direction to ascending:
	  dir = "asc"; 
	  /*Make a loop that will continue until
	  no switching has been done:*/
	  while (switching) {
	    //start by saying: no switching is done:
	    switching = false;
	    rows = table.getElementsByTagName("tr");
	    /*Loop through all table rows (except the
	    first, which contains table headers):*/
	    for (i = 1; i < (rows.length - 1); i++) {
	      //start by saying there should be no switching:
	      shouldSwitch = false;
	      /*Get the two elements you want to compare,
	      one from current row and one from the next:*/
	      x = rows[i].getElementsByTagName("td")[n];
	      y = rows[i + 1].getElementsByTagName("td")[n];
	      /*check if the two rows should switch place,
	      based on the direction, asc or desc:*/
	      if (dir == "asc") {
	        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
	          //if so, mark as a switch and break the loop:
	          shouldSwitch= true;
	          break;
	        }
	      } else if (dir == "desc") {
	        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
	          //if so, mark as a switch and break the loop:
	          shouldSwitch= true;
	          break;
	        }
	      }
	    }
	    if (shouldSwitch) {
	      /*If a switch has been marked, make the switch
	      and mark that a switch has been done:*/
	      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
	      switching = true;
	      //Each time a switch is done, increase this count by 1:
	      switchcount ++; 
	    } else {
	      /*If no switching has been done AND the direction is "asc",
	      set the direction to "desc" and run the while loop again.*/
	      if (switchcount == 0 && dir == "asc") {
	        dir = "desc";
	        switching = true;
	      }
	    }
	  }
	}







/*pagination*/

// get the table element
var $table = document.getElementById("table"),
// number of rows per page
$n = 10,
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
    $table.insertAdjacentHTML("afterend","<div id='buttons'></div");
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
       
        $buttons = "<input type='button1' value='&lt;&lt; Prev' onclick='sort("+($cur - 1)+")' "+$prevDis+">";
    for ($i=1; $i<=$pCount;$i++)
        $buttons += "<input type='button' id='id"+$i+"'value='"+$i+"' onclick='sort("+$i+")'>";
    $buttons += "<input type='button' value='Next &gt;&gt;' onclick='sort("+($cur + 1)+")' "+$nextDis+">";
    return $buttons;

}



 </script>

 <script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>



















