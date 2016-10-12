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
      <h1> Project BudBurst<sup class="sm">SM</sup> Promotional Materials</h1>
            <h2>Help us spread the word!</h2>
      
	  <p>Share Project BudBurst with your friends, family and community! And remember to include the <a href="mediacenter_logos.php" class="maincontent">Project BudBurst logo</a> when highlighting Project BudBurst.</p>
			  <p align="center">&nbsp;</p>
			  <p align="center"><a href="pdfs/PBBpostcard_Web.pdf" target="_blank" class="maincontent">Download</a> our postcard now! (2 MB pdf)*</p>
		    <p align="center"><a href="pdfs/PBBpostcard_Web.pdf" target="_blank"><img src="images/PBpostcardA_4.jpg" alt="postcard" width="378" height="284" border="0" /></a></p>
            <br/>
           <p align="center"> Or <a href="pdfs/general_overview_flyer.pdf">Download</a> our General Overview Flyer</p>
           <p align="center"> <a href="pdfs/general_overview_flyer.pdf"><img src=
			  images/general_overview_flyer_web.jpg border="0"></a>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>*  requires the free <a href="http://get.adobe.com/reader/" target="_blank" class="maincontent">Adobe Reader</a>. </p>
            

      

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