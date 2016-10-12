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
HeaderStart("Project BudBurst - What's New"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>
<!--NEXT THREE LINES ADD SPACING TO THE LIST ITEMS ON THIS PAGE ONLY -->
<style type="text/css">
	li
	{
		margin-bottom:1em;
	}
</style>

<?php
//
HeaderEnd();
?>

<body>

<div id="wrapper">

 <div id="contentwrapper">
  	
    <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      <h1>What's New with the BudBurst Website</h1>
       <img src="images/71_m.jpg" width="125" height="149" style="float:right; padding-left:12px;" />
      <p>You may have noticed that Project BudBurst has a new look! We've been working diligently for several weeks to update the look and feel of the website while still maintaining the resources and materials you've come to expect. Here are just a few of the new items you might see as you explore the site:</p>
      <ul>
        <li class="whats_new">We've streamlined the <a href="getstarted.php">Get Started</a> page to help you find the resources you need<br /></li>
        <li>We've created  new and better Field Journals on our Plant Resources pages for you to record your observations on, which includes checkboxes for all of the site description information<br /></li>
        
        <li>We've developed an &quot;<a href="getstarted-single-report.php">Occasional Observations</a>" database so that you can record observations about Project BudBurst plants you see on hikes and while you travel, even if you can't visit them all season<br/></li>
        
        <li>You'll notice a fresh face on our <a href="refuges/index.php">BudBurst at the Refuges</a> pages and you'll find new BudBurst Refuge partners, the John Heinz National Wildlife Refuge (NWR) in Pennsylvania, Bosque del Apache NWR in New Mexico, and Quivira NWR in Kansas <br/></li>
       
        <li>Check out the new page for <a href="citizenscientists/index.php">Citizen Scientists</a>, linked directly from the home page<br/></li>
        <li>Explore our <a href="gardens/index.php">Botanical Gardens</a> pages and learn more about how the Chicago Botanical Garden is partnering with Project BudBurst<br/></li>
        <li>Check out the Plant Haiku of the Week on the home page. There will be new haiku's to discover throughout the year        <br/></li>
        <li>We've consolidate all of the plant lists, plants by area, phenophases, and plant group information into five easier-to-use sections in our<a href="plantresources.php"> Plant Resources </a>page<br/></li>
        <li>We also added a running stream of "Recent Reports" to the home page so that you can see what's happening with plants around the country as people report what they see       <br/>   </li>
        <li>And much, much more! Have fun exploring all of the great new features on the site and let us know what you think! Share your comments with us at <a href="mailto::budburstinfo@neoninc.org">budburstinfo@neoninc.org</a></li>
      </ul>
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