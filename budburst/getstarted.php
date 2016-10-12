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
      <h2>Join the Project BudBurst community!</h2>
      <p>I am able to adopt at least one plant and make regular reports:</p>
      <ul class="plantgrouplinks">
        <li class="darkgreen">
        <a href="getstarted-regular-report.php"><img src="images/icons/reportStepsIcons/makeObs.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Learn About Regular Reports</p></a></li>
      </ul>
      <p>You can count on me for single reports:</p>
      <ul class="plantgrouplinks">
        <li class="darkgreen">
        <a href="getstarted-single-report.php"><img src="images/icons/reportStepsIcons/makeObs.png" alt="" name="sdf" width="32" height="32" align="left" />
        <p>Learn About Single Reports</p></a></li>
      </ul>
</div>
      <div id="LeftColumnSpecialSection">
      
      <h1>Getting Started!</h1>
      <p>Every plant tells a story. Whether you have an afternoon, a few weeks, a season, or a whole year, you can make an important contribution to better understand changing climates in your area. Our web site provides everything you need to get outside, make reports, and share what you find with others. Sign up and start making Project BudBurst observations today. We are looking forward to learning more about the stories your plants can tell.</p>
      <h2>Regular Reports</h2>
      <p>Simply register, select a plant(s), make regular observations of your plants throughout the seasons and submit your data. By choosing this approach, you benefit from having permanent site records that can be compared from year to year. </p>
       
       <h2>Single Reports</h2>
      <p> If you are traveling, planning a hike,  or can't make regular visits to a site, Single Reports may be the right approach for you. Register, select a plant, make a one-time observation of your plant, and submit your data.<br style="clear:both;" />
      </p>
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