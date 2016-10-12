<?php 

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

//fetch common name and scientific name for species selected
	$newspeciesid = $_POST['newspeciesid'];
	$result_plantNames = get_plant($dbh, $newspeciesid);
	while($row_plantName = $result_plantNames->fetch_object()) 
	{
			$commonName = $row_plantName->Common_Name;
			$scientificName = $row_plantName->Species;
	}
	
	//fetch plant group from species selected
	$result_plantGroupId = get_plant_group_ID($dbh, $newspeciesid);
	$plantGroupSet=get_plant_group($dbh,$result_plantGroupId);
	$plantGroupRow=$plantGroupSet->fetch_object();
	$plantGroupName=$plantGroupRow->Plant_Group_Name;
	
	//echo results
	echo '{"plantGroupName":"' . $plantGroupName;
	echo '", "commonName":"'.$commonName;
	echo '", "scientificName":"'.$scientificName;
	echo '"}';
?>
		
	
