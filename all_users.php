<?php include 'core/init.php';
	  include 'core/connect.php';

	  include 'includes/header.php';
	  if (!isset($_SESSION['sess_user'])) {
	  		header("Location:index.php");
	  }
	  elseif ($_SESSION['designation']!="superuser") {
	  		header("Location:no_entry.php");
	  }
	  else{
	  		include 'includes/navbar.php';
 ?>

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


<body>
	<div class="container-fluid">
		<div class="content">
			<input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search For Username.." style="width: 30%;">
		<?php 
			$userdata = array();
		//	$connect = mysqli_connect('localhost','root','','comp_sys');
			$query = mysqli_query($connect, "SELECT * FROM user");
			$numrows = mysqli_num_rows($query);
			if ($numrows!=0) {
				while ($row = mysqli_fetch_assoc($query)) {
					$userdata[] = $row;
				}
			}
			?>
				<table id="table" class="table table-bordered">
					<thead>
					<tr>
						<th>S. No.</th>
						<th>User ID</th>
						<th>Username</th>
						<th>Name</th>
						<th>Email</th>
						<!-- <<th>Status</th> -->
						<th>Deactivate User</th>
					</tr>
					</thead>
					<tbody>
				<?php 
					$i =1;

					foreach ($userdata as $user) {?>
						<tr>
							<td><?php echo $i;$i++.'<br>'; ?></td>
							<td><?php echo $user['user_id'].'<br>'; ?></td>
							<td><?php echo $user['username'].'<br>'; ?></td>
							<td><?php echo $user['first_name'].' '.$user['last_name'].'<br>'; ?></td>
							<td><?php echo $user['email'].'<br>'; ?></td>
							<!-- <<td id="status"><?php #if($user[active] == 1) {echo 'Active';} else{echo 'Inactive';} ?></td> -->

							<td><?php 
								if($user['active'] == 1){
									?>
								<button class="btn btn-default" id="deactivebtn" value="<?php echo $user['user_id'] ?>" onclick="deactivate(this)">Deactivate</button>
								<?php } 
								else {
									?>
								<button class="btn btn-default" id="activebtn" value="<?php echo $user['user_id'] ?>" onclick="activate(this)">Activate</button>
								
								<?php }
							

							?>
							</td>


						</tr>


					<?php

					}



				 ?>



				</tbody>

				</table>		


	</div>


</body>

 <?php } ?>

 <script>
 function activate(el){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
           		var activebtn = document.getElementById(el.id);
           		//var status = document.getElementById("status");
           		//status.innerHTML = "Active";
				//var p = document.createElement('p');
				//p.innerHTML = "Activated";
				//activebtn.parentNode.replaceChild(p, activebtn);
        		el.innerHTML = "Activated";
				el.id = "activebtn";
        	}
   		};
		xmlhttp.open("GET","user_activate.php?q="+el.value,true);
		xmlhttp.send();
	}

function deactivate(el){
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
				var deactivebtn = document.getElementById(el.id);
				//var status = document.getElementById("status");
				//status.innerHTML = "Inactive";
				//var p = document.createElement('p');
				//p.innerHTML = "DeActivated";
				//deactivebtn.parentNode.replaceChild(p, deactivebtn);
				el.innerHTML = "De-activated";
				el.id = "deactivebtn";
        	}
   		};
		xmlhttp.open("GET","user_deactivate.php?q="+el.value,true);
		xmlhttp.send();
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

function filterTable() {
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("table");
	  tr = table.getElementsByTagName("tr");

	  for (i = 0; i < tr.length; i++) {
	  	td1 = tr[i].getElementsByTagName("td")[2];
	    //td2 = tr[i].getElementsByTagName("td")[4];
	    if (td1) {
	      if (td1.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
	}



</script>