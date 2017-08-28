<?php
   

	function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}



    function check_username($username){
        $connect = mysqli_connect('localhost','root','','comp_sys');
        $q_username = mysqli_query($connect, "SELECT `username` FROM `users` WHERE `username`='".$username."'" );
        $chk_username = mysqli_result($q_username);
        return $chk_username;

    }
?>