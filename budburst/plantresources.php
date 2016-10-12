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
HeaderStart("Project BudBurst - Plant Resources"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="PlantResources">

<div id="wrapper">

  <div id="contentwrapper">
  	
    <!--<div><a href="index.php"><img src="images/Banner_3.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
	<?php
		WriteTopLogin($dbh);
	?>
        
    <!-- Top Navigation for Home Page -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Plant Resources</h1>
      
      <img style="float:right; padding-left:12px;" src="images/AboutProjectBudBurst/Flower1.jpg" />
      
     <h2>It's easy to pick a plant to observe!</h2>
     You can do any of the following:
     <ul>
    <li>    Learn more about plants we recommend in Plants By Group below  OR   </li><br/>
 <li>Choose a plant from our <a href="display_all_plants_list.php">Master Plant List</a> OR</li><br/>

 <li>View<a href="plantresources_list_bystate.php"> lists of plants from your state</a> that we recommend OR</li>
 <br/>
 <li>View the <a href="mostwanted.php">Project BudBurst Ten Most Wanted</a> plants OR</li>
    <br/>
    <li> Don't see a plant on our lists that you want to monitor? No problem! You can monitor any plant that you are interested in, even if it isn't on our lists, using our <a href="getstarted_budburstobserver.php">Regular Observation </a>protocol. At this time,  <a href="getstarted_occasionalobserver.php">Single Reports</a> can only be reported for Project BudBurst deciduous trees/shrubs, grasses, and wildflowers and our Special Projects species (such as Wildlife Refuge species), but we are working on making this available for other species in the near future.  <a href="pdfs/Generic-Field-Journal.pdf">Download a Generic Field Journal</a> if you are going to do Regular Observations of a species NOT on the Project BudBurst list. Check out our <a href="pdfs/How_to_enter_OTHER_plants.pdf">How to Enter &quot;Other&quot; Plants</a> guide.</li>
    </ul>
    </br>
      <h1>Plants by Group</h1>
      <p>As a Project BudBurst volunteer, you have been asked to monitor a plant throughout various stages of its life cycle and watch for several important phenophases. Phenophases are stages in a plant's life such as the first flower for the season, the first leaf, the first fruit, and more. To help you decide which plant(s) and what phenophases to monitor, we've selected many plant species and organized them into five distinct plant groups. These plants were chosen because they are easy to identify and in many cases are widespread, spanning the continental United States.</p>
      <p>Read about the plant groups below and click on a plant group to see the list of species and phenophases for that group. You can also download the <a href="pdfs/MasterPlantList.pdf" target="_new">Master Plant List</a> or check out our <a href="plantresources_list_bystate.php">plant lists by state </a>! If you do not see the species you want to monitor on our list, that's okay! You can still monitor it! We welcome the observation of any plant species for which you have access. Our  <a href="getstarted.php">Get Started! </a>resources can help you learn more about how to monitor your chosen plant(s).
<?php
      
	  $RecordSet=get_plant_groups($dbh);
	  
	  while ($Row=$RecordSet->fetch_object())
	  {
	  		$Plant_Group_ID=$Row->Plant_Group_ID;
			$Plant_Group_Name=$Row->Plant_Group_Name;
			$Definition=$Row->Definition;
			
			echo("<h2>$Plant_Group_Name</h2>");
			
			echo("<div style='margin-left:12px;'>$Definition <a href='plantresources_list.php?PlantGroupID=$Plant_Group_ID'>Check our List of $Plant_Group_Name</a>!</div>");
	  }
	  
	  ?>
      
        <br />
      
      </p>
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