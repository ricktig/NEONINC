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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Results"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script src="maps/PGmapV3.js" type="text/javascript"></script>

<?php
//
HeaderEnd();
?>

<body id="Data" onload="allObs();">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_5.jpg" width="762" height="180" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Results for <?php echo $current_year; ?></h1>
      
      <h2>All Observations Reported During <?php echo $current_year; ?></h2>
      
			  <p align="left">Below you can view all observations that have been reported to Project BudBurst during <?php echo $current_year; ?>! Use  the navigation buttons on the left to zoom in/out and pan around. Click  on each place marker to get detail information about that observation. </p>

            <div id="PBBmapLegend_horizontal" style="margin: 0 0 0 100px">
         	<?php 
			//GET Plant Group information 
			
			$result_plantGroupsAll = get_plant_groups_all($dbh);
			$noPlantGroupsAll = $result_plantGroupsAll->num_rows;
			if ($noPlantGroupsAll == 0) {
					$error.='<p>Sorry, no plant groups could be found in the database.<br>
				Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with the following error:<br>results.php - no plant group information found</p>';
				}
				
				else{
					$i=0;
					while($row_plantGroupsAll = $result_plantGroupsAll->fetch_object()) {
						$plantGroupName = $row_plantGroupsAll->Plant_Group_Name;
						$i++;
						//echo $phenophaseName;
						//echo "result_num_rows" . $result->num_rows . "<br>";
						//echo "Error message = " . mysqli_error($dbh) . "<br>";
						$plantGroupID = $row_plantGroupsAll->Plant_Group_ID;
						echo '<img src="maps/icons/g' . $plantGroupID . 
								'.png" alt="' . $plantGroupID . '" width="12" height="20" /> = '. $plantGroupName ;
						echo '  ';
							//.'<br> ';
						if ($i==3)	{echo '<br>';} //add a spacer
					} //while
							
				}//else
			//echo $noPhenophasesAll;

		 ?>
		   <!-- <p>Coming soon - View latest observations by phenophase.</p>-->
         </div>
		 <!--map div-->
           <div id="PBBmap" style="width: 512px; height: 498px; margin: 5px auto 50px auto; border: 1px solid grey"></div>         
    </div><!-- MainContent -->

	<?php	
	WriteFooterNavigation();
	?>

</div> <!-- contentwrapper -->
</div> <!--wrapper -->

<?php
mysqli_close($dbh);
?>

</body>
</html>