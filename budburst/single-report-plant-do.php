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
<script language="javascript" src="js/menuswap.js"></script>

<?php
HeaderStart("Project BudBurst - Register a Plant"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>



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
    <h1>Enter Single Report - Select Plant</h1>
      
    <?php
		$maincontent='';
		$flag=0; 
		
		 //make sure user is logged in
		if(!checklogin($dbh))
		{
				$maincontent .=  '<p>Sorry, you are not logged in.  Please <a href="login.php">login</a> or <a href="register.php">join</a> today!';
				$maincontent.= $spacer;
				$flag=1;
		}
		else
		{
			//if (isset($_POST['submit'])) - Rick Rose - 12-Oct-2012 - removed submit button check since click event from occ_obs2 is now called via jQuery due to form timing issue
			//{
					
				//if a required field is empty, error message
				//Rick Rose - Sep-14_2012 - removed stationid from required vars for single reporting
				//if (!($_GET['stationid'] && ($_GET['speciesid'] || $_POST['common_name_userdef'])))
				if (!($_GET['speciesid']) || ($_GET['speciesid']=='999' && !$_GET['common_name_userdef']))
				{
					$maincontent.='<p>You did not fill in a required field.</p> 
					<p>Please go back and try again.</p>
					<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
					$flag=1;	
				}
					
					//everything should be good at this point

					//Set Species ID
					//if other species, save in Species table and get autogenerated species id
					//todo if other common name reported this is higher priority than from selected list??
					if($_GET['common_name_userdef'])
					{
					
						if(!$_GET['genus_userdef']){$genus_udef='';}
						else $genus_udef=$_GET['genus_userdef'];
					
						if(!$_GET['species_userdef']){$species_udef='';}
						else $species_udef=$_GET['species_userdef'];
						
						$qry = sprintf("INSERT INTO tbl_species (
						Common_Name, 
						Genus, 
						Species,
						User_Defined) 
						values ('%s','%s','%s',1)", //1=user_defined
						$dbh->real_escape_string($_GET['common_name_userdef']),
						$dbh->real_escape_string($genus_udef),
						$dbh->real_escape_string($species_udef)
						);
						
						$check = $dbh->query($qry);
						if ($dbh->affected_rows == 0) //display error message if couldn't write other species to tblspecies
						{
							$maincontent.='<p>Error - Could not add to database:Species</p> 
								<p>Please go back and try again.</p>
								<FORM>
								<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
								</FORM>';
							$flag=1;	
						} 
						else 
						{
							$speciesid_verified = $dbh->insert_id;
							//echo '<br> species verified = '.$speciesid_verified;
							
							//store in rel_species_protocol based on plant group selection
							//TODO have user select protocol group instead of plant group to decide pollination?
							if (!isset($_GET['plantgroupid']) ||  ($_GET['plantgroupid']==0))
							{
								$protocolid = get_other_protocol_id($dbh);
							}
							else
							{
								$protocolid = get_protocol_id($dbh, $_GET['plantgroupid']);
							}
							//echo 'Protocolid = ' . $protocolid . '<br>';
							$qry = sprintf("INSERT INTO rel_species_protocol (Species_ID,Protocol_ID) values (%d, %d)", 																		
								$dbh->real_escape_string($speciesid_verified),$dbh->real_escape_string($protocolid)
							);
							
							$check = $dbh->query($qry);
							//echo $qry;
							//echo "Error message = " . mysqli_error($dbh) . "<br>";
							if ($dbh->affected_rows == 0)
							{
								$maincontent.='<p>Error - Could not add to database:rel_species_protocol</p> 
									<p>Please go back and try again.</p>
									<FORM>
									<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
									</FORM>';
								$flag=1;		
							} //if
							else
							{ 
									//everything a-okay
									//echo 'Protocolid = ' . $protocolid . '<br>';
									//echo "species protocol has been added";
							}
						}//else
					}
					else
					{
						//if not other species, use selected species id as verfied speciesid
						$speciesid_verified = $_GET['speciesid'];
					}
				
				//if okay store in rel_station_species table
				if(!$flag)
				{
					$qry = sprintf("INSERT INTO rel_station_species (Station_ID, Species_ID) values ('%d', '%d')", 
					$dbh->real_escape_string($_GET['stationid']),
					$dbh->real_escape_string($speciesid_verified)
					);
				
					$check = $dbh->query($qry);
					if ($dbh->affected_rows == 0)
					{
						$maincontent.='<p>Error - Could not add to database:rel_station_species</p> 
							<p>Please go back and try again.</p>
							<FORM>
							<INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> 
							</FORM>';
					} 
					else
					{
						//use JS to load single-report-site.php
						$maincontent .= "<script language='javascript'>";
						$maincontent .= 'window.location="single-report-site.php?' .
										'personid=' . $_GET['personid'] .
										'&plantgroupid=' . $_GET['plantgroupid'] .
										'&speciesid=' . $_GET['speciesid'] .
										'&speciesid_verified=' . $speciesid_verified .
										//'&sitename=' . urlencode($sitename) .
										'";';
						$maincontent .= "</script>";
						

					} //else affected rows
				} //if $flag = 0
			//} //if $_POST['submit']
		}//end else logged in
			

		echo $maincontent;
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