<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/4/2012
# Copyright 2008-2012 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Enter Single Report - Select Plant Group"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed

?>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script language="javascript" src="js/menuswap.js"></script>
<script language="javascript" src="js/showhide.js"></script>
<script language="javascript" src="js/plantonchange.js"></script>

<script type="text/javascript">

	
//function reloadoccobs(form)
//{
//	var val=form.plantgroupid.options[form.plantgroupid.options.selectedIndex].value;
//	self.location='report_occ_obs.php?plantgroupid=' + val;
//}
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
      
      <h1>Enter Single Report - Select Plant Group</h1>
      
      <?php 
			  
			  $maincontent = '';
			  
			  if(checklogin($dbh))
			  {
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
				
				// Build a Field Guide selection drop down menu
				// Note, the values are based on PlantGroupID values
				// 1 = Wildflowers and Herbs
				// 2 = Grasses
				// 3 = Deciduous Trees and Shrubs
				// 4 = Evergreens
				// 5 = Conifers
				//$usersite_selection_menu="<select name='plantgroupid' class='select' id='plantgroupid' tabindex='1' onchange='reloadoccobs(form)'>";
				//$usersite_selection_menu.="<option value='0' selected='selected'>Select</option>";
				//$usersite_selection_menu.="<option value='1'>Wildflowers</option>";
				//$usersite_selection_menu.="<option value='2'>Grasses</option>";
				//$usersite_selection_menu.="<option value='3'>Trees and Shrubs</option>"; 
				//$usersite_selection_menu.="<option value='4'>Evergreens</option>"; 
				//$usersite_selection_menu.="<option value='5'>Conifers</option>"; 
				//$usersite_selection_menu.="</select>";
				
				//Build Plant Group selection radio button group
				$usersite_selection_menu.='<input type="radio" name="plantgroupid" id="plantgroupid" value="3" /> Deciduous Trees and Shrubs<br />';
				$usersite_selection_menu.='<input type="radio" name="plantgroupid" id="plantgroupid" value="1" tabindex="1"/> Wildflowers and Herbs<br />';
				$usersite_selection_menu.='<input type="radio" name="plantgroupid" id="plantgroupid" value="5" /> Conifers<br />';
				$usersite_selection_menu.='<input type="radio" name="plantgroupid" id="plantgroupid" value="4" /> Evergreen Trees and Shrubs<br />';
				$usersite_selection_menu.='<input type="radio" name="plantgroupid" id="plantgroupid" value="2" /> Grasses<br />';


				
				
				//DISPLAY SITE SELECTION
				?>
				
				<!--This JavaScript is down this far because it needs $personid from PHP which is not defined until now-->
				<script type="text/javascript">
				$(function()
				{
					//when a plant group is selected, enable submit button
				 	$('input:radio[name=plantgroupid]').change(function()
					{
						$('#btnsubmit').prop("disabled",false)

					});
				
					//submit button click
					$('#btnsubmit').click(function()
					{
						var plantgroupid = $('input:radio[name=plantgroupid]:checked').val();

						newurl = "single-report-plant.php?plantgroupid=" + plantgroupid + "&personid=<?php echo $personid?>";
						window.location = newurl;
						return false;
					});
				}); // end DOM load function
				</script>
				
                <p><strong>Select Plant Group</strong> <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Select Plant <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Site Location <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Report Observation</p>
                <p>&nbsp;</p>
                <br />
				<form id="form1" name="form1" method="post"> <!-- report_obs_logged2.php -->
				<div style="width:550px;height:187px;margin:0 auto;background-color:#C3D9A5">
					<div style="background-image:url('images/SectionHeader_BG.png');background-repeat: repeat-x;color: #FFFFFF;font-size: 11pt;font-weight: bold;height: 22px;text-align: center;padding-top:4px;">Select Plant Group</div>
					<div style="width:200px;margin:16px auto 0 auto">
						<?php echo $usersite_selection_menu;?>
					</div>
					<div style="width:100px;margin: 5px auto 0;">
						<input name="btnsubmit" type="button" id="btnsubmit" disabled="disabled" value="Submit" tabindex="2" />
					</div>
				</div>
                </form>
                <?php
        
                //}//else no stations

				} //if logged in
				else // not logged in... entice them to either login or register
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