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
HeaderStart("Project BudBurst - Single Report"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->
	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">

<div id="RightColumnSpecialSection">
 <h2>Single Reports in 6 Easy Steps</h2>
       <ul class="plantgrouplinks">
      <li class="darkgreen">
        <a href="register.php"><img src="images/icons/reportStepsIcons/Register_White.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Register For An Account</p></a></li>
     <li class="darkgreen">
        <a href="choose.php"><img src="images/icons/reportStepsIcons/choosePlant.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Choose a Plant</p></a></li>
      
        <li class="darkgreen">
          <a href="#"><img src="images/icons/reportStepsIcons/downloadDatasheet.png" alt="" name="sdf" width="32" height="32" align="left" />
          <p>Download Datasheet</p></a></li>
      </ul>
        <!-- breaking this into two lists as the css as is is not allowing a second set of links in the list; Also note the images in each "button" are left aligned. This was css that i grabbed from the plant styles page. it probably should use classes and background images to place the images if we do these again in the future... but this works for the time being -->
        
         <ul class="sublinks"> <li><a href="pdfs/singlereports/Deciduous_single_report.pdf" target="_new">Deciduous Trees and Shrubs</a></li>
                    <li><a href="pdfs/singlereports/Wildflowers_single_report.pdf" target="_new"> Wildflowers</a></li>
                    <li><a href="pdfs/singlereports/Grasses_single_report.pdf" target="_new">Grasses</a></li>
                    <li> <a href="pdfs/singlereports/Evergreen_single_report.pdf" target="_new">Evergreen Trees and Shrubs</a></li>
                    <li> <a href="pdfs/singlereports/Conifers_single_report.pdf" target="_new">Conifers</a></li>
                    </ul>
       
        <ul  class="plantgrouplinks">
        <li class="darkgreen">
          <a href="help_describeitsenvironment.php"><img src="images/icons/reportStepsIcons/selectSite.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Locate / Describe Site</p></a></li>
        <li class="darkgreen">
        <a href="getstarted-make-single-reports.php"><img src="images/icons/reportStepsIcons/makeObs.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Make Observations</p></a></li>
        <li class="darkgreen">
        <a href="mybudburst.php"><img src="images/icons/reportStepsIcons/reportObs.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Report Observations Online</p></a></li>
      </ul>

</div>
 <div id="LeftColumnSpecialSection">
 <h1>Single Reports</h1>
   <!--<img src="images/SingleReport_collage.jpg" alt="Photos of people observing plants" width="254" height="264" align="right" />  
-->
      
      <p>Scientists have found that one time observations can  be very important to better understanding plant responses to environmental change. These Single Reports or 'status based observations' provide data on what is happening phenologically on any given day. We  developed Single Reports to encourage you to share the status of plants you encounter on a one-time basis. Single Report datasheets are available for each of our plant groups.</p>
      <p>The approach for Single Reports is  different than for the Regular Reports. Some steps are the same, but instead of  watching a plant regularly and noting the date of a phenological &lsquo;event,&rsquo; you  simply tell us the one-time status of the plant you want to report on. </p>
      <p>Now that you have the overview for Single Reports, it is time to take  your first step and register! We have lots of resources to help you along the way. If you have any questions, please contact the Project BudBurst team at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
 </div>
        
        <br clear="all"  />   
      
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