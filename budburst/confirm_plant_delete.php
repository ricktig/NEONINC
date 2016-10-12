<?php
/*------------------------------------------------
# Author: Dennis Ward (NEON)
# Last modified 2/12/2012
# Copyright 2008-2012 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';
//require_once 'cgi-bin/pb_lib_kkm.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("My BudBurst Sites and Plants - Verify Plant Deletion"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<?php
HeaderEnd();
?>

<?php
//fetch post variables
$commonname = $_POST['commonname'];
$sitename = $_POST['sitename'];
$speciesid = $_POST['speciesid'];
$stationid = $_POST['stationid'];
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
 
<?php
			// Check if user is not logged in
			if(!checklogin($dbh))
			{	
				$maincontent.="<h1>My BudBurst</h1>".
				"<h2>Welcome Guest!</h2>".
				"You will need to login to make regular reports or view your MyBudBurst page. ".
				"To do so, <a href='login.php'>login</a> or <a href='register.php'>join</a> today!<p>".
				//"Once you have logged in, simply mark the dates of the <a href='help_phenophases.php'>phenophases</a> of trees, shrubs, or flowers in your community.".
				"Visit our <a href='getstarted.php'>Get Started</a> pages for complete information including a reporting form to help you note phenological changes as they occur throughout the year.</p>".
				"<ul>".
					"<li><a href='login.php'>Login</a> or 
						 <a href='register.php'>join</a> to become a member and start reporting observations today!</li>".
				"</ul>";
			}
				
			//logged in show content
			else
			{
				?>
			<h1 style="width:70%;">Confirm Plant Deletion</h1>
						
   			<p>You're about to delete <?php echo $commonname?> from <?php echo $sitename?>.</p>
			<p>Are you sure that you want to continue?</p>
			<form id="form1" method="post" action="register_plant_delete.php">
			<input type="hidden" name="stationid" value="<?php echo $stationid?>" />
			<input type="hidden" name="speciesid" value="<?php echo $speciesid?>" />
			<input type="hidden" name="commonname" value="<?php echo $commonname?>" />
			<input type="hidden" name="sitename" value="<?php echo $sitename?>" />

			<INPUT TYPE='button' VALUE='Cancel' onClick='history.go(-1);return true;'>		
			<input name="deleteplantsubmit" type="submit" id="deleteplantsubmit" value="Yes - Delete" />
			</form>
			
			<?php
			}
			echo $spacer;
			?>
    </div> <!-- MainContent -->
	
    <!-- Footer -->
    
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
