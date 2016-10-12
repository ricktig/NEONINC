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
HeaderStart("Project BudBurst Results and Data"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="Data">

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
      
      <h1>Project BudBurst<sup class="sm">SM</sup> Data</h1>
      <p>Project BudBurst data is freely available for anyone to download and use.  The data is provided by thousands of observers from across the country.  If you use data submitted by Project BudBurst observers for analysis, reports, or presentations, we ask that you link to our <a href="results_attribution.php">Community Attribution page</a> to recognize the efforts of our dedicated volunteers. </p>
      
      <div id="data_year">
		<p>The <?php echo $current_year?> campaign is underway! The latest  observations can be viewed in the <strong>live map</strong> shown on the <a href="results.php" class="maincontent">Results</a> page. Also you can view <strong>live maps</strong> of each plant species by visiting our <a href="display_all_plants_list.php" class="maincontent">View All Plants</a> page and selecting a plant from the list.</p>
      </div>
      <div id="data_year">
        <h2>Project BudBurst Data Downloads</h2>
 		
		<?php
		//loop through files in /data folder to build array containing years with existing data files for xls, txt, and csv
		$directory = "data";
		$dir = opendir ($directory);
		
		while($file = readdir($dir))
		{

			preg_match("/PBBdata[0-9]{4}/", $file, $filename);
			if($filename)
			{
				preg_match("/[0-9]{4}/", $file, $year);
				preg_match("/\.[a-z]{3}/", $file, $extension);
				
				$arr[] = array('year' => $year[0], 'ext' => $extension[0], 'file' => $file);
				
				rsort($arr);
			}
		}
		
		$i = 0;		
		foreach($arr as $row)
		{

			if ($i%3==0)
			{
				echo '<div style="width:90px;height:30px;float:left;margin-left:10px">';
				echo '<strong>' . $row['year'] . '</strong>';
				echo '</div>';
			}
			echo '<div style="width:150px;height:30px;float:left">';
			echo '<a href="' . $row['file'] . '">' . $row['ext'] . '</a>';
			echo '</div>';
			
			if ($i%3==2)
			{
				echo '<div style="clear:both" />';
			}
			$i++;
		}
		
	
						
		closedir($dir);
		

		
		?>
		
        <p align="left">Depending on your Operating System and Web Browser, you my need to right-click on the links and &quot;Save As...&quot; to download the file to your computer.<br />
        </p>
      </div>
			<p align="center">&nbsp;</p>
 		  	<p align="center">&nbsp;</p>
 		  	<p align="left">*Requires the free <a href="http://www.adobe.com/products/acrobat/readstep2.html" target="_blank" class="maincontent">Adobe Reader</a>.</p>
             
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