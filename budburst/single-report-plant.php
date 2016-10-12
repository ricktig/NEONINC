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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--this css forces the jQueryUI autocomplete function to scroll-->
<style>
.ui-autocomplete {
	max-height: 200px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
	/* add padding to account for vertical scrollbar */
	padding-right: 20px;
}
/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
	height: 200px;
}
</style>

<?php
HeaderStart("Project BudBurst - Enter Single Report - Select Plant"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
$plantgroupid = $_GET['plantgroupid'];
$speciesid=0;
?>

<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.min.js"></script>
<link rel="stylesheet" href="jquery-ui-1.9.0.custom/css/ui-lightness/jquery-ui-1.9.0.custom.min.css" />

<script type="text/javascript">
//define var speciesid globally here
var speciesid;

	$(function()
	{
		//display plant group icon
		var innerhtml = "images/icons/100plantgroup/<?php echo $_GET['plantgroupid']?>.png";
		$('#mainImg').attr('src', innerhtml);

		//when species selection made from drop down box
		$("#speciesid").change(function()
		{
			//capture speciesid when combo box selection made
			speciesid = $('#speciesid').val();

			
			//check for 'other' species
			if(speciesid==999)
			{
				//display 'Other' div for entry of common name and scientific name when speciesid = 999
				$("#div_hide").css({"display":"block"});
				//build string - path to plant group image
				var innerhtml = "images/icons/100plantgroup/<?php echo $plantgroupid?>.png";
				//change mainImg img to image string
				$('#mainImg').attr('src', innerhtml);
			}
			//check for reset to no species selection
			else if(speciesid==0)
			{
				//build string - path to plant group image
				var innerhtml = "images/icons/100plantgroup/<?php echo $plantgroupid?>.png";
				//change mainImg img to image string
				$('#mainImg').attr('src', innerhtml);
			}
			//if species set, display image and hide 'other' entry div
			else
			{
				//hide 'other' species div
				$("#div_hide").css({"display":"none"});
				//build string - path to species image
				var innerhtml = "images/" + speciesid + ".jpg";
				//change mainImg img to image string
				$('#mainImg').attr('src', innerhtml);
			}
			
			//if speciesid = 0 for 'select' then disable submit button
			if(($('#speciesid').val()=='0'))
				{
					$('#btnsubmit').prop("disabled",true);
				}
			else //if valid speciesid (not zero) then enable submit button
				{
					$('#btnsubmit').prop("disabled",false);
				}
		});//end speciesid change
		
		//display photo of species if PBB species selected from 'other' species autocomplete selection
		/*$( "#common_name_userdef" ).autocomplete(
		{
			minLength: 3,
			source: source,
			select: function(event, ui)
			{
				self.location='single-report-plant.php?personid=' +<?php echo $_GET['personid']?> + '&plantgroupid=' + <?php echo $plantgroupid?> + '&speciesid=' + ui.item.value;
				return false;
			}
			
		});*/

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
		};
	
		//clear no matches found box on keyup (keypress doesn't react to backspace key, keyup does)
		$("#common_name_userdef").keyup(function()
		{
			$('#nomatchesbox').css('display','none');
		});
		
		//load next page on submit button click with GET url variables
		$('#btnsubmit').click(function()
		{
			// other species - include user defined common name and scientific name in URL
			if(speciesid==999)
			{
				newurl = 'single-report-plant-do.php?personid=' + <?php echo $_GET['personid']?> + '&plantgroupid=' + <?php echo $_GET['plantgroupid']?> + '&speciesid=' + speciesid + '&common_name_userdef=' + $("#common_name_userdef").val() + '&species_userdef=' + $("#species_userdef").val();
			}
			else
			// all non-'other' species
			{
				newurl = 'single-report-plant-do.php?personid=' + <?php echo $_GET['personid']?> + '&plantgroupid=' + <?php echo $_GET['plantgroupid']?> + '&speciesid=' + speciesid;
			}
			
			window.location = newurl;
			return false;
		});
		

	}); // end jQuery DOM load function

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
				$("#mainImg").attr("src", "images/" + newspeciesid + ".jpg");
				//display continue button
				$('#div_hide').hide();
				//change current speciesid to selected species id
				speciesid = newspeciesid;
			}//end success
		});//end ajax
	}//end selectSpecies()	

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
      
    <h1>Enter Single Report - Select Plant</h1>
      
    <?php 
	if(checklogin($dbh))
	{	
		if( ($_GET['plantgroupid']!=0) && isset($_GET['personid']) )
		{		
		// ------------ GET SPECIES LIST FROM PLANTGROUPID ------------
					
			//PlantGroupID from form from previous page (single-report-plant-group.php or plantresources_speciesinfo.php)
			$plantgroupid = $_GET['plantgroupid'];
			//$plantgroupid = $_POST['plantgroupid'];
			
			$plantgroupid=(int)($plantgroupid);
			
			// get a recordset for the selected plant group and make sure it exists; gjn
			$plant_group_set=get_plant_group($dbh,$plantgroupid);
			
			if (!$plant_group_set)
			{
				die('That field guide or plant group does not exist in our database. 
				Please contact the web manager - error: Report_Occ_Obs_2 - plantgroupid not found');
			}
			while ($row = $plant_group_set->fetch_object())
			{
				$plant_group_name = $row->Plant_Group_Name;
				$plantgroupname="";
				if ($plant_group_name=="Wildflowers and Herbs") $plantgroupname="wildflower or herb";
				else if ($plant_group_name=="Grasses") $plantgroupname="grass";
				else if ($plant_group_name=="Deciduous Trees and Shrubs") $plantgroupname="deciduous tree or shrub";
				else if ($plant_group_name=="Evergreen Trees and Shrubs") $plantgroupname="evergreen";
				else if ($plant_group_name=="Conifers") $plantgroupname="conifer";
				//echo($plant_group_name);
			}
			//echo "plant_group_name = ".$plant_group_name;
			//echo "plantgroupid = ".$plantgroupid;
			$personid = $_POST['personid'];
			//echo "person id = ". $personid;
			
			// build a select drop down menu of all plants in selected plant group
			//$plantgroup_plant_menu = build_plantgroup_species_menu($plantgroupid,$dbh);
			$plantgroup_plant_menu = build_single_report_pg_spp_menu($plantgroupid,$dbh);
			
			if ($plantgroup_plant_menu=='') // we did not get any select list back from above function
			{
				$maincontent .= '<p>Please select a different 
				<a href = "single-report-plant-group?plantgroupid=0" class="maincontent">plant group</a> 
				for your single report observation.</p>';
			}
			else
			{
				?>
				<p>Select Plant Group <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> <strong> Select Plant</strong> <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Site Location <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Report Observation</p>
				<p style="font-size: 1.2em">Please select the <span class="username"><b><?php echo $plantgroupname;?></b></span> you observed from the dropdown menu below.</p>
				<br />

				<form id="form1" name="form1" method="post" ><!-- report_obs_logged2_do.php -->
				
				<table align="center" width="550" border="0" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form">
					<th colspan="3" style="height:20px">Select the plant you observed</th>
					<tr>
						<td width="157"><div align="right">Plant:</div></td>
						<td width="262"><?php echo $plantgroup_plant_menu;?></td>
						<td width="101"><strong><img name="mainImg"  id="mainImg" width="100" height="100" alt="plant group icon"/></strong></td>
					</tr>
				</table>
			  
				<!--if species ID selected from list is 999/Other, display Other species entry table-->
				<?php 
					//if ($_GET['speciesid'] == "999"){ ?>
						<div id="div_hide" style="display: none;" >
							<table width="550" border="0" align="center" cellpadding="5" cellspacing="0">
								<tr bgcolor="#C3D9A5" class="form">
									<td colspan="3" bgcolor="#C3D9A5">
									<div align="left" style="padding:0 10px 0 10px">
										<p>You have selected <strong>'-- Other --'</strong>, indicating that you want to monitor a plant that is <strong>not</strong> among the <? echo get_all_PBBspecies($dbh); ?> species already  included in Project BudBurst.</p>
										<p><strong>Before</strong> completing this form, please double-check that your plant is not already listed in the Project BudBurst <a href="display_all_plants_list.php" target="_new"><strong>Master Species List</strong></a>. (Link will open in a new window.)</p>
										<p>If your plant is on the list, please select it from the &quot;My BudBurst Plant&quot; dropdown list above. If your plant is not on the list, please fill in the fields below.<br /></p>
									</div>
									</td>
								</tr>
								<tr bgcolor="#C3D9A5" class="form">
									<td width="28%" valign="top" bgcolor="#C3D9A5">
										<div align="right">
											<strong>*Common name:</strong>	
										</div>
									</td>
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
									<td valign="top" bgcolor="#C3D9A5">
										<div align="right">Genus and species:<strong><br />
											</strong>(If known)
										</div>
									</td>
									<td colspan="2" valign="top" bgcolor="#C3D9A5">
										<div align="left">
										<strong>
											<input name="species_userdef" type="text" id="species_userdef" tabindex="3" size="30" />
										</strong>
										</div>
									</td>
								</tr>
							</table>
						</div>
				<?php //}?>
				  
				  
				  <div style="margin: 0 auto; padding-top:10px; background-color:#C3D9A5; width:550px; height:40px" align="center">
					<input name="btnsubmit" type="submit" id="btnsubmit" disabled="disabled" tabindex="4" value="Submit" />
				  </div>
				</form>
				<?php
			}//else plantgroup menu
		} //if isset () from submit of prior page
		else // we did not get the expected form variables from previous page
		{
			$maincontent .=  '<p>Please first <a href="single-report-plant-group.php">select the Plant Group</a> you are 
									reporting on for your occasional observation.</p> ';
			$maincontent .= "<FORM><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'></FORM>";
			$maincontent .= '<p>You may also return to your  
			<a href="mybudburst.php">MyBudBurst</a> page.</p>';	
		}
		} //if logged in
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