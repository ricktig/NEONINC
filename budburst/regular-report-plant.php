<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/3/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

//process post variables - stationid, plantgroupid, speciesid
	if (isset($_GET['stationid']))
	{
		$stationid = $_GET['stationid'];
	}
	else
	{
		$stationid = $_POST['stationid'];
	}

	if (isset($_GET['plantgroupid']))
	{
		$plantgroupid = $_GET['plantgroupid'];
	}
	else
	{
		$plantgroupid = $_POST['plantgroupid'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Register a plant"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.min.js"></script>
<link rel="stylesheet" href="jquery-ui-1.9.0.custom/css/ui-lightness/jquery-ui-1.9.0.custom.min.css" />

<script type="text/javascript">
	$(function()
	{
		//$('#speciesid').val(<?php echo $speciesid;?>);
		
		//display plant group icon
		$("#mainImg").html("<img src='images/icons/100plantgroup/<?php echo $plantgroupid?>.png' width='100' height='100' alt='plant group icon' />");
		
		//when species selection made from drop down box
		$("#speciesid").change(function()
		{
			//capture speciesid  and stationid when combo box selection made
			speciesid = $('#speciesid').val();
			stationid = $('#stationid').val();
			
			//check for 'other' species
			if(speciesid==999)
			{
				//display 'Other' div for entry of common name and scientific name when speciesid = 999
				$("#div_hide").css({"display":"block"});
				//build string - path to plant group image
				var innerhtml = "images/icons/100plantgroup/<?php echo $plantgroupid?>.png";
				//change mainImg img to image string
				$('#mainImg img').attr('src', innerhtml);
			}
			//check for reset to no species selection
			else if(speciesid==0)
			{
				//hide 'other' species div
				$("#div_hide").css({"display":"none"});
				//build string - path to plant group image
				var innerhtml = "images/icons/100plantgroup/<?php echo $plantgroupid?>.png";
				//change mainImg img to image string
				$('#mainImg img').attr('src', innerhtml);
			}
			//if species set, display image and hide 'other' entry div
			else
			{
				//hide 'other' species div
				$("#div_hide").css({"display":"none"});
				//build string - path to species image
				var innerhtml = "images/" + speciesid + ".jpg";
				//change mainImg img to image string
				$('#mainImg img').attr('src', innerhtml);
			}
			
			//if speciesid = 0 for 'select' then disable submit button
			if(!(speciesid=='0') && !(stationid=='0'))
				{
					$('#btnsubmit').prop("disabled",false);
				}
			else //if valid speciesid (not zero) then enable submit button
				{
					$('#btnsubmit').prop("disabled",true);
				}
		});//end speciesid change
		
		//when station selection made from drop down box
		$("#stationid").change(function()
		{
			//capture speciesid  and stationid when combo box selection made
			speciesid = $('#speciesid').val();
			stationid = $('#stationid').val();
			
			//if speciesid not equal to zero for 'select' and stationid not null
			//then disable submit button
			if(!(speciesid=='0') && !(stationid==''))
				{
					$('#btnsubmit').prop("disabled",false);
				}
			else //if valid speciesid (not zero) then enable submit button
				{
					$('#btnsubmit').prop("disabled",true);
				}
		});//end speciesid change
		
		//build json string for jQueryUI autocomplete which autocompletes 
		//species common name if speciesid = 999/other
		var source = <?php 
		$plant_menu_json = build_species_JSON_single_report($dbh, $plantgroupid);
		echo $plant_menu_json;
		?>
		
		//load jQueryUI autocomplete into input box where visitor can enter species name
		$( "#common_name_userdef" ).autocomplete(
		{
				//set number of characters required before matches are returned
				minLength: 3,
				//set source to both common name and scientific name
				source: function(request, response)
				{
					var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
					response($.grep(source, function(value)
					{
						return matcher.test(value.label) || matcher.test(value.description);
					}));
				},
				
				//check for response matches - if none, display div indicating no matches
				response: function(event, ui)
				{
					if(ui.content.length===0)
					{
						//alert('We didn\'t find any matches');
						$('#nomatchesbox').css('display','block');
						$('#nomatchesbox').css('float','left');
					}
					return false;
				},

				//on select, call function to update input fields and image
				select: function(event, ui)
				{
					newspeciesid=ui.item.value;
					selectSpecies(newspeciesid);
					//clear searchbox text on selection of species
					$('#common_name_userdef').val("");
					return false;
				},
				
				//left align results list when opened and set label and description fields to display with <a> tag for clickability - must have <a> to allow click to work!
				open: function(event, ui)
				{
					$('.ui-autocomplete').css('text-align', 'left');
				}			
		}).data( "autocomplete" )._renderItem = function( ul, item )
		{
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.label + "<em> " + item.description + "</em></a>" )
				.appendTo( ul );
		};//end autocomplete
	
		//clear no matches found box on keyup (keypress doesn't react to backspace key, keyup does)
		$("#common_name_userdef").keyup(function()
		{
			$('#nomatchesbox').css('display','none');
		});

	}); //end DOM load function
	


		//function to fetch selected species data via AJAX call to PHP query
	//and assign results to HTML elements and update image
	function selectSpecies(newspeciesid)
	{
		$.ajax(
		{
			type: "POST",
			url:"choose_select_plant.php",
			data: "newspeciesid=" + newspeciesid,
			dataType: "json",
			success:function(result)
			{
				document.getElementById('speciesid').value = newspeciesid;
				//load species image
				$("#mainImg img").attr("src", "images/" + newspeciesid + ".jpg");
				//display continue button
				$('#div_hide').hide();
				//change current speciesid to selected species id
				speciesid = newspeciesid;
			}//end success
		});//end ajax
	}//end selectSpecies()	

</script>

<?php
//
HeaderEnd();
?>

<body id="MyBudBurst">

<div id="wrapper">

 <div id="contentwrapper">
  	
    <!--<div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Add a Plant - Select Plant</h1>
      
      <?php 
			$maincontent='';
			$display_table='';
			
			//make sure user is logged in
			if(!checklogin($dbh))
			{
					$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
					$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.</p>';
					$maincontent.= $spacer;
					
			}
			else
			{  //logged in
				//check if plant group selected on previous page
				//no plant group id
				if(!$_POST['plantgroupid'])
				{
					$maincontent .=  '<p>Please first select the Plant Group that you are 
											reporting on for your regular report.</p> ';
					$maincontent .= "<FORM><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'></FORM>";
					$maincontent .= '<p>You may also return to your <a href="mybudburst.php">MyBudBurst</a> page.</p>';	
				}
				else
				//plant group id provided
				{
					//Get PersonID
					$qry = sprintf("SELECT Person_ID from tbl_users WHERE BINARY UserName = '%s'",$dbh->real_escape_string($_SESSION['username']) );
					$check = $dbh->query($qry);
					if ($dbh->affected_rows == 0) {
						die('That username does not exist in our database.');
					}
					while ($row = $check->fetch_object()) {
						$personid = $row->Person_ID;
					}
					
					//get personID's registered sites
					$stations = get_myBudBurst_sites($personid, $dbh);
					$no_stations = mysqli_num_rows($stations);
					
					//check that user has registered sites first
					if (!$no_stations){  
						$maincontent.='<p>Sorry, you must first register an observation site.</p>';
						$maincontent.= '<p>Continue by registering a <a class="maincontent" href="regular-report-site.php">myBudBurst site</a>.</p>';
						$maincontent.= $spacer;
					}	
					else{ //okay to create display table
					
						//build dynamic site selection drop down menu
						$site_selection_menu = '<select name="stationid" class="select" id="stationid" tabindex="1">
												<option value="" selected="selected">Select</option>';
						while ($row = $stations->fetch_object()) {
							$site_selection_menu .= '<option value="';
							$site_selection_menu .= $row->Station_ID;
							$site_selection_menu .= '"';
							
							//check if posted station
							if ($stationid){
								if ( $stationid == $row->Station_ID ){
									$site_selection_menu .= 'selected="selected"';
								}	
							}
							$site_selection_menu .='>';
							$site_selection_menu .= $row->Station_Name;
							$site_selection_menu .= '</option>';
							} 
						$site_selection_menu .= '</select>';
						
						//build plant selection dynamic drop down menu based on specieslist and special projects id
						$specialProjectsString = get_SpecialProjectsID($stationid, $dbh); 
						//echo "Special Projects ID = " . $specialProjectsString;
						
						//$plant_selection_menu = build_species_menu_new_special($dbh, $speciesid, $specialProjectsString);
						$plant_selection_menu = build_single_report_pg_spp_menu($plantgroupid,$dbh);
						
						//$plant_selection_menu = build_species_menu_new($dbh, $speciesid);
						if ($plant_selection_menu ==''){
							die('No plants found in Species Table.');
						}
						?>
						<p>Select Plant Group <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> <strong>Select Plant</strong></p>
						
						<br />
						<form action="regular-report-plant-do.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm_Plant();return document.MM_returnValue">
						
						<input name="plantgroupid" type="hidden" value="<?php echo $plantgroupid;?>" />
						<?php //build dynamic table based on # of species ?>
						<table width="100%" border="0" cellspacing="0" cellpadding="5" summary="plant selection table" bgcolor="#C3D9A5" class="form">
						  <th colspan="3">Select plant</th>
						<tr>
							<td valign="top" width="29%">
							<div align="right"><span class="username">*My BudBurst Site:</span></div></td>
							<td width="71" valign="top"><div align="left">
							<?php echo $site_selection_menu;?>
							</div></td>
							<td></td>
						</tr>
						<tr>
							<td valign="top"width="29%">
							<div align="right"><span class="username">*My BudBurst Plant:</span></div></td>
							<td valign="top"><div align="left">
							<?php echo $plant_selection_menu;?>
							</div></td>
							<td valign="top"> 
								<div name="mainImg" id="mainImg" style="margin: 0 0 0 50px"></div>
							</td>
						  </tr>
							
						<tr>
						  <td colspan="3" valign="top">
						  
						  <?php  
						  //SHOW/HIDE--------------------------------
						 // if ($speciesid == $otherID){ ?>
							<div id="div_hide" style="display: none; margin-top:10px">
	
						  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
							<tr bgcolor="#C3D9A5" class="form">
							  <td colspan="3" bgcolor="#C3D9A5"><div align="left">
								<p>You have selected <strong>'--Other--'</strong>, indicating that you want to monitor a plant that is <strong>not</strong> among the <? echo get_all_PBBspecies($dbh); ?> species already  included in Project BudBurst.</p>
								
								<p><strong>Before</strong> completing this form, please double-check that your plant is not already listed in the Project BudBurst <a href="display_all_plants_list.php" target="_new"><strong>Master Species List</strong></a>. (Link will open in a new window.)</p>
								<p>If your plant is on the list, please select it from the &quot;My BudBurst Plant&quot; dropdown list above. If your plant is not on the list, please fill in the fields below.<br />
								</p>
							  </div></td>
							</tr>
							<tr bgcolor="#C3D9A5" class="form">
							  <td width="28%" valign="top" bgcolor="#C3D9A5"><div align="right"><strong>*Common name:</strong></div></td>
						<td colspan="2" valign="top" bgcolor="#C3D9A5">
							<div style="float:left">
								<input name="common_name_userdef" type="text" id="common_name_userdef" tabindex="2" size="30" />
							</div>
							<div id="nomatchesbox" style="float:left;display:none;padding-left:5px" >
								No matches found
							</div>
						</td>
						</tr>
							<tr bgcolor="#C3D9A5" class="form">
							  <td valign="top" bgcolor="#C3D9A5"><div align="right">Genus and species:<strong><br />
							  </strong>(If known)</div></td>
							  <td colspan="2" valign="top" bgcolor="#C3D9A5"><div align="left"><strong>
								  <input name="species_userdef" type="text" id="species_userdef" tabindex="3" size="30" />
							  </strong></div></td>
							</tr>
							<?php 
						//plant group menu
						/*
							<tr bgcolor="#EDB6BF" class="form">
							  <td valign="top" bgcolor="#CBDCEF"><div align="right">Plant Group:<br />
								(if known)<a href="participate_plantgroups.php" target="_blank" class="maincontent"><br />
							  </a></div></td>
							  <td colspan="2" valign="top" bgcolor="#CBDCEF">
						
						$plant_group_menu = build_plant_groups_menu($dbh);
						if ($plant_group_menu ==''){
									$plant_group_menu='No plants groups found in Species Table.';
									$plant_group_menu.='$error_web';
								}
								echo $plant_group_menu;
						
						</td>
							</tr>
							<tr bgcolor="#EDB6BF" class="form">
							  <td valign="top" bgcolor="#CBDCEF">&nbsp;</td>
							  <td width="53%" valign="top" bgcolor="#CBDCEF"><a href="participate_plantgroups.php" target="_blank" class="maincontent">Help</a> me select a <a href="participate_plantgroups.php" target="_blank" class="maincontent"> plant group</a>!</td>
							  <td width="19%" valign="top" bgcolor="#CBDCEF">&nbsp;</td>
							</tr>
							*/    
						?>
						  </table>
							</div>
							<?php //}//if species id is other
							//----SHOW HIDE---------------------------- ?>                              </td>
						</tr>
						<tr>
						  <td valign="top"> <div align="right"><br />
						  </div></td>
						  <td valign="top">&nbsp;</td>
						  <td valign="top">&nbsp;</td>
						  </tr>
						<tr>
						  <td colspan="3" align="center" valign="top" style="height:40px"><input type="submit" id="btnsubmit" name="btnsubmit" value="Submit" disabled="disabled" tabindex ="10"/></td>
						  </tr>
				        </table>
				  <p align="center">
					
				  </p>
</form> 	  
				<?php
					} //else stations
					
					unset($qry);
					unset($row);
					unset($check);
					unset($personid);
					unset($site_selection_menu);
					unset($plant_selection_menu);
					unset($site);
			}//else - plantgroupid provided
		}//else - logged in

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