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
HeaderStart("BudBurst Help - Phenophases"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body>

<div id="wrapper">

 <div id="contentwrapper">
  	
    <div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Phenophases</h1>
      
      <?php
    	//echo("<div id='Phenophases'>");
      	//echo("<div id='Phenophases_Header'>Phenophases</div>");
        //echo("<div id='SectionContainer'>");
			
			$result_phenophases=get_phenophases_protocol($dbh,1); //$p_protocol=1 all phenophases
			
			while($row_phenophases=$result_phenophases->fetch_object() )
			{
				$PhenophaseID=$row_phenophases->Phenophase_ID;
				$PhenophaseName=$row_phenophases->Phenophase_Name;
				$PhenophaseComment=$row_phenophases->Comment;
				
				//prepare variables needed:
				$PhenophaseAnchor=str_replace(" ", "_",$PhenophaseName);
				
				//display
				
				echo("<h2>".$PhenophaseName." </h2>");
				
				echo("<img src='images/Phenophase_Icons/$PhenophaseID.png' width='40' height='40' style='float:left; padding-right:6px;' />");
				
				echo("<div style='margin-left:2px;'>$PhenophaseComment<br /><br /></div>");
				
				//echo '<a name="'.$phenophaseAnchor.'_'.$plantGroupIDArr[$i].'" 
				//id ="'.$phenophaseAnchor.'_'.$plantGroupIDArr[$i] .' "></a><strong>' . $phenophaseName . '</strong> : ' . $phenophaseComment . ' <br><br>';
				
			}//while
			
			echo("<br />");
			
       // echo("</div>");
    //echo("</div>");
    ?>
    
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