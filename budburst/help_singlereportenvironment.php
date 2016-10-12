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
HeaderStart("BudBurst Help - Describe your plant's environment (Single Report)"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
?>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<?php
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
  
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      <h1><strong>Determine Your Plant&rsquo;s Location</strong></h1>
      <p>Step 2 on the Single Report form asks you &quot;Where is your plant located?&quot; In  order to submit your Single Report, you will need to know  the geographic coordinates of the plant's location. This is known as  Latitude and  Longitude (Lat/Lon).&nbsp;Determine your Lat/Lon in decimal degrees. Choose one  of the three ways listed below to determine the Lat/Lon coordinates for your  plant.</p>
      <ul type="disc">
        <li>Enter a street       address or city/state location in the <a href="#" class="maincontent" onclick="MM_openBrWindow('geocoder.php','Geocoder','scrollbars=yes,width=525,height=720')">Project BudBurst Geocoder</a>.</li>
        <li>Use a GPS unit       outside at your location. Report as many decimal places as the unit       provides.</li>
        <li>Find the       coordinates on a topographic map.</li>
      </ul>
      <p>Need help  in converting degrees/minutes/seconds to decimal degrees? <a href="http://www.fcc.gov/mb/audio/bickel/DDDMMSS-decimal.html" target="NewWindow">Converter from the  National Geodetic Survey<br />
      </a> </p>
      <p>Would you like to learn how to do this yourself? <a href="http://en.wikipedia.org/wiki/Geographic_coordinate_conversion" target="NewWindow">Wikipedia geographic coordinate conversion</a></p>
      
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