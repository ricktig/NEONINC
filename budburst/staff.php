<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Last modified 1/9/11
# Copyright 2008-2010 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Staff"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

  <div id="contentwrapper">
  
    <!-- <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      <h1>Project BudBurst Staff</h1>
      <h2>Who we are</h2>
      
      <p>Project BudBurst is managed by the following individuals and organizations. Project BudBurst is further funded by generous contributions from our <a href="sponsors.php" class="maincontent">sponsors</a>.<br />
      </p>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
            	<tr>
					<td width="12%"><img src="images/sh.jpg" alt="sh" width="150" height="150" /></td>
                  	<td width="88%" valign="top">
                    	<strong><a name="sandra" id="sandra"></a>Dr. Sandra Henderson, <em>Director</em></strong>, is a senior science education specialist with the <a href="http://www.neoninc.org/" target="NewWindow">National Ecological Observatory Network</a> (NEON) in Boulder, Colorado. She oversees program collaboration, management, and resource development. Her background is in climate change science education with an emphasis on teacher professional development and citizen science outreach programs. Before becoming a science educator, she worked as a project scientist studying the effects of climate change on terrestrial ecosystems.					</td>
       		  </tr>
                <tr>
                  <td><div align="center"><img src="images/KH.jpg" alt="Dr. Kayri Havens" width="145" height="145" /></div></td>
                  <td valign="top"><strong><a name="kay" id="kay"></a>Dr. Kayri Havens, <em>Co-Director</em></strong>,  is Medard and Elizabeth Welch Director at the <a href="http://www.chicagobotanic.org/" target="NewWindow">Chicago Botanic Garden</a>. Her research interests include reproductive ecology and conservation genetics of plant species. Her research focuses on invasive plant species and has worked with a team that developed the Chicago Botanic Garden's Invasive Plant Policy. Kay has worked with students from Northwestern University, Loyola University, and the University of Illinois Chicago. She leads work on conservation and restoration projects at University of Illinois Chicago in partnership with Chicago Botanic Garden.				  </td>
      			</tr>
				<tr>
                	<td><img src="images/PA.jpg" alt="Dr. Paul Alaback" width="150" height="150" /></td>
                  	<td valign="top"><strong><a name="paul" id="paul"></a>Dr. Paul Alaback, </strong><em><strong>Lead Science Advisor</strong></em>, is Professor Emeritus of Forest Ecology at the  <a href="http://www.cfc.umt.edu/" target="_blank" class="maincontent">University of Montana</a>, <a href="http://www.cfc.umt.edu/" target="NewWindow">College of Forestry and Conservation</a>, and principal of  Melipal Consulting, LLC. His research centers on understanding patterns of  plant biodiversity of forest and grassland landscapes, and how they are  affected by disturbances and climatic variation.&nbsp; He has been conducting field studies on plant  phenology for over 20 years.                  </td>
       		  </tr>
              <tr>
                	<td><img src="images/SN.jpg" alt="Ms. Sarah Newman" width="150" height="150" /></td>
                  	<td valign="top"><strong><a name="paul" id="paul"></a>Ms. Sarah Newman</strong>, is a <em><strong>Citizen Science Coordinator</strong></em> at the <a href="http://www.neoninc.org/" target="NewWindow">National Ecological Observatory Network</a> (NEON). She develops content for Project BudBurst and consults on other citizen science projects. Most recently she was a Citizen Science Director at <a href="http://www.beavercreekreserve.org/" target="NewWindow">Beaver Creek Reserve</a> in Wisconsin where she worked with dozens of citizen science programs from the local to state level. Past positions have also included stints as an herbarium curator and as a technician for the US Fish and Wildlife Service National Wildlife Refuge program.                  </td>
       		  </tr>
              <tr>
                <td><img src="images/DW.jpg" alt="Dennis Ward" title="Dennis Ward" width="150" height="150" /></td>
                <td valign="top"><strong><a name="dennis" id="dennis2"></a>Mr. Dennis Ward</strong><em> </em>is the <em><strong>Educational Technologist</strong></em> at the <a href="http://www.neoninc.org/" target="NewWindow">National Ecological Observatory Network</a> (NEON) in Boulder, Colorado.&nbsp; He coordinates the technical aspects of  Project BudBurst, including data collection and analysis tools.&nbsp; Dennis has more than twenty years experience  in distance learning and online citizen science programs, focusing primarily on  teacher professional development.<br /></td>
              </tr>
              <tr>
                  	<td><img src="images/LAWProfile.jpg" alt="LAW" width="149" height="111" /></td>
                  	<td valign="top"><strong><a name="jennifer" id="jennifer"></a>Dr. Leah A. Wasser</strong><em>, <strong>National Geographic FieldScope Coordinator</strong></em> is a <em><strong>Senior Science Educator, Universities</strong></em> with the <a href="http://www.neoninc.org/" target="NewWindow">National Ecological Observatory Network</a> (NEON) in Boulder, Colorado. As the National Geographic Coordinator, Leah assists with the development of online data visualization and analysis tools. Leah has a Ph.D. in remote sensing ecology from Penn State  and over 10 years of University Level teaching experience.<br />
                    </td>
                                 </tr>
<tr>
                  	<td><img src="images/liz.jpg" alt="LAW" width="150" height="150" /></td>
                  	<td valign="top"><strong><a name="jennifer" id="jennifer"></a>Ms. Liz Goehring</strong><em>,</em> is a <em><strong>Senior Science Educator, Programs</strong></em> with the <a href="http://www.neoninc.org/" target="NewWindow">National Ecological Observatory Network</a>  (NEON) in Boulder, Colorado. She helps develop materials for K-12 educators for Project BudBurst in classroom settings. Liz has over sixteen years experience developing K-12 science education programs and teaching at the middle and high school level.  She has a Masters in ecology from the University of Minnesota where she studied environmental factors triggering reproductive diapause in monarch butterflies.<br />
                    </td>
          		</tr>
                <tr>
                  <td><img src="images/JSB.jpg" alt="jsb" width="150" height="150" /></td>
                  <td valign="top"><strong><a name="jennifer" id="jennifer2"></a>Dr. Jennifer Schwarz Ballard</strong><em>, <strong>Lead Science Educator</strong></em>, is Director of the Center for Teaching and Learning at the <a href="http://www.chicagobotanic.org/" target="_blank" class="maincontent">Chicago Botanic Garden</a>. As such, she supervises youth and teacher programs and  citizen science initiatives at the Garden.&nbsp;  Jennifer brings expertise in both formal and informal science  education.&nbsp; Her areas of expertise  include diversity studies, program design, and evaluation. Before joining the  Garden she completed her graduate studies in Learning Sciences at Northwestern  University.<br /></td>
                </tr>
                <tr>
                  	<td><img src="images/kkm.jpg" alt="kkm" width="150" height="150" /></td>
                  	<td valign="top"><strong><a name="kirsten" id="kirsten"></a>Ms. Kirsten K. Meymaris<em>, Lead Web Technologist with KKM Consulting, </em></strong>in Boulder, Colorado. She designed the original  Project BudBurst web site and database. She continues to work with Project  BudBurst in the areas of online education and tutorials.&nbsp; Kirsten has over twelve years of experience  in educational technology and online citizen science programs.&nbsp; She also teaches online college courses in  mathematics.                    </td>
       		  </tr>
              </table>
          <br />
    </div><!-- End MainContent -->

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