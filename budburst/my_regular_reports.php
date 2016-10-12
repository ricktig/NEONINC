<?php
/*------------------------------------------------
# Author: Dennis Ward (NEON)
# Modified by: Rick Rose
# Last modified 12/3/2012
# Copyright 2008-2013 All Rights Reserved	
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
HeaderStart("My BudBurst Sites and Plants"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script type="text/javascript">
	// document load - assign JavaScript variables from URL PHP variables
	$(function()
	{
		//function to display map help text pop up window
		$("#btnhelp").click(function()
		{
			$("#helptext").css('display', 'block');
		});
	});

	//close map help text popup div
	function closeWindow()
	{
		$(".popupmaphelp").css('display', 'none');
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
 
	<?php
			// Check if user is not logged in
			if(!checklogin($dbh))
			{	
				$maincontent.="<h1>My BudBurst</h1>".
				"<h2>Welcome Guest!</h2>".
				"You will need to login to make regular reports or view your MyBudBurst page. ".
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
				<h1 style="width:70%;"><?php echo $_SESSION['username'];?>'s My Regular Reports Page</h1>
						
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
				
				//check to see if person is teacher - if so, set flag
				if (get_k12teacher($dbh))
				{
					//set student flag
					$teacher = 1;
					
				} else $teacher = 0;
			  
				if ($student)
				{
					echo 'Here you will be able to report all your observations on any of your plants. 
					If you have any questions about the site or plant that is registered, please contact your teacher.';
				}
				
				if (!$student)
				{
					echo 'Here you will be able to save information about your Regular Report sites and plants.
					This allows you to report the dates of each phenophase as they occur throughout the season.</p>';
				}
				
				
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
				
				/*//fetch success flag, if set, indicating whether previous page was a successful site or plant addition
				//and display success message
				if(isset($_POST['successflag']))
				{
					if($_POST['successflag']==1)
					{
						//successful site addition
						$successmessage .= "You've successfully registered a new site!";
						$successmessage .= "Now you'll need to add a plant to the site.  Click on the 'Add A Plant' button below";
					}
					
					if($_POST['successflag']==2)
					{
						//successful plant addition
						$successmessage .= "You've successfully registered a new plant!";
						$successmessage .= "Now you'll need to report your observation.  Click on the 'Tell Us About..' button below";
					}
					
					echo $successmessage;
				}*/
			?>

			<div id="helptext" class="popupmaphelp">
				<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>
				<p>Each plant that you are contributing Regular Reports for must be registered at a specific site. You may have more than one plant species registered at a site.
					<?php
					if ($student)
					{
						echo 'Please contact your teacher if the plant that you are observing is not found in your list below.';
					}
					?>
				</p>
			</div>
		    			
						<?php //dynamically created site/plant display table 
						/*echo 'cleansessions';
						 $qry = "DELETE FROM tbl_sessions where End_DateTime < '%s'";
						  $qry = sprintf($qry, date('Y-m-d H:i:s'));
						  //echo $qry;
						 $dbh->query($qry);*/
						
						if ($no_stations == '0')
						{  
							//no sites - display message
							$maincontent.='<div id="headerholder">';
							$maincontent.='<div style="width:390px;float:left"><strong>Hello!  We\'ve noticed that you haven\'t registered any sites yet.</strong><br /><br />
							Here\'s how to start:</div>';
							$maincontent.= '<img src="images/help.png" style="vertical-align:bottom; float:left" id="btnhelp" />';
							$maincontent.='<div style="clear:both"></div>';
							$maincontent.='<a href="regular-report-site.php" class="buttons">';
							$maincontent.='<img width="22" height="22" align="left" alt="Add A Site" src="./images/icons/addSite_icon.png">Add a Site</a>';
							$maincontent.='</div>';
							$maincontent.= $spacer;
						}	
						else
						{ 
							//yes sites - display site 'header' text
							//display non-student header text
							if(!$student)
							{
								$maincontent.='<div id="headerholder">';
								$maincontent.= '<div style="float:left">Here are your registered site(s) and plant(s):</div>';
								$maincontent.= '<img src="images/help.png" style="vertical-align:bottom; margin:0 0 0 5px; float:left" id="btnhelp" />';
								$maincontent.= '<a href="regular-report-site.php" class="btnregister">Add a Site</a>';
								$maincontent.='</div>';
							}
							else
							{
								//display student header text
								$maincontent.='<div id="headerholder">';
								$maincontent.= '<div style="float:left">Here are the plant(s) registered for you at your classroom:</div>';
								$maincontent.= '<img src="images/help.png" style="vertical-align:bottom; margin:0 0 0 5px; float:left" id="btnhelp" />';
								$maincontent.='</div>';
							}
						
							//$display.='';
							$display='';
							//okay to create div for each site
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
								{ //student - fetch classroom
									$qry = sprintf("SELECT * FROM tbl_stations WHERE Station_ID = %d", $stationid );
									$result = $dbh->query($qry);
									//echo $qry;
									$row2 = $result->fetch_object();
									$stationname=$row2->Station_Name;
									//echo $stationname;
								}
									
								//new div for each new site
								$maincontent.='<div class="siteholder">';
									
								//table row
								$maincontent.='<h2><span style="font-weight:normal">Plants for Site Name:</span> ';
								$maincontent.=$stationname;
								$maincontent.='</h2>';
								//$maincontent.='<div id="stationname">';


								//manage classroom button for teacher
								if ($teacher)
								{
									$maincontent.='<form id="form1" name="form1" method="post" style="float:left"action="manage_student_accounts.php">
										<input name="stationid" type="hidden" value="';
									$maincontent.=$stationid;
									$maincontent.='" /><input name="submit" type="submit" id="update" class="btnManage" value="Manage Student Accounts" /></form>';
								 }
								//$maincontent.='</div>';
								
									//display add plant button
									if (!$student)
									{
										//$maincontent.='<div id="addplantholder">';
										$maincontent.='<form id="form1" name="form1"  class="button2" style="float:left" method="post" action="regular-report-plant-group.php">
											<input name="stationid" type="hidden" value="';
										$maincontent.=$stationid;
										$maincontent.='" />';
										$maincontent.='<input name="submit" type="submit" id="update" class="btnAddPlant" value="Add A Plant To ' . $stationname . '" /></form>';
										//$maincontent.='</div>';
										
									}
									$maincontent.='<br clear="all"/>';
									//get registered plants at site
									$plants=get_myBudBurst_plants($stationid, $dbh);

									//no plants registered									
									if(!mysqli_num_rows($plants))
									{
										//if not student or teacher, display message indicating successful registration
										//and plants need to be added
										if (!$student && !$teacher)
										{
											$maincontent.='<div id="messageholder">';
											$maincontent.='<div class="plantholder">';
											$maincontent.='Congratulations!  You\'ve successfully registed a new site. ';
											$maincontent.='Now you need to add a plant to this site. ';
											$maincontent.='Click the button above to add a plant to ' . $stationname . '.';
											$maincontent.='</div>';
											$maincontent.='</div>';
										}
										
										//student - display message directing student to contact teacher to add a plant
										if($student)
										{
											$maincontent.='<div id="messageholder">';
											$maincontent.='<div class="plantholder">';
											$maincontent.='It doesn\'t look like any plants have been added to your classroom. ';
											$maincontent.='Contact your teacher to have him/her add plants so you can make your report.';
											$maincontent.='</div>';
											$maincontent.='</div>';										
										}
										
										//student - display message directing student to contact teacher to add a plant
										if ($teacher)
										{
											$maincontent.='<div id="messageholder">';
											$maincontent.='<div class="plantholder">';
											$maincontent.='Congratulations!  You\'ve successfully registed a new classroom. ';
											$maincontent.='Now you need to add a plant to this classroom. ';
											$maincontent.='Click the button below to add a plant to ' . $stationname . '.';
											$maincontent.='</div>';
											$maincontent.='</div>';									
										}
										//$display.='</div>';
												
									}
									else
									{ //plants found for this user - build table rows for each plant
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
												$maincontent.='<div id="messageholder">';
												$maincontent.='No plants found';
												$maincontent.='</div>';
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
												
												$maincontent.='<div class="plantholder"><img class="imageholder" src="images/';
												$maincontent.=$imgID;
												$maincontent.='.jpg" alt="plant image" width="100" height="100" />';
												$maincontent.='<div class="plantname"><h3>';
												$maincontent.=$commonname;
												$maincontent.=' </h3></div>
												<form id="form1" name="form1" method="post" class="button1" action="regular-report-submit.php">
												<input name="stationid" id="stationid" type="hidden" value="';
												$maincontent.=$stationid;
												$maincontent.='" /><input name="speciesid" id="speciesid" type="hidden" value="';
												$maincontent.=$speciesid;
												$maincontent.='" /><input name="personid" id="personid" type="hidden" value="';
												$maincontent.=$personid;
												$maincontent.='" />';
												$maincontent.='<input class="btnmake" type="submit" id="btnmake" value="Make A Report" />';
												$maincontent.='</form>';
												
												if (!$student)
												{
													$maincontent.='<form id="form1" name="form1"  class="button1" method="post" action="regular-report-plant-delete-confirm.php">';
													$maincontent.='<input name="stationid" type="hidden" value="';
													$maincontent.=$stationid;
													$maincontent.='" /><input name="speciesid" type="hidden" value="';
													$maincontent.=$speciesid;
													$maincontent.='" /><input id="commonname" name="commonname" type="hidden" value="';
													$maincontent.=$commonname;
													$maincontent.='" /><input id="sitename" name="sitename" type="hidden" value="';
													$maincontent.=$stationname;
													$maincontent.='" />';
													$maincontent.='<input class="btnabc" type="submit" id="btndeleteplant" value="Delete" />';
													$maincontent.='</form>';
												}
												$maincontent.='</div>';
																	
											} //else common name found
										}//while plants
										
									}//else check for registered plants


	
								$maincontent.='</div>';//end siteholder
							}//end while display site div
							

									//display update site button
									if (!$student)
									{
										$maincontent.='<p>To request a change to a site such as name or longitude/latitude coordinates, please <a href="mailto:budburstweb@neoninc.org">email</a> the webmaster.</p>';
									}
							
						}//else	sites found	
						//echo $display;		
			}//else logged in
			echo $maincontent;
			?>
 	<!--hidden delete alert text div -->
	<div id="deleteplanttext" class="popupmaphelp">
		You're about to delete <?php echo $commonname?> which will remove all of your reports of <?php echo $commonname ?> from <?php echo $stationname?>.<br /><br />
		Are you sure you want to delete <?php echo $commonname ?>?
		<form id="deleteplantform" name="deleteplantform" method="post" action="regular-report-plant-delete.php" style="margin: 10px 0 0 0">
			<input name="deleteplantformsitename" type="hidden" />
			<input name="deleteplantformcommonname" type="hidden" />
			<div style="text-align:center">
				<input name="deleteplantsubmit" type="submit" id="deleteplantsubmit" value="Yes" />
				<input name="deleteplantcancel" type="button" id="deleteplantcancel" onclick="closeWindow()" value="Cancel" />
			</div>
		</form>
	</div><!--end hidden help text div-->

</div> <!-- MainContent -->
	

	
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
