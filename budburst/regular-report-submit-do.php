<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/6/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Report a Regular Observation"); // The first and only parameter is the page title
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
      
      <h1>Regular Reports - Report a Regular Observation</h1>
      
      <?php

			$maincontent='';
			$flag=0;
			$obs_recorded_flag=0;
			
			if(checklogin($dbh))
			{	 
				if (isset($_POST['submit']))
				{		
					//if a required field is empty, redirect the user
					if ( !($_POST['stationid'] || $_POST['personid'] || $_POST['speciesid'] ))
					{
							//missing fields
							$maincontent.=$missing_fields;
							$flag=1; 
					}

					if (!$flag)
					{
						//ADD TO tbl_submissions TABLE
						
						$Session_ID=$dbh->real_escape_string($_SESSION['UUID']);
						//echo("sessionid=$Session_ID"); //COMMENTED OUT BY DLW ON 3/29/11
						
						$qry = "INSERT INTO tbl_submissions 
								(Session_ID, Submission_DateTime) 
								values ('".$Session_ID."', NOW())";
						//echo("qry=$qry");
						
						$submissionset=$dbh->query($qry);
						
						if (!$submissionset)
						{
							die('Could not update Submissions Table.');
						}
						else
						{
							$submissionid= $dbh->insert_id;
							//echo("submissionid=$submissionid");
						}
					
						//note: validation of input type is done on register_site
						//everything should be good at this point

							// get speciesid from previous page
							$speciesid=$_POST['speciesid'];
							
							//get species information from speciesid
							$species=get_Species($speciesid,$dbh);
							if(!mysqli_num_rows($species))
							{
								$commonname='';
								$user_defined='';
							}
							else
							{
								$srow=$species->fetch_object();
								$commonname=$srow->Common_Name;
								$user_defined=$srow->User_Defined;
							}
							
							//if user defined species ---------------------------------------------
							if ($user_defined==1) //user defined species; gjn
							{
								// for each plant group, check to see if any phenophase dates were submitted
								for ($i=1;$i<=5;$i++)
								{
									${phenophases.$i} = get_phenophase_plant_group($dbh,$i);
								
									//get ALL phenophases for budburst protocol  
									//$phenophases = get_phenophase_species($dbh, $_POST['speciesid']);
									
									if (!${phenophases.$i})
									{
										die('No phenophases found in database.
										Please contact the web manager - error: report_obs_logged3 - phenophases not found');	
									}
									${no_phenophases.$i} = mysqli_num_rows(${phenophases.$i});
									//echo  "no phenophases = " .$no_phenophases;
											
									//cycle through phenophases
									while ($phenophase_row = ${phenophases.$i}->fetch_object()){
											
										//get phenophase id
										$phenophaseid = $phenophase_row->Phenophase_ID;
	
										//build post variables
										//$month = 'monthID'.$phenophaseid."_".$i;
										//$day = 'dayID'.$phenophaseid."_".$i;
										//$year = 'yearID'.$phenophaseid."_".$i;
										$ddate = 'date' . $phenophaseid;
											
										//check for valid date
										$year = substr($_POST[$ddate], 0, 4);
										$month = substr($_POST[$ddate], 5, 2);
										$day = $day = substr($_POST[$ddate], 8, 2);
										$validdate = checkdate($month, $day, $year);
										
										//if (($_POST[$month] != "") && ($_POST[$day] != "") && ($_POST[$year] != ""))
										//if (($_POST[$ddate] != "" ) && ($_POST[$ddate] != "0000-00-00") )
										if (($_POST[$ddate] != "" ) && ($_POST[$ddate] != "0000-00-00") && !($_POST[$ddate] < "2008-01-01") && !($_POST[$ddate] > date('Y-m-d', time())) && $validdate)
										{	
											//set date
											//$date = $_POST[$year] .'-' .$_POST[$month].'-'.$_POST[$day];
											$date = $_POST[$ddate];
											
											//check these optional fiels before entering in db
											if ($_POST[commadd]==''){
												$comment='NULL';
											} else {
												$comment="'";
												$comment.=$dbh->real_escape_string($_POST['commadd']);
												$comment.="'";
											}
											
											if($_POST['common_name_userdef']){
												$species_comment="'";
												$species_comment .= $dbh->real_escape_string($_POST['common_name_userdef']);
												$species_comment .= ' ';
												$species_comment .= $dbh->real_escape_string($_POST['sci_name_userdef']);
												$species_comment .="'";
											} else {
												$species_comment = 'NULL';
												}
		
											//ADD TO 'TBL_OBSERVATIONS' TABLE
											$obsqry = sprintf("INSERT INTO tbl_observations
												(Observer_ID,
												Submission_ID,
												Station_ID,
												Species_ID,
												Phenophase_ID,
												Observation_Date,
												Comment,Species_Comment) 
												values (%d,%d,%d,%d,%d,'%s',%s,%s)",	 
												$dbh->real_escape_string($_POST['personid']),
												$dbh->real_escape_string($submissionid),
												$dbh->real_escape_string($_POST['stationid']),
												$dbh->real_escape_string($_POST['speciesid']),
												$dbh->real_escape_string($phenophaseid),
												$dbh->real_escape_string($date),
												$comment,
												$species_comment
												);
												
												//echo $obsqry;	//COMMENTED OUT BY DLW ON 3/39/11
												
												$obscheck = $dbh->query($obsqry);
												if (!$obscheck) {
													die('Could not enter report into database.
													Please contact the web manager - error: Observations Table');
												}
												$recordno = $dbh->insert_id;
												echo "<h2>Congratulations! We have received your observation!</h2><p>Your observation, number <strong> " . $recordno. "</strong> in the Project BudBurst database, has been reported!</p>";
												$obs_recorded_flag=1;
												
												//fetch common name for results 'echo' below
												$result_plantNames = get_plant($dbh,$speciesid);
							
												while($row_plantName = $result_plantNames->fetch_object())
												{
													$commonName = $row_plantName->Common_Name;
													$scientificName = $row_plantName->Species;
												}//while
												
												//fetch site location name
												$siteName = get_StationName($dbh,$_POST['stationid']);
												
										} //if phenophase reported
									} //while
								}// end for loop for each plant group possibility; gjn
							}
							else // species is a PBB species
							{
								//get ALL phenophases for budburst protocol  
								//echo  "speciesid = " .$speciesid;
								
								$phenophases = get_phenophase_species($dbh,$speciesid);
								
								if (!$phenophases)
								{
									die('No phenophases found in database.
									Please contact the web manager - error: report_obs_logged3 - phenophases not found');	
								}
								$no_phenophases = mysqli_num_rows($phenophases);
								//echo  "no phenophases = " .$no_phenophases;
										
								//cycle through phenophases
								while ($phenophase_row = $phenophases->fetch_object())
								{		
										//get phenophase id
										$phenophaseid = $phenophase_row->Phenophase_ID;
										//echo  "phenophaseid = " .$phenophaseid."<br>";
										
										//build post variables
										//$month = 'monthID'.$phenophaseid;
										//$day = 'dayID'.$phenophaseid;
										//$year = 'yearID'.$phenophaseid;
										$ddate = 'date' . $phenophaseid;
										//echo($month);
										//echo($day);
										//echo($year);

										//check for valid date
										$year = substr($_POST[$ddate], 0, 4);
										$month = substr($_POST[$ddate], 5, 2);
										$day = $day = substr($_POST[$ddate], 8, 2);
										$validdate = checkdate($month, $day, $year);

									//if (($_POST[$month] != "") && ($_POST[$day] != "") && ($_POST[$year] != ""))
									if (($_POST[$ddate] != "" ) && ($_POST[$ddate] != "0000-00-00") && !($_POST[$ddate] < "2008-01-01") && !($_POST[$ddate] > date('Y-m-d', time())) && $validdate)
									{		
										
										//set date
										//$date = $_POST[$year] .'-' .$_POST[$month].'-'.$_POST[$day];
										$date = $_POST[$ddate];
										
																		
										//check these optional fiels before entering in db
										if ($_POST[commadd]==''){
											$comment='NULL';
										} else {
											$comment="'";
											$comment.=$dbh->real_escape_string($_POST['commadd']);
											$comment.="'";
										}
										
										if($_POST['common_name_userdef']){
											$species_comment="'";
											$species_comment .= $dbh->real_escape_string($_POST['common_name_userdef']);
											$species_comment .= ' ';
											$species_comment .= $dbh->real_escape_string($_POST['sci_name_userdef']);
											$species_comment .="'";
										} else {
											$species_comment = 'NULL';
											}
	
										//ADD TO 'TBL_OBSERVATIONS' TABLE
										$obsqry = sprintf("INSERT INTO tbl_observations
											(Observer_ID,
											Submission_ID,
											Station_ID,
											Species_ID,
											Phenophase_ID,
											Observation_Date,
											Comment,Species_Comment) 
											values (%d,%d,%d,%d,%d,'%s',%s,%s)",	 
											$dbh->real_escape_string($_POST['personid']),
											$dbh->real_escape_string($submissionid),
											$dbh->real_escape_string($_POST['stationid']),
											$dbh->real_escape_string($_POST['speciesid']),
											$dbh->real_escape_string($phenophaseid),
											$dbh->real_escape_string($date),
											$comment,
											$species_comment
											);
	
											
											//echo $obsqry;	//COMMENTED OUT BY DLW ON 3/39/11
											
											$obscheck = $dbh->query($obsqry);
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
											$result_plantNames = get_plant($dbh,$speciesid);
						
											while($row_plantName = $result_plantNames->fetch_object())
											{
												$commonName = $row_plantName->Common_Name;
												$scientificName = $row_plantName->Species;
											}//while
											
											//fetch site location name
											$siteName = get_StationName($dbh,$_POST['stationid']);
																
									} //if phenophase reported
								} //while
							} // end else a PBB species
						
						////////////////////////////////////////////////////////////////
						
						if (!$obs_recorded_flag)
						{
							$maincontent .= '<p> Sorry, no valid observation date was reported.  Please go back and make sure you reported a date for your observation.</p>';
							$maincontent .= '<FORM>
							<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
							</FORM>';
							$maincontent .= '<p>If you continue to receive this error, please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.';
						
						}
						else
						{

							$maincontent.='<p>Your observation was for <strong> ' . $commonName . ' </strong> at the site: <strong>' . $siteName . '</strong></p>';
							$maincontent.='<p>What would you like to do next?</p>';
							$maincontent.='<div style="margin: 30px auto 0 auto; width: 660px; height: 100px; text-align:center;">'; 
							$maincontent.='<a href="my_regular_reports.php"><div class="buttons regReportSubmit">Enter Another<br/>Regular Report</div></a>'; 
							$maincontent.='<a href="mybudburst.php"><div class="buttons regReportSubmit">Go To Your<br />MyBudBurst</div></a>';
							$maincontent.='<a href="results.php"><div class="buttons regReportSubmit">View a Map <br />of All Reports</div></a>';
							$maincontent.="</div>";
						}
					}//if $flag
						
					//Clean up
					unset($_POST['stationid']);
					unset($_POST['personid']);
					unset($_POST['speciesid']);
					unset($submissionid);
					unset($phenophaseid);
					unset($date);
					unset($comment);
					unset($species_comment);
	
			} //if submit
				else{
					$maincontent .=  '<p>Please first select your MyBudBurst site/plant at which you are 
											observing.</P> ';
					$maincontent .= '<p>Please continue at 
					<a href="mybudburst.php" class="maincontent">MyBudBurst Space</a></p>';	
				}
			} //if logged in
			else {
				$maincontent .=  $not_logged_in_msg;	
			}

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