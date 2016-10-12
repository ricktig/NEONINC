<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Dennis Ward
# Last modified 9/27/2011
# Copyright 2008-2011 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';
require_once 'cgi-bin/pb_lib_kkm.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head></head>

<body>

<div id="wrapper">

  <div id="contentwrapper">
  	
<div id="MainContent">  
      
	  <?php
	  
		$flag=0;
		
		// if submit (we did NOT got all fields from previous page)
		
		if ( !isset($_POST['submit']) || !($_POST['login']) || !($_POST['firstname']) || 
				!($_POST['lastname']) || !($_POST['email']) 
			)
		{ 		
			$maincontent.=$missing_fields;
			//$maincontent.="we are here";
			$flag=1;
		}							
		else // no missing fields so check passwords, existing username, recaptcha, etc.
		{
			//these are required for local only
			if( ($_POST['authtype'] == 'local') && ((!($_POST['password1'])) || (!($_POST['password2']))))
			{
				//missing fields
				$maincontent .= '<h1>Registration - You did not fill in a required field.</h1> 
				<p>Please go back and try again.</p>
				<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
				$flag=1;
			}
			else
			{
				//if username exists redirect user 
				$login = $_POST['login'];
				
				//check usename is already taken
				if ($result = $dbh->query("Select UserName from tbl_users"))
				{
					while ($row = $result->fetch_object())
					{
						if ($row->UserName === $login)
						{
							//username already exists
							$maincontent .='<h1>Registration - Username Already Exists</h1> 
							<p>Please go back and try again.</p>
							<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
							$flag=1;
						}
					}
				}
				
				
				//check 'password' field against 'retype password' field
				//if not a match send to "try again" page
				if (!($_POST['password1'] === $_POST['password2']))
				{
					$maincontent .='<h1>Registration - Passwords Do Not Match</h1> 
					<p>Please go back and try again.</p>
					<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
					$flag=1;
				}
								
				if ($flag==0) // was if (!flag) E.G. THERE WERE NO ERRORS FROM ABOVE ERROR CHECKING; gjn
				{
					//hash the password
					$password_hash = hash("sha512",$_POST['password1']);

					//default country - taking off form for now
					$country="United States";

					echo $_POST['login'] . ' ' .  $password_hash . ' ' .  $_POST['firstname'] . ' ' . $_POST['middlename'] . ' ' . $_POST['lastname'] . ' ' . $_POST['suffix'] . ' ' .$_POST['address1'] . ' ' .  $_POST['address2'] . ' ' . $_POST['city'] . ' ' . $_POST['state'] . ' ' .  $_POST['zip'] . ' ' .  $country . ' ' . $_POST['comments'] . ' ' . $_POST['email'] . ' ' .  $_POST['k12teacher'] . ' ' . $_POST['authtype'];
					
					// Now that the data is in the array $_POST, store it in SQL database 
					store_user($_POST['login'], $password_hash, $_POST['firstname'], $_POST['middlename'], 
					$_POST['lastname'], $_POST['suffix'], $_POST['address1'], $_POST['address2'], 
					$_POST['city'], $_POST['state'], $_POST['zip'], $country, 
					$_POST['comments'], $_POST['email'], $_POST['k12teacher'], $_POST['authtype'], $dbh);
					
					//log user since registration successful
					//echo "lastname=" . $_POST['lastname'];
					log_user($_POST['login'],$dbh);
					
					echo "<h2>You have successfully registered!</h2>";
					echo "<p>Welcome to the Project BudBurst Community!</p>";
					echo "<p>You may now close this window and return to the Mobile App.</p>";
					echo "<p>We look forward to seeing your observations!</p>";
					
					// redirect them to MYBudBurst.php since registration was successful
					
/*					?>
                    <script language="javascript">
						window.location="mybudburst.php?NewRegistration=1";
					</script>
                    <?php
*/					
				}// end if (flag !=1)
			} //else password fields required
		} //else submit had all fields
		
		echo $maincontent;
		echo $spacer;
		
		//Clean up
		unset($login);
		unset($password_hash);
		unset($_POST['password1']);
		unset($_POST['password2']);
		unset($_POST['login']);
		unset($_POST['lastname']);
		unset($_POST['authtype']);
		unset($_POST['address1']);
		unset($_POST['address2']);
		?>
		<!--
        <script language="javascript">
			window.location="mybudburst.php?NewRegistration=1";
		</script>
        -->
        <p>&nbsp;</p>
        
    </div><!-- MainContent -->

</div> <!-- contentwrapper -->
</div> <!--wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>