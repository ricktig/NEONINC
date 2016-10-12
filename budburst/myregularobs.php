<?php
/*------------------------------------------------
# Author: Dennis Ward (NEON)
# Last modified 2/12/2012
# Copyright 2008-2012 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';
require_once 'cgi-bin/pb_lib_kkm.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("My BudBurst Sites and Plants"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function()
	{ 


	
	});//end DOM load function


	//close plant delete text popup div
	function closeWindow()
	{
		$("#deleteplanttext").css('display', 'none');

	}	
</script>
<style type="text/css">
.new
{
	color: #F00;
}
</style>

<?php
//
HeaderEnd();
?>

<body>

<div id="wrapper">

 <div id="contentwrapper">
  	
    <div><a href="index.php"><img src="images/Banner_6.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>
    
    <div id="MainContent"> 
 
<?php
			// Check if user is not logged in
			if(!checklogin($dbh))
			{	
				$maincontent.="<h1>My BudBurst</h1>".
				"<h2>Welcome Guest!</h2>".
				"You will need to login to report occasional observations or view your personal BudBurst reports.".
				"To do so, <a href='login.php'>login</a> or <a href='register.php'>join</a> today!<p>".
				//"Once you have logged in, simply mark the dates of the <a href='help_phenophases.php'>phenophases</a> of trees, shrubs, or flowers in your community.".
				"Visit our <a href='getstarted.php'>Get Started</a> pages for complete information including a reporting form to help you note phenological changes as they occur throughout the year.</p>".
				"<ul>".
					"<li><a href='login.php'>Login</a> or 
						 <a href='register.php'>join</a> to become a member and start reporting observations today!</li>".
				"</ul>";
			}
				
			//logged in show content
			else
			{
				?>
				<h1 style="width:70%;">Enter Regular Reports - MyBudBurst Sites and Plants</h1>
						
				<?php 
				//get person_ID
				$personid = get_personID($dbh);
				if (!$personid)
				{
					die('personid not found');
				}
							
				//check to see if person is student - if so, set flag they have limited access...
				if (check_Student($personid, $dbh))
				{
					//set student flag
					$student = 1;
				} else $student = 0;
			  
				if ($student)
				{
					echo 'Here you will be able to report all your observations on any of your plants. 
					If you have any questions about the site or plant that is registered, please contact your teacher.';
				}
				else
				{
					//echo 'Here you will be able to save information about your observation sites and plants.
					//This allows you to report the dates of each phenophase as they occur throughout the season.</p>';
				}
			?>
			</p>
            <h2><?php echo $_SESSION['username'];?>'s Registered Sites and Plants</h2>
			<p>Each plant that you are contributing <a href="getstarted-regular-report.php">Regular Reports</a> for must be registered at a specific site. You may have more than one plant species registered at a site if they are located <strong>within a half mile</strong> of each other.
				<?php
				if ($student)
				{
					echo 'Please contact your teacher if the plant that you are observing is not found in your list below.';
				}
				?>
			</p>
				<ul>
					<?php
					if (get_k12teacher($dbh)&& !$student)
					{
						echo '<li><a href="register_site_classroom1.php">Register your classroom</a></li>';
					}
				  
					if (!$student)
					{
					  echo '
					  <li><a href="register_site.php">Register a new site</a></li>
					  <li><a href="register_plant_select_plant_group.php">Register a new plant</a> (You must first register a site.) </li> ';
					}
					?>
				</ul>
		                 
			
			<h2>You have registered the following sites:</h2>
			
						<?php //dynamically created site/plant display table 
						/*echo 'cleansessions';
						 $qry = "DELETE FROM tbl_sessions where End_DateTime < '%s'";
						  $qry = sprintf($qry, date('Y-m-d H:i:s'));
						  //echo $qry;
						 $dbh->query($qry);*/

						//get stations
						if (!$student)
						{
							$stations=get_myBudBurst_sites($personid, $dbh);
						}
						else
						{
						 	$stations=get_studentBudBurst_sites($personid, $dbh);
						}
						
						$no_stations=mysqli_num_rows($stations);
						
						if ($no_stations == '0')
						{  
							$maincontent.='<p><strong>No MyBudBurst Sites have been registered.</strong></p>';
							$maincontent.= $spacer;
						}	
						else
						{ 
							//$display.='';
							$display='';
							//okay to create display table
							while ($row = $stations->fetch_object())
							{
								//get station id
								$stationid=$row->Station_ID;
								//echo("stationid=$stationid");
								//get station name, if student look at 'rel_teacher_student_station' and Station tables
								if (!$student)
								{
									$stationname=$row->Station_Name;
								}
								else
								{
									$qry = sprintf("SELECT * FROM tbl_stations WHERE Station_ID = %d", $stationid );
									$result = $dbh->query($qry);
									//echo $qry;
									$row2 = $result->fetch_object();
									$stationname=$row2->Station_Name;
									//echo $stationname;
								}
									
								//new table for each new site
								$display.='<table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#C3D9A5" class="form">';
									
								//table row
								$display.='<tr><td><h3>';
								$display.=$stationname;
								$display.='</h3></td> <td>';
								if (!$student)
								{
									$display.='<form id="form1" name="form1" method="post" action="register_siteupdate.php">
									 <input name="" type="hidden" value="';
									$display.=$stationid;
									$display.='" />';
									$display.='<input name="submit" type="submit" id="update" value="Update ' . $stationname . '" />'; 
									$display.=' </form> ';  
								}
								$display.='</td><td>';
									
								if (!$student)
								{
									  $display.='<form id="form1" name="form1" method="post" action="register_plant_select_plant_group.php">
										  <input name="stationid" type="hidden" value="';
									 $display.=$stationid;
									 $display.='" />';
									 $display.='<input name="submit" type="submit" id="update" value="Add Plants" /></form>';
								}
								$display.='</td>';
								
								if (get_k12teacher($dbh) && !$student)
								{
									$display.='<td>
										<form id="form1" name="form1" method="post" action="manage_classroom.php">
										<input name="stationid" type="hidden" value="';
									$display.=$stationid;
									$display.='" /><input name="submit" type="submit" id="update" value="Manage Classroom" /></form></td>';
								}
								else $display.= '<td></td>';
								$display.='</tr>';	
									  
									//get registered plants at site
									$plants=get_myBudBurst_plants($stationid, $dbh);
											  
									if(!mysqli_num_rows($plants))
									{
													//no plants registered
													$display.='<tr><td colspan="4">';
													$display.='No plants registered at this site';
													$display.='</td></tr>';
												
									}
									else
									{ //build table rows for each plant
										//get plants
										while ($prow = $plants->fetch_object() )
										{
											//get common name from species id
											$speciesid=$prow->Species_ID;
											$species=get_Species($speciesid,$dbh);
											
											//$display.=$speciesid;
											if(!mysqli_num_rows($species))
											{
												//no common name found
												$display.=$display.='<tr><td colspan="4">';
												$display.='No plants found';
												$display.='</td></tr>';
											}
											else
											{
												$srow=$species->fetch_object();
												$commonname=$srow->Common_Name;
												//echo 'species id = ' . $speciesid;
												$imgID=$speciesid;
												$otherid = get_other_speciesID($dbh);
												//$no_species = get_no_PBBspecies($dbh);
												//hard coded this to acccount for special projects
												if ($imgID>999)//user defined image
												{ 
													$imgID=$otherid;
												}
												
												$display.='<tr><td ><img src="images/';
												$display.=$imgID;
												$display.='.jpg" alt="plant image" width="100" height="100" /></td>';
												$display.='<td colspan="2"><strong>';
												$display.=$commonname;
												$display.='<br /> </strong> </td>
												<td> <form id="form1" name="form1" method="post" action="report_obs_logged3.php">
												<input name="stationid" id="stationid" type="hidden" value="';
												$display.=$stationid;
												$display.='" /><input name="speciesid" id="speciesid" type="hidden" value="';
												$display.=$speciesid;
												$display.='" /><input name="personid" id="personid" type="hidden" value="';
												$display.=$personid;
												$display.='" /><input name="submit" type="submit" id="submit" value="Make A Regular Report of ' . $commonname . '!" /> </form>';
												
												if (!$student)
												{
													$display.='<form id="form1" name="form1" method="post" action="confirm_plant_delete.php">';
													$display.='<input name="stationid" type="hidden" value="';
													$display.=$stationid;
													$display.='" /><input name="speciesid" type="hidden" value="';
													$display.=$speciesid;
													$display.='" /><input id="commonname" name="commonname" type="hidden" value="';
													$display.=$commonname;
													$display.='" /><input id="sitename" name="sitename" type="hidden" value="';
													$display.=$stationname;
													$display.='" />';
													$display.='<input class="btnabc" type="submit" id="btndeleteplant" value="Delete" />';
													$display.='</form>';
												}
												$display.='</td></tr>';
													
											} //else common name found
										}//while plants
								}//else no plants registered
				
								$display .='</table>';
								
								$display .='<p>&nbsp;</p>';	  							
							}//while
						}//else		
						echo $display;		
			}//else logged in
			echo $maincontent;
			?>
    </div> <!-- MainContent -->
	
	<!--hidden delete alert text div -->
	<div id="deleteplanttext" class="popupmaphelp">
		You're about to delete <?php echo $commonname?> which will remove all of your reports of <?php echo $commonname ?> from <?php echo $stationname?>.<br /><br />
		Are you sure you want to delete <?php echo $commonname ?>?
		<form id="deleteplantform" name="deleteplantform" method="post" action="register_plant_delete.php" style="margin: 10px 0 0 0">
			<input name="deleteplantformsitename" type="hidden" />
			<input name="deleteplantformcommonname" type="hidden" />
			<div style="text-align:center">
				<input name="deleteplantsubmit" type="submit" id="deleteplantsubmit" value="Yes" />
				<input name="deleteplantcancel" type="button" id="deleteplantcancel" onclick="closeWindow()" value="Cancel" />
			</div>
		</form>
	</div><!--end hidden help text div-->
	
    <!-- Footer -->
    
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
