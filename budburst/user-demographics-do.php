<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Rick Rose
# Last modified 3/15/2013
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
HeaderStart("Project BudBurst Demographic Survey Error"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="MyBudBurst">

<div id="wrapper">

  <div id="contentwrapper">
  	
	<?php
		WriteTopLogin($dbh);
	?>
        
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

		<div id="MainContent">  
			  
			<?php
				//process survey results
				//validate newuserid
				if (isset($_POST['newuserid']))
				{
					$newuserid = $_POST['newuserid'];
				}
				
				//No newuserid
				if (!$newuserid)
				{
					//call function to email webmaster with database insert error info
					sendEmailAlertToWebmaster('user-demographics-do.php - line 54','N/A',' Missing newuserid in POST array');
					
					//redirect to mybudburst anyway without writing record to tbl_demographics
				?>
					<script language="javascript">
							window.location="mybudburst.php?NewRegistration=1";
					</script>
					
				<?php	
				}
				else
				{ //newuserid ok
					//create insert sql
					$sql = sprintf
					("INSERT INTO tbl_demographics (
							fkUserId,
							Ethnicity,
							Gender,
							AgeRange,
							CSProjectCount,
							ReferenceSource,
							UploadLevel,
							ObsLevel)
							VALUES
							('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
							$dbh->real_escape_string($_POST['newuserid']),
							$dbh->real_escape_string($_POST['ethnicityconcat']),
							$dbh->real_escape_string($_POST['gender']),
							$dbh->real_escape_string($_POST['age']),
							$dbh->real_escape_string($_POST['csprojectcount']),
							$dbh->real_escape_string($_POST['sourcetext']),
							$dbh->real_escape_string($_POST['uploadlevel']),
							$dbh->real_escape_string($_POST['obslevel'])
					);

					$dbh->query($sql);
					
					//check for successful insert
					if($dbh->affected_rows == 0)
					{
						//call function to email webmaster with database insert error info
						sendEmailAlertToWebmaster('user-demographics-do.php - line 96',' tbl_demographics','Couldn\'t write to table');
					
						//redirect to mybudburst anyway without writing record to tbl_demographics
					?>
						<script language="javascript">
							window.location="mybudburst.php?NewRegistration=1";
						</script>
					<?php
					}
					else
					{
						// redirect them to mybudburst.php since demographic survey was successful
						?>
						<script language="javascript">
							window.location="mybudburst.php?NewRegistration=1";
						</script>
						<?php
					}//end successful database insert
				}//end newuserid ok
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