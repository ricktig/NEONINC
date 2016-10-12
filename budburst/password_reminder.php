<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Last modified 2/8/13 by Dennis Ward
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
HeaderStart("Request Password Reset"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="MyBudBurst">

<div id="wrapper">

  <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
	<?php
		WriteTopLogin($dbh);
	?>
        
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">  
<h1>Forgot Your Password?</h1>
			<!--image holder-->
			<div class="picture right" style="width:200px">
				<img width="200px" src="images/157_m.jpg" alt="forget-me-not" title="Alpine forget-me-not" />
                Alpine forget-me-not photo courtesy of the National Park Service		
			</div><!--end image holder-->

<p>No problem! It happens to almost everyone from time to time.</p>
<p>Just <a href="mailto:budburstweb@neoninc.org?subject=Project BudBurst Password Reset Request"><strong>send us an email</strong></a> and our staff will send you a new temporary password, along with instructions for changing it to one of your choosing, within 24 hours (48 on weekends and holidays).</p>
<p><strong>Please include your Project BudBurst login/username in the body of  the email, if known.</strong> This will allow us to more quickly find your account and reset its password.</p>
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