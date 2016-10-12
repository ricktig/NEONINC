<?php
/*--------------------------------------
# Author: Dennis L. Ward (NEON)
# REVISED: 11 OCT 2012	
----------------------------------------*/

$host="localhost";
$username = "myusername";
$password = "mypassword"; 
$database = "mydatabase"; 


// connect to database using mysqli plugin for PHP
$dbh = new mysqli($host,$username,$password,$database)
	or die("Unable to connect to MySQL");
	
// check connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//Start session
session_start();
?>
