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
      <div id="RightColumnSpecialSection">
         <h2>Example phenophases</h2>
      <p><img src="images/phenophase_sequence.jpg" alt="phenophase sequence image" width="240" height="270" border="1" />
     <p> Example phenophases from a Red Maple: <strong>Flowers middle</strong> (top,<em> Paul Alaback</em>), <strong>Leaves early</strong> (middle, <em>Paul Alaback</em>) and <strong>Fruits middle</strong> (bottom, <em>Steve Baskauf</em>) </p>
      <ul class="sublinks">
        
      </ul>
      </div>
      <div id="LeftColumnSpecialSection">
      
      <h1>Get Started - Make Single Reports</h1>
      <!-- <img src="images/RegularObs_collage.jpg" alt="Photos of people observing plants" width="254" height="264" align="right" />  
        -->
      <p>For Single Reports, the datasheet asks you to choose the most appropriate phenophase and determine if your plant is in the  &quot;early,&quot; &quot;middle,&quot; or &quot;late&quot; stages of that phase. For example, if your plant is just starting the Leaves Unfolding phenophase, you might select the &quot;Early&quot; stage. But if most or all of the leaves are unfolded, you might choose the &quot;Late&quot; stage.</p>
      <p>We have lots of resources to help you along the way. If you have any questions, please contact the Project BudBurst team at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
      
      </div>

      <br style="clear:both; display:block;" />

      
     
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