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
HeaderStart("Project BudBurst Credits"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
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
      
      <h1>Project BudBurst Credits</h1>
      
      <p>Project BudBurst data is freely available for anyone to download and   use.  The data is provided by thousands of observers from across the   country.  If you use data submitted by Project BudBurst observers for   analysis, reports, or presentations, we ask that you link to our <a href="attribution.php">Community Attribution page</a> to recognize the efforts of our dedicated volunteers.</p>
      
      <p>The beautiful photos and images  you see throughout the Project BudBurst website have been provided by many  generous contributors. Permissions regarding the use of any photos on our  website are dependent upon the photographer and/or organization from whence the  photo came. Should you have questions regarding the credit of a particular  photo or should you like to request permission to use a photo, contact us at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>. Please  provide us with a link to the web page the photo is on and a brief description  of the photo. <br />
      <p> Photo credits for images used in the  Project BudBurst phenophase field journals and ID Guides are included on the documents in  which they appear. &nbsp;</p>
 
   <h2>Some of our most common photo providers include:</h2>
   <p><img src="images/FlowersPiutePassTrail_SierraNevada_WallyWoolfenden_small.jpg" width="379" height="252" hspace="10" border="1" align="right" />
	 Project BudBurst Citizen Scientists<br/> 
     USDA PLANTS Database<br />
     US Fish and Wildlife Service <br />
     Chicago Botanic Garden<br />
     National Park Service<br />
     Paul Alaback, Melipal Consulting<br />
     Bugwood.org<br />
     CalPhotos<br />
     Louisiana State Ag University<br />
     Ladybird Johnson Wildflower Center<br />
     The Ohio State University<br />
     The Burke Museum of Natural History  and Culture<br />
     Vanderbilt University<br />
     University of Wisconsin Stevens  Point-Freckmann Herbarium<br />
     NEON, Inc.</h2>
   </p>
<br/>
   <div align="left"><em>Photo: Flowers in the Sierra Nevada; Courtesy of Wally Woolfenden, Project BudBurst Citizen Scientist</em>
   </div>   
     
     
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