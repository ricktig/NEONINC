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
HeaderStart("About Project BudBurst"); // The first and only parameter is the page title
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
       <h2>Most Recent Articles</h2>
<p>Below is a list of articles, radio shows, and podcasts that have highlighted Project BudBurst. Read what people are saying about this premiere citizen science field campaign! If news is missing, please contact the Web Manager at <a href="mailto:budburstweb@neoninc.org" class="maincontent">budburstweb@neoninc.org</a>. </p>

<p>Short selection of the </p>
<p>Short selection of the 2012 news coverage:</p>
<ul>
<li>The New York Times - February 29, 2012 - <a href="http://learning.blogs.nytimes.com/2012/02/29/how-does-your-garden-grow-discovering-how-weather-patterns-affect-natural-cycles/">link</a>
<li>Minnesota Public Radio - March 6, 2012 - <a href="http://minnesota.publicradio.org/collections/special/columns/updraft/archive/2012/03/spring_fever_meltmageddon_feat.shtml">link</a>
<li>Chicago Tribune - March 8, 2012 - <a href="http://www.chicagotribune.com/classified/realestate/home/ct-sun-garden-0311-climate-20120308,0,660902.story">link</a>
<li>National Science Foundation - April 19, 2012 - <a href="http://www.nsf.gov/discoveries/disc_summ.jsp?cntn_id=123903">link</a>
<li>The Washington Post - April 22, 2012 - <a href="http://www.washingtonpost.com/conversations/earth-day-six-ways-to-help-scientists-in-your-own-backyard/2012/04/20/gIQAQONRVT_gallery.html">link</a>
      

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