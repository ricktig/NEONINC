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
//require_once 'cgi-bin/pb_lib_kkm.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Request Student Reporter Accounts"); // The first and only parameter is the page title
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
  	
    <!--<div><a href="index.php"><img src="images/Banner_6.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
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
		$flag=0; 
		 
		 //make sure user is logged in
		if(!checklogin($dbh))
		{
			$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
			$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.';
			$maincontent.= $spacer;
			$flag=1;
		}
		else
		{
			//echo("test");
			//if (isset($_POST['submit']))
			//{
				//if a required field is empty, error message
				if ( !($_POST['stationid']))
				{
					$maincontent.='<p> Reporter Request - We didn\'t get a valid classroom id.</p> 
					<p>Please go back and try again.</p>
					<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
					$flag=1;	
				}
				else
				{
					//everything should be good at this point
					$userid = get_PersonID($dbh);
					$stationid = $_POST['stationid'];
					$stationname = get_StationName($dbh, $stationid);
					?>
					
					<h1>My BudBurst - Student Reporter Accounts
					</h1>
<p> <span style="color:green;font-weight:bold;">Please print this page for your records!</span> You can now assign a student to each of the student reporter accounts below. Once logged in, the student reporter can change their password. </p>
					<p>The following student reporter accounts have been created for:</p>
					<p><strong>My BudBurst Site: <?php echo $stationname; ?></strong> </p>
					
					<table width="100%" border="0" bgcolor="#C3D9A5"> <!-- style="border:solid 2px green;" -->
						<!--<tr>
						  <td><strong>Username</strong></td>
						  <td><strong>Password</strong></td>
					   </tr>-->
					   <th>Username</th>
					   <th>Password</th>
						
					<?php
					//set up variables and info needed to store user
					$noReporters = $_POST['no_reporters'];
					$userNameArray = array();
					$email = get_email_byUsername($dbh);
					
					$startnumberSet = get_Students_byStation($userid, $stationid, $dbh);
					$startnumber = $startnumberSet->num_rows;
					
					//create usernames based on siteName
					for ($i=0; $i<$noReporters; $i++)
					{
						$j = $startnumber + $i + 1;
						
						$userName = $_SESSION['username'];
						$userName .= '_';
						
						//add underscores if spaces exist in station name
						$stationname_nospaces = str_replace(" ","_",$stationname);
						
						$userName .= $stationname_nospaces;
						$userName .= '_reporter' . $j; //example "meymaris_class1_reporter1"

						//TODO check that username doesn't already exist - okay since logged in username is unique!
						//if it does, then regenerate username 
						
						//else push into array
						array_push($userNameArray, $userName);
					//}
					
					//store new person id and user id, add to Manage_Reporters table
					//for ($i=0; $i<$noReporters; $i++)
					//{
						//create random password
						$password = createRandomPassword();
						$password_hash = hash("sha512",$password);
						
						//store person as auto generated username, 
						//random password, student reporter in comments field, and teachers' email address
						store_user($userNameArray[$i], $password_hash, '', '', '', '', '', '', '', '', '', '', 'student reporter', $email , '', '', $dbh);
						
						//echo $userName;						

						//Modify user account to be a student reporter account - restricted user
						$studentID = get_UserID_byUserName($userName, $dbh);
						
						
						
						//$dbh->insert_id;//get_lastInsertID($dbh); 
						// echo "<tr><td>Last inserted record has id " . $id .  "</td><td></td></tr>";
						update_Student($studentID, $dbh);
						
						//add to Manage_Student table
						//echo 'teacher: ' . $userid . ' student: ' . $studentID . ' station: ' . $stationid;
						
						//add record to student/teacher relationship table
						store_student($userid, $studentID, $stationid, $dbh);
						?>

						<tr>
						  <td style="border-bottom:solid 2px green;"><?php echo $userNameArray[$i]; ?> </td>
						  <td style="border-bottom:solid 2px green;"><?php echo $password; ?></td>
					   </tr>


						<?php    
					} // for loop	
					echo '</table><!-- end of username display table-->';
				} //if $_POST['stationid']
				
					$maincontent.= '<form id="form1" action="manage_student_accounts.php" method="post">';
					$maincontent.= '<input type="hidden" name="stationid" value="' . $stationid . '" />';
					$maincontent.= '<input type="submit" name="submit" value="Return to Manage Student Accounts" />';
					$maincontent.= '</form>';
				
			//} //if $_POST['submit']
			
		}//else logged in
			
		$maincontent.=$spacer;
		echo $maincontent;
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