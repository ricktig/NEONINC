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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Enter Single Report - Observation"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>

<script type="text/javascript">

function MM_openBrWindow(theURL,winName,features)
{ //v2.0
  	window.open(theURL,winName,features);
}
</script>

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
      
      <h1>Single Reports - Report a BudBurst Observation</h1>
      
      <?php
			$maincontent='';
			$obs_recorded_flag=0;
			
			if(checklogin($dbh))
			{	 
				if (isset($_POST['btnsubmit']))
				{	
					$personid = $_GET['personid'];
					$plantgroupid = $_GET['plantgroupid'];
					$speciesid = $_GET['speciesid'];
					$speciesid_verified = $_GET['speciesid_verified'];
					$stationid = $_GET['stationid'];
					$sitename = $_GET['sitename'];
					
					date_default_timezone_set('America/Denver');
					$eDate=$_POST['date1'];
					$curDate = time();
					//check for valid date
					$year = substr($eDate, 0, 4);
					$month = substr($eDate, 5, 2);
					$day = $day = substr($eDate, 8, 2);
					$validdate = checkdate($month, $day, $year);
					
					if (!($stationid||$personid||$speciesid||$speciesid_verified)||
					($eDate=='0000-00-00' || ($eDate < '2008-01-01') || ($eDate > date('Y-m-d', time())) || !$validdate))
					{
						//missing fields
						$maincontent.="One or more required fields were not completed. Please <a href='javascript:history.back()'>return to the form</a> to verify your entry.";
					}
					//code to check that the date isn't in the future ADDED 3/11/2012 by DLW
					else if ($curDate < $eDate)  
					{
						//future date
						$maincontent.="The date entered is in the future. Please <a href='javascript:history.back()'>return to the form</a> and enter a valid date.";
					}
					else
					{	
						
						$Session_ID=$dbh->real_escape_string($_SESSION['UUID']);
						
						$qry = "INSERT INTO tbl_submissions 
								(Session_ID, Submission_DateTime) 
								values ('".$Session_ID."', NOW())";
								
						$check = $dbh->query($qry);
						
						//echo("qry=$qry");
						
						if (!$check)
						{
							die('Could not update Submissions Table. Please log out of your account, log back in, and resubmit.');
						}
						$submissionid=$dbh->insert_id;
						//echo $submissionid;
							
						//get phenophase id
						if(isset($_POST['phenophase_chosen']))
						{
							$phenophaseid = $_POST['phenophase_chosen'];
						}
						
						// get unique post variables and their values
						if ($phenophaseid) // we have a selection; "" - what is unchecked radio button value????
						{
							//ADD TO rel_station_species TABLE
														
							//$stationid=$_POST['stationid']; //echo("stationid=".$stationid."<br>");
							//$speciesid=$_POST['speciesid']; //echo("speciesid=".$speciesid."<br>");
							
							$qry = "INSERT INTO rel_station_species 
									(Station_ID, Species_ID) 
									values ('".$stationid."', '".$speciesid_verified."')";
							
							//echo("<br>rel qry === ".$qry);
							
							$dbh->query($qry);
														
							//echo("date=".$date."<br>"); //keep for testing
														
							//check these optional fields before entering in db
							if ($_POST[commadd]=='')
							{
								$comment='NULL';
							}
							else
							{
								$comment="'";
								$comment.=$dbh->real_escape_string($_POST['commadd']);
								$comment.="'";
							}
							
							if($_POST['common_name_userdef'])
							{
								$species_comment="'";
								$species_comment .= $dbh->real_escape_string($_POST['common_name_userdef']);
								$species_comment .= ' ';
								$species_comment .= $dbh->real_escape_string($_POST['sci_name_userdef']);
								$species_comment .="'";
							}
							else
							{
								$species_comment = 'NULL';
							}
							$obsqry = sprintf("INSERT INTO tbl_observations
										(Observer_ID,
										Submission_ID,
										Station_ID,
										Species_ID,
										Phenophase_ID,
										Observation_Date,
										Comment,Species_Comment) 
										values (%d,%d,%d,%d,%d,'%s',%s,%s)",	 
										$dbh->real_escape_string($personid),
										$dbh->real_escape_string($submissionid),
										$dbh->real_escape_string($stationid),
										$dbh->real_escape_string($speciesid_verified),
										$dbh->real_escape_string($phenophaseid),
										$dbh->real_escape_string($_POST['date1']),
										$comment,
										$species_comment
										);
										
										
							$obscheck=$dbh->query($obsqry);
							if (!$obscheck)
								{
									die('Could not enter report into database.
									Please contact the web manager - error: Observations Table');
								}
								$recordno = $dbh->insert_id;
								echo "<h2>Congratulations! We have received your observation!</h2>";
								echo "<p>Observation number <strong>" . $recordno. "</strong> has been recorded in the Project BudBurst database!</P>";
								$obs_recorded_flag=1;							
							
							//fetch common name for results 'echo' below
								$result_plantNames = get_plant($dbh,$speciesid_verified);
			
								while($row_plantName = $result_plantNames->fetch_object())
								{
									$commonName = $row_plantName->Common_Name;
									$scientificName = $row_plantName->Species;
								}//while
								
								//fetch site location name
								$siteName = get_StationName($dbh,$stationid);
											
							//echo("<br>obs qry === ".$obsqry);
							
							//} // end if for successul relcheck, insert into rel_station_species table
							

						} //if phenophase 
						
						if (!$obs_recorded_flag)
						{
							$maincontent.='<p> Sorry, no observation was reported.  Please go back and make sure you reported both the date and phenophase for your observation.</p>
							<FORM>
							<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
							</FORM>
							<p>If you continue to receive this error, please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.';
						}
						else
						{ 
							$maincontent.='<p>Your observation was for <strong> ' . $commonName . ' </strong> at the site: <strong>' . $siteName . '</strong></p>';
							$maincontent.='<p>What would you like to do next?<br /></p>';
							$maincontent.='<div style="margin: 50px auto 0 auto; width: 487px; height: 100px; text-align:center;">';
							$maincontent.='<a href="single-report-plant-group.php" class="buttons" style="width:120px;height:50px;padding:10px;float:left">Enter Another<br/>Single Report</a>'; 
							$maincontent.='<a href="mybudburst.php" class="buttons" style="width:120px;height:50px;margin-left:20px;padding:10px;float:left">Go To Your<br />MyBudBurst</a>';
							$maincontent.='<a href="results.php" class="buttons" style="width:120px;height:50px;margin-left:20px;padding:10px;float:left">View a Map of<br/>All Reports</a>';
							$maincontent.='</div>';
						}
					}//end else isset post variables
						
					//Clean up
					unset($_POST['stationid']);
					unset($_POST['personid']);
					unset($_POST['speciesid']);
					unset($submissionid);
					unset($phenophaseid);
					unset($date);
					unset($comment);
					//unset($species_comment);
				} //if submit
				else // no submit from prior page
				{
					$maincontent.='<p>Please first describe your MyBudBurst site/plant for which you are 
						making your single report.</P> ';
					$maincontent.='<p>Please continue by going to your 
						<a href="mybudburst.php" class="maincontent">MyBudBurst</a>.</p>';	
				}
			} //if not logged in
			else
			{
				$maincontent .=  '<p>Sorry, you are not logged in.  Please <a href="login.php">login</a> or <a href="register.php">join</a> today!';	
			}

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