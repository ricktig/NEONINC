<?php 
/*------------------------------------------------
# Author: Rick Rose
# Last modified: 30-Oct-2012
# Copyright 2008-2012 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Display All Project BudBurst Species"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<?php
//
HeaderEnd();
?>


<body id="PlantResources">
<div id="wrapper">
	<div id="contentwrapper">
		
		
		<?php
			WriteTopLogin($dbh);
		?>
			
		<!-- Top Navigation for Home Page -->

		<?php	
			WriteTopNavigation();
		?>
		
		<!--main content div-->
		<div id="maincontent">
			<h1 style="margin-left: 10px;">Project BudBurst Plants - Images</h1><!--end header div-->
		
			<?php 

				
				//fetch species name
				$result_PBB_Species = get_PBB_species($dbh);
				
				while($row_PBB_Species = $result_PBB_Species->fetch_object())
				{
					$speciesId = $row_PBB_Species->Species_ID;
					$commonName = $row_PBB_Species->Common_Name;
					//echo Common Name, 100x100 image (speciesid.jpg), 200xwhatever image (speciesid_m.jpg)
					echo'<div id="rowholder" style="border:1px solid grey;margin:10px; padding:10px">';
					echo $speciesId . ' ';
					echo $commonName . '<br /> ';
					//echo '<img src="images/'. $speciesId . '.jpg" width="100" height="100" style="border:1px solid grey" alt="image ' . $speciesId  . '.jpg missing"/>';
					echo '<img src="images/'. $speciesId . '.jpg" style="border:1px solid grey" alt="image ' . $speciesId  . '.jpg missing"/>';
					echo $speciesId . '.jpg';
					echo '<img src="images/'. $speciesId . '_m.jpg" style="margin-left:15px; border:1px solid grey" alt="image ' . $speciesId . '_m.jpg missing"/>';
					echo $speciesId . '_m.jpg';
					
					echo '</div>';
				}//while
				
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
