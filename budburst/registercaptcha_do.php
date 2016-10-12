<?php session_start(); ?>

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
//require_once 'cgi-bin/pb_lib_kkm.php';

//reCAPTCHA code
//require_once('cgi-bin/recaptchalib.php');
//$privatekey = "6LeQOgUAAAAAADupc40ADbDqu0rAdi_us8YsWrVx";
//$privatekey = "6LeMgMUSAAAAAHLRw_yJBKqLMIAazyyuRUhvA-wY"; // updated from reCAPTCHA on 6/22/2011
//reCAPTCHA code

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Registration"); // The first and only parameter is the page title
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
	  
		$flag=0;
		
		// if submit (we did NOT got all fields from previous page)
		
		if ( !isset($_POST['submit']) || !($_POST['login']) || !($_POST['firstname']) || 
				!($_POST['lastname']) || !($_POST['email']) 
				|| !($_POST["captcha_code"]) 

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
				
				//new captcha check - 
				include_once 'securimage/securimage.php';

				$securimage = new Securimage();

				if ($securimage->check($_POST['captcha_code']) == false) 
				{
					// the code was incorrect
					// you should handle the error so that the form processor doesn't continue

					// or you can use the following code if there is no validation or you do not know how
					$maincontent .='<h2>Registration - Error in section \'Type the words that you see\'</h2> 
						<p>Please go back and try it again. <p>
							<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
						$flag=1;
				}


				//reCAPTCHA check
				
				/*$resp = recaptcha_check_answer ($privatekey,
						$_SERVER["REMOTE_ADDR"],
						$_POST["recaptcha_challenge_field"],
						$_POST["recaptcha_response_field"]);*/

				/*if (!$resp->is_valid)
				{
					$maincontent .='<h2>Registration - Error in \'Type the words that you see\'</h2> 
					<p>reCAPTCHA said: ' . 	$resp->error . 	') </p><p>Please go back and try it again. <p>
						<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
					$flag=1;
				}*/
				
				if ($flag==0) // was if (!flag) E.G. THERE WERE NO ERRORS FROM ABOVE ERROR CHECKING; gjn
				{
					//hash the password
					$password_hash = hash("sha512",$_POST['password1']);

					//default country - taking off form for now
					$country="United States";

					//process multiple special project participations
					//$sp_array = $_POST[special_project_participation_array];
					//echo "count of array = " . count($sp_array);
					//for ( $ii = 0 ; $ii < count($sp_array) ; $ii++ )
					//	{
					//	$special_project_participation = $special_project_participation . ", " . $sp_array[$ii] ;
					//	}
					//echo "you choose: " . $special_project_participation;
					//$special_project_participation='';
					
					// Now that the data is in the array $_POST, store it in SQL database 
					store_user($_POST['login'], $password_hash, $_POST['firstname'], $_POST['middlename'], 
					$_POST['lastname'], $_POST['suffix'], $_POST['address1'], $_POST['address2'], 
					$_POST['city'], $_POST['state'], $_POST['zip'], $country, 
					$_POST['comments'], $_POST['email'], $_POST['k12teacher'], $_POST['authtype'], $dbh);
					
					//log user since registration successful
					//echo "lastname=" . $_POST['lastname'];
					log_user($_POST['login'],$dbh);
					
					// redirect them to MYBudBurst.php since registration was successful
					
					?>
                    <script language="javascript">
						window.location="mybudburst.php?NewRegistration=1";
					</script>
                    <?php
					
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