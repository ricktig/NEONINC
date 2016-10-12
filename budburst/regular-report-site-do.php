<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/5/2012
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
HeaderStart("Project BudBurst - Register a Site"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<script type="text/javascript">
//JS function to set cookie saving user provided site data for 30 minutes
//function createCookie(name, value, minutes)
//{
//	if (minutes)
//	{
//		var date = new Date();
//		date.setTime(date.getTime()+(minutes*60*1000));
//		var expires = "; expires="+date.toGMTString();
//	}
//	else var expires = "";
//	document.cookie = name+"="+value+expires+"; path=/";

//}
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
      
      <?php
				$maincontent='';
				$ok_flag=1; //assume good to go
				 
				 //make sure user is logged in
				if(!checklogin($dbh))
				{
					$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
					$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.';
					$maincontent.= $spacer;
					$ok_flag=0;
				}
				else
				{	
					if (isset($_POST['btnsubmit']))
					{
						//if a required field is empty, redirect the user
						if ( (!$_POST['sitename']) || (!$_POST['lat']) || (!$_POST['lon']) || (!$_POST['state'])){
							//missing fields
							/*echo'<h1> Site Registration - You did not fill in a required field.</h1> 
							<p>Please go back and try again.</p>
							<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>'.$spacer;*/
							$maincontent.='<h1> Site Registration - You did not fill in a required field.</h1> 
							<p>Please go back and try again.</p>
							<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
							$ok_flag=0;
						}
						
						//note: validation of input type is done on register_site
						//everything should be good at this point
					
						//Get PersonID
						$qry = sprintf("SELECT Person_ID from tbl_users WHERE BINARY UserName = '%s'",$dbh->real_escape_string($_SESSION['username']) );
						$check = $dbh->query($qry);
						if ($dbh->affected_rows == 0) {
							die('That username does not exist in our database. Please contact the web manager - error: register_site - username not found');
						}
						while ($row = $check->fetch_object()) {
							$personid = $row->Person_ID;
						}
					
						//check unique name for site name
						$usersitename = $_POST['sitename'];
						$qry = sprintf("SELECT Station_Name from tbl_stations WHERE Observer_ID = '%s'",$dbh->real_escape_string($personid) );
						$check = $dbh->query($qry);
						while ($row = $check->fetch_object()) {
							$dbsitename = $row->Station_Name;
							if ($dbsitename === $usersitename){
								$ok_flag=0;
								$maincontent .= '<p>Sorry, you already have a myBudBurst site with that name.  
								Please go back and choose a unique site name.</p>
								<FORM><INPUT TYPE="button" VALUE="Back" onclick="location.href=\'regular-report-site.php\'"/> </FORM>';
							}
						}
							
						//todomake sure same person not registering same site again?
						//check person id and lat/lon
						
/*						//COMMENTED BLOCK BELOW TO SKIP PROCESSING NON-EXISTANT ARRAY- DLW, OCT 14, 2011
						//process multiple special project participations
						$special_project_participation='';
						//$special_project_participation=array();
						//if (isset($_POST[special_project_participation_array]))
						//{
							$sp_array = $_POST[special_project_participation_array];
							echo "count of array = " . count($sp_array);
							for ( $ii = 0 ; $ii < count($sp_array) ; $ii++ )
							{
								$special_project_participation = $special_project_participation . ", " . $sp_array[$ii] ;
							}
							//echo "you choose: " . $special_project_participation;
						//}
						
*/						
						//insert station
						//k QUESTION: do we want to include city/state/postalcode/zip???
					   if ($ok_flag){
						   
						  // force all longitude values to negative
						  $fixedLON = abs($_POST['lon']) * -1;
						  // force all latitude values to positive
						  $fixedLAT = abs($_POST['lat']);
					

						   
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
								Special_Project_Participation,
								Station_Human,
								Station_Shading,
								Station_Irrigation,
								Station_Concrete,
								Station_Habitat,
								Station_Forest,
								Station_Slope,
								Comments)	
								values( '%d', '%s', '%f', '%f', '%d', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
								$dbh->real_escape_string($personid),
								$dbh->real_escape_string($_POST['sitename']),
								$dbh->real_escape_string($fixedLAT),
								$dbh->real_escape_string($fixedLON),
								'', // not used - set to null - $dbh->real_escape_string($_POST['elevation']),
								$dbh->real_escape_string($_POST['city']),
								$dbh->real_escape_string($_POST['state']),
								$dbh->real_escape_string($_POST['zip']),
								'', // not used - set to null - $dbh->real_escape_string($_POST['country']),
								//$special_project_participation, - commented out so as not to generate flash of error messages for missing post fields - Rick R. 2012-Dec-14
								//$dbh->real_escape_string($_POST['special_project_participation']),
								'', //special_project_participation - not used - set to null
								//$dbh->real_escape_string($_POST['human_disturbance']),
								'', //human_disturbance - not used - set to null
								$dbh->real_escape_string($_POST['station_shading']),
								$dbh->real_escape_string($_POST['station_irrigation']),
								$dbh->real_escape_string($_POST['station_concrete']),
								$dbh->real_escape_string($_POST['station_habitat']),
								//$dbh->real_escape_string($_POST['forest_type']),
								//$dbh->real_escape_string($_POST['slope_direction']),
								//$dbh->real_escape_string($_POST['comments'])*/
								'', //forest_type - not used - set to null
								'', //slope_direction - not used - set to null
								'' //comments - not used
								
								);
						
							//echo "<br>tbl_stations qry: ".$qry;	
							$dbh->query($qry);
							
							if ($dbh->affected_rows == 0) {
								die('Could not enter site into database.
								Please contact the web manager - error: register_site - count not enter site');
							}
						

							
							//get Station_ID to pass on
							$stationid = $dbh->insert_id;

							//set interval for setting cookie expiration time
							$cookietimeinterval = 30; // in minutes

							$maincontent .= "<script language='javascript'>";
						
							//creates cookies for use on next observation - 30 minute parameter
							$maincontent .= "createCookie('regularreportsitename','" . $usersitename . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportlat','" . $fixedLAT . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportlon','" . $fixedLON . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportcity','" . $_POST['city'] . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportstate','" . $_POST['state'] . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportzip','" . $_POST['zip'] . "'," . $cookietimeinterval . ");";					
							$maincontent .= "createCookie('regularreportirrigation','" . $_POST['station_irrigation'] . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportshaded','" . $_POST['station_shading'] . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreportconcrete','" . $_POST['station_concrete'] . "'," . $cookietimeinterval . ");";
							$maincontent .= "createCookie('regularreporthabitat','" . $_POST['station_habitat'] . "'," . $cookietimeinterval . ");";							$maincontent .= "</script>";	

							echo $maincontent;
							
							//if teacher, redirect to manage classroom page
							if (get_k12teacher($dbh))
							{
								//redirect to manage_classroom.php on success, passing stationid as POST variable
								echo "<FORM id='form1' action='my_regular_reports.php' method='POST'>";
								echo "<input type='hidden' name='stationid' value='" . $stationid . "' />";
								echo "</FORM>";
								echo "<script>document.forms['form1'].submit();</script>";
								
								//header("Location: manage_classroom.php");							
							}
							else
							//not teacher
							{
								//redirect to my_regular_reports.php on success
								echo "<script>location.href='my_regular_reports.php'</script>";
							}
							
						}//if $ok_flag
						
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
						

						
					} //if submit
					else
					{
						$maincontent.='<p>Sorry, we didn\'t understand your input.</p> 
						<p>Please go back and fill out the 
						<a href="register_site.php" class="maincontent">site registration form</a>.</p>';
					} //else form not submitted
				} //else logged in
				
				$maincontent.=$spacer;
				echo $maincontent;
				?>
				<p>&nbsp;</p>
             
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