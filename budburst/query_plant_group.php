<?php 

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

	//fetch common name and scientific name for species selected
	$newspeciesid = $_POST['speciesid'];
	
	//fetch plant group from species selected
	$result_plantGroupId = get_plant_group_ID($dbh, $newspeciesid);

	//echo results
	echo $result_plantGroupId;
?>
		
	
