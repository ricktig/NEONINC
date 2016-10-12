<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/11/2012
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
HeaderStart("Project BudBurst - Change My Password"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
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
			 	$maincontent='';	
				$ok_flag=1;  //assume good to go
								
			    //make sure user is logged in
				if(!checklogin($dbh))
				{
						$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
						$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.</p>';
						$maincontent.= $spacer;
						
			  	}
				else
				{  //logged in
			
					//form submitted?
					if (isset($_POST['submit']))
					{ 
						
						//check they filled in what they were supposed to 
						if( (!$_POST['passwd']) || (!$_POST['password1']) || (!$_POST['password2']) )
						{ // missing inputs
							$maincontent.='<h1>Password Change Error</h1>
									<h2>You did not fill in a required field.</h2> 
									<p>Please go back and try again.</p>
									<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>';
							$ok_flag=0;	
						} 
						else
						{ // fields filled in
					
							// Get password hash from database that corresponds to given username
							$qry = sprintf("SELECT Passwd_Hash FROM tbl_users WHERE BINARY UserName = '%s'",
												$dbh->real_escape_string($_SESSION['username']));
							$check = $dbh->query($qry);
							if ($dbh->affected_rows == 0) {
								die('That username does not exist in our database.');
							}
							while ($row = $check->fetch_object()) {
								$info = $row->Passwd_Hash;
							}
							
							//check password matches database
							$hash_pw = hash("sha512",$_POST['passwd']);
							if ($hash_pw != $info) {
								$maincontent.='<h1>Password Change Error</h1>
										<h2>Current password supplied is incorrect.</h2> 
										<p>Please go back and try again.</p>
										<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>';
								$ok_flag=0;	
							}
						
							//they are good to change password!
							
							//check new passwords match
							//if not a match send to "try again" page
							else if (!($_POST['password1'] === $_POST['password2'])) {
								$maincontent.='<h1>Password Change Error</h1>
										<h2>New passwords do not match.</h2> 
										<p>Please go back and try again.</p>
										<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>';
								$ok_flag=0;		
							}
							//new password is good	
							$newpassword_hash = hash("sha512",$_POST['password1']);
							
							//all checks passed - change password
							if ($ok_flag){
							
								//Get UserID
								$qry = sprintf("SELECT User_ID from tbl_users WHERE BINARY UserName = '%s'",
										$dbh->real_escape_string($_SESSION['username']));
								$check = $dbh->query($qry);
								if ($dbh->affected_rows == 0) {
									die('That username does not exist in our database.');
								}
								while ($row = $check->fetch_object()) {
									$userid = $row->User_ID;
								}
							
								//update User table with $newpassword_hash
								$qry = sprintf("UPDATE tbl_users SET Passwd_Hash = '%s' WHERE User_ID='%s'", 
									$dbh->real_escape_string($newpassword_hash),
									$dbh->real_escape_string($userid));
								
								$check = $dbh->query($qry);
								if ($dbh->affected_rows == 0) {
									die('Password could not be updated.'); //fyi...error occurs when new password is same as old
								} 
								
								$maincontent.='<h2>Your password has been changed!</h2>';
								$maincontent.='<p>Continue by visiting <a href="mybudburst.php">MyBudBurst</a> page</p>';
								
							} //if $ok_flag
						} // end if fields filled in
						
						//clean up
						unset($info);
						unset($hash_pw);
						unset($newpassword_hash);
						unset($userid);
						unset($_POST['passwd']);
						unset($_POST['password1']);
						unset($_POST['password2']);
						
					} else { 
					//form hasn't been submitted, display form
					?>
							  
						<h1>Change Password </h1>
                        <p>The form below will allow you to change your password.  If you <a href="password_reminder.php">forgot your password</a> and requested to have it "reset" with a temporary one, you'll be directed to this page when your are sent a temporary password.</p>
							 <center><div style="text-align:left; width:60%;">(* = required fields)</div></center>
								<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
								 <table width="60%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#C3D9A5" class="form" summary="password change">
									<th colspan="2">Change My Password</th>
									<tr>
									  <td width="45%"><div align="right"><strong>*Current Password: </strong></div></td>
									  <td><strong>
										<input name="passwd" type="password" id="passwd" size="20" />
									  </strong></td>
									</tr>
									<tr>
									  <td><div align="right"><strong>*New Password: </strong></div></td>
									  <td>
										<input name="password1" type="password" id="password1" size="20" /></td>
									</tr>
									<tr>
									  <td><div align="right"><strong>*Retype New Password: </strong></div></td>
									  <td><strong>
										<input name="password2" type="password" id="password2" size="20" />
									  </strong></td>
									</tr>
									
									<tr>
									  <td>&nbsp;</td>
									  <td><input type="submit" name="submit" value="Submit" /></td>
									</tr>
							</table> 
					</form>
							
					<?php
						} //else

				} //else logged in
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