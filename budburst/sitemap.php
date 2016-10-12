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
HeaderStart("Project BudBurst - Site Map"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="Home">

<div id="wrapper">

 <div id="contentwrapper">
  	
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
  	  <h1>Site Map</h1>
  	  	<ul class='sitemap'>
				<li><a href='getstarted.php' id='TopNavigation_AboutUs' alt='Get Started' title='About'>Get Started</a>
					<ul>
						<li class='AboutUs'><a href='getstarted.php' alt='Home' title='Home'><span id='SubNavElement'>Get Started</span></a></li>
						<li class='AboutUs'><a href='getstarted-regular-report.php' alt='Regular Observation' title='Regular Report'><span id='SubNavElement'>&ndash;&#8202;Regular Report</span></a></li>
						<li class='AboutUs'><a href='getstarted-single-report.php' alt='Single Report' title='Single Report'><span id='SubNavElement'>&ndash;&#8202;Single Report</span></a></li>
						<li class='AboutUs'><a href='cherry/index.php' alt='Cherry Blossom Blitz' title='Cherry Blossom Blitz'><span id='SubNavElement'>Cherry Blossom Blitz</span></a></li>
						
						<li class='AboutUs'><a href='summer/index.php' alt='Summer Solstice Snapshot' title='Summer Solstice Snapshot'><span id='SubNavElement'>Summer Solstice Snapshot</span></a></li>
						
						<li class='AboutUs'><a href='fall/index.php' alt='Fall into Phenology' title='Fall into Phenology'><span id='SubNavElement'>Fall into Phenology</span></a></li>
						
						<li class='AboutUs'><a href='aboutus.php' alt='Home' title='Home'><span id='SubNavElement'>About Project BudBurst</span></a></li>
						
						<li class='AboutUs'><a href='getstarted_Media.php' alt='PBB Media' title='PBB Media'><span id='SubNavElement'>&ndash;&#8202;Media </span></a></li>
						<li class='AboutUs'><a href='gomobile.php' alt='Go Mobile' title='Go Mobile'><span id='SubNavElement'>&ndash;&#8202;Android Mobile App</span></a></li>
						
					</ul>
				</li>
				<li><a href='choose.php' id='TopNavigation_PlantResources' alt='Plant Resources' title='Plant Resources'>Choose a Plant</a>
					<ul>
						<li class='PlantResources'><a href='choose.php' alt='Plant Resources' title='Plant Resources'><span id='SubNavElement'>Choose a Plant</span></a></li>
						<li class='PlantResources'><a href='display_all_plants_list.php' alt='All Plants' title='All Plants'><span id='SubNavElement'>View All Plants</span></a></li>						
						<li class='PlantResources'><a href='plantresources_list.php?PlantGroupID=1' alt='Wildflowers and Herbs' title='Wildflowers and Herbs'><span id='SubNavElement'>&ndash;&#8202;Wildflowers &amp; Herbs</span></a></li>
						<li class='PlantResources'><a href='plantresources_list.php?PlantGroupID=2' alt='Grasses' title='Grasses'><span id='SubNavElement'>&ndash;&#8202;Grasses</span></a></li>
						<li class='PlantResources'><a href='plantresources_list.php?PlantGroupID=3' alt='Deciduous Trees and Shrubs' title='Deciduous Trees and Shrubs'><span id='SubNavElement'>&ndash;&#8202;Deciduous</span></a></li>
						<li class='PlantResources'><a href='plantresources_list.php?PlantGroupID=4' alt='Evergreen Trees and Shrubs' title='Evergreen Trees and Shrubs'><span id='SubNavElement'>&ndash;&#8202;Evergreens</span></a></li>
						<li class='PlantResources'><a href='plantresources_list.php?PlantGroupID=5' alt='Conifers' title='Conifers'><span id='SubNavElement'>&ndash;&#8202;Conifers</span></a></li>
						<li class='PlantResources'><a href='plantresources_list_bystate.php' alt='Plants By State' title='PLants By State'><span id='SubNavElement'>Plants By State</span></a></li>
						<li class='PlantResources'><a href='mostwanted.php' alt='Top Ten Species' title='Top Ten Species'><span id='SubNavElement'>10 Most Wanted</span></a></li>
					</ul>
				</li>
				<li><a href='partnerGroups_index.php' id='TopNavigation_Partners' alt='PBB Partners' title='PBB Partners!'>Partners</a>
					<ul>
						<li class='Partners'><a href='partnerGroups_index.php' alt='PBB Partners' title='PBB Partners'><span id='SubNavElement'>Partners</span></a></li>
						<li class='Partners'><a href='refuges/index.php' alt='Wildlife Refuges' title='Wildlife Refuges'><span id='SubNavElement'>Wildlife Refuges</span></a></li>
						<li class='Partners'><a href='gardens/index.php' alt='Botanic Gardens' title='Botanic Gardens'><span id='SubNavElement'>Botanic Gardens</span></a></li>
						<li class='Partners'><a href='parks/index.php' alt='National Parks' title='National Parks'><span id='SubNavElement'>National Parks</span></a></li>
						<li class='Partners'><a href='urbantree/index.php' alt='Urban Trees' title='Urban Trees'><span id='SubNavElement'>Urban Trees</span></a></li>
						
					</ul>
					
				</li>
				
				
				
				<li><a href='educators/index.php' id='TopNavigation_Education' alt='Education' title='Education'>Education</a>
					<ul>
						<li class='Education'><a href='educators/index.php' alt='Home' title='Home'><span id='SubNavElement'>Education</span></a></li>
						<li class='Education'><a href='educators/educator_K_4.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Grade K-4 </span></a></li>
						<li class='Education'><a href='educators/educator_5_8.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Grade 5-8 </span></a></li>
						<li class='Education'><a href='educators/educator_9_12.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Grade 9-12 </span></a></li>
						<li class='Education'><a href='educators/educator_informal.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Informal Ed </span></a></li>
						<li class='Education'><a href='educators/educator_uni.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;University Ed </span></a></li>
						<li class='Education'><a href='educators/educators_CSA.php' alt='Home' title='Home'><span id='SubNavElement'>Academy Online</span></a></li>
					<!--	<li class='Education'><a href='educators/edu_resources.php' alt='Home' title='Home'><span id='SubNavElement'>Educator Resources</span></a></li> -->
						<li class='Education'><a href='buddies/index.php' target='NewWindow' alt='BudBurst Buddies' title='BudBurst Buddies'><span id='SubNavElement'>BudBurst Buddies</span></a></li>
					</ul>
				</li>
				
				<li><a href='science/phenology.php' id='TopNavigation_Phenology' alt='Phenology' title='Phenology'>Science</a>
					<ul>
						<li class='Phenology'><a href='science/phenology.php' alt='Phenology Defined' title='Phenology Defined'><span id='SubNavElement'>Science</span></a></li>
						<li class='Phenology'><a href='science/phenology_defined.php' alt='Phenology Defined' title='Phenology Defined'><span id='SubNavElement'>Phenology Defined</span></a></li>
						<li class='Phenology'><a href='science/phenology_climatechange.php' alt='Climate Change' title='Climate Change'><span id='SubNavElement'>Climate Change</span></a></li>
						<li class='Phenology'><a href='science/phenology_whyphenology.php' alt='Why Phenology?' title='Why Phenology?'><span id='SubNavElement'>Why Phenology?</span></a></li>
						<li class='Phenology'><a href='science/phenology_history.php' alt='History' title='History'><span id='SubNavElement'>History</span></a></li>
						<li class='Phenology'><a href='science/phenology_phenologytoday.php' alt='Phenology Today' title='Phenology Today'><span id='SubNavElement'>Phenology Today</span></a></li>
					</ul>
				</li>
				
				<li><a href='results_data.php' id='TopNavigation_Data' alt='View Results' title='View Results'>Data</a>
					<ul>
						<li class='Data'><a href='results_data.php' alt='Data' title='Data'><span id='SubNavElement'>Data</span></a></li>
						<li class='Data'><a href='results.php' alt='Data' title='Data'><span id='SubNavElement'>Data Map</span></a></li>
						<!-- <li class='Data'><a href='results_data.php' alt='Data' title='Data'><span id='SubNavElement'>About Our Data</span></a></li> -->
						<li class='Data'><a href='results_byphenophase.php?Phenophase_ID=flower' alt='By Phenophase' title='By Phenophase'><span id='SubNavElement'>Map By Phenophase</span></a></li>
						<li class='Data'><a href='results_attribution.php' alt='Data' title='Data'><span id='SubNavElement'>Community Attribution</span></a></li>
					</ul>
				</li>
				<li><a href='mybudburst.php' id='TopNavigation_MyBudBurst' alt='My BudBurst' title='My BudBurst'>My BudBurst</a>
				<ul>
						<li class='MyBudBurst'><a href='mybudburst.php' alt='Data' title='Data'><span id='SubNavElement'>My BudBurst</span></a></li>
						<li class='MyBudBurst'><a href='my_regular_reports.php' alt='Data' title='Data'><span id='SubNavElement'>Regular Reports Page</span></a></li>
						<li class='MyBudBurst'><a href='my_account.php' alt='Data' title='Data'><span id='SubNavElement'>Manage Account</span></a></li>
					</ul>
				</li>
			</ul>
            
            
           
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