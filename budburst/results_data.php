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

<?php
//loop through files in '/data' folder to build array containing years with existing data files
//set directory to '/data'
$directory = "data";

//create a directory object
$dir = opendir ($directory);

//fetch today's current year
$currentyear = date("Y");

//calculate last year
$lastyear = $currentyear-1;

//set found flag to false
$found = 0;

//loop through all files in 'data' folder
while($file = (readdir($dir)))
{

	//look for files with four adjacent numbers representing a year (ie. 2007)
	//and assign to $year array
	preg_match("/[0-9]{4}/", $file, $year);
	
	//if the file year is the same as last year, then you've got a fileset for last year
	//build a table row to display the file extensions and links
	if($year[0] == $lastyear)
	{
		//set found flag to true for use later to display 'data not available' div
		$found=1;
	}
	


}
				
closedir($dir);

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
      
      <h1>Project BudBurst Data</h1>
        <p>The <?php echo $current_year?> campaign is underway! The latest  observations can be viewed in the <strong>live map</strong> shown on the <a href="results.php" class="maincontent">Results</a> page. Also you can view <strong>live maps</strong> of each plant species by visiting our <a href="display_all_plants_list.php" class="maincontent">View All Plants</a> page and selecting a plant from the list.</p>
      <h2>Project BudBurst Data Citation and Community Attribution</h2>
      <p>Project BudBurst data is freely available for anyone to download and use for noncommercial use. The data is provided by thousands of observers from across the country. Please cite your use of the data and recognize our observers with the following citation and <a href="results_attribution.php">community attribution</a>:</p>
            <p>
  <textarea name="citation" cols="85" rows="3" readonly="readonly" id="citation">Project BudBurst. <?php echo $current_year?>. Project BudBurst: An online database of plant phenological observations. Project BudBurst, Boulder, Colorado. Available: http://www.budburst.org; Community Attribution: http://budburst.org/attribution.php; Accessed: <?php echo $cite_today?>.</textarea>
            </p>
      <div id="data_year">
        <h2>Project BudBurst Data Downloads</h2>
		
		<?php
		//display data being reviewed message
		if(!$found)
		{
			echo '<p><b>Special Note</b> &ndash; We\'re still collecting observations for ' . $lastyear . '.  If you have any reports from last year, please enter them by January 31st, ' . $current_year . '. As soon as the ' . $lastyear . ' data has been collected and reviewed by Project BudBurst scientists, they will be added to the list below as available for download.</p>';
		}
		?>
		
		
        <table width="100%" border="0" cellpadding="5">
          <tr>
            <th align="center" valign="top" scope="col">Year</th>
            <th align="center" valign="top" scope="col">Spreadsheet</th>
            <th align="center" valign="top" scope="col">Comma-Separated Values</th>
            <th align="center" valign="top" scope="col">Tab-Delimited Text</th>
            <th align="center" valign="top" scope="col">Other</th>
          </tr>
		  
		  <?php echo $message;?>
		  
          <tr>
            <td align="center" valign="top"><strong>2011</strong></td>
            <td align="center" valign="top"><a href="data/PBBdata2011.xls">.xls</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2011.csv">.csv</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2011.txt">.txt</a></td>
            <td align="center" valign="top"><a href="pdfs/PBB2011Summary.pdf">2007-2011 Summary Report (PDF)</a></td>
          </tr>
          <tr>
            <td align="center" valign="top"><strong>2010</strong></td>
            <td align="center" valign="top"><a href="data/PBBdata2010.xls">.xls</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2010.csv">.csv</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2010.txt">.txt</a></td>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top"><strong>2009</strong></td>
            <td align="center" valign="top"><a href="data/PBBdata2009.xls">.xls</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2009.csv">.csv</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2009.txt">.txt</a></td>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top"><strong>2008</strong></td>
            <td align="center" valign="top"><a href="data/PBBdata2008.xls">.xls</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2008.csv">.csv</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2008.txt">.txt</a></td>
            <td align="center" valign="top"><a href="pdfs/PBB2008Summary.pdf">2008 Summary Report* (PDF)</a></td>
          </tr>
          <tr>
            <td align="center" valign="top"><strong>2007</strong></td>
            <td align="center" valign="top"><a href="data/PBBdata2007.xls">.xls</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2007.csv">.csv</a></td>
            <td align="center" valign="top"><a href="data/PBBdata2007.txt">.txt</a></td>
            <td align="center" valign="top"><a href="pdfs/Report_PB2007.pdf">2007 Analysis Report* (PDF)</a></td>
          </tr>
        </table>
		

		
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