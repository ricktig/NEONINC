<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/4/2012
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
<script language="javascript" src="js/calendar/calendar.js"></script>
<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function()
	{
		//when a phenophase is selected, enable submit button
		$('input:radio[name=phenophase_chosen]').change(function()
		{
			$('#btnsubmit').prop("disabled",false)
		});
	});

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
      <h1>Enter Single Report - Observation</h1>

	<?php 
	$maincontent='';
	$display_table='';

	if(checklogin($dbh))
	{	
		if(isset($_GET['plantgroupid'])&&isset($_GET['personid']))
		{
			$personid = $_GET['personid'];
			$plantgroupid = $_GET['plantgroupid'];
			$speciesid = $_GET['speciesid'];
			$stationid = $_GET['stationid'];
			$sitename = $_GET['sitename'];
			$speciesid_verified = $_GET['speciesid_verified'];
			
		//check for common name and assign	
		if(isset($_POST['common_name_userdef']))
		{
			$common_name_userdef = $_POST['common_name_userdef2'];
		}
		else
		{
			$common_name_userdef = "";
		}

		//check for scientific and assign
		if(isset($_POST['species_userdef']))
		{
			$species_userdef = $_POST['species_userdef2'];
		}
		else
		{
			$species_userdef = "";
		}
			
			$imgID=$speciesid;
			if ($imgID>999)
			{ //user defined image
				$imgID=$otherID;
			}
			
			//get common name 
			$species=get_Species($speciesid_verified,$dbh);
			if(!mysqli_num_rows($species)) //no common name found
			{
				$commonname='';
			}
			else
			{
				$srow=$species->fetch_object();
				$commonname=$srow->Common_Name;
			}
			
			//echo("plantgroupid=".$plantgroupid);
			
			if ($plantgroupid==1) $plantgroupname="occ_wildflowers"; // wildflowers
			if ($plantgroupid==2) $plantgroupname="occ_grasses"; // grasses
			if ($plantgroupid==3) $plantgroupname="occ_trees"; // trees and shrubs
			if ($plantgroupid==4) $plantgroupname="occ_evergreens"; // trees and shrubs
			if ($plantgroupid==5) $plantgroupname="occ_conifers"; // trees and shrubs
			
			//echo("plantgroupname=".$plantgroupname);
			
			//get phenophases for plant group of selected plant for occassional observations; gjn
			$phenophases=get_phenophases_plant_group_name($dbh,$plantgroupname);
			
			if (!$phenophases)
			{
				die('No phenophases found in database.
				Please contact the web manager - error: single-report-submit.php - phenophases not found');	
			}
			$no_phenophases = mysqli_num_rows($phenophases);
			//echo  "no phenophases = " .$no_phenophases;
			
			//display table
			?>
			<p>Select Plant Group <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Select Plant <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Site Location <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> <strong>Report Observation</strong></p>
			
			<p>Please select the date along with the phenophase you observed for your Single Report.</p>
			<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#CEE7A9">
			  <tr>
					<td>MyBudBurst Site: <strong><?php echo $sitename;?></strong></td>
					<td>MyBudBurst Plant: <strong><?php echo $commonname;?></td>
					<td><img src="<?php echo 'images/' .$imgID. '.jpg';?>" alt="plant image" height="100" width="100" /></td>
				  </tr>
				</table>
			<br />
			<form id="form1" name="form1" method="post" action="single-report-submit-do.php?personid=<?php echo $personid;?>&plantgroupid=<?php echo $plantgroupid;?>&speciesid=<?php echo $speciesid;?>&speciesid_verified=<?php echo $speciesid_verified;?>&stationid=<?php echo $stationid;?>" style="background-color:#CEE7A9">
			
			<table class="form" width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CEE7A9">
			  <th colspan="2">Report the Date and Phenophase Observed</th>
			  <!--<tbody>-->
				<tr>
				  <td colspan="2">&nbsp;</td>
				</tr>
				<tr>
				  <td colspan="2" style="padding: 0 0 0 10px"><strong>WHEN</strong> DID YOU MAKE YOUR SINGLE REPORT?</td>
				</tr>
				<tr>
					<td width="220"><div align="right">Date:</div></td>
					<td>
			<?php
			
			//START NEW DATE PICKER
			//get class into the page
			require_once('js/calendar/classes/tc_calendar.php');
			//$today = date("Y-m-d");
			$curYear = date("Y");
			//instantiate class and set properties
			$myCalendar = new tc_calendar("date1", true);
			$myCalendar->setIcon("js/calendar/images/iconCalendar.gif");
			$myCalendar->setDate(date('d'), date('m'), date('Y'));
			$myCalendar->setPath("js/calendar/");
			$myCalendar->setYearInterval(2008, $curYear);
			$myCalendar->dateAllow('2008-01-01', date("Y-m-d"));
			$myCalendar->writeScript();
			// END NEW DATE PICKER
			?>
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			</tr>

			<?php
			$display_table.='<tr>';
			$display_table.='<td colspan="2" style="padding: 0 0 0 10px"><strong>WHAT PHENOPHASE</strong> DID YOU OBSERVE?</td>';
			$display_table.='</tr>';
			
			// cycle through phenophases and display a radio button for each
			
			while ($phenophase_row = $phenophases->fetch_object())
			{
				//get phenophase id
				$phenophaseid = $phenophase_row->Phenophase_ID;	
				$phenophasename = $phenophase_row->Phenophase_Name;
				
				$display_table.='<tr>';
				$display_table.="<td colspan='2' style=" . '"padding: 0 0 0 10px"' . "><input type='radio' name='phenophase_chosen' value='" . $phenophaseid."'>" . $phenophasename . "</input></td>";
				$display_table.='</tr>';
			} //end while
			
			echo $display_table;
			?>
			 <td colspan="2"><div align="center"></div></td>
				  </tr>
				<tr>
				  <td width="120" valign="top"><div class="style5" align="right">
					  <label for="commadd">Additional Comments: </label>
				  </div></td>
				  <td width="460"><div align="left">
					  <textarea name="commadd" cols="40" id="commadd" tabindex="30"></textarea>
				  </div></td>
				</tr>
				<tr colspan="2">
					<td>&nbsp;</td>
				</tr>
			  <!--</tbody>-->
			</table>
			<div align="center" style="height:30px">
				<input name="btnsubmit" type="submit" id="btnsubmit" disabled="disabled" value="Submit" />
			</div>
			</form>
			<!--hidden help text div -->
				<div id="popupdateerror">
					<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>
					Please enter a valid date between January 1, 2008 and <?php echo date("F j, Y");?>.
				</div><!--end hidden help text div-->

			<?php
		} //if submit/missing fields
		else
		{
			$maincontent.= '<p>Please first select your MyBudBurst site/plant for which you are 
					making your occasional observation.</p> ';
			$maincontent.='<p>Please continue from your 
					<a href="mybudburst.php">MyBudBurst</a>.</p>';	
		} //else
				
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