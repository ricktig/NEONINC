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

//Thanks to OldSite on http://www.free2code.net for the basic framework of this code

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Login"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>

<?php
//
HeaderEnd();
?>

<body id="MyBudBurst">

<div id="wrapper">

  <div id="contentwrapper">
  	
    <!--<div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
	<?php
		WriteTopLogin($dbh);
	?>
        
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">  
      <?php				
		if ( !isset($_POST['submit']) || !($_POST['uname']) || !($_POST['passwd']))
		{ 
			$maincontent.=$missing_fields;
		}							
		else
		{
			// Get password hash from database that corresponds to give username
			$qry = sprintf("SELECT Passwd_Hash FROM tbl_users WHERE BINARY UserName = '%s'",
						$dbh->real_escape_string($_POST['uname']));
			
			$check = $dbh->query($qry);
			if ($dbh->affected_rows == 0) {
				$maincontent.='Incorrect Username.  Please go back and try again.';
				$maincontent.='<FORM><INPUT TYPE="button" VALUE="Back" 
								onClick="history.go(-1);return true;"> </FORM>';
			} 
			else
			{
				while ($row = $check->fetch_object())
				{
					$info = $row->Passwd_Hash;
				}
			
				// check password
				$hash_pw = hash("sha512",$_POST['passwd']);
				if ($hash_pw != $info) {
					$maincontent.= 'Incorrect password.  Please go back and try again.';
					$maincontent.='<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
				}
				else
				{
					// if we get here, username and password are correct,  run log_user function
					log_user($_POST['uname'],$dbh);
					
					// redirect to my budburst page GJN
			?>
                    <script language="javascript">
						window.location="mybudburst.php";
					</script>
                    <h1>Welcome back <span class="username"><?php echo $_SESSION['username'];?></span>!</h1>
                    <p>Continue on to  <a href="_old/mybudburst.php" class="maincontent">MyBudBurst Space</a>!</p>
                    <p>Here you can:
                    <ul>
                      <li>Report your observations </li>
                      <li>View and update your saved plants and sites</li>
                      <li>Register new plants and sites you will be monitoring </li>
                      <li>Update your membership information</li>
                    </ul>
						
			<?php
				} //else password hash
					unset($hash_pw);
					unset($info);
				} //else username
			unset($_POST['uname']);
			unset($_POST['passwd']);
			} //else 
	echo $maincontent;
	echo $spacer;
	?>
      
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