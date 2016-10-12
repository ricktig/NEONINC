<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Dennis Ward (NEON) on 10-19-2011
# Modified by Greg Newman (NewmanDesigns.org) 
# Last modified 10-19-2011
# Copyright 2008-2011 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

$error='';
$display ='';

if (isset($_GET["Phenophase_ID"])) {
	$phenophaseid = $_GET["Phenophase_ID"];
	$phenophaseid = '\'' . $phenophaseid . '\'';
	//echo '<h2>True!: '. $phenophaseid .'</h2>';
} else {
	//echo '<h2>False!</h2>';
    $phenophaseid='\'flower\''; //default to first phenophase
}
?>
<!-- <!DOCTYPE html> -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Results By Phenophase"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script src="maps/PPmapV3.js" type="text/javascript"></script> 

<script type="text/javascript">
function setSelectedIndex(v) {
    for ( var i = 0; i < form1.phenophaseid.options.length; i++ ) {
        if ( form1.phenophaseid.options[i].value == v ) {
            form1.phenophaseid.options[i].selected = true;
            return;
        }
    }
}
</script>

<script type="text/javascript">
function reload(form){
	var val=form1.phenophaseid.options[form.phenophaseid.options.selectedIndex].value;
	self.location='results_byphenophase.php?Phenophase_ID=' + val;
}
</script>


<?php
//
HeaderEnd();
?>

<body id="Data" onload="phenoMap(<?php echo $phenophaseid; ?>); setSelectedIndex(<?php echo $phenophaseid; ?>)" >

<div id="wrapper">

 <div id="contentwrapper">
  	
    <!-- <div><a href="index.php"><img src="images/Banner_5.jpg" width="762" height="180" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">

      <h1><?php echo $current_year; ?> Results for all <span id="nowShowing"></span>&nbsp;Phenophases</h1>

<script type="text/javascript">
var $temp1 = <?php echo $phenophaseid; ?>;
switch ($temp1){
	case 'leaf': $myText ="Leafing"; break;
	case 'needle': $myText ="Needle"; break;
	case 'stalk': $myText ="Stalk"; break;
	case 'flower': $myText ="Flowering"; break;
	case 'pollen': $myText ="Pollen"; break;
	case 'fruit': $myText ="Fruiting"; break;
	case 'color': $myText ="Color";	 break;
	default: $myText = "Flowering";
}
document.getElementById("nowShowing").innerHTML= $myText;
</script>
      


	<form id="form1" name="form1" method="post" action="" style="margin: 10px 0 10px 0">
	<span class="title"> Other phenophases available for viewing: </span>     
    <select name="phenophaseid" class="select" id="phenophaseid" tabindex="1" onchange="reload(this.form)">
         	<option>Select...</option>
         	<option value="leaf">All Leafing Events</option>
            <option value="needle">All Needle Events</option>
            <option value="stalk">All Stalk Events</option>
            <option value="flower">All Flowering Events</option>
            <option value="pollen">All Pollen Events</option>
            <option value="fruit">All Fruiting Events</option>
            <option value="color">All Color Events</option>
    </select>
	</form>
	<p align="left">Below you can view  observations reported in <?php echo $current_year; ?>! Use the navigation buttons on the left to zoom in/out and pan around. Click  on each place marker to get detail information about that observation. If the map below is empty then there have not been any <?php echo $current_year; ?> observations reported for the selected phenophase.</p>
		
	<!-- map -->
	<div id="PBBmap" style="width: 512px; height: 498px; margin: 0 auto; border:1px solid grey"></div>
	<!-- map -->
	<br />
    
	<div id="PBBmapLegend_horizontal"></div>
	
	<p>&nbsp;</p>
	<?php
	echo $error;
	//} //else 
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