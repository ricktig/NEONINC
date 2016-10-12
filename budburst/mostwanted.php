<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/6/2012
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
HeaderStart("Project BudBurst - Our 10 Most Wanted Plants"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="PlantResources">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_3.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst - Plant Resources Section" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Project BudBurst's 10 Most Wanted Plants</h1>
      
      <p>Why did we choose these plants? Our science team requested that special attention be given to these plant species for the 2013* field campaign because these 10 Most Wanted plants are easily identified, widely distributed across the US, and scientifically interesting.</p>

		<p>One of the most exciting aspects of Project BudBurst is that it provides consistent data at hundreds of locations across the country. Many observations of these 10 Most Wanted plants were made in recent years and more observations are very valuable to the scientists and educators who use the Project BudBurst data. Your observations of Project BudBurst's 10 Most Wanted plants will help us better understand how these plants are changing with our changing environment.</p>
	    
	  <div id="mostWantedSpecies" style="width:710px;height:375px;">
	  <?php
	  //select species from special projects table where special project id = 21 (top ten)
	  //ordered by species id
					$qry2 = sprintf("SELECT tbl_special_projects.ID, tbl_species.Species_ID, tbl_species.Common_Name, tbl_species.Species
									FROM (tbl_special_projects RIGHT JOIN rel_species_special_projects ON tbl_special_projects.ID=rel_species_special_projects.Special_Project_ID)
									LEFT JOIN tbl_species ON rel_species_special_projects.Species_ID=tbl_species.Species_ID
									WHERE tbl_special_projects.ID = '%s' ORDER BY tbl_species.Species_ID", '21');
									
					$check2 = $dbh->query($qry2);
					$i = 1;
					while ($row2 = $check2->fetch_object())
					{

						//add row break after 5th image
										if ($i == 6)
										{
											//$float = 'clear:both';
										} 
						
							//display top ten image
							echo '<a href="plantresources_speciesinfo.php?speciesid=' . $row2->Species_ID . '">';
							echo '<div class="mostwantedplants" style="width:120px; height:180px; margin:0 15px 10px 0;' . $float .'">';
							echo '<img style="padding: 0;border-radius:8px;" src="images/' . $row2->Species_ID . '.jpg" height="120px" width="120px" border="0" />';
							echo '<div style="padding:3px 0 0 3px;line-height:1.3">';
							echo $row2->Common_Name . '<br />';
							echo '<em style="font-size:0.75em;padding: 2px 0 0 0">' . $row2->Species . '</em>';
							echo '</div></div></a>';
							$i++;
						//}
					}//end while qry2
		?>
      </div>
 <p>&nbsp;</p>
<p>Of course, your observations of all 208 targeted Project BudBurst species are important to us and we are always interested in your observations of 'Other' species as well. Your observations help us better understand how plants are responding to changes in their environments.</p>

<p>*<em>To make certain that at least one of the 10 Most Wanted Plant species can be found in each of the 50 states, this year's list includes Southern magnolia and California poppy. Although Spiderwort and Black cottonwood are no longer on our 10 Most Wanted list, your observations of these species are still important and we hope you will continue to monitor them!</em></p>

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