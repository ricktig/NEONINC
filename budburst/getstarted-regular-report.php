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
HeaderStart("Project BudBurst - BudBurst Observer"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed


//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
  <!--  <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->
	
	<?php	
		WriteTopNavigation();
	?>
    
    <div id="MainContent">
      <div id="RightColumnSpecialSection">
      <h2>Regular Reports in 6 Easy Steps</h2>
      <ul class="plantgrouplinks">
      <li class="darkgreen">
        <a href="register.php"><img src="images/icons/reportStepsIcons/Register_White.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Register For An Account</p></a></li>
     <li class="darkgreen">
        <a href="choose.php"><img src="images/icons/reportStepsIcons/choosePlant.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Choose a Plant</p></a></li>
      
        <li class="darkgreen">
          <a href="getstarted-download-datasheet.php"><img src="images/icons/reportStepsIcons/downloadDatasheet.png" alt="" name="sdf" width="32" height="32" align="left" />
  <p>Download Datasheet</p></a></li>
              <li class="darkgreen">
          <a href="help_describeitsenvironment.php"><img src="images/icons/reportStepsIcons/selectSite.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Locate / Describe Site</p></a></li>
        <li class="darkgreen">
        <a href="getstarted-make-regular-reports.php"><img src="images/icons/reportStepsIcons/makeObs.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Make Observations</p></a></li>
        <li class="darkgreen">
        <a href="mybudburst.php"><img src="images/icons/reportStepsIcons/reportObs.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Report Observations Online</p></a></li>
      </ul>
      
     </div>
      <div id="LeftColumnSpecialSection">
      
      <h1>Regular Reports</h1>
      <!-- <img src="images/RegularObs_collage.jpg" alt="Photos of people observing plants" width="254" height="264" align="right" />  
        -->
      <p>The most valuable phenology information for scientists is when people make regular observations at specified sites on the same plants or group of plants from year to year. Regular Reports are a type of  event-based monitoring and are the backbone of data that help us better understand change. This is what Project BudBurst is all about.</p>
      <p>Project BudBurst supports individuals or groups in making regular observations of a plant or plants in their local area. As a participant, you might observe a plant that is in your backyard, neighborhood, school, workplace, or you may want to observe a  plant that you find on your daily walk. </p>
      <h2>What  does &lsquo;Regular Report&rsquo; mean?</h2>
      <p>When your plant is active, you'll want to check it a few times a week and watch for the <strong>date</strong> when it to   reaches one of the phenological events as identified on the Regular Report datasheet. This is what is referred to as event-based monitoring. Phenological events of interest focus on various stages of leafing, flowering and fruiting. If you miss a phenophase or two (for example, if you're away from home when it occurs) that's okay. Just record as many of the phenophases for your plant that you do observe.</p>
      <p>Now that you have the overview for Regular Reports, it is time to take  your first step and register! We have lots of resources to help you along the way. If you have any questions, please contact the Project BudBurst team at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
      
      </div>

      <br style="clear:both; display:block;" />

      
     
      </div>
      
      <!-- MainContent -->

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