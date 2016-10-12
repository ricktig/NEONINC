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
HeaderStart("Project BudBurst - Delete Student Reporter Accounts"); // The first and only parameter is the page title
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
					$maincontent.='<p> Reporter View - You did not fill in a required field.</p> 
					<p>Please go back and try again.</p>
					<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
					$flag=1;	
				}
				//everything should be good at this point
				$stationid = $_POST['stationid'];
				$stationname = get_StationName($dbh, $stationid);
				?>
				
				 <h1><strong>MyBudBurst - Delete Student Reporter Accounts</strong><br /></h1>
				 <!--<p> The Student Reporter Accounts have been deleted for your classroom</p>
			   <p><strong>MyBudBurst Classroom: <?php  echo $stationname;  ?></strong> </p>-->
				  
				  <p>Please <a href="mailto:budburstweb@neoninc.org">email</a> us the name of your classroom and we'll delete your student reporter accounts.</p>
				  <p>&nbsp;</p>
				  
				<?php
					echo '<form id="form1" action="manage_student_accounts.php" method="post">';
					echo '<input type="hidden" name="stationid" value="' . $stationid . '" />';
					echo '<input type="submit" name="submit" value="Return to Manage Student Accounts" />';
					echo '</form>';
				?>

				<?php
				/*
				//set up variables and info needed
				$personid = get_personID($dbh);
				//echo "person id = " . $personid ;
				$students = get_Students_byStation($personid, $stationid, $dbh);
				
				//loop through getting all students with access to site
				while ($students_row = $students->fetch_object() ){
						
					$studentID  = $students_row->Student_ID;

					//make user inactive in Person table
					$qry = sprintf("UPDATE tbl_people SET active=0 WHERE Person_ID=%d", $studentID );		
					echo $qry;
					//$result = $dbh->query($qry);
					
					//make user inactive in User table
					$qry = sprintf("UPDATE tbl_users SET active=0 WHERE Person_ID=%d", $studentID );		
					echo $qry;
					//$result = $dbh->query($qry);
					
					//update 'rel_teacher_student_station' table
					$qry = sprintf("UPDATE rel_teacher_student_station SET active=0 WHERE Student_ID=%d",$studentID);		
					echo $qry;
					//$result = $dbh->query($qry);
													
						
						
				} // while loop	
				*/
			} //if $_POST['submit']
			
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