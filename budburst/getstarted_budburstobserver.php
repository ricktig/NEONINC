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
HeaderStart("Project BudBurst - BudBurst Observer"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed


//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
  <!--  <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->
	
	<?php	
		WriteTopNavigation();
	?>
    
    <div id="MainContent">
      
      <h1>Regular Observations</h1>
       <img src="images/RegularObs_collage.jpg" alt="Photos of people observing plants" width="254" height="264" align="right" />  
      <!--<div style="float:right; display:block; width:284px; padding-left:12px; padding-bottom:12px;">
        <div id='Phenophases'>
            <div id='Phenophases_Header'>Steps to Getting Started</div>
            <div id='SectionContainer'>
              <table width="254" border="0" align="center" cellpadding="6">
                <tr>
                  <td width="36"><img src='images/Register.png' border="0" width='20' height='20' style='float:left; padding-right:6px;' /></td>
                  <td width="196"><a class="BigLink" href="register.php">Register</a></td>
                </tr>
                <tr>
                  <td width="36"><img src='images/Register.png' border="0" width='20' height='20' style='float:left; padding-right:6px;' /></td>
                  <td><a class="BigLink" href="pdfs/Generic-Field-Journal.pdf">Download field journal</a></td>
                </tr>
                <tr>
                  <td width="36"><img src='images/Register.png' border="0" width='20' height='20' style='float:left; padding-right:6px;' /></td>
                  <td><a class="BigLink" href="plantresources.php">Select a plant(s)</a></td>
                </tr>
                <tr>
                  <td width="36"><img src='images/Register.png' border="0" width='20' height='20' style='float:left; padding-right:6px;' /></td>
                  <td><a class="BigLink" href="help_describeitsenvironment.php">Describe  environment</a></td> 
                </tr>
                <tr>
                  <td width="36"><img src='images/Register.png' border="0" width='20' height='20' style='float:left; padding-right:6px;' /></td>
                  <td><a class="BigLink" href="plantresources.php">Make observations</a></td>
                </tr>
                <tr>
                  <td width="36"><img src='images/Register.png' border="0" width='20' height='20' style='float:left; padding-right:6px;' /></td>
                  <td><a class="BigLink" href="report_observations.php">Share your observations</a></td>
                </tr>
              </table>
            </div>
    	</div>
      </div>-->
      
      <p>The most valuable phenology information for scientists is when people make regular observations at specified sites on the same plants or group of plants from year to year. This type of observation is the backbone of data that helps us better understand change and this is what Project BudBurst is all about.</p>
      <p>Project BudBurst is designed for individuals or groups to make regular observations of a plant(s) in their local area. As a participant, you might observe a plant that is in your backyard, neighborhood, school, workplace, or you may want to observe a  plant that you find on your daily walk. Resources  about many suggested plants are available on the <a href="choose.php">Plant Resources</a> pages of the  website, but you are not limited to these species. If you choose to observe a  species not on our list, we recommend downloading our <a href="pdfs/Generic-Field-Journal.pdf">Generic Field Journal</a> and use it to monitor your species of interest.  If you do not wish to make regular observations of a plant, you can make <a href="getstarted_occasionalobserver.php">Single Reports</a> of plants on the Project BudBurst <a href="display_all_plants_list.php">Master Plant List</a> instead. Learn more about how to do so under our <a href="getstarted_occasionalobserver.php">Single Reports</a> section of the Get Started tab.</p>
      <h2>What  does &lsquo;regular observation&rsquo; mean?</h2>
      <p>When your plant is active, you'll want to check on your plant a few times a week so you know when your plant  reaches one of the phenological stages such as first leaf, full leaf, or first flower. Then, on your Phenophase Field Guide, you'll record the exact date your plant reached each phenological stage. If you miss a phenophase or two (for example, if you're away from home when it occurs) that's okay. Just record as many of the phenophases for your plant that you do observe.</p>
      <h2>Let&rsquo;s walk through the steps so you can get started  making observations.</h2>
      <ul class="plantgrouplinks">
      <li class="darkgreen">
        <a href="register.php"><img src="images/icons/reportStepsIcons/Register_White.png" alt="" name="sdf" width="38" height="38" align="left" />
        <p>Register For An Account</p></a></li>
     <li class="darkgreen">
        <a href="choose.php"><img src="images/icons/reportStepsIcons/choosePlant.png" alt="" name="sdf" width="38" height="38" align="left" />
        <p>Choose a Plant</p></a></li>
      
        <li class="darkgreen">
          <a href="register.php"><img src="images/icons/reportStepsIcons/downloadDatasheet.png" alt="" name="sdf" width="38" height="38" align="left" />
          <p>Download Datasheet</p></a></li>
      </ul>
        <!-- breaking this into two lists as the css as is is not allowing a second set of links in the list; Also note the images in each "button" are left aligned. This was css that i grabbed from the plant styles page. it probably should use classes and background images to place the images if we do these again in the future... but this works for the time being -->
        <ul class="sublinks">
            <li><a href="#">Data Sheet 1</a></li>
            <li><a href="#">Data Sheet 2</a></li>
            <li><a href="#">Data Sheet 3</a></li>
          </ul>
        <ul  class="plantgrouplinks">
        <li class="darkgreen">
          <a href="help_describeitsenvironment.php"><img src="images/icons/reportStepsIcons/selectSite.png" alt="" name="sdf" width="38" height="38" align="left" />
        <p>Locate / Describe Site</p></a></li>
        <li class="darkgreen">
        <a href="choose.php"><img src="images/icons/reportStepsIcons/makeObs.png" alt="" name="sdf" width="38" height="38" align="left" />
        <p>Make Observations Outside</p></a></li>
        <li class="darkgreen">
        <a href="mybudburst.php"><img src="images/icons/reportStepsIcons/reportObs.png" alt="" name="sdf" width="38" height="38" align="left" />
        <p>Report Observations Online</p></a></li>
      </ul>
<!--<div style="width:100%; display:block;">--> 
<!-- THIS BELOW SHOULD ALL BE DELETED! 
<table width="700" border="0" align="left" cellpadding="4">
                <tr>
                    <td width="50" valign="top"><img src='images/Register.png' width='20' height='20' style='float:left; padding-right:6px;' /></td>
                    <td valign="top" bgcolor="#C3D9A5">
                    <span id="H2Text"><a href="register.php" >Register (if you don't already have a Project BudBurst<sup class="sm">SM</sup> account).</a></span>
                    By registering with Project BudBurst, you will have access to your very own My BudBurst space where you can describe one or more sites and the plant(s) that you observe at each site. By doing so, all your data will be saved, eliminating the need to re-enter site descriptions every time you report                    </td>
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/Register.png' width='20' height='20' style='float:left; padding-right:6px;' /></td>
                    <td valign="top">
                    <span id="H2Text"><a href="choose.php" >Select a plant(s).</a></span> The key to selecting a plant is to find one that will be convenient for you to observe on a regular basis. In order to help you find a plant(s), we have several resources you can use.</td>
                </tr>
<tr>
                    <td width="50" valign="top"><img src='images/Register.png' width='20' height='20' style='float:left; padding-right:6px;' /></td>
                    <td valign="top" bgcolor="#C3D9A5">
<span id="H2Text"><a href="pdfs/Generic-Field-Journal.pdf">Download field journal.</a></span> We&rsquo;ve created an easy-to-use Field Journal that you can  print and use to record information about your plant. You can also download customized Field Journals for Project BudBurst plants via our <a href="plantresources.php">Plant Resources</a> page. That way you won&rsquo;t forget anything!</td>
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/Register.png' width='20' height='20' style='float:left; padding-right:6px;' /></td>
                    <td valign="top">
                    <span id="H2Text"><a href="help_describeitsenvironment.php">Describe the environment.</a></span> Use the <a href="geocoder.php">Project BudBurst&#8480 Geocoder</a> or a GPS unit to determine the latitude and longitude for your plant. Also, note other features about your site using the checklist on your Field Journal. Describe your site in terms of proximity to buildings, presence of asphalt surfaces, slope, sunlight, and irrigation. When you register a site, for example, your yard, you will only have to enter this information once for that site. You can monitor multiple plants under at the same site, as long as those plants are within a 1/2 mile of each other and you can monitor multiple different sites. </td>
                    
        </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/Register.png' width='20' height='20' style='float:left; padding-right:6px;' /></td>
                    <td valign="top" bgcolor="#C3D9A5">
                    <span id="H2Text"><a href="plantresources.php">Make observations of the phenophases.</a></span> This is probably the trickiest part of Project BudBurst and the most important. It is worth spending some time to learn about the phenophases of your plant to make certain you are collecting useful data. The plant groups all have slightly different phenophases for you to observe. You can find phenophase information in the Plant Resources section of the site on each of the plant group pages (ie. Wildflowers and Herbs, Conifers, etc.)</td>
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/Register.png' width='20' height='20' style='float:left; padding-right:6px;' /></td>
                    <td valign="top">
                    <span id="H2Text"><a href="mybudburst.php" >Share your observations.</a></span>
                  This final step is very important. Your Project BudBurst investigation is not complete until you have entered your data to share your plant&rsquo;s story with others. This final step only takes a few minutes on our web site!</td>
                </tr>
      </table> -->
      <!--</div>-->
      <br style="clear:both; display:block;" />
      <p>Now that you have the overview, it is time to take  your first step and register! We have lots of resources to help you along the way. If you have any questions, please contact the Project BudBurst team at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
      
      <br />
      <br />
      
     
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