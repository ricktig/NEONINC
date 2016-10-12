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

<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>

<script type="text/javascript">
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
      
      <h1>Enter Regular Report - Site Location</h1>
      
      <?php 
			  
			  $maincontent = 	'';
			  
			  if(checklogin($dbh)) {
				
				//get Person_ID based on username
				$qry = sprintf("SELECT Person_ID from tbl_users WHERE BINARY UserName = '%s'",
								$dbh->real_escape_string($_SESSION['username']) );
				$check = $dbh->query($qry);
				if (!$check) {
					die('That username does not exist in our database. 
					Please contact the web manager - error: report_obs_logged - username not found');
				}
				while ($row = $check->fetch_object()) {
					$personid = $row->Person_ID;
				}
				//echo "personid = ".$personid;
				
				//GET SITES FROM tbl_stations TABLE
				$stations = get_myBudBurst_sites($personid, $dbh);
				$no_stations = mysqli_num_rows($stations);
						
				//check that user has registered sites 
				if (!$no_stations){  
						$maincontent .= '<p>Please <a href="register_site.php" class="maincontent">register a 
						MyBudBurst site</a> before continuing.</p><p>  Or you can 
						<a href="getstarted_occasionalobserver.php" class="maincontent">report a single observation</a>  
						without registering a myBudBurst site and plant.</p>';
				}	
				else{ 
						
					//build dynamic site selection drop down menu of registered sites
					$usersite_selection_menu = '<select name="stationid" class="select" id="stationid" tabindex="1">
											<option value="" selected="selected">Select</option>';
					while ($row = $stations->fetch_object()) {
						$usersite_selection_menu .= '<option value="';
						$usersite_selection_menu .= $row->Station_ID;
						$usersite_selection_menu .= '">';
						$usersite_selection_menu .= $row->Station_Name;
						$usersite_selection_menu .= '</option>';
						} 
					$usersite_selection_menu .= '</select>';
					
					//DISPLAY SITE SELECTION
					?>
					<p><strong>(1) Site Location</strong> --&gt; (2) Select  Plant --&gt; (3) Report Observation</p>
					<p>Please select where you made your observation.  Or you can make a <a href="http://neoninc.org/budburst/getstarted_occasionalobserver.php">Single Report</a> without registering a MyBudBurst Site and Plant.</p>
					<p>&nbsp;</p>
					<form id="form1" name="form1" method="post" action="report_obs_logged2.php">
					<input name="personid" type="hidden" value="<?php echo $personid; ?>" />
					  <table width="550" border="0" cellpadding="5" cellspacing="0" bgcolor="#CBDCEF" class="form">
                        <tr>
                          <td colspan="2"><strong>WHERE</strong> DID YOU OBSERVE?</td>
                        </tr>
                        <tr>
                          <td width="160"><div align="right"><strong>*MyBudBurst Site</strong>:</div></td>
                          <td width="370"><?php echo $usersite_selection_menu;?></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="submit" type="submit" id="submit" value="Submit" /></td>
                        </tr>
                      </table>
				    </form>
					<?php
			
				}	//else no stations

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