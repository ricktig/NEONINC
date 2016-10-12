<?php 
/*------------------------------------------------
# Author: Rick Rose
# Last modified 10/1/2012
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
HeaderStart("Project BudBurst - Make a Single Report"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	// document load - load Google map
	$(function()
	{
		loadMap();
	});
	
	//Google Maps load
	//initialize variables
	var map;
	var marker = null;
	var markersArray = [];
	var myLatLng = null;
	var myLat;
	var myLng;
	
	function loadMap()
	{
		mapCenter = new google.maps.LatLng(<?php echo $_POST['lat'] . ',' . $_POST['lon']?>);
		
		var mapOptions =
		{
			zoom: 15,
			center: mapCenter,
			streetViewControl: false,
			scaleControl: true,
			zoomControl: true,
			zoomControlOptions:
			{
				style: google.maps.ZoomControlStyle.LARGE
			},
			mapTypeControl: true,
			mapTypeControlOptions:
			{
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
			},
			mapTypeId: google.maps.MapTypeId.TERRAIN
		}; // end mapOptions

		//create new map object
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		
		marker = new google.maps.Marker(
		{
			position: mapCenter,
			map: map
		});
		
		//add new marker object to markers array
		markersArray.push(marker);
	} // end loadMap()
	
	function goBack()
	{
		history.go(-1);
	}
</script>

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
	
	<h1>Verify Your Site Location</h1>
      
	<!--<h1>Enter Single Report - Verify Site Information</h1>-->
		   
    <?php
		$maincontent='';
		//$ok_flag=1; //assume good to go
		
		//make sure user is logged in
		if(checklogin($dbh))
		{
			
			//if submit button clicked - Rick R - 7-Nov-2012 - Removed check for submit button click 
			//if (isset($_POST['submit']))
			//{
			//if a required field is empty, redirect the user
				if ((!$_POST['sitename']) || (!$_POST['lat']) || (!$_POST['lon']) || (!$_POST['city']) || (!$_POST['state']))
				{
				?>
					<h2>You did not fill in all required fields.</h2>
					<p>When describing your single report site, you will need to fill in all required fields.
					 Please go back and try again.</p>
					<form id="form2" name="form2" action="single-report-site.php?personid=<?php echo $_GET['personid'];?>&plantgroupid=<?php echo $_GET['plantgroupid'];?>&speciesid=<?php echo $_GET['speciesid'];?>&speciesid_verified=<?php echo $_GET['speciesid_verified'];?>" method="post">
					<!--//add hidden fields to get lat, lon, city, state, zip from previous page back to previous page w/o adding more length to the URL vars-->
					<input type="hidden" name="lat" value="<?php echo $_POST['lat'];?>" />
					<input type="hidden" name="lon" value="<?php echo $_POST['lon'];?>" />
					<input type="hidden" name="sitename" value="<?php echo $_POST['sitename'];?>" />
					<input type="hidden" name="city" value="<?php echo $_POST['city'];?>" />
					<input type="hidden" name="state" value="<?php echo $_POST['state'];?>" />
					<input type="hidden" name="zip" value="<?php echo $_POST['zip'];?>" />

					<input type="button" id="btnback" name="btnback" onclick="document.getElementById('form2').submit();" value="Back" tabindex ="2" />
					</form>
					
				<?php
				}
			   	else // they have filled in required fields ; if ($ok_flag)
			   	{
					// force all longitude values to negative
					$fixedLON = abs($_POST['lon']) * -1;
					// force all latitude values to positive
					$fixedLAT = abs($_POST['lat']);
					
					//Get information from URL for vars not submitted by site description form elements
					$personid = $_GET['personid'];
					$plantgroupid = $_GET['plantgroupid'];
					$speciesid = $_GET['speciesid'];
					$speciesid_verified = $_GET['speciesid_verified'];
					?>
					
					<p>Select Plant Group <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" />  Select Plant <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> <strong> Site Location</strong> <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" />  Report Observation</p>
					
					<form action="single-report-site-do.php?personid=<?php echo $personid;?>&plantgroupid=<?php echo $plantgroupid;?>&speciesid=<?php echo $speciesid;?>&speciesid_verified=<?php echo $speciesid_verified;?>" method="POST" name="form1" id="form1" style="background-color:#C3D9A5; margin: 0 0 10px 0">
					
					<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form" style="margin: 0 auto">
						
						<th align="center" colspan="2" style="height:20px">Verify Site Location</th><!--  #7EAF20 -->
						<tr><td>
						<div id="dataholder" style="width:71%;margin: 20px auto 0 auto;">
						
							<div id="leftholder" style="float:left">
								<table style="width:250px">
									<!--<tr colspan="2" style="width: 100px">Verify your site information:</tr>-->
									<tr><td>
										<tr>
											<td>
												<strong>Site Name:</strong>
												<?php echo $_POST['sitename'];?>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Latitude:</strong>
												<?php echo $_POST['lat'];?>&deg;
											</td>
										</tr>
										<tr>
											<td>
												<strong>Longitude:</strong>
												<?php echo $_POST['lon'];?>&deg;
											</td>
										</tr>
									</td>
								</table>
							</div>
							<div id="rightholder" style="float:right">
									<table style="width:250px">
									<td>
										<tr>
											<td>
												<strong>City:</strong>
												<?php echo $_POST['city'];?>
											</td>
										</tr>
										<tr>
											<td>
											<strong>State:</strong>
												<?php echo $_POST['state'];?>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Zip:</strong>
												<?php echo $_POST['zip'];?>
											</td>
										</tr>
									</td></tr>
								</div>
						</div>
						</table>
						</td></tr>
						<tr>
							<td colspan="2">
								<!-- div for static Google map of user supplied location-->
								<div id="map" style="margin: 10px auto 10px auto; width:400px; height: 400px; border: 1px solid grey" tabindex="1"></div>
							</td>
						</tr>
						</table>
						<!-- add hidden fields to get lat, lon, city, state, zip from previous page to next page w/o adding more length to the URL vars-->
						<input type="hidden" name="lat" value="<?php echo $_POST['lat'];?>" />
						<input type="hidden" name="lon" value="<?php echo $_POST['lon'];?>" />
						<input type="hidden" name="sitename" value="<?php echo $_POST['sitename'];?>" />
						<input type="hidden" name="city" value="<?php echo $_POST['city'];?>" />
						<input type="hidden" name="state" value="<?php echo $_POST['state'];?>" />
						<input type="hidden" name="zip" value="<?php echo $_POST['zip'];?>" />
						
						<!-- div to center submit/clear buttons-->
						<div style="text-align: center; margin: 0 auto 0 auto; width: 600px;padding: 5px 0 15px 0;">
						
						<input type="button" id="btnback" name="btnback" onclick=" document.getElementById('form2').submit();" value="No, this is not correct.  Please take me back." tabindex ="2"/>

						<input type="submit" name="btnsubmit" value="Yes, this is correct.  Please continue." tabindex ="3" />
						</div>
					</form>
					
					<!--hidden form for back button data transfer via hidden inputs-->
					<form id="form2" name="form2" action="single-report-site.php?personid=<?php echo $personid;?>&plantgroupid=<?php echo $plantgroupid;?>&speciesid=<?php echo $speciesid;?>&speciesid_verified=<?php echo $speciesid_verified;?>" method="post">
						<!-- add hidden fields to get lat, lon, city, state, zip from previous page back to previous page w/o adding more length to the URL vars-->
						<input type="hidden" name="lat" value="<?php echo $_POST['lat'];?>" />
						<input type="hidden" name="lon" value="<?php echo $_POST['lon'];?>" />
						<input type="hidden" name="sitename" value="<?php echo $_POST['sitename'];?>" />
						<input type="hidden" name="city" value="<?php echo $_POST['city'];?>" />
						<input type="hidden" name="state" value="<?php echo $_POST['state'];?>" />
						<input type="hidden" name="zip" value="<?php echo $_POST['zip'];?>" />
					</form>					
				
				
				<?
				} // end if all fields provided from single-report-site.php
			//} //if submit isset(submit)
			//else //form not submitted
			//{
			//	$maincontent.='<p>Sorry, you must first describe a site for your single report.</p> 
			//	<p>Please go back and fill out the site description form.';
			//	//changed to include back button so GET variables are avaiable for site entry retry - Rick R. 01-Oct-2012
			//	$maincontent.="<FORM><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'></FORM>";
			//}
		}
		else // else not logged in
		{
			$maincontent.='<p>You are not logged in. Please <a href="login.php">login</a> to continue.';
		}
		//$maincontent.=$spacer;
		echo $maincontent;
		?>
		             
    </div>
    
    <!-- MainContent -->

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