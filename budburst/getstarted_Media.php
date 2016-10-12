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
      <h1> Project BudBurst Media Resources</h1>
      The resources on this page can be used for media articles, newsletters, and other publications when discussing Project BudBurst.
      <h2>What is Project BudBurst</h2>
      <p>Project BudBurst is a network of people across the United States who monitor plants as the seasons change. We are a national field campaign designed to engage the public in the collection of ecological data based on the timing of leafing, flowering, and fruiting of plants (plant phenophases). Project BudBurst participants make careful observations of these plant phenophases. The data are collected in a consistent manner across the country so that scientists can use the data to learn more about the responsiveness of individual plant species to changes in climate locally, regionally, and nationally. Thousands of people from all 50 states have participated. Project BudBurst began in 2007 in response to requests from people like you who wanted to make a meaningful contribution to understanding changes in our environment.</p>
     <h2> Photos and Logos</h2>
     <p>Explore our <a href="getstarted_Media_photoslogos.php">Photos and Logos page</a> to find images to accompany your news story.</p>
         
     <h2> Promotional Materials</h2>
     <p> Help spread the word about Project BudBurst by downloading our Overview Flyer and Postcard and sharing them with your community!</p>
     <p><a href="pdfs/BudBurst-eflyer.pdf">Overview Flyer</a></p>
     <p><a href="pdfs/PBBpostcard_Web.pdf">Postcard</a></p>
     <h2>  Project BudBurst Data Citation and Community Attribution</h2>
       
     <p>Project BudBurst data is freely available for anyone to download and use for noncommercial use. The data is provided by thousands of observers from across the country.  Please cite your use of the data and recognize our observers with the following citation and community attribution:</p>
<h3>Citation Format</h3>

 <p>
  <textarea name="citation" cols="85" rows="3" readonly="readonly" id="citation">Project BudBurst. <?php echo $current_year?>. Project BudBurst: An online database of plant phenological observations. Project BudBurst, Boulder, Colorado. Available: http://www.budburst.org; Community Attribution: http://budburst.org/attribution.php; Accessed: <?php echo $cite_today?>.</textarea>
            </p>

<h2>Project BudBurst Visualizations</h2>
  <p>Project BudBurst maps, tables and other visualizations may be reproduced in publications without further permission provided that the figure is attributed as follows:</p>
  <p>Image provided by Project BudBurst (www.budburst.org) and created [date]. </p>
<h2>Project BudBurst in the News</h2>
<h3> Most Recent Articles</h3>
<p>Below is a list of articles, radio shows, and podcasts that have highlighted Project BudBurst. Read what people are saying about this premiere citizen science field campaign! If news is missing, please contact the Web Manager at <a href="mailto:budburstweb@neoninc.org" class="maincontent">budburstweb@neoninc.org</a>. </p>
<p>Short selection of the 2013 news coverage:</p>
<ul> 
<li> Marketplace Tech - January 7, 2013 - <a href="http://www.marketplace.org/topics/tech/apps-transform-cellphone-users-citizen-scientists">link</a>
</ul>
<p>Short selection of the 2012 news coverage:</p>
<ul>
<li>The New York Times - February 29, 2012 - <a href="http://learning.blogs.nytimes.com/2012/02/29/how-does-your-garden-grow-discovering-how-weather-patterns-affect-natural-cycles/">link</a>
<li>Minnesota Public Radio - March 6, 2012 - <a href="http://minnesota.publicradio.org/collections/special/columns/updraft/archive/2012/03/spring_fever_meltmageddon_feat.shtml">link</a>
<li>Chicago Tribune - March 8, 2012 - <a href="http://www.chicagotribune.com/classified/realestate/home/ct-sun-garden-0311-climate-20120308,0,660902.story">link</a>
<li>National Science Foundation - April 19, 2012 - <a href="http://www.nsf.gov/discoveries/disc_summ.jsp?cntn_id=123903">link</a>
<li>The Washington Post - April 22, 2012 - <a href="http://www.washingtonpost.com/conversations/earth-day-six-ways-to-help-scientists-in-your-own-backyard/2012/04/20/gIQAQONRVT_gallery.html">link</a></li> </ul>
 <h3> Past  Articles    </h3>
 <p>Explore some of our past news coverage <a href="getstarted_Media_pastarticles.php">here</a>.</p>
 <h2> Contact Info </h2>
     <p> For programmatic information, contact:<br/>
     <br/>
     Sarah Newman<br/>
Citizen Science Coordinator<br/>
snewman at neoninc.org </p>
<p> For media information, contact:<br/>
<br/>
Jennifer Walton<br/>
Public Affairs Manager<br/>
jwalton at neoninc.org</p>
</div>
    <!-- End MainContent -->
	
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