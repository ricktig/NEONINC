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
<style type="text/css">
h6 {
	color: #666;
}
</style>

<?php
HeaderStart("Participants"); // The first and only parameter is the page title
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
      <h1>Project BudBurst Participants</h1>
	   <p>Project BudBurst data  is provided by thousands of observers from across the country.  Please cite your use of the data and recognize our observers with the following community attribution:</p>
<h3>Citation Format</h3>

 <p>
  <textarea name="citation" cols="85" rows="3" readonly="readonly" id="citation">Project BudBurst. <?php echo $current_year?>. Project BudBurst: An online database of plant phenological observations. Project BudBurst, Boulder, Colorado. Available: http://www.budburst.org; Community Attribution: http://budburst.org/attribution.php; Accessed: <?php echo $cite_today?>.</textarea>
      
      <div id="ParticipantAttribution">
	  
	  <?php 
			//DENNIS'CODE FOR DATA RETRIEVAL
			
				// Connects to your Database 
 				mysql_connect("$host", "$username", "$password") or die(mysql_error()); 
 				mysql_select_db("$database") or die(mysql_error());

				// Collects data from "Observation" table
 				$data = mysql_query("SELECT tbl_people.First_Name, 
											tbl_people.Last_Name, 
											tbl_people.Addr_City, 
											tbl_people.Addr_State, 
											tbl_people.Create_Date, 
											tbl_people.Person_ID
									 FROM tbl_people
									 WHERE Person_ID > '1' AND LOWER(First_Name) NOT LIKE '%test%' 
									 ORDER BY RAND()"
									) 
 				or die(mysql_error()); 
			
				//get number of rows returned
				$num_rows = mysql_num_rows($data);
				$num_rows = number_format($num_rows + 3368);
				Print "<p> We would like to thank the " . $num_rows . " Citizen Scientists who have participated to date: </p>";
								
				// Print out the contents of the entry 
				Print "<H6>";
				while($info = mysql_fetch_array( $data )) {
					//force case in first name
					$lcFirst= strtolower($info['First_Name']);
					$tcFirst = ucwords($lcFirst);
					//get last initial only
					$lcLast= strtoupper($info['Last_Name']);
					$lastWhole = ucwords($lcLast);
					$tcLast = $lcLast[0];
					
					$lcCity= strtolower($info['Addr_City']);
					$tcCity = ucwords($lcCity);
					
					
 					//Print $tcFirst . " " . $tcLast . ", "; 		
 					//conditionals for names
					if (($tcFirst != "")&&($tcLast != ""))
							{
								Print $tcFirst . " ". $tcLast . "., ";
							}
							else if ($tcLast != "")
							{
								Print $lastWhole . ", ";
							}

					
					
					//conditionals for location
					if (($info['Addr_City']!="")&&($info['Addr_State']!=""))
							{
								Print $tcCity . ", ". $info['Addr_State'] . " | ";
							}
							else if ($Addr_State!="")
							{
								Print $info['Addr_State'] . " | ";
							}
				} //END WHILE
				Print "Plus those wonderful people who contributed 3,368 observations anonymously between 2007 & 2010!</H6>";
			
			//END OF DENNIS' CODE
			?> 
</div><!-- End ParticipantAttribution -->









</div><!-- End MainContent -->
	
	<?php
    WriteFooterNavigation();
    ?>
    
  </div> <!-- End contentwrapper -->
</div> <!-- End wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>