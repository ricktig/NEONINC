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
HeaderStart("Project BudBurst - What's New - Earth Day"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
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
      <h1>Celebrate Earth Day with Project BudBurst!</h1>
      
      <img src="images/WhatsNew_EarthDay_Image1.jpg" alt="Test" style="float:right; padding:6px 0px 12px 12px;" />
      
      <h2>Here are some ideas to get you started:</h2>
      
      <p>1.  Make an observation of your <a href="plantresources.php">favorite plant</a>!</p>
      
      <p>2.  Use your <a href="gomobile.php">mobile phone</a> to make an observation.</p>
      
      <p>3.  Read the new essay on the <a href="science/whatsnew_lilacphenology.php">history of lilac observations</a>.</p>
      
      <p>4.  Tell a friend or family member <a href="aboutus.php">about Project BudBurst</a>.</p>
      
      <p>5.  Read the story of the <a href="http://budburstbuddies.org" target="NewWindow">BudBurst Buddies </a>to a young person.</p>
      
      <p>6.  Visit our <a href="results.php">View Results map</a> to see what's happening in your area.</p>
      
      <p>7.  Write a haiku about your favorite plant and share it on our <a href="http://www.facebook.com/ProjectBudBurst" target="NewWindow">Facebook</a> page!</p>
      
      <p>8.  Upload your favorite plant photos to our <a href="http://www.flickr.com/groups/projectbudburst/" target="NewWindow">Flickr</a> page.</p>
      
      <p>9.  <a href="http://twitter.com/#search?q=%23budburst" target="NewWindow">Tweet</a> about Project BudBurst at #budburst.</p>
    
      <p>10.  Get outside and enjoy the changing environment around you!</p>
        <p>&nbsp;</p>
      <h2> <strong>Tell us how you celebrated Earth Day with Project BudBurst at <a class="maincontent" href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>!</strong>      </h2>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
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