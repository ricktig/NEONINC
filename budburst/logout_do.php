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
HeaderStart("Project BudBurst - Logout"); // The first and only parameter is the page title
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
    
    	<?php
			// Check if user is NOT logged in
			if(!checklogin($dbh))
			{
				echo("<p>You are not logged in so you cannot log out.  
				Please continue by <a class='maincontent' href='login.php'>logging in</a>!</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>");
			}//logged in
			else
			{
			
				//Get UserID corresponding to Session ID
				$qry = sprintf("SELECT User_ID from tbl_sessions WHERE Session_ID = %d",$_SESSION['UUID']);
			
				// %d means treat as integer
				
				//$qry = "SELECT User_ID from tbl_sessions WHERE Session_ID = %d",$dbh->real_escape_string($_SESSION['UUID']);
				$result = $dbh->query($qry);
				while ($row = $result->fetch_object())
				{
					$userid = $row->User_ID;
				}
				
				//end all sessions associated with userID that are active...
				$qry = sprintf("UPDATE tbl_sessions SET End_DateTime = NOW(), Active = 0 WHERE User_ID = %d AND Active = 1",$dbh->real_escape_string($userid));
				$dbh->query($qry);
				
				//Clean up
				unset($userid);
				mysqli_close($dbh);
				
				//clean session variables and destroy session
				unset($_SESSION['IP']);
				unset($_SESSION['UUID']);
				unset($_SESSION['username']);
				session_unset();
				session_destroy();
				// redirect user
				//header('Location: logout.php');
				// using header here may not alway work b/c we are not in the <head></head> portion of the page. GJN
				// instead, use javascript tpo redirect after we close session variables server side etc.
				
				echo("<script type='text/javascript'>window.location='logout.php';</script>");
				
			} //else
			?>  
    
    </div><!-- MainContent -->

	<?php	
	WriteFooterNavigation();
	?>

</div> <!-- contentwrapper -->
</div> <!--wrapper -->

<?php
//mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>