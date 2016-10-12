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
HeaderStart("Project BudBurst - Photo Gallery"); // The first and only parameter is the page title
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
    
      <h1>Photo Gallery</h1>
      
      <p>We are looking for photographs of Project BudBurst in action as well as the  phenophases for
      <a href="plantresources.php" class="maincontent">Project BudBurst plants</a> for inclusion here on this Website and in the new Phenophase Field  Guides.</p>
			  <p>If you take photos of the phenological events of plants  <strong>please share them with us</strong>!&nbsp; We have two  options for you to share your photos with us:</p>
			  <p><strong>1)</strong> We have set up a Flickr group space (<a href="http://www.flickr.com/groups/projectbudburst/" target="_blank" class="maincontent">http://www.flickr.com/groups/projectbudburst/</a> ) to allow for you to share your photos with us and the Project BudBurst  community.&nbsp; This space will serve as the  staging area for photos which then will be reviewed and possibly chosen for  inclusion in new Phenophase Field Guides as well as displayed here on our Website. For complete  instructions on how to share your photos through flickr.com - click <a href="pdfs/PBB_Flickr.pdf" target="_blank" class="maincontent">here</a>. (You must be 18 years or older, or have parental/guardian consent  to share your photos on Flickr.)</p>
			  <p><strong>2)</strong> Or you can  email up to 3 of your plant photos  directly to us at <a href="mailto:budburstweb@neoninc.org" class="maincontent">budburstweb@neoninc.org</a>. (Please keep your attached files  to under our 5MB size limit.)</p>
			  <p>For all questions or comments please contact us at <a class="maincontent" href="mailto:budburstweb@neoninc.org">budburstweb@neoninc.org</a>.</p>
			  <p>&nbsp;</p>
            
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