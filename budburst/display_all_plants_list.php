<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/6/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/
require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Display All Project BudBurst Species"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<?php
//
HeaderEnd();
?>



<body id="PlantResources">
<div id="wrapper">
	<div id="contentwrapper">
		<!--<div><a href="index.php"><img src="images/Banner_3.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a>	</div> -->
		
		<?php
			WriteTopLogin($dbh);
		?>
			
		<!-- Top Navigation for Home Page -->

		<?php	
			WriteTopNavigation();
		?>
		
		<!--main content div-->
		<div id="maincontent">
			<h1 style="margin-left: 10px;">Project BudBurst Master Plant List</h1><!--end header div-->
			
			<!-- hold common name and scientific name of species with odd speciesid-->
			<div id="leftcolumn" style="margin: 0 0 5px 20px; float:left;width:350px;">
			<?php
			//fetch species in plant groups 1 through 5
			$i=0;
			//array to provide 'sort' order of how plant groups are displayed
			//1=wildflowers and herbs
			//2=grasses
			//3=conifers
			//4=deciduous trees and shrubs
			//5=evergreen trees and shrubs
			$sortorder=array(1,2,5,3,4);

			while ($i<5)
			{
				$PlantGroupID=$sortorder[$i];
				$PlantGroupSet=get_plant_group($dbh,$PlantGroupID);
				$PlantGroupRow=$PlantGroupSet->fetch_object();
				$PlantGroupName=$PlantGroupRow->Plant_Group_Name;
				
				//$RecordSet=get_PBBplants_in_plant_group($dbh,$PlantGroupID);
				$RecordSet=get_PBBplants_in_plant_group($dbh,$PlantGroupID);
				
				echo '<div id="greenheader"><img src="images/plantGroups/' . $PlantGroupID . 'i.png" style="margin: -6px 10px 0 10px; float:left"/>' . $PlantGroupName . '</div>';
				while($row_plants = $RecordSet->fetch_object())
				{
					$speciesid	= $row_plants->Species_ID;
					//get common and scientific name for species id
					$result_plantNames = get_plant($dbh, $speciesid);
					while($row_plantName = $result_plantNames->fetch_object())
					{
						$commonName = $row_plantName->Common_Name;
						$scientificName = $row_plantName->Species;
						//uncomment to view images
						//echo '<img src="images/' . $speciesid . '.jpg" alt="' . $commonName . '" width="50" />';
						echo '<div style="margin: 3px 0 0 0"><a href="plantresources_speciesinfo.php?speciesid='.$speciesid.'" class="maincontent">'.$commonName.'</a><span style="font-size:0.85em"> (<em>' . $scientificName.'</em>)<br /></span></div>';
					}//while common and scientific name
				}//while get plant id
				
				//if plantgroupid = 5, switch content to right column
				if ($PlantGroupID==5)
				{
					echo '</div>'; //end leftcolumn
		
					//hold common name and scientific name of species with even speciesid
					echo '<div id="rightcolumn" style="float:right; width:350px; margin:0 20px 5px 0">';
				} // end if plantgroupid = 5 switch content to right column
				
				//increment plantgroupid by 1
				$i++;
			}// end while to fetch all plant groups
		?>
			
			</div><!--end RightColumnSpecialSection-->
		
		</div> <!--end main content div-->
		<!--div to clear two column display-->
		<div style="clear:both" />
		<?php
		WriteFooterNavigation();
		?>
    
    </div><!-- End contentwrapper -->
</div> <!-- End wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>
</html>