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
HeaderStart("Project BudBurst - Single Report"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->
	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">

        <h1>Single Reports</h1>
         <img src="images/SingleReport_collage.jpg" alt="Photos of people observing plants" width="254" height="264" align="right" />  

      
      <p>We have heard from many of you who simply can&rsquo;t commit to  watching a plant during the entire growing season. Others have asked if there is a way to  share information on plants they see on vacation or out on a hike. Yes to both suggestions. We have developed an alternate approach that allows you to share the status of plants you encounter on a one-time basis. At this time, we are limiting Single Reports to plants that are found on the Project BudBurst <a href="display_all_plants_list.php">Master Plant List</a>. We have single report forms for each plant group.</p>
      <p>We are testing this approach and would like your help. Keep in mind that you can make Regular Observations and still submit Single Reports. Please send any comments or feedback to <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
      <p>The approach for the Single Report is  different than for the Regular Observations. Some steps are the same, but instead of  watching a plant regularly and noting the date of a phenological &lsquo;event,&rsquo; you  simply tell us the one-time status of the plant you want to report on.</p>
     
    <br/>  
      <h2>Let's walk through the steps for Single Reports: </h2>
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
        
         <ul class="sublinks"> <li><a href="pdfs/Deciduous_single_report.pdf" target="_new">Deciduous Trees or Shrubs Single Report</a></li>
                    <li><a href="pdfs/Wildflowers_single_report.pdf" target="_new"> Wildflowers Single Report</a></li>
                    <li><a href="pdfs/Grasses_single_report.pdf" target="_new">Grasses Single Report</a></li>
                    <li> <a href="pdfs/Evergreen_single_report.pdf" target="_new">Evergreen Trees or Shrubs Single Report</a></li>
                    <li> <a href="pdfs/Conifers_single_report.pdf" target="_new">Conifers Single Report</a></li>
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
<br />
            
            <div style="width:100%; display:block;"> 
            <!--     
			<table width="700" border="0" align="left" cellpadding="4">
                <tr>
                    <td width="50" valign="top"><img src='images/_H1_Icon.gif' width='24' height='24' style='float:left; padding-right:6px;' /></td>
                    <td valign="top" bgcolor="#C3D9A5">
                  <span id="H2Text"><a href="register.php" >Register</a> (if you don't already have a Project BudBurst<sup class="sm">SM</sup> account).</span></td>
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/_H1_Icon.gif' width='24' height='24' style='float:left; padding-right:6px;' /></td>
                    <td valign="top">
                    <span id="H2Text"> <a href="choose.php"> Select a plant.</a></span> This may be a plant in your neighborhood, yard, school ground, or somewhere convenient for you. Please remember that your plant needs to be a <strong>deciduous tree or shrub, wildflower, or grass from the <a href="display_all_plants_list.php">Master Plant List</a>.</strong></td>
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/_H1_Icon.gif' width='24' height='24' style='float:left; padding-right:6px;' /></td>
                    <td valign="top" bgcolor="#C3D9A5">
                   <span id="H2Text">Download Single Report Form.</span> Once you've selected your plant, you can download an easy-to-use Single Report Form for the appropriate plant group. 
                    <ul> <li><a href="pdfs/Deciduous_single_report.pdf" target="_new">Deciduous Trees or Shrubs Single Report</a></li>
                    <li><a href="pdfs/Wildflowers_single_report.pdf" target="_new"> Wildflowers Single Report</a></li>
                    <li><a href="pdfs/Grasses_single_report.pdf" target="_new">Grasses Single Report</a></li>
                    <li> <a href="pdfs/Evergreen_single_report.pdf" target="_new">Evergreen Trees or Shrubs Single Report</a></li>
                    <li> <a href="pdfs/Conifers_single_report.pdf" target="_new">Conifers Single Report</a></li>
                    </ul>
                    
                  <p>You can print this report form and use it to record information about your plant. That way you won't forget anything! </p></td>
              </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/_H1_Icon.gif' width='24' height='24' style='float:left; padding-right:6px;' /></td>
                    <td valign="top">
                  <span id="H2Text"><a href="help_singlereportenvironment.php" > Determine your plant's location.</a></span> Tell us the latitude, longitude, city, state, and zip of your plant. Use the <a href="geocoder.php">Project BudBurst<sup class="sm">SM</sup> Geocoder</a> or a GPS unit to determine latitude and longitude.</td>
                    
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/_H1_Icon.gif' width='24' height='24' style='float:left; padding-right:6px;' /></td>
                    <td valign="top" bgcolor="#C3D9A5">
                  <span id="H2Text" class="BigLink">Make observations using the Single Report Form. </span> Choose the  phenophase category that best describes what your plant is doing.</td>
                </tr>
                <tr>
                    <td width="50" valign="top"><img src='images/_H1_Icon.gif' width='24' height='24' style='float:left; padding-right:6px;' /></td>
                    <td valign="top">
                       <span id="H2Text"><a href="mybudburst.php" >Share your observations.</a></span> This final step is very important. Your Project BudBurst investigation is not complete until you have entered your data to share your plant&rsquo;s story with  others. This final step only takes a few minutes on our web site.
                  </td>
                </tr>
      </table> -->
      
      </div>
      
      
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