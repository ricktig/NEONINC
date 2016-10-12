<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/5/2012
# Copyright 2008-2011 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<style>
.div_calendar
{
	z-index:999;
	position:relative;
	top:5px;
	left: 245px;
	border: 1px solid grey;
	width:164px;
	height:188px;
}
</style>

<?php
HeaderStart("Project BudBurst - Report a BudBurst Observation"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>
<script language="javascript" src="js/calendar/calendar.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script type="text/javascript">
	//close help div
	function closeWindow()
	{
		$("#popupdateerror").css('display', 'none');
	}
	


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
      
      <h1>Enter Regular Report - Observation</h1>
      
      <?php 
			  $maincontent ='';
			  $display_table='';
			  
			  if(checklogin($dbh))
			  {	
				//check for missing fields
				//if( isset($_POST['submit']) &&	isset($_POST['stationid']) && 
					//isset($_POST['personid']) && ($_POST['speciesid'] != 0) ){
					
				if( isset($_POST['stationid']) && 
					isset($_POST['personid']) && ($_POST['speciesid'] != 0) ){
						
					$personid = $_POST['personid'];
					$stationid = $_POST['stationid'];
					$speciesid = $_POST['speciesid'];
					
					$imgID=$speciesid;
					
					//echo 'personid: ' . $personid;
					//echo 'stationid: ' . $stationid;
					//echo 'speciesid: ' . $speciesid;
					
					if (isset($_POST['stationname']))
					{
							$stationname = $_POST['stationname'];
					}
					else
					{
					   // get station name from selected station id
						$qry = sprintf("SELECT Station_Name from tbl_stations WHERE Station_ID = %d",
									$stationid );
						$check = $dbh->query($qry);
						if (!$check)
						{
							die('That station id does not exist in our database. 
							Please contact the web manager - error: regular-report-submit.php - station name not found');
						}
						while ($row = $check->fetch_object())
						{
							$stationname = $row->Station_Name;
						}
					} //else
					
					//get the plant group for this species
					$plantgroupid=get_plant_group_ID($dbh,$speciesid);
					
					//echo 'plantgroupid: ' . $plantgroupid;
					
					//assign plantgroupid to imgID so plant group icon is displayed
					if ($imgID>999)
					{ //if older observation without specified plantgroupid, display image 999 - other
						if ($plantgroupid == 6)
						{
							$imgID='images/' . $otherID . '.jpg';
						}
						else
						//display plantgroup icon
						{
							$imgID = 'images/icons/100plantgroup/' . $plantgroupid . '.png';
						}
					}
					else
					{
					//display speciesid image
						$imgID = 'images/' . $speciesid . '.jpg';
					}
					
					//get common name 
					$species=get_Species($speciesid,$dbh);
					
					if(!mysqli_num_rows($species)) //no common name found
					{
						$commonname='';
					}
					else
					{
						$srow=$species->fetch_object();
						$commonname=$srow->Common_Name;
					}
					
					$user_defined=$srow->User_Defined;
					?>

					<p>Site Location  <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Select  Plant <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> <strong>Report Observation</strong></p>
					<p>&nbsp;</p><br />
					<div id="obsholder" style="border:1px solid grey;background-color:#EAE5E5;">
					<div style="width:520px;height:100px;padding:15px;">
                        <div style="width:400px;float:left">
							MyBudBurst Site: <strong><?php echo $stationname;?></strong><br/>
							MyBudBurst Plant: <strong><?php echo $commonname;?></strong>
						</div>
                        <img src="<?php echo $imgID;?>" alt="<?php echo $commonname?>" width="100" height="100" style="float:right;border:1px solid grey" />


					</div>
					<form id="form1" name="form1" method="post" action="regular-report-submit-do.php">
					
					<input name="personid" type="hidden" value="<?php echo $personid;?>" />
					<input name="stationid" type="hidden" value="<?php echo $stationid;?>" />
					<input name="stationname" type="hidden" value="<?php echo $stationname;?>" />
					<input name="speciesid" type="hidden" value="<?php echo $speciesid;?>" />
					<table class="form" width="550" border="0" cellpadding="0" cellspacing="0" bgcolor="#EAE5E5">
                      <tbody>
                        <tr>
                          <td colspan="2"><div style="margin-left:15px"><strong>WHEN</strong> DID YOU OBSERVE?</div></td>
                        </tr>
					
					<?php
					$tabindex=1;
					
					if ($user_defined==1) // other species user defined; gjn
					{
						//cycle through phenophases for each ith plant group to show all 2011 possible phenophases
						//as options for user defined species; gjn
						
						//echo("user defined");
						
						$plantgroupnames=array(
							'Wildflowers and Herbs',
							'Grasses',
							'Deciduous Trees and Shrubs',
							'Evergreen Trees and Shrubs',
							'Conifers');
						
						//if older other species observation without user selected plant group, display all plant groups and phenophase
						//else display phenophase for newer other species observations selected plant group
						if($plantgroupid==6)
						{
							//display all plant groups and phenophases for older other species observations
							for ($i=1;$i<=5;$i++)
							{
								//create variable for each plant group name; gjn
								${phenophases.$i} = get_phenophase_plant_group($dbh,$i);
								
								if (!${phenophases.$i})
								{
									die('No phenophases found in database.
									Please contact the web manager - error: regular-report-submit.php - phenophases not found');	
								}
								$no_phenophases = mysqli_num_rows(${phenophases.$i});
								//echo 'no phenophases: ' . $no_phenophases;
								//new table row for ith plant group name column heading
								?>
								
								<tr>
								<td colspan="2">
									<b>
									<?php echo $plantgroupnames[$i-1];?>
									</b>
								</td>
								</tr>
								
								<?php
								// write phenophases for the ith plant group; gjn
								while ($phenophase_row = ${phenophases.$i}->fetch_object())
								{
									//new table row
									echo '<tr>';
						
									//get phenophase id
									$phenophaseid = $phenophase_row->Phenophase_ID;
		
									//build table row
									$phenophase_name=$phenophase_row->Phenophase_Name;
									//echo "Phenophase ID " . $phenophaseid . " and Name:";
									//echo"<br>";
									echo '<td width="220"><div align="right">'; // 220
									echo $phenophase_name; 
									echo ':</div></td>';
									
									echo '<td>';
									
									//check if user reported this phenophase for this season/year
									//check if user reported any phenophase for this season/year for this species and station
									//get all reported phenophase observations for species and station and pp
									
									//echo("speciesid=$speciesid");
									
									$reported_obs_pp = get_user_obs_pp($personid,$stationid,$speciesid,$phenophaseid,$dbh);
								
									//if (($reported_obs_id == $phenophaseid) && ($reported_obs_date_year >= $current_year))
								
									$reported_obs_pp_row = $reported_obs_pp->fetch_object();
									$reported_obs_pp_date = $reported_obs_pp_row->Observation_Date;
									$reported_obs_pp_date_year = mb_substr($reported_obs_pp_date,0,4);
								
									// we got rows; the 1st row has obsdate >= current year
									if((mysqli_num_rows($reported_obs_pp))&&($reported_obs_pp_date_year >= $current_year)) 
									{	
										echo '&nbsp; <b> Already reported on: ';
										echo date("F j, Y", strtotime($reported_obs_pp_date));
										echo '</b>';
									}	
									else // no prior obs in this year for this pp
									{
										//START NEW DATE PICKER
										//get class into the page
										require_once('js/calendar/classes/tc_calendar.php');
										//$today = date("Y-m-d");
										$curYear = date("Y");
										//instantiate class and set properties
										$myCalendar = new tc_calendar("date$phenophaseid", true);
										$myCalendar->setIcon("js/calendar/images/iconCalendar.gif");
										//don't preset date
										//$myCalendar->setDate(date('d'), date('m'), date('Y'));
										$myCalendar->setPath("js/calendar/");
										$myCalendar->setYearInterval(2008, $curYear);
										$myCalendar->dateAllow('2008-01-01', date("Y-m-d"));
										$myCalendar->writeScript();
										// END NEW DATE PICKER									
									}	
									echo '</td>';
									echo '</tr>';
								} //while
							}//end loop through all five plant groups
						}
						else
						//newer 'other species' observation - only display phenophases for selected plant group
						{
							//fetch phenophases for specific plantgroupid
							$phenophases = get_phenophase_plant_group($dbh,$plantgroupid);
							
							if (!$phenophases)
							{
								die('No phenophases found in database.
								Please contact the web manager - error: regular-report-submit.php - phenophases not found');	
							}
							$no_phenophases = mysqli_num_rows($phenophases);
						
						// write phenophases for the ith plant group; gjn
							while ($phenophase_row = $phenophases->fetch_object())
							{
								//new table row
								echo '<tr>';
					
								//get phenophase id
								$phenophaseid = $phenophase_row->Phenophase_ID;
	
								//build table row
								$phenophase_name=$phenophase_row->Phenophase_Name;
								//echo "Phenophase ID " . $phenophaseid . " and Name:";
								//echo"<br>";
								echo '<td width="220"><div align="right">'; // 220
								echo $phenophase_name; 
								echo ':</div></td>';
								
								echo '<td>';
								
								//check if user reported this phenophase for this season/year
								//check if user reported any phenophase for this season/year for this species and station
								//get all reported phenophase observations for species and station and pp
								
								//echo("speciesid=$speciesid");
								
								$reported_obs_pp = get_user_obs_pp($personid,$stationid,$speciesid,$phenophaseid,$dbh);
							
								//if (($reported_obs_id == $phenophaseid) && ($reported_obs_date_year >= $current_year))
							
								$reported_obs_pp_row = $reported_obs_pp->fetch_object();
								$reported_obs_pp_date = $reported_obs_pp_row->Observation_Date;
								$reported_obs_pp_date_year = mb_substr($reported_obs_pp_date,0,4);
							
								// we got rows; the 1st row has obsdate >= current year
								if((mysqli_num_rows($reported_obs_pp))&&($reported_obs_pp_date_year >= $current_year)) 
								{	
									echo '&nbsp; <b> Already reported on: ';
									echo date("F j, Y", strtotime($reported_obs_pp_date));
									echo '</b>';
								}	
								else // no prior obs in this year for this pp
								{
									//START NEW DATE PICKER
									//get class into the page
									require_once('js/calendar/classes/tc_calendar.php');
									//$today = date("Y-m-d");
									$curYear = date("Y");
									//instantiate class and set properties
									$myCalendar = new tc_calendar("date$phenophaseid", true);
									$myCalendar->setIcon("js/calendar/images/iconCalendar.gif");
									//don't preset date
									//$myCalendar->setDate(date('d'), date('m'), date('Y'));
									$myCalendar->setPath("js/calendar/");
									$myCalendar->setYearInterval(2008, $curYear);
									$myCalendar->dateAllow('2008-01-01', date("Y-m-d"));
									$myCalendar->writeScript();
									// END NEW DATE PICKER									
								}	
								echo '</td>';
								echo '</tr>';
							} //while
						}//end if older 'other species' observation
					}
					else // pbb species
					{
						$phenophases=get_phenophase_plant_group($dbh,$plantgroupid);
						
						if (!$phenophases)
						{
							die('No phenophases found in database.
							Please contact the web manager - error: regular-report-submit.php - phenophases not found');	
						}
						$no_phenophases = mysqli_num_rows($phenophases);
						//echo  "no phenophases = " .$no_phenophases;
						
						//cycle through phenophases
						while ($phenophase_row = $phenophases->fetch_object())
						{			
							//new table row
							echo '<tr>';
				
							//get phenophase id
							$phenophaseid = $phenophase_row->Phenophase_ID;
							//echo("phenophase id for spid 101 = ".$phenophaseid."<br>");
							
							//build table row
							$phenophase_name=$phenophase_row->Phenophase_Name;
							//echo "Phenophase ID " . $phenophaseid . " and Name:";
							//echo"<br>";
							echo '<td width="220"><div align="right">';
							//$display_table.= $phenophaseid." - ".$phenophase_name;
							echo $phenophase_name;
							echo ':</div></td>';
							
							echo '<td>';
							
							//check if user reported any phenophase for this season/year for this species and station
							//get all reported phenophase observations for species and station and pp
							
							$reported_obs_pp = get_user_obs_pp($personid,$stationid,$speciesid,$phenophaseid,$dbh);
							
							//if (($reported_obs_id == $phenophaseid) && ($reported_obs_date_year >= $current_year))
							
							$reported_obs_pp_row = $reported_obs_pp->fetch_object();
							$reported_obs_pp_date = $reported_obs_pp_row->Observation_Date;
							$reported_obs_pp_date_year = mb_substr($reported_obs_pp_date,0,4);
							
							// we got rows; the 1st row has obsdate >= current year
							if((mysqli_num_rows($reported_obs_pp))&&($reported_obs_pp_date_year >= $current_year)) 
							{	
								echo '&nbsp; <b> Already reported on: ';
								echo date("F j, Y", strtotime($reported_obs_pp_date));
								echo '</b>';
							}
							else
							{
								//START NEW DATE PICKER
								//get class into the page
								require_once('js/calendar/classes/tc_calendar.php');
								//$today = date("Y-m-d");
								$curYear = date("Y");
								//instantiate class and set properties
								$myCalendar = new tc_calendar("date$phenophaseid", true);
								$myCalendar->setIcon("js/calendar/images/iconCalendar.gif");
								//don't preset date
								//$myCalendar->setDate(date('d'), date('m'), date('Y'));
								$myCalendar->setPath("js/calendar/");
								$myCalendar->setYearInterval(2008, $curYear);
								$myCalendar->dateAllow('2008-01-01', date("Y-m-d"));
								$myCalendar->writeScript();
								// END NEW DATE PICKER					
							}	
							echo '</td>';
							echo '</tr>';			
						} //while
					}// end else
					
					//echo $display_table; // really only displaying 'n' number of rows of the table; gjn
					
					?>

					<td colspan="2"><div align="center"></div></td>
                          </tr>
                        <tr>
                          <td width="220" valign="top"><div class="style5" align="right">
                              <label for="commadd">Additional Comments: </label>
                          </div></td>
                          <td width="360"><div align="left">
                              <textarea name="commadd" cols="40" id="commadd" tabindex="30"></textarea>
                          </div></td>
                        </tr>
                      </tbody>
                    </table>
					<p align="center">
						<input name="submit" type="submit" id="submit" value="Submit" />
				    </p>
					</form>
			</div><!--end obsholder div-->
			<!--hidden help text div -->
				<div id="popupdateerror">
					<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>
					Please enter a valid date between January 1, 2008 and <?php echo date("F j, Y");?>.
				</div><!--end hidden help text div-->

				<?php
				} //if submit/missing fields
				else
				{
				$maincontent.='<p> Sorry, no plant was selected.  Please go back and select the plant for your observation.</p>
							<FORM>
							<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
							</FORM>
							<p>If you continue to receive this error, please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.';
				} //else
			} //if logged in
			else
			{
					$maincontent .=  '<p>Sorry you are not logged in, 
											this area is restricted to registered members. ';
					$maincontent .= '<a class="maincontent" href="login.php">Click here</a> to log in.</p>';	
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