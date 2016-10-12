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
HeaderStart("Project BudBurst - Report a BudBurst Observation"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>

<script type="text/javascript">
				
	$(function()
	{
		//visitor selects species from drop down menu
		$('#radiospeciesid').change(function()
		{
			//fetch species id from value attribute in pull down menu
			var speciesid = form1.radiospeciesid.options[form1.radiospeciesid.options.selectedIndex].value;
			
			//if speciesid is a PBB species, call function to display image
			if(speciesid<999)
			{
				showImage(speciesid);
			}
			
			//if speciesid is user defined species, call function to query plant group from db and display plant group icon
			if(speciesid>999)
			{
				selectPlantGroup(speciesid);
			}
			
			//assign speciesid to hidden input element for passage to report_obs_logged3.php
			$('input[name=speciesid]').val(speciesid);
		});
	}); // end DOM load function
	
	//function to fetch plantgroupid from speciesid
	function selectPlantGroup(speciesid)
	{
		$.ajax(
		{
			type: "POST",
			url: "query_plant_group.php",
			data: "speciesid=" + speciesid,
			dataType: "json",
			success:function(result)
			{
				//load species image
				if(result==6)
				{
					$("#mainImg").attr("src", "images/999.jpg");
				}
				else
				{
					$("#mainImg").attr("src", "images/plantGroups/" + result + ".png");
				}
			}//end success
		});//end ajax
	}//end selectPlantGroup()				
	
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

	function reload(form)
	{
		var val=form.speciesid.options[form.speciesid.options.selectedIndex].value;
		self.location='report_obs.php?speciesid=' + val;
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
      
      <h1>Enter Regular Report - Select Plant</h1>
      
      <?php 
			  if(checklogin($dbh)) {
			 	
				if(isset($_POST['submit']) && ($_POST['stationid']!=0) && isset($_POST['personid']) ){
						
					//GET SPECIES LIST FROM rel_station_species
					//station id available
					$stationid = $_POST['stationid'];

					//todo get station name from selected station id
					$qry = sprintf("SELECT Station_Name from tbl_stations WHERE Station_ID = %d",
								$stationid );
					$check = $dbh->query($qry);
					if (!$check) {
						die('That station id does not exist in our database. 
						Please contact the web manager - error: report_obs_logged2 - station name not found');
					}
					while ($row = $check->fetch_object()) {
						$stationname = $row->Station_Name;
					}
					
					//echo "stationname = ".$stationname;
					//echo "station id = ".$stationid;
					$personid = $_POST['personid'];
					//echo "person id = ". $personid;
					
					$user_plant_menu = build_user_species_menu($stationid, $dbh);
					
					if ($user_plant_menu==''){
					$maincontent.='<form id="form2" name="form2" method="post" action="register_plant_select_plant_group.php"><input name="stationid" type="hidden" value="' . $stationid . '" /></form>';
						$maincontent .= '<p>Please first ';
						$maincontent.= '<a href = "#" class="maincontent" onclick="document.forms[\'form2\'].submit(); return false;"> register a plant</a> 
						at ' . $stationname . '.</p>';
						$maincontent.='<p>  Or you can 
						<a href="getstarted_occasionalobserver.php"><b>make a single report</b></a>  
						without registering a MyBudBurst plant.</p>';
					}
					else {
						?>
						<p>(1) Site Location --&gt; <strong> (2) Select  Plant </strong>--&gt; (3) Report Observation </p>
						<p>Please select what plant you are observing at site:
						<span class="username"><?php echo $stationname;?></span>.</p>
						<p>&nbsp;</p>
						<form id="form1" name="form1" method="post" action="regular-report-submit.php">
					
					<input name="personid" type="hidden" value="<?php echo $personid;?>" />
					<input name="stationid" type="hidden" value="<?php echo $stationid;?>" />
					<input name="stationname" type="hidden" value="<?php echo $stationname; ?>" />
					<input name="speciesid" type="hidden" value="" />
					
					  <table width="550" border="0" cellpadding="5" cellspacing="0" bgcolor="#EDB6BF" class="form">
                        <tr>
                          <td colspan="3"><strong>WHAT</strong> PLANT DID YOU OBSERVE?</td>
                        </tr>
                        <tr>
                          <td width="157"><div align="right"><strong>*MyBudBurst Plant</strong>:</div></td>
                          <td width="262"><?php echo $user_plant_menu;?></td>
                          <td width="101"><strong><img src="images/select.jpg" alt="plant" name="mainImg" width="100" height="100" id="mainImg" /></strong></td>
                        </tr>
                      </table>
					  <p align="center">
				        <input name="submit" type="submit" id="submit" value="Submit" />
				      </p>
					</form>


					<?php
					}//else plant menu
					
				} //if submit
				else
				{
					$maincontent.='<p> Sorry, no site was selected.  Please go back and select the site for your observation.</p>
							<FORM>
							<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
							</FORM>
							<p>If you continue to receive this error, please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.';
				}
			} //if logged in
			else {
				$maincontent .=  '<p>Sorry you are not logged in, 
											this area is restricted to registered members. ';
					$maincontent .= '<a href="login.php">Click here</a> to log in.</p>';	
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