<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Last modified 1/9/11
# Copyright 2008-2011 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

$PlantGroupID=$_GET["PlantGroupID"];

//get plant group information (for $PlantGroupID passed into this page)
		
$PlantGroupSet=get_plant_group($dbh,$PlantGroupID);
$PlantGroupRow=$PlantGroupSet->fetch_object();
$PlantGroupName=$PlantGroupRow->Plant_Group_Name;
$Definition=$PlantGroupRow->Definition;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("BudBurst Resources - ".$PlantGroupName); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="PlantResources">

<div id="wrapper">
  
  <div id="contentwrapper">
  
  <!--  <div><a href="index.php"><img src="images/Banner_3.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation for Home Page -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <?php
		$error='';
		
		echo("<h1>$PlantGroupName</h1>");
		
		echo("<div style='width:435px; background-color:transparent; margin-right:10px; float:left;'>");
			
		//get plant list (for $PlantGroupID passed into this page)
		
		$RecordSet=get_PBBplants_in_plant_group($dbh,$PlantGroupID);
		
		$noPlantsInGroup=$RecordSet->num_rows;
		if ($noPlantsInGroup==0)
		{
			$error.='<p>Sorry, no plants found in plant group in the database.<br>
					Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> 
					with the following error:<br>plantlist.php - no plants found in plant group</p>';
		}
		else
		{
		?>
		We have identified <b><?php echo($noPlantsInGroup);?> <?php echo($PlantGroupName);?></b> that are easy to identify and widespread across the continental United States.
				<p>Click on the plant names below for a printable Identification Guide and Regular Report Datasheet that include pictures, identifying characteristics, and plant specific phenophase descriptions.</p>
				<p>
				  <?php
					echo '<table width="456" border="0" cellpadding="1">
						<tr>';
						;
						while($row_plants = $RecordSet->fetch_object() ) {
							$speciesid	= $row_plants->Species_ID;
							//get common and scientific name for species id
							$result_plantNames = get_plant($dbh, $speciesid);
							while($row_plantName = $result_plantNames->fetch_object() ) {
									$commonName = $row_plantName->Common_Name;
									$scientificName = $row_plantName->Species;
									echo '<td width="10%" align="left"><img src="images/' . $speciesid . '.jpg" alt="' . $commonName . 
											'" width="50" /></td>';
									echo '<td width="80%"  align="left"><p><a href="plantresources_speciesinfo.php?speciesid='.$speciesid.'" class="maincontent">'.$commonName.'</a> (<em>' . $scientificName.'</em>)</p></td></tr>';
							}//while common and scientific name
						}//while get plant id
						echo '</table>';
					}//else
				//}//for each plant group
	echo $error;
	
	echo("</div>");
	?>
				  <!-- **************** Phenophase sidebar for each plant group **************** -->
    
    <?php
    echo("<div id='Phenophases'>");
      	echo("<div id='Phenophases_Header'>Phenophases</div>");
        echo("<div id='SectionContainer'>");
            
			$result_phenophases=get_phenophase_plant_group($dbh,$PlantGroupID);
			while($row_phenophases=$result_phenophases->fetch_object())
			{
				$PhenophaseID=$row_phenophases->Phenophase_ID;
				$PhenophaseName=$row_phenophases->Phenophase_Name;
				$PhenophaseComment=$row_phenophases->Comment;
				
				//prepare variables needed:
				//$PhenophaseAnchor=str_replace(" ", "_",$PhenophaseName);
				
				//display
				
				echo("<h2>".$PhenophaseName." </h2>");
				
				echo("<img src='images/Phenophase_Icons/$PlantGroupID/$PhenophaseID.png' width='40' height='40' style='float:left; padding-right:6px;' />");
				
				echo("<div style='margin-left:2px;'>$PhenophaseComment</div>");
				
				//echo '<a name="'.$phenophaseAnchor.'_'.$plantGroupIDArr[$i].'" 
				//id ="'.$phenophaseAnchor.'_'.$plantGroupIDArr[$i] .' "></a><strong>' . $phenophaseName . '</strong> : ' . $phenophaseComment . ' <br><br>';
				
			}//while
			
			echo("<br />");
			
        echo("</div>");
    echo("</div>");
    ?>
    
    <br style="clear:both;" />
    </div><!-- MainContent -->

	<?php	
	WriteFooterNavigation();
	?>

</div> <!-- contentwrapper -->
</div> <!--wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>