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

//reCAPTCHA code
require_once 'cgi-bin/recaptchalib.php';
$publickey = "6LdWv7kSAAAAAEgSxIePmZdl-zGwwfS7sWEGjN_M"; // we got this from the signup page on 4/26/2010
//reCAPTCHA code

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Registration Update ConfirmationPolicies"); // The first and only parameter is the page title
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
				 //make sure user is logged in
				if(!checklogin($dbh)) {
						$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
						$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.';
						$maincontent.= $spacer;
				} 
				else {
						if (isset($_POST['submit'])){
							
							//if a required field is empty, redirect the user
							if ( !$_POST['firstname'] || !$_POST['lastname'] || !$_POST['email'])
							{
								//missing fields

								$maincontent.='<h1>Registration Update</h1>';
								$maincontent.='<h3>You did not fill in a required field.</h3>';
								$maincontent.='<p>Please go back and try again.</p>';
								$maincontent.='<form id="form1" action="register_update.php" method="post">';
								$maincontent.='<input type="submit" name="submit" value="Back" />';
								$maincontent.='</form>';
							}
							else
							{
								//Get PersonID
								$personid = get_personID($dbh);
								
								//process multiple special project participations
								//$sp_array = $_POST[special_project_participation_array];
								//echo "count of array = " . count($sp_array);
								//for ( $ii = 0 ; $ii < count($sp_array) ; $ii++ )
								//	{
								//	$special_project_participation = $special_project_participation . ", " . $sp_array[$ii] ;
								//	}
								//echo "you choose: " . $special_project_participation;
								$special_project_participation='';
								
								if ($personid)
								{
									//update tbl_people table
									/*$qry = sprintf("UPDATE tbl_people SET 
														First_Name='%s', 
														Middle_Name='%s', 
														Last_Name='%s', 
														Name_Suffix='%s', 
														Addr_Street1='%s', 
														Addr_Street2='%s', 
														Addr_City='%s', 
														Addr_State='%s', 
														Addr_PostalCode=%d, 
														Addr_Country='%s', 
														Create_Date=NOW(), 
														Comments='%s', 
														Special_Project_Participation ='%s',
														email='%s'
											 WHERE Person_ID = '%s' ",
											$dbh->real_escape_string($_POST['firstname']),
											  $dbh->real_escape_string($_POST['middlename']), 
											  $dbh->real_escape_string($_POST['lastname']), 
											  $dbh->real_escape_string($_POST['suffix']), 
											  $dbh->real_escape_string($_POST['address1']),
											  $dbh->real_escape_string($_POST['address2']),
											  $dbh->real_escape_string($_POST['city']), 
											  $dbh->real_escape_string($_POST['state']), 
											  $dbh->real_escape_string($_POST['zip']), 
											  $dbh->real_escape_string($_POST['country']), 
											  $dbh->real_escape_string($_POST['comments']),
											  //$dbh->real_escape_string($special_project_participation),
											  $dbh->real_escape_string($_POST['email']),
											  $personid
											  );*/
									$qry = sprintf("UPDATE tbl_people SET 
														First_Name='%s', 
														Middle_Name='%s', 
														Last_Name='%s', 
														Name_Suffix='%s', 
														Addr_Street1='%s', 
														Addr_Street2='%s', 
														Addr_City='%s', 
														Addr_State='%s', 
														Addr_PostalCode=%d, 
														Addr_Country='%s', 
														Create_Date=NOW(), 
														Comments='%s', 
														email='%s'
											 WHERE Person_ID = '%s' ",
											$dbh->real_escape_string($_POST['firstname']),
											  $dbh->real_escape_string($_POST['middlename']), 
											  $dbh->real_escape_string($_POST['lastname']), 
											  $dbh->real_escape_string($_POST['suffix']), 
											  $dbh->real_escape_string($_POST['address1']),
											  $dbh->real_escape_string($_POST['address2']),
											  $dbh->real_escape_string($_POST['city']), 
											  $dbh->real_escape_string($_POST['state']), 
											  $dbh->real_escape_string($_POST['zip']), 
											  $dbh->real_escape_string($_POST['country']), 
											  $dbh->real_escape_string($_POST['comments']),
											  $dbh->real_escape_string($_POST['email']),
											  $personid
											  );
									//echo $qry;			  
									$check = $dbh->query($qry);
									if ($check)
									{
										$maincontent.='<p>Your membership information has been updated!</p>
														<p>Please continue to your 
														<a href="mybudburst.php">MyBudBurst</a>.</p>';
									}
									else
									{
										$maincontent.='<p>We are sorry, but there was an error updating your membership information.  
														Please contact the Web Manager at <a href="mailto:budburstweb@neoninc.org">
														budburstweb@neoninc.org</a> with this error - membership update query failed.</p>';
									}
								}//if personid true
								else
								{ // no personid
									$maincontent .= '<p>We are sorry, but there was an error updating your membership information.  
													Please contact the Web Manager at <a href="mailto:budburstweb@neoninc.org">budburstweb@neoninc.org</a> with this error - personid not found in registration update.</p>';										
								}//end if personid
								
							}//else missing fields
						}//if submit
						else
						{ // not submit
							$maincontent .= '<h1>Registration Update Error<h1>';
							$maincontent .=	'<h3>We didn\'t get your information from the registration page.</h3>';
							$maincontent .= '<form id="form1" action="register_update.php" method="post">';
							$maincontent .= '<input type="hidden" name="stationid" value="' . $stationid . '" />';
							$maincontent .= '<input type="submit" name="submit" value="Return to Registration Page" />';
							$maincontent .= '</form>';
						}
						
					} //else checklogin
		
				echo $maincontent;
				echo $spacer;
				
				//Clean up
				
				unset($_POST['lastname']);
				unset($_POST['firstname']);
				unset($_POST['email']);
				unset($_POST['submit']);

				?>
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