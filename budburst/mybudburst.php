<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/10/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';
//require_once 'cgi-bin/pb_lib_kkm.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("My BudBurst Page"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>

<style type="text/css">
.new
{
	color: #F00;
}

#myDataTable th{
font-size: 85%;
}

#myDataTable td{
font-size: 85%;
}

#myTeacherDataTable th{
font-size: 85%;
}

#myTeacherDataTable td{
font-size: 85%;
}
.buttonholder p {padding:13px 0 0 0}
</style>


<!-- JAVASCRIPT AND CSS REQUIRED FOR DISPLAY OF DATA TABLES -->
<style type="text/css" title="currentStyle"> 
	@import "js/DataTables-1.9.4/media/css/demo_page.css";
	@import "js/DataTables-1.9.4/media/css/demo_table.css";
	@import "js/DataTables-1.9.4/extras/TableTools/media/css/TableTools.css";
</style> 
<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/media/js/jquery.js"></script> 
<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="js/DataTables-1.9.4/extras/TableTools/media/js/TableTools.min.js"></script>
<script type="text/javascript" charset="utf-8"> 
	$(document).ready( function ()
	{
		//DataTable object for non-teachers	
		$('#myDataTable').dataTable( {
			"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
						"sSwfPath": "js/DataTables-1.9.4/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
					}, //END OF oTablesTools
			"sPaginationType": "full_numbers",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "aaSorting": [[0,'desc']]

/*			"aoColumnDefs": [
				{ "asSorting": [ "desc" ], "aTargets": [ 0 ] }, //set date to desc sort	
				] //END OF aoColumnDefs
					
*/		}); //END OF myDataTable - non-teachers

		//DataTable object for teachers - adds reporters column
		$('#myTeacherDataTable').dataTable( {
			"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
						"sSwfPath": "js/DataTables-1.9.4/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
					}, //END OF oTablesTools
			"sPaginationType": "full_numbers",
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "aaSorting": [[0,'desc']]

/*			"aoColumnDefs": [
				{ "asSorting": [ "desc" ], "aTargets": [ 0 ] }, //set date to desc sort	
				] //END OF aoColumnDefs
					
*/		}); //END OF myTeacherDataTable - teachers

		//function to display dataviewer help text pop up window
		$("#btnhelp").click(function()
		{
			$("#dataviewerhelp").css('display', 'block');
		});
		
	} ); //END OF $.ready FUNCTION
	
	//close help pop up div
	function closeWindow()
	{
		$("#dataviewerhelp").css('display', 'none');
	}
	
</script> 
<!-- END OF DATA TABLE INCLUDES AND SCRIPTS-->


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
						
						//not logged in
						?>
						<h1>My BudBurst</h1>
						<h2>Welcome Guest!</h2>
						
						You will need to login to make regular reports or view your MyBudBurst page.
						To do so, <a href='login.php'>login</a> or <a href='register.php'>join</a> today!<p>
						Visit our <a href='getstarted.php'>Get Started</a> pages for complete information including a reporting form to help you note phenological changes as they occur throughout the year.</p>
						<ul>
							<li><a href='login.php'>Login</a> or <a href='register.php'>join</a> to become a member and start reporting observations today!</li>
						</ul>


					<?php
					}
					//logged in
					else
					{
						//check for first time at this page
						if(($_GET['NewRegistration']))
						{
							echo "<h3>Thank you for registering!</h3>";
						}
					?>
			  		<h1><?php echo $_SESSION['username']; ?>'s MyBudBurst Page <!-- $WelcomeBackText --></h1>
			  		
                    <p>Welcome to your personal MyBudBurst Page! This is the page you will see each time you log into your Project BudBurst Account. Here you can submit observations and manage your account. You can also review, search, and even download information about the reports you have submitted.</p>


		<div class="outerholder">
			<div class="buttonholder">
					<a href="my_regular_reports.php" class="buttons" style="width:177px;height:70px;display:table-cell;vertical-align:middle">Regular Reports</a>
				<p>Simply register, select a plant(s), make observations of your plants throughout the seasons, and submit your data. By choosing this approach, you benefit from having permanent site records that can be compared from year to year.</p>  
			</div>
			<div class="buttonholder">
				<a href="single-report-plant-group.php" class="buttons" style="width:177px;height:70px;display:table-cell;vertical-align:middle">Single Reports</a>
				<p>If you are traveling, planning a hike, or can't make regular visits to a site, Single Reports may be the right approach for you. Register, select a plant, make a one-time observation of your plant, and submit your data.</p> 
			</div>
			
			<?php
				//check for first time at this page
				//display button to prompt user to join newsletter 
				if(($_GET['NewRegistration']))
				{
			?>
					<!--change width/height of outerholder div to hold buttons to accomodate third button on new registration-->
					<script>
					$(".outerholder").css("width","720px");
					$(".outerholder").css("height","240px");
					</script>
					<div class="buttonholder">
						<a href="http://tinyurl.com/bj6rxff" target="_blank" class="purplebuttons" style="width:177px;height:70px;display:table-cell;vertical-align:middle"><img src="images/icons/MailingList.png" alt="Mailing List" width="40" height="42" align="left" />Subscribe to the<br/>Project BudBurst<br/>Newsletter</a>
						<p>Receive the latest project news and results at the beginning of each month.</p> 
					</div>
						

					
			<?php
				}
			?>
		</div>

		<br style="clear: left;" />

		<hr />
	
 		<h1>MyBudBurst Data Viewer</h1> <!-- $WelcomeBackText -->	
		
		<!--hidden div used to pop up help text for data viewer-->
		<div id="dataviewerhelp">
			<img src="images/red_close_button.png" alt="close help window button" class="btnclosewindow" id="btnclosewindow" onclick="closeWindow()"/>
			<p>The table below displays all of the reports that you've made in Project BudBurst. By default, the data is sorted by the date on which the phenophase occurred. Clicking the up and down arrows next to each column name allows you to sort on any value.  If there have been more than 10 observations submitted, you can choose how many to display at a time using the &quot;Show __ entries&quot; control. You can also page through the data using the forward and back arrows at the bottom right of the table.</p>
			<p>The Search box allows you to search all of the data. Searching by date, species, phenophase, etc. is easy&#8212;just start typing and the table will immediately change to contain only observations that contain your search phrase. Do you want to see only 2011 observations? Just type &quot;2011&quot; in the search box. Only want to see maples? Enter &quot;Acer.&quot; You can combine searches, too! Searching for &quot;acer 2011&quot; will narrow your results to only the maples that were observed in 2011 (assuming that any observations exist, of course).</p>
			<p>Once you have your results in the order desired, you can use any of the buttons above the search box to copy the results to the clipboard; save them as a text, spreadsheet, or PDF file; or even print them from your browser!</p>
		</div><!--end dataviewerhelp div-->

		<div>
				<h2 style="float:left;margin: 1px 0 0 0;padding:0"><?php echo $_SESSION['username']; ?>'s reports:</h2>
				<img src="images/help.png" alt="help button" style="float:left;margin: 0 0 0 5px" id="btnhelp" />
		</div>

		  
              <?php 
			//DENNIS'CODE FOR DATA RETRIEVAL
			
				// Connects to your Database 
 				mysql_connect("$host", "$username", "$password") or die(mysql_error()); 
 				mysql_select_db("$database") or die(mysql_error());
				$username=$_SESSION['username'];
				
				$UserID=get_personID($dbh);
				
				
				//check if logged in user is a teacher to fetch a different dataset for DataViewer
				if(get_k12teacher($dbh))
				{
						//fetch reporter observations on reporter name & underscore
						$reporterresult = mysql_query("SELECT tbl_observations.ID, tbl_stations.Station_Name, tbl_users.User_ID, tbl_users.UserName, tbl_observations.Species_ID, tbl_observations.Phenophase_ID, tbl_observations.Observation_Date
						FROM (tbl_stations INNER JOIN tbl_observations ON tbl_stations.Station_ID = tbl_observations.Station_ID) INNER JOIN tbl_users ON tbl_observations.Observer_ID = tbl_users.User_ID
						WHERE ((tbl_users.UserName) Like '" .$username. "\_%')");
						
						//fetch teacher observations on teacher userid
						$teacherresult = mysql_query("SELECT O.ID AS ID, 
												ST.Station_Name AS Site, 
												S.Common_Name AS Common, 
												S.Species AS Species, 
												P.Phenophase_Name AS Phenophase, 
												O.Observation_Date AS Date
										FROM tbl_observations as O 
										JOIN tbl_species as S on (O.Species_ID = S.Species_ID) 
										LEFT JOIN tbl_phenophases as P on (O.Phenophase_ID = P.Phenophase_ID) 
										LEFT JOIN tbl_stations as ST on (O.Station_ID = ST.Station_ID) 
										WHERE O.Observer_ID = ".$UserID." 
										");
										
					//check for observations for this teacher
					if(mysql_num_rows($reporterresult)==0 && mysql_num_rows($teacherresult)==0  )
					{
						$error .= '<br /><div style="width:500px; height:200px; margin:50px auto 0 auto; padding:0 30px 0 30px; border:1px solid grey">
						<p>This is where you\'ll see a table displaying the reports that you and your students have made.</p>
						<p>Click on one of the buttons above to get started or click on the help icon above to get more information about how to use the Data Viewer!</p>
						</div>';
					}
					else
					//observations found
					{
						// write out table code
						Print "<table width='100%' id='myTeacherDataTable'>";
						Print "<thead><tr>
								<th style='color:#000; line-height:1.1em;'>Observation <br/>Date</th>
								<th style='color:#000;'>Site/Classroom</th>
								<th style='color:#000;'>Reporter</th>								
								<th style='color:#000;'>Common Name</th>
								<th style='color:#000;'>Scientific Name</th>
								<th style='color:#000;'>Phenophase</th>
								<th style='color:#000;'>Obs#</th>
								</tr></thead>";
						Print "<tbody>";
						
						//loop through student observations
						while($row = mysql_fetch_array($reporterresult))
						{
				
							$studentname=get_username_byPersonID($row['User_ID'], $dbh);
							
							$stationname=$row['Station_Name'];//get_StationName($dbh, $row['Station_ID']); 
							
							//find first underscore and assign it with all characters to the right to $reportername
							$reportername=strrchr($studentname,'_');
							
							//substring reportername to fetch only reporter(n) segment - leading underscore
							$reportername=substr($reportername,(strlen($reportername)-1)*-1,strlen($reportername)-1);
							$commonname=get_common_name($dbh, $row['Species_ID']);
							$scientificname=get_scientific_name($dbh, $row['Species_ID']);
							$phenophasename=get_phenophasename_species($dbh, $row['Phenophase_ID']);

							Print "<tr>";
							Print "<td>".$row['Observation_Date'] . "</td> "; 
							Print "<td>".$stationname . "</td> "; 		
							Print "<td>". $reportername . "</td> "; 							
							Print "<td>".$commonname . "</td> ";
							Print "<td><em>" . $scientificname ."</em></td> "; 		
							Print "<td>".$phenophasename . "</td> "; 		
							Print "<td>".$row['ID'] . "</td></tr>"; 
						}//end while student's data
						
						//loop through the teacher's observations
						while($info = mysql_fetch_array( $teacherresult ))
						{
						
							//echo 'Userid: ' . $row['User_ID'] .'Teacher: ' . $username . ' Station: ' . $info['Site'] . ' Obs:' . $info['ID'] . '<br />';
						
							Print "<tr>";
							Print "<td>".$info['Date'] . "</td> "; 
							Print "<td>".$info['Site'] . "</td> "; 	
							Print "<td>" . $username . "</td>";
							Print "<td>".$info['Common'] . "</td>";
							Print "<td><em>" .  $info['Species'] . "</em></td> "; 		
							Print "<td>".$info['Phenophase'] . "</td> "; 		
							Print "<td>".$info['ID'] . "</td></tr>"; 		
						} //END WHILE
										

						
						//close datatable
						// end table code
						Print "</tbody>";
						Print "</table>";
					}
					
					echo $error;
				
				
				}
				else
				{ //not a teacher
					$qry="SELECT * FROM tbl_users WHERE UserName = '". mysql_real_escape_string($username) . "'";
					$UserSet=$dbh->query($qry);
					$row=$UserSet->fetch_object();
					$UserID=$row->User_ID;

					// Collects data from "Observation" table
					$data = mysql_query("SELECT O.ID AS ID, 
												ST.Station_Name AS Site, 
												S.Common_Name AS Common, 
												S.Species AS Species, 
												P.Phenophase_Name AS Phenophase, 
												O.Observation_Date AS Date
										FROM tbl_observations as O 
										JOIN tbl_species as S on (O.Species_ID = S.Species_ID) 
										LEFT JOIN tbl_phenophases as P on (O.Phenophase_ID = P.Phenophase_ID) 
										LEFT JOIN tbl_stations as ST on (O.Station_ID = ST.Station_ID) 
										WHERE O.Observer_ID = ".$UserID." 
										") 
					or die(mysql_error()); 
					
					//check for observations
					if(mysql_num_rows($data)==0)
					{
						echo '<br /><div style="width:500px; height:200px; margin:50px auto 0 auto; padding:0 30px 0 30px; border:1px solid grey">
						<p>This is where you\'ll see a table displaying the reports that you have made.</p>
						<p>Click on one of the buttons above to get started making reports or click on the help icon above to get more information about how to use the Data Viewer!</p>
						</div>';
					}
					else
					//observations found - display datatable
					{
						// write out table code
						Print "<table width='100%' id='myDataTable'>";
						Print "<thead><tr>
									<th style='color:#000; line-height: 1.1em'>Observation<br/>Date</th>
									<th style='color:#000;'>Site</th>
									<th style='color:#000;'>Common Name</th>
									<th style='color:#000;'>Scientific Name</th>
									<th style='color:#000;'>Phenophase</th>
									<th style='color:#000;'>Obs#</th>
								</tr></thead>";
						Print "<tbody>";
						// Print out the contents of the entry 
						while($info = mysql_fetch_array( $data )) {
							Print "<tr>";
							Print "<td>".$info['Date'] . "</td> "; 
							Print "<td>".$info['Site'] . "</td> "; 		
							Print "<td>".$info['Common'] . "</td> "; 
							Print "<td>".$info['Species'] . "</td> "; 	
							Print "<td>".$info['Phenophase'] . "</td> "; 		
							Print "<td>".$info['ID'] . "</td></tr>"; 		
						} //END WHILE
					
						// end table code
						Print "</tbody>";
						Print "</table>";
					
					}
					//END OF DENNIS' CODE
				}//end teacher/non-teacher block
			?> 
              <br />
              <br />
              <br />
           <h6> Funding for the MyBudBurst Data Viewer was provided by NASA and the Chicago Botanic Garden.<br />
		  </h6>
	  </p>
	<?php } //magic closing brace ?> 

      
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