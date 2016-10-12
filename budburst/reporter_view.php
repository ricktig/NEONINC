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
HeaderStart("Project BudBurst - View Student Reporter Accounts"); // The first and only parameter is the page title
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
				if (isset($_POST['submit']))
				{
					//if a required field is empty, error message
					if ( !($_POST['stationid']))
					{
						$maincontent.='<p>Reporter View - You did not fill in a required field.</p> 
						<p>Please go back and try again.</p>
						<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
						$flag=1;	
					}
					//everything should be good at this point
					$stationid = $_POST['stationid'];
					$stationname = get_StationName($dbh, $stationid);
					
					//set up variables and info needed
					$personid = get_personID($dbh);
					$students = get_Students_byStation($personid, $stationid, $dbh);
					?>
					
					 <p><strong>MyBudBurst - View Student Reporter Accounts</strong><br /></p>
					 <p><span style="color:green;font-weight:bold;">Please print this page for your records!</span> Listed below are the student accounts that you have assigned for your site. If you or your student has forgotten the password for any of these accounts, please request a <a href="mailto:budburstweb@neoninc.org?Subject=Password reset for Classroom ID:<?php echo $stationid . ' User ID:' . $personid?>" class="maincontent">password change</a>. An email will be sent to you, the teacher, with the new password.</p>

						<div id="classroomholder" style="width:100%; background-color:#C3D9A5; margin: 0 0 50px 0">
						<h3>Usernames for Classroom: <?php echo $stationname;?></h3>

							<?php
							//check to see if any student accounts exist for this teacher
							if(!$students)
							//no student records found
							{
								echo '<div id="studentsholder" style="width:500px; height:200px; margin:10px auto 0 auto; padding:0 30px 0 30px; border:1px solid grey">';
								echo '<form id="form1" action="manage_student_accounts.php" method="post">';
								echo '<input type="hidden" name="stationid" value="' . $stationid . '" />';
								echo '<p>It doesn\'t look like you\'ve registered any students yet.</p>';
								echo '<p>Go back and request student reporter accounts.</p>';
								echo '<input type="submit" name="submit" value="Back" />';
								echo '</form>';
								echo '</div>'; //end studentsholder for no students
								echo '</div>'; //end classroom holder for no students
							}
							else
							//students found - display student account information
							{
								//loop through getting all students with access to site
								while ($students_row = $students->fetch_object())
								{
									$studentID  = $students_row->Student_ID;

									//get username from User Table based on student ID
									$username = get_username_byPersonID($studentID, $dbh);

									echo '<div id="studentholder">';
									echo'<div style="border-bottom:solid 2px green;">'; 
									echo  $username;
									echo  $info;
									echo  '</div>';
									echo '</div>'; //end studentholder div
								} // end while loop	
								
								echo '</div>'; //end of username display div
							}//end check for student accounts
							
							//$maincontent.='Return to <a onClick="history.go(-1);return true;">My Classroom</a> to continue';
							
							echo '<form id="form1" action="manage_student_accounts.php" method="post">';
							echo '<input type="hidden" name="stationid" value="' . $stationid . '" />';
							echo '<input type="submit" name="submit" value="Return to Manage Student Accounts" />';
							echo '</form>';
							
				} //if $_POST['submit']
			}//else logged in
				
			//$maincontent.=$spacer;
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