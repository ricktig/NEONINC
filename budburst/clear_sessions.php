<?php
/*--------------------------------------
# Author: Dennis L. Ward (NEON)
# REVISED: 11 OCT 2012	
----------------------------------------*/

$host="localhost";
$username = "pbbtest1010"; // csdbmod
$password = "usw4pd4r"; // !!csdbmod314
$database = "budburst_test"; // budburst

require 'cgi-bin/db_connect.php';


// DELETE all entries older than 30 minutes
printf("Deleting... ");
mysqli_query($dbh,"DELETE FROM tbl_sessions WHERE Create_DateTime <= NOW() - INTERVAL 1 hour")
	or die(mysqli_error($dbh));  
printf("Done!");
mysqli_close($dbh);  

?>
