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
HeaderStart("About Project BudBurst"); // The first and only parameter is the page title
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
      <h1> Project BudBurst Photos and Logos</h1>
             <h2>Logos</h2>
     <p>Please share Project BudBurst with your community by  downloading and using any of the following logos. Please do not alter this logo  in any way (except for resizing with aspect ratio constrained) without first  contacting us at <a class="maincontent" href="mailto:budburstweb@neoninc.org">budburstweb@neoninc.org</a>. If you need specific dimensions or  resolution, please simply contact the Web manager.</p>
		    <p><img src="images/PBBlogo_transparent_URL_mini.gif" alt="logo with URL" width="250" height="48" /></p>
		    <p>Transparent Background with URL:<br />
              <a href="images/PBBlogo_transparent_URL_lr.gif" class="maincontent">Low resolution</a> (gif)<br />
 <a href="images/PBBlogo_transparent_URL_hr.gif" class="maincontent">High resolution</a> (gif)</p>
		    <p>White Background with URL:<br />
 <a href="images/PBBlogo_white_URL_lr.jpg" class="maincontent">Low resolution</a> (jpg)<br />
 <a href="images/PBBlogo_white_URL_hr.jpg" class="maincontent">High resolution</a> (jpg)</p>
		   
		    <p>Design by Kirsten K. Meymaris, UCAR.</p>
     <h2> Photos </h2>
 <p> You have permission to use the following photos to accompany your news articles, provided that you provide appropriate credit as listed with each photo. 
 <p>Click on the thumbnails below to download the full size images. 
 <p><a href="images/ProjectBudBurst_SarahNewman.jpg"><img src="images/ProjectBudBurst_SarahNewman_thumb.jpg" alt="Project BudBurst Image 1" width="100" height="100" border="0" /></a> Photo courtesy of Sarah Newman, Project BudBurst
 <p> <a href="images/ProjectBudBurst2_DennisWard.jpg"><img src="images/ProjectBudBurst2_DennisWard_thumb.jpg" alt="Project BudBurst Image 3" width="100" height="100" border="0" /></a>   Photo courtesy of Dennis Ward, Project BudBurst
 <p><a href="images/ProjectBudBurst_CarlyeCalvin.jpg"><img src="images/ProjectBudBurst_CarlyeCalvin_thumb.jpg" alt="Project BudBurst Image 2" width="100" height="100" border="0" /></a> 
 Photo courtesy of Carlye Calvin, University Center for Atmospheric Research, Project BudBurst
 <p>  <a href="images/ProjectBudBurst2_SarahNewman.jpg"><img src="images/ProjectBudBurst2_SarahNewman_thumb.jpg" alt="Project BudBursts Image 4" width="100" height="100" border="0" /></a>Photo courtesy of Sarah Newman, Project BudBurst       
   </div><!-- End MainContent -->
	
	<?php
    WriteFooterNavigation();
    ?>
    
    </div> <!-- End contentwrapper -->
</div> <!-- End wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>