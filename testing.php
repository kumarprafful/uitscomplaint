<?PHP 
session_start();
if (isset($_POST["usernameform"])){ 

$username = $_POST['usernameform'];
$password1 = $_POST['passwordform'];


$user_name = "XXXX";
$password = "XXXXX";
$database = "XXX";
$server = "XXXX";

$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);


$SQL = "SELECT * FROM login WHERE Username = '$username' AND Password = '$password1' "; //grab all the records from table
$result = mysql_query($SQL)
    or die("Error:" . mysql_error());

if (mysql_num_rows($result) > 0){ //if username and password match return number of rows is always 1

$_SESSION['login'] = $username; //by placing this in session it will remember this variable on the page it directs too

while ( $row = mysql_fetch_assoc($result) ){ //lays out array in $result
$_SESSION['ID'] = $row['ID']; //selects from list of array ID
$_SESSION['firstname'] = $row['First_Name'];
echo'<script> window.location="page1.php"; </script> ';

}
} else {
$_SESSION['login'] = '';
print('
<script type="text/javascript"> //place html script for alert. Use single comma for print command here.
    alert("Sorry, your username or password could not be recognized")
</script>
');
session_destroy();
}
}
?>