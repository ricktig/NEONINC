<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Last modified 1/9/11
# Copyright 2008-2010 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Partners"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">
  
  <div id="contentwrapper">
  
   <!-- <div><a href="index.php"><img src="images/Banner_refuges.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Project BudBurst Sponsors</h1>

      
      <p>As a National Ecological Observatory Network (NEON) program, Project BudBurst receives its primary funding from the National Science Foundation. We also receive additional NSF funding through a sub-award as part of the National Geographic Society's FieldScope program.</p>
      
      <center>
<table align="center" width="100%" border="0" cellspacing="5" class="form">
                               <tr>
                  <td width="24%"><div align="center"><img src="images/nsf_web.jpg"  alt="NSF Logo" width="107" height="107" /></div></td>
                  <td width="76%">National Science Foundation, <a href="http://www.nsf.gov/" target="_blank" class="maincontent">www.nsf.gov</a></td>
                </tr>
                <tr>
                  <td width="24%"><div align="center"><img src="images/natgeo.jpg" alt="NPN" width="147" height="42" /></div></td>
               <td width="76%"><p>National Geographic Society, <a href="http://www.nationalgeographic.com/" target="_blank" class="maincontent">www.nationalgeographic.com</a></p></td>
                </tr>
                <tr>
                  <!--   <td width="24%"><div align="center"><img src="images/logo_npn.jpg" alt="NPN" /></div></td>
                  <td width="76%">National Phenology Network, <a href="http://www.usanpn.org/" target="_blank" class="maincontent">www.usanpn.org</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/W2U_logo_small.jpg" alt="Windows to the Universe" width="149" height="50" /></div></td>
                  <td>Windows to the Universe, <a href="http://windows2universe.org/" target="_blank" class="maincontent">windows2universe.org</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/ORNL_logo.gif" alt="ORNL logo" width="87" height="45" /></div></td>
                  <td>Oak Ridge National Laboratory, <a href="http://www.ornl.gov/" target="_blank" class="maincontent">www.ornl.gov</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_ua.gif" alt="UA logo" width="60" height="51" /></div></td>
                  <td>University of Arizona, <a class="maincontent" href="http://www.arizona.edu/" target="_blank">www.arizona.edu</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_UCSB.jpg" alt="UCSB logo" width="75" height="41" /></div></td>
                  <td>University of California, Santa Barbara, <a class="maincontent" href="http://www.ucsb.edu/" target="_blank">www.ucsb.edu</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_UWM.gif" alt="UW-Milwaukee logo" width="122" height="40" /></div></td>
                  <td>University of Wisconsin, Milwaukee, <a href="http://www4.uwm.edu/" target="_blank" class="maincontent">www4.uwm.edu</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_PCA.gif" alt="PCA logo" width="75" height="43" /></div></td>
                  <td> Plant  Conservation Alliance, <a class="maincontent" href="http://www.nps.gov/plants/" target="_blank">www.nps.gov/plants</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/ucar-logo-sm.jpg" alt="UCAR" title="UCAR" /></div></td>
                  <td> UNiversity Corporation for Atmospheric Research <a class="maincontent" href="http://www2.ucar.edu/" target="_blank">http://www2.ucar.edu/</a></td>-->
                </tr>
        </table>
   	  </center>
      
    
     
      
      <h2>Past Funding</h2>  
      
      <p>We would also like to acknowledge past sponsors who made the early years of Project BudBurst possible through  their generous funding.</p>
      
      <table width="100%" border="0" cellpadding="5" class="form">
                <tr>
                  <td width="16%"><div align="center"><img src="images/logo_BLM.jpg" alt="BLM logo" width="60" height="56" /></div></td>
                  <td width="84%">United States Bureau of Land Management, <a class="maincontent" href="http://www.blm.gov/" target="_blank">www.blm.gov</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_nfwf.gif" alt="NFWF logo" width="63" height="60" /></div></td>
                  <td>National Fish and Wildlife Foundation, <a href="http://www.nfwf.org/" target="_blank" class="maincontent">www.nfwf.org</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_usgs.jpg" alt="USGS logo" width="100" height="37" /></div></td>
                  <td> United States Geological Survey (USGS), <a href="http://www.usgs.gov/" target="_blank" class="maincontent">www.usgs.gov</a></td>
                </tr>
                
                <tr>
                  <td><img src="images/UFS_Logo.gif" alt="USF" width="100" height="55" /></td>
                  <td> USDA Forest Service, Centers for Urban and Interface Forestry, <a href="http://www.UrbanForestrySouth.org" target="_blank" class="maincontent">www.UrbanForestrySouth.org</a> </td>
                </tr>
                <tr>
                  <td><img src="images/logo_NGE.gif" width="100" height="41" /></td>
                  <td>National Geographic Education Foundation, <a href="http://www.nationalgeographic.com/foundation/" target="_blank" class="maincontent">www.nationalgeographic.com/foundation</a></td>
                </tr>
                <tr>
                  <td><div align="center"><a href="http://www.fws.gov" target="_blank"><img
src="images/logo_usfws_a.gif" width="88" height="31" title="Use of this image and
link does not imply endorsement by the U.S. Fish &amp; Wildlife Service." alt="Use of this
image and link does not imply endorsement by the U.S. Fish &amp; Wildlife Service."
border="0"></a></div></td>
                  <td>U.S. Fish &amp; Wildlife Service, <a href="http://www.fws.gov" target="_blank" class="maincontent">www.fws.gov</a></td>
                </tr>
                <tr>
                  <td><div align="center"><img src="images/logo_CENS.gif" alt="CENS" width="100" height="67" /></div></td>
                  <td>Center for Embedded Networked Sensing, University of California Los Angeles, <a href="http://research.cens.ucla.edu/" target="_blank" class="maincontent">research.cens.ucla.edu</a></td>
                </tr>
      </table>
      <p>&nbsp;</p>
           
    </div>
    <!-- End MainContent -->

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