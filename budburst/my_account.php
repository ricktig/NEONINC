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
HeaderStart("Welcome to Project BudBurst"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<body id="MyBudBurst">

<div id="wrapper">

  <div id="contentwrapper">
  	
    <!-- <div><a href="index.php"><img src="images/Banner_0.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation for Home Page -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
	<?php
			// Check if user is not logged in
			if(!checklogin($dbh))
			{	
	?>
				<h1>My BudBurst</h1>
				<h2>Welcome Guest!</h2>
				You will need to login to make regular reports or view your MyBudBurst page.
				To do so, <a href='login.php'>login</a> or <a href='register.php'>join</a> today!<p>
				Visit our <a href='getstarted.php'>Get Started</a> pages for complete information including a reporting form to help you note phenological changes as they occur throughout the year.</p>
				<ul>
					<li><a href='login.php'>Login</a> or <a href='register.php'>join</a> to become a member and start reporting observations today!</li>
				</ul>
	<?php
			}
				
			//logged in show content
			else
			{
				?>
			
				<p>If you want to keep informed about Project BudBurst or need to manage your account settings, please follow the links below.</p>  
				<p><a href="http://visitor.r20.constantcontact.com/d.jsp?llr=7sqd9aiab&p=oi&m=1108128940636" target="NewWindow">Subscribe to our Community Newsletter</a></p>
				<p><a href="password_change.php">Change your password</a></p>
				<p><a href="register_update.php" class="maincontent">Update your membership information</a></p>
			<?php
			}
			?>
</div><!-- MainContent -->

	<?php	
	WriteFooterNavigation();
	?>

</div> <!-- contentwrapper -->
</div> 
<!--wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>