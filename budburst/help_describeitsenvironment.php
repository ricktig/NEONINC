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
HeaderStart("BudBurst Help - Describe your plant's environment"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>
<?php
//
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
      <h1><strong>Describe Your Plant&rsquo;s Environment</strong></h1>
     <div class="picture right" style="width:257px;"> 
	  <img style="float:right;" src="images/backyard_brendarezk.jpg" width="255" height="191" border="1" class="ImageWithBorder" />   Photo: Brenda Rezk</div>
      <h3> Latitude and Longitude</h3>  
      <p>
       Latitude and longitude (lat/lon) coordinates are needed for both Regular and Single Reports.     When you get ready to submit your data, we have simple tools for you to use to determine the latitude and longitude of your observations. These tools can be found during the data entry process on your MyBudBurst page.</p> 
     <p>Or, if you'd like, you can use a GPS unit or a topographic map. Report your observations in decimal degrees to as many decimal places as the unit       provides.</p>
    
      <p><em>Optional</em> Need help  in converting degrees/minutes/seconds to decimal degrees? <a href="http://www.fcc.gov/mb/audio/bickel/DDDMMSS-decimal.html" target="NewWindow">Converter from the  National Geodetic Survey<br />
      </a> </p>
      <p><em>Optional</em> Would you like to learn how to do this yourself? <a href="http://en.wikipedia.org/wiki/Geographic_coordinate_conversion" target="NewWindow">Wikipedia geographic coordinate conversion</a></p>
      
      <h3> For Regular Reports Only</h3>
      <p>You will be asked for some additional site description information such as habitat type, shading, and irrigation specific to your site. This will be called out on the Regular Report datasheet.  You only have to record this information once for each site you register with Project BudBurst. You may choose to have more than one plant species registered under the same site description. For example, you may choose to monitor a maple tree AND a lilac bush in your yard. You can create one site description for “Your Yard” and monitor both plants at that site, without needing to enter a separate site description for your maple tree and your lilac bush.
     
      
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