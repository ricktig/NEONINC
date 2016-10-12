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
HeaderStart("Contact Project BudBurst"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_2.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
        WriteTopLogin($dbh);
    ?>
    
    <!-- Top Navigation -->
	
	<?php	
		WriteTopNavigation();
	?>
    
    <div id="MainContent">
      <h1>What's New with the Website</h1>
  
      <p> You may have noticed some new changes to the website. We've been working diligently behind-the-scenes to create a more streamlined and easier to navigate Project BudBurst experience for you. We hope you like the changes and as always, contact us at <a href = "mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a> if you have any questions or suggestions.</p>
      <p>Here is a sampling of the changes you might see:
      <ul>
      <li>A streamlined top navigation bar, with new buttons for <a href="partnerGroups_index.php">Partners</a> and <a href="educators/index.php">Educators</a>, and a new <a href="science/phenology.php">Science</a> section (formerly &quot;Phenology&quot;)</li>
      <br/>
      <li>New mapping tools in the data entry screens to make it easy to find your latitude and longitude coordinates</li><br/>
      <li>Improved <a href="getstarted.php">Get Started</a> pages, including 6 easy steps to making Regular Reports and Single Reports</li><br/>
      <li>A new  <a href="choose.php">Choose a Plant</a> section (formerly Plant Resources) complete with a search box to make it easy to find Project BudBurst plants, including Partner plant species</li><br/>
      <li> A new phenophase, <a href="plantresources_list.php?PlantGroupID=3">bud burst</a>, for Deciduous Trees and Shrubs, to capture this important plant event (our namesake!)</li>  <br/>
      
      <li>Revised and enhanced resources for <a href="educators/index.php">formal and informal educators</a></li>
    
      </ul>
  <p> And much, much, more. Of course the work is never done and we are constantly adding new content and improving  resources we already have, so watch for more improvements throughout the year. </p>
  
 
 <!--</div>
 </div>
 </div>-->
         
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