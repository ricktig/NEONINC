<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/4/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Report an Single Observation"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<script type="text/javascript">
//JS function to set cookie saving user provided site data for 30 minutes
function createCookie(name, value, minutes)
{
	if (minutes)
	{
		var date = new Date();
		date.setTime(date.getTime()+(minutes*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";

}
</script>

<body id="MyBudburst">
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
      
    <?php
		$maincontent='';
		//$ok_flag=1; //assume good to go
		//make sure user is logged in
		if(checklogin($dbh))
		{
			//if submit button clicked
			if (isset($_POST['btnsubmit']))
			{
				//if a required field is empty, redirect the user
				if ((!$_POST['sitename']) || (!$_POST['lat']) || (!$_POST['lon']) || (!$_POST['city']) || (!$_POST['state']))
				{
					//missing fields
					$maincontent.="<h1>Oops! We're Sorry.</h1>".
					"<h2>You did not fill in all required fields.</h2>".
					"<p>When describing your single observation site, you will need to fill in all required fields.".
					" Please go back and try again.</p>".
					"<FORM><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'></FORM>";
					//$ok_flag=0;
				}
			   	else // they have filled in required fields ; if ($ok_flag)
			   	{
					// force all longitude values to negative
					$fixedLON = abs($_POST['lon']) * -1;
					// force all latitude values to positive
					$fixedLAT = abs($_POST['lat']);
					
					//Get information from previous form not submitted by site description form elements
					$personid = $_GET['personid'];
					$plantgroupid = $_GET['plantgroupid'];
					$speciesid = $_GET['speciesid'];
					$speciesid_verified = $_GET['speciesid_verified'];
					$occasionalobserverid = 1;

					//$maincontent.=$personid;
					//$maincontent.="-----------------------------<br>";
					$qry = sprintf("INSERT INTO tbl_stations (
						Observer_ID,  
						Station_Name, 
						Latitude, 
						Longitude,  
						Elevation_m, 
						Station_City, 
						Station_State, 
						Station_PostalCode, 
						Station_Country, 
						Station_Human,
						Station_Shading,
						Station_Irrigation,
						Station_Concrete,
						Station_Habitat,
						Station_Forest,
						Station_Slope,
						Comments)	
						values('%d','%s','%f','%f','%d','%s','%s','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
						$dbh->real_escape_string($occasionalobserverid),
						$dbh->real_escape_string($_POST['sitename']),
						$dbh->real_escape_string($fixedLAT),
						$dbh->real_escape_string($fixedLON),
						$dbh->real_escape_string($_POST['elevation']),
						$dbh->real_escape_string($_POST['city']),
						$dbh->real_escape_string($_POST['state']),
						$dbh->real_escape_string($_POST['zip']),
						$dbh->real_escape_string($_POST['country']),
						$dbh->real_escape_string($_POST['human_disturbance']),
						$dbh->real_escape_string($_POST['shading']),
						$dbh->real_escape_string($_POST['irrigation']),
						$dbh->real_escape_string($_POST['concrete_close']),
						$dbh->real_escape_string($_POST['habitat_type']),
						$dbh->real_escape_string($_POST['forest_type']),
						$dbh->real_escape_string($_POST['slope_direction']),
						$dbh->real_escape_string($_POST['comments'])
						);
					
					$sitename=$_POST['sitename'];
					//$maincontent.=$sitename;
					//$maincontent.=$qry;
					
					$dbh->query($qry);
					
					if ($dbh->affected_rows == 0)
					{
						$maincontent.='Could not enter site description for single observation into database.
						Please contact the web manager - error: single-report-site-do - could not save site';
					}
					else
					{
						// redirect to step 4 page but pass on stationid variable
						
						//get Station_ID to pass on
						
						$stationid = $dbh->insert_id;
						
						//DLW ADDED .urlencode() BELOW ON 05OCT2011 TO SOLVE APOSTROPHE PROBLEM???
						//Rick R. - Sep-18-2012 - added content to create cookie for reuse of site variables

						//set interval for setting cookie expiration time
						$cookietimeinterval = 30; // in minutes
											
						$maincontent .= "<script language='javascript'>";
						
						//creates cookies for use on next observation - 30 minute parameter set two lines above
						$maincontent .= "createCookie('singlereportsitename','" . $dbh->real_escape_string($_POST['sitename']) . "'," . $cookietimeinterval . ");";
						$maincontent .= "createCookie('singlereportlat','" . $fixedLAT . "'," . $cookietimeinterval . ");";
						$maincontent .= "createCookie('singlereportlon','" . $fixedLON . "'," . $cookietimeinterval . ");";
						$maincontent .= "createCookie('singlereportcity','" . $_POST['city'] . "'," . $cookietimeinterval . ");";
						$maincontent .= "createCookie('singlereportstate','" . $_POST['state'] . "'," . $cookietimeinterval . ");";
						$maincontent .= "createCookie('singlereportzip','" . $_POST['zip'] . "'," . $cookietimeinterval . ");";					
						$maincontent .= 'window.location="single-report-submit.php?' .
										'personid=' . $personid .
										'&plantgroupid=' . $plantgroupid .
										'&speciesid=' . $speciesid .
										'&speciesid_verified=' . $speciesid_verified .
										'&stationid=' . $stationid .
										'&sitename=' . urlencode($sitename) .
										'";';
						$maincontent .= "</script>";
						
						// instead echo a confirmation and a form? GJN
						/*
						$maincontent.="<form action='single-report-submit.php' method='post' name='form1' id='form1'>";
						$maincontent.="<input type='hidden' name='personid' value='".$personid."' tabindex ='18'/>";
                        $maincontent.="<input type='hidden' name='plantgroupid' value='".$plantgroupid."' tabindex ='18'/>";
                        $maincontent.="<input type='hidden' name='speciesid' value='".$speciesid."' tabindex ='18'/>";
						$maincontent.="<input type='hidden' name='stationid' value='".$stationid."' tabindex ='18'/>";
						$maincontent.="<input type='hidden' name='sitename' value='".$sitename."' tabindex ='18'/>";
						
                        $maincontent.="<input type='submit' name='submit' value='Submit' tabindex ='18'/>";
						$maincontent.="</form>";
						*/
					}
				}
				//Do we still need to do this since we are re-directing?
				//Clean up
				unset($personid);
				unset($_POST['sitename']);
				unset($_POST['lon']);
				unset($_POST['lat']);
				unset($_POST['elevation']);
				unset($_POST['city']);
				unset($_POST['state']);
				unset($_POST['zip']);
				unset($_POST['country']);
				unset($_POST['human_disturbance']);
				unset($_POST['shading']);
				unset($_POST['irrigation']);
				unset($_POST['concrete_close']);
				unset($_POST['habitat_type']);
				unset($_POST['forest_type']);
				unset($_POST['slope_direction']);
				unset($_POST['comments']);
			} //if submit isset(submit)
			else //form not submitted
			{
				$maincontent.='<p>Sorry, you must first describe a site for your single observation.</p> 
				<p>Please go back and fill out the 
				<a href="single-report-site.php">site description form</a>.</p>';
			}
		}
		else // else not logged in
		{
			$maincontent .=  '<p>Sorry, you are not logged in.  Please <a href="login.php">login</a> or <a href="register.php">join</a> today!';
		}
		$maincontent.=$spacer;
		echo $maincontent;
		
		?>
		<p>&nbsp;</p>
             
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