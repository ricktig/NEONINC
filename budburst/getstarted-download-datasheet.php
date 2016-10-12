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
    <h2>Download <em>plant specific</em> Regular Report datasheets</h2>
      <ul class="sublinks">
        <li><a href="display_all_plants_list.php">Project BudBurst plant list</a></li></ul>
        <br/>
        <br/>
        <br/>
      <h2>Download <em>generic</em> Regular Report datasheets</h2>
      <ul class="sublinks">
        <li><a href="pdfs/regularreports/generic_regular_reports/Deciduous_regular_report.pdf">Deciduous Trees and Shrubs</a></li>
        <li><a href="pdfs/regularreports/generic_regular_reports/Wildflowers_regular_report.pdf">Wildflowers</a></li>
        <li><a href="pdfs/regularreports/generic_regular_reports/Grasses_regular_report.pdf">Grasses</a></li>
        <li><a href="pdfs/regularreports/generic_regular_reports/Evergreen_regular_report.pdf">Evergreen Trees and Shrubs</a></li>
        <li><a href="pdfs/regularreports/generic_regular_reports/Conifers_regular_report.pdf">Conifers</a></li>
      </ul>
      </div>
      <div id="LeftColumnSpecialSection">
      
      <h1>Download Datasheet</h1>
      <!-- <img src="images/RegularObs_collage.jpg" alt="Photos of people observing plants" width="254" height="264" align="right" />  
        -->
     <h3> Plant Specific Regular Report Datasheets</h3>
      <p>If you have chosen to monitor a plant from the <a href="display_all_plants_list.php">Project BudBurst list</a>, you can download a customized Regular Report datasheet for your plant from its species resource page. For example, let's say you'd like to monitor an Apple tree. Find Apple on the Project BudBurst list, click on it, and look for the &quot;Download Regular Report Datasheet for Apple&quot; button. </p>
      <h3>Generic Regular Report Datasheets</h3>
      <p>If you have chosen to monitor a plant not on the Project BudBurst list, you can download a generic Regular Report datasheet for that plant group from the list on the right. Either way, you will be outside monitoring your plant in no time!</p>
      <p>If you have any questions, please contact the Project BudBurst team at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
      
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