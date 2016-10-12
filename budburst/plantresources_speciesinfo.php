<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/6/2012
# Copyright 2008-2011 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script src="maps/SPmapV3.js" type="text/javascript"></script>
<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>

<!-- JAVASCRIPT AND CSS REQUIRED FOR DISPALY OF DATA TABLES -->
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
	$(document).ready( function () {
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
					
*/		} ); //END OF $.dataTable

		//function to display dataviewer help text pop up window
		$("#btnhelp").click(function()
		{
			$("#dataviewerhelp").css('display', 'block');
		});
		
		//center img and text in button div
		$(window).load(function()
		{
			//get the height of the parent
			var height_idguide = $('#idguide').height();
			var height_singlereport = $('#singlereport').height();
			var height_regularreports = $('#regularreport').height();

			//get the height of the image
			var height_idguide_img = $('#idguide img').height();
			var height_singlereport_img = $('#singlereport img').height();
			var height_regularreports_img = $('#regularreport img').height();
			
			//get the height of the p
			var height_idguide_p = $('#idguide p').height();
			var height_singlereport_p = $('#singlereport p').height();
			var height_regularreports_p = $('#regularreport p').height();			
			
			//calculate how far from top the image should be
			var top_margin_idguide_img = (height_idguide - height_idguide_img)/2;
			var top_margin_singlereport_img = (height_singlereport - height_singlereport_img)/2;
			var top_margin_regularreports_img = (height_regularreports - height_regularreports_img)/2;
			
			//calculate how far from top the p should be
			var top_margin_idguide_p = (height_idguide - height_idguide_p)/2;
			var top_margin_singlereport_p = (height_singlereport - height_singlereport_p)/2;
			var top_margin_regularreports_p = (height_regularreports - height_regularreports_p)/2;
			
			//alert(height_idguide + ' ' + height_idguide_p + ' ' + top_margin_idguide_p);
			
			//change the margin-top css attribute of the image
			$('#idguide img').css('margin-top', top_margin_idguide_img);
			$('#singlereport img').css('margin-top', top_margin_singlereport_img);
			$('#regularreport img').css('margin-top', top_margin_regularreports_img);
			
			//change the margin-top css attribute of the p
			$('#idguide p').css('margin-top', top_margin_idguide_p-1);
			$('#singlereport p').css('margin-top', top_margin_singlereport_p-1);
			$('#regularreport p').css('margin-top', top_margin_regularreports_p-1);
			
		});
			
		
	} ); //END OF $.ready FUNCTION
	
	//close help div
	function closeWindow()
	{
		$("#dataviewerhelp").css('display', 'none');
	}
	
</script> 
<!-- END OF DATA TABLE INCLUDES AND SCRIPTS-->

<?php
$speciesid = $_GET["speciesid"];

HeaderStart("Plant Species Information"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed

HeaderEnd();
?>

<body id="PlantResources" onload="speciesMap(<?php echo $speciesid; ?>)">
<div id="wrapper">
	<div id="contentwrapper">

		<!-- Top Login -->
		<?php
			WriteTopLogin($dbh);
		?>
			
		<!-- Top Navigation for Home Page -->
		<?php	
			WriteTopNavigation();
		?>
		
		<?php
		//get plant species information (for $speciesid passed into this page)

		//set up variables
		$error='';
		$display ='';

		// if speciesid is < 999 - Other or not numeric, generate error text
		if ( ($speciesid >= get_other_speciesID($dbh)) || !(is_numeric($speciesid)))
		//if ( !(is_numeric($speciesid)))
		{ 
			$nospeciesflag = 1;
			$error.='<div style="padding: 10px;min-height:200px;">Sorry, species id was not recognized.<br>
					Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with the following error:<br>
					plantresources_speciesinfo.php - no valid species ID</div>';
		}
		else
		{  //species id valid
			//SPECIES TABLE -------------------------
			 $qry = "SELECT Species, Common_Name,Plant_Family, Photo_Filename,Photo_Credit FROM tbl_species WHERE Species_ID = $speciesid";				
			//echo "<br>species qry: ".$qry;	
			$result = $dbh->query($qry);
			//echo "result_num_rows" . $result->num_rows . "<br />";
			//echo "Error message = " . mysqli_error($dbh) . "<br />";

			if ($result->num_rows == 0)
			{
					$nospeciesflag = 1;
					$error.='<div style="padding: 10px;min-height:200px;">Sorry, no species information could be found in the database.<br />
					Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with the following error:<br />
					plantresources_speciesinfo.php - no species information found</div>';
			}
			else
			{
				while($row = $result->fetch_object())
				{
					$commonname = $row->Common_Name;
					$scientificname = $row->Species;
					$plantfamily = $row->Plant_Family;
					$photofile = $row->Photo_Filename;
					$photocredit = $row->Photo_Credit;
					
					//prepare variables needed:
					$commonname_nospace = str_replace(" ", "", $commonname);

				}// end while species results
					
				//FETCH MULTIPLE SPECIES COMMON NAMES FROM SPECIES_COMMON_NAMES TABLE FOR DISPLAY IN HEADER-------------------------
				$qry_cn = "SELECT Common_Name FROM rel_species_common_names WHERE Species_ID = $speciesid";	
				$result_cn = $dbh->query($qry_cn);
				// can fail silently - okay to fail
				
				/*if ($result_cn->num_rows == 0) {
						$error.='<p>Sorry, no species information could be found in the database.<br>
					Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with the following error:<br>
					plantresources_speciesinfo.php - no species information found';
						}
				else{*/
					$alt_commonnames = "";
					for ($i=0; $i< ($result_cn->num_rows); $i++){
						$row_cn = $result_cn->fetch_object();
						$alternatename = $row_cn->Common_Name;
						$alt_commonnames .= $alternatename;
						if ( $i < $result_cn->num_rows - 1){
							$alt_commonnames .= ", ";
						}//if
					}//for
				/*}//else*/
				
				//-------------------------
				
				//IDENTIFICATION_GUIDE TABLE --------------------------
				$result_id = get_id_guide($dbh, $speciesid);
				if ($result_id->num_rows == 0)
				{
					//set noidguideflag to true
					//$noidguideflag = 1;
					//$error.='<p>Sorry, no Identification Guide information could be found in the database.<br>
					//Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with the following error:<br>plantresources_speciesinfo.php - no identification guide found</p>';
				}// end if

				while($row_id = $result_id->fetch_object())
				{
					$identificationhints = $row_id->Identification_Hints;
					$didyouknow = $row_id->Did_You_Know;
				}//while
				
				//Check to see if id guide file exists and set flag to true if so
				//filename must be all lower case to match
				$idguidepathname = 'pdfs/idguides/';
				$idguidefilename = $commonname_nospace . '_id.pdf';
				if (file_exists($idguidepathname . $idguidefilename))
				{
					//set $idguideflag to true
					$idguideflag = 1;
				}
				
				//Check to see if field guide file exists and set flag to true if so
				//filename must be all lower case to match
				$fieldguidepathname = 'pdfs/regularreports/';
				$fieldguidefilename = $commonname_nospace . '_report.pdf';
				if (file_exists($fieldguidepathname . $fieldguidefilename))
				{
					//set $idguideflag to true
					$fieldguideflag = 1;
				}
				
				// get the plant group for this species
				$PlantGroupID=get_plant_group_ID($dbh, $speciesid);
				//get plant group name
				$PlantGroupSet=get_plant_group($dbh,$PlantGroupID);
				$PlantGroupRow=$PlantGroupSet->fetch_object();
				$PlantGroupName=$PlantGroupRow->Plant_Group_Name;
				//remove spaces from plant group name for use in retrieving single report guide
				$plantgroupname_nospace = str_replace(" ", "", $PlantGroupName);
				//fetch first word of plant group name for use in retrieving single report guide
				$words = explode(' ', $PlantGroupName);
				$plantgroupname_firstword = $words[0];
				//echo("PlantGroupID=$PlantGroupID");
				
				//get Person_ID based on username
				$qry = sprintf("SELECT Person_ID from tbl_users WHERE BINARY UserName = '%s'", $dbh->real_escape_string($_SESSION['username']) );
				$check = $dbh->query($qry);
				if (!$check) {
					die('That username does not exist in our database. 
					Please contact the web manager - error: report_obs_logged - username not found');
				}
				while ($row = $check->fetch_object()) {
					$personid = $row->Person_ID;
				}//end while
				
				//call function to get special projects for this speciesid and return object
				$check2 = get_special_projects_for_speciesid($speciesid, $dbh);
					
					while ($row2 = $check2->fetch_object())
					{
						if($row2->type == "REFUGES")
						{
							//set refuges flag to true
							$refugeflag = true;
						}
						if($row2->type == "GARDENS")
						{
							//set gardens flag to true
							$gardensflag = true;
						}
						if($row2->type == "PARKS")
						{
							//set parks flag to true
							$parksflag = true;
						}
						if($row2->ID == "21")
						{
							//set top ten flag to true
							$toptenflag = true;
						}
						if($row2->ID == "NELOP")
						{
							//set NELOP flag to true
							$nelopflag = true;
						}
					}//end while check2
		} //end species isnumeric and species not other
		?>

		<!--display html main content-->
		<?php 
		if (!$nospeciesflag)
		{
		?>
			
		<div id="MainContent">
        
			<!--badge div-->
			<div id="badgeholder" style="float:right;width:250px;height:60px">
				<?php 

				//check for top ten flag - if true, display top ten badge image
				if($toptenflag)
				{
				echo '<div id="toptenbadge" style="height:50px;width:50px;border:1px solid grey;float:left;margin: 0 10px 0 0;"><a href="mostwanted.php"><img src="images/top_ten.png" alt="top ten species" height="50" width="50" border="0"/></a></div>';
				}
				
				//check for refuge flag - if true, display refuges badge image
				if($refugeflag)
				{
				echo '<div id="refugebadge" style="height:50px;width:50px;border:1px solid grey;float:left;margin: 0 10px 0 0;"><a href="refuges/index.php"><img src="images/refuge_species.png" height="50" alt="refuge species" width="50" border="0"/></a></div>';
				}
				
				//check for garden flag - if true, display gardens badge image
				if($gardensflag)
				{
				echo '<div id="gardensbadge" style="height:50px;width:50px;border:1px solid grey;float:left;margin: 0 10px 0 0;"><a href="gardens/index.php"><img src="images/gardens_species.png" height="50" alt="gardens species" width="50" border="0"/></a></div>';
				}
				
				//check for park flag - if true, display parks badge image
				if($parksflag)
				{
				echo '<div id="parksbadge" style="height:50px;width:50px;border:1px solid grey;float:left;margin: 0 10px 0 0;"><a href="parks/index.php"><img src="images/parks_species.png" height="50" width="50" alt="parks species" border="0"/><a/></div>';
				}
				
				//check for NELOP flag - if true, display NELOP badge image
				//if($nelopflag)
				//{
				//echo '<div id="nelopbadge" style="height:50px;width:50px;border:1px solid grey;float:left;margin: 0 10px 0 0;"><a href="nelop/index.php"><img src="images/nelop_species.png" height="50" width="50" alt="NELOP species" border="0"/><a/></div>';
				//}
				
				
				?>
			</div><!--end badgeholder div-->
			
			<h2 style="border-bottom:2px solid rgb(48, 104, 72);width:50%;padding:0 0 5px 0;margin:25px 0 10px 0"><a name="top" id="top"></a><?php echo $commonname;?>

				<?php
				// exclude parenthesis if no scientific name
				if ($scientificname)
				{
					echo '(<em>' . $scientificname . '</em>)';
				}
				?>
			</h2>

			<!--image holder-->
			<div class="picture right" style="width:200px">
				<img width="200px" src="
					<?php 
						//build _m filename var
						$filename_m='images/' . $speciesid . '_m.jpg';
						
						//if _m file exists, display it
						if (file_exists($filename_m))
						{
							echo $filename_m . '"';
						}
						else //no _m file
						{
							//build no _m filename var
							$filename='images/' . $speciesid . '.jpg';
						
							//if no _m file exists, try larger photo (without _m)
							if (file_exists($filename))
							{
								echo $filename  . '"';
							}
							else
							{
								//build no image filename var to use image 999.jpg (no photo available)
								$filename="images/999.jpg";
								echo $filename  . '"';
							}
						}//end if _m file exists
					?> 
					alt="<?php echo $commonname;?>" title="<?php echo $commonname;?>" />
					<?php 
						echo ("Photo courtesy of ".$photocredit);
					?>
			</div><!--end image holder-->
			

			<p>
				<?php
					if ($alt_commonnames!="")
					{
						echo("<strong>Also Known As: </strong>".$alt_commonnames."<br />");
					}//if
					
					if ($plantfamily!="")
					{
						echo("<strong>Plant Family: </strong>".$plantfamily."<br />");
					}//if
					
					
					if ($PlantGroupName!=NULL)
					{
						echo("<strong>Project BudBurst Plant Group: </strong>".$PlantGroupName."<br />");
					}//if 
				?>
			</p>
			
			<?php
					if ($identificationhints != NULL)
					{
						$identificationhints_fixed=str_replace(array("“","”","'","'"),array("\"","\"","'","'"),$identificationhints);
						echo '<p><strong>Identification Hints:</strong> ' . $identificationhints_fixed . '</p>';
					}//if
					if ($didyouknow != NULL)
					{
						$didyouknow_fixed=str_replace(array("“","”","'","'"),array("\"","\"","'","'"),$didyouknow);
						echo '<p><strong>Did you Know?</strong> ' . $didyouknow_fixed . '</p>';
					}//if 
					
				?>

				<div id="plantpagebuttons">
				
				<?php
				//if field guide file exists, display field guide
				if($idguideflag)
				{
				?>
					<a href="pdfs/idguides/<?php echo $commonname_nospace?>_id.pdf" target="_blank" class="maincontent">
					<span class="highlight"></span>
					<div id="idguide" class="buttons" style="width:200px;padding:0" >
						<img  style="float:left;margin:0 5px 0 0;" alt="download identification guide" src="images/icons/reportStepsIcons/downloadDatasheet.png" border="0"/>
						<p style="float:left;width:151px;text-align:left;font-size:0.85em;line-height:1.3em">
							Download Identification Guide for <?php echo $commonname?>
						</p>

					</div>
					</a><!--end idguide div-->
					<?php
				}//end no id guide check
					?>
					
					<!--single report-->
					<a href="pdfs/singlereports/<?php echo $plantgroupname_firstword?>_single_report.pdf" target="_blank" class="maincontent">
					<span class="highlight"></span>
					<div id="singlereport" class="buttons" style="width:200px;padding:0">
						<img  style="float:left;margin:0 5px 0 0;" alt="download single report datasheet" src="images/icons/reportStepsIcons/downloadDatasheet.png" border="0"/>
						<p style="float:left;width:151px;text-align:left;font-size:0.85em;line-height:1.3em">
							Download Single Report Datasheet for <span><?php echo $PlantGroupName?></span>
						</p>
					</div><!--end single report-->
					</a>
					
					<!--regular report-->
					<?php
					//if field guide file exists, display field guide
					if($fieldguideflag)
					{
					?>
						<a href="pdfs/regularreports/<?php echo $commonname_nospace?>_report.pdf" target="_blank" class="maincontent">
						
						<div id="regularreport" class="buttons" style="width:200px;padding:0">
							<img  style="float:left;margin:0 5px 0 0;" alt="download regular report datasheet" src="images/icons/reportStepsIcons/downloadDatasheet.png" border="0"/>
							<p style="float:left;width:151px;text-align:left;font-size:0.85em;line-height:1.3em">
							Download Regular Report Datasheet for <span><?php echo $commonname?></span>
							</p>

						</div><!--end regular report div-->
						</a>
					<?php
					}//end regular reports (field guide) check
					?>

				</div><!--end buttonholder div-->

				<!----- LIVE MAP--------------------------------->
				<div id="livemap" style="border-top: 1px solid rgb(48, 104, 72); border-bottom:1px solid rgb(48, 104, 72); float:left">
					
					<!--<a name="livemap" id="livemap"></a>-->
					<h2><?php echo $current_year; ?> Live Map for <?php echo $commonname;?>:</h2>
					<p>Below you can view all observations that have been reported in <? echo $current_year; ?> for <?php echo $commonname;?>
					<?php //echo '<p> Mapping species=' . $speciesid . '</p><br>';?>
					(If the map below is empty then there have not been any <?php echo $current_year; ?> observations reported.)</p>
					<p>Use the navigation buttons on the left to zoom in/out and pan around. Click on each place marker to get detail information about that observation.</p>
					<!--mapholder holds map and legend-->
					<div id="mapholder" style="height: 525px;">
						<!--map legend-->
						<div id="PBBmapLegendRegReport" style="width:500px;padding-left:82px">
							<?php 
							//set the number of the marker dot png files to include in map
							$reportphaseid = array('3','9','7','12');
							$reportphasename = array('Leaf/Needles/Stalk','Flower/Pollen', 'Fruiting', 'Color');
							$sizeof_reportphaseid_arr = sizeof($reportphaseid);
							
							for ($i=0; $i<$sizeof_reportphaseid_arr; $i++)
							{
								$j = $reportphaseid[$i];
								echo '<img src="maps/icons/p' . $j . 
								'.png" alt="' . $reportphasename[$i] . '" title="' . $reportphasename[$i] . '" width="12" height="20" style="padding-left:15px" />'  
								. ' ' . $reportphasename[$i];
							}//for
							?>
						</div><!--end div PBBmapLegendRegularReport-->
						
						<!--map div-->
						<div id="PBBmap" style="width: 512px; height: 498px; position:relative; padding-left:40px;border:1px solid grey;margin: 0 auto;">
						</div>
					</div><!--end mapholder div-->
					
					<p>--<a href="#top" class="maincontent" >Back to Top</a>--</p>
				</div><!--end livemap div-->

				<!----- END LIVE MAP------------------------------->
			 
				<!---------------- DATA VIEWER -------------------->
					<!--hidden div used to pop up help text for data viewer-->
					<div id="dataviewerhelp">
						<img src="images/red_close_button.png" alt="close help window button" class="btnclosewindow" id="btnclosewindow" onclick="closeWindow()"/>
						<p>The table below displays all the data that has been submitted to Project BudBurst. By default, the data is sorted by the date on which the phenophase occurred. Clicking the up and down arrows next to each column name allows you to sort on any value.  If there have been more than 10 observations submitted, you can choose how many to display at a time using the &quot;Show __ entries&quot; control. You can also page through the data using the previous and next buttons at the bottom right of the table.</p>
						<p>The Search box allows you to search all of the data. Searching by date, species, phenophase, etc. is easy&#8212;just start typing and the table will immediately change to contain only observations that contain your search phrase. Do you want to see only 2012 observations? Just type &quot;2012&quot; in the search box. Only want to see maples? Enter &quot;Acer.&quot; You can combine searches, too! Searching for &quot;acer 2012&quot; will narrow your results to only the maples that were observed in 2012 (assuming that any observations exist, of course).</p>
						<p>Once you have your results in the order desired, you can use any of the buttons above the search box to copy the results to the clipboard; save them as a text, spreadsheet, or PDF file; or even print them from your browser!</p>
					</div><!--end dataviewerhelp div-->
					<div>
						<h2 style="margin: 5px 0 0 0;padding 0;height:25px;float:left">Observational data for <?php echo $commonname;?>:</h2>
						<img src="images/help.png" alt="help button" style="float:left;margin: 10px 0 0 5px" id="btnhelp" />
					</div>
					
					<div style="clear:both"></div>
					<?php 
						//DENNIS'CODE FOR DATA RETRIEVAL
						
						// Connects to your Database 
						mysql_connect("$host", "$username", "$password") or die(mysql_error()); 
						mysql_select_db("$database") or die(mysql_error());
						$username=$_SESSION['username'];
						$qry="SELECT * FROM tbl_users WHERE UserName = '".$username."'";
						$UserSet=$dbh->query($qry);
						$row=$UserSet->fetch_object();
						$UserID=$row->User_ID;

						// Collects data from "Observation" table
						$data = mysql_query("SELECT O.ID AS ID, 
													ST.Station_Name AS Site, 
													S.Common_Name AS Common, 
													S.Species AS Species, 
													P.Phenophase_Name AS Phenophase, 
													O.Observation_Date AS Date,
													U.Username
												FROM tbl_observations as O 
												JOIN tbl_species as S on (O.Species_ID = S.Species_ID) 
												LEFT JOIN tbl_phenophases as P on (O.Phenophase_ID = P.Phenophase_ID) 
												LEFT JOIN tbl_stations as ST on (O.Station_ID = ST.Station_ID) 
												JOIN tbl_users as U on (U.User_ID = O.Observer_ID)
												WHERE S.Species_ID = ".$_GET['speciesid']." 
												AND U.UserName NOT LIKE 'pbbtest%' ") 
						or die(mysql_error()); 
							
						// write out table code
						Print "<table width='100%' id='myDataTable'>";
						Print "<thead>
							<tr>
								<th style='color:#000; font-size: 80%;'>Date</th>
								<th style='color:#000; font-size: 80%;'>Site</th>
								<th style='color:#000; font-size: 80%;'>Common Name</th>
								<th style='color:#000; font-size: 80%;'>Species</th>
								<th style='color:#000; font-size: 80%;'>Phenophase</th>
								<th style='color:#000; font-size: 80%;'>Obs#</th>
							</tr></thead>";
							Print "<tbody>";
						// Print out the contents of the entry 
						while($info = mysql_fetch_array( $data ))
						{
							Print "<tr>";
							Print "<td>".$info['Date'] . "</td> "; 
							Print "<td>".$info['Username'] . "</td> "; 		
							Print "<td>".$info['Common'] . "</td> "; 		
							Print "<td>".$info['Species'] . "</td> "; 		
							Print "<td>".$info['Phenophase'] . "</td> "; 		
							Print "<td>".$info['ID'] . "</td></tr>"; 		
						} //END WHILE
						
						// end table code
						Print "</tbody>";
						Print "</table>";
						print "<br /><br />";
						
						//END OF DENNIS' CODE
						
					?> 
				
				<!----- END DATA VIEWER ------------------------------->

				<p>*All downloadable materials require the free <a href="http://www.adobe.com/products/acrobat/readstep2.html" target="_blank" class="maincontent">Adobe Reader</a>.</p>
		</div><!-- MainContent -->


		<?php 
			}//else species info not found in db SPECIES TABLE
		}//else Species_ID not null from $_GET
		echo $error;
		?>    

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