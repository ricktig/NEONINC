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
      <h2>Past Articles</h2>
<p>Below is a list of articles, radio shows, and podcasts that have highlighted Project BudBurst. Read what people are saying about this premiere citizen science field campaign! If news is missing, please contact the Web Manager at <a href="mailto:budburstweb@neoninc.org" class="maincontent">budburstweb@neoninc.org</a>. </p>

<p>Short selection of the 2012 news coverage:</p>
<ul>
<li>The New York Times - February 29, 2012 - <a href="http://learning.blogs.nytimes.com/2012/02/29/how-does-your-garden-grow-discovering-how-weather-patterns-affect-natural-cycles/">link</a>
<li>Minnesota Public Radio - March 6, 2012 - <a href="http://minnesota.publicradio.org/collections/special/columns/updraft/archive/2012/03/spring_fever_meltmageddon_feat.shtml">link</a>
<li>Chicago Tribune - March 8, 2012 - <a href="http://www.chicagotribune.com/classified/realestate/home/ct-sun-garden-0311-climate-20120308,0,660902.story">link</a>
<li>National Science Foundation - April 19, 2012 - <a href="http://www.nsf.gov/discoveries/disc_summ.jsp?cntn_id=123903">link</a>
<li>The Washington Post - April 22, 2012 - <a href="http://www.washingtonpost.com/conversations/earth-day-six-ways-to-help-scientists-in-your-own-backyard/2012/04/20/gIQAQONRVT_gallery.html">link</a>
<li>Northwest Public Radio - August 8, 2012 - <a href="http://www.nwpr.org/post/citizen-science-gains-momentum-northwest-and-nationally">link</a>
<li>The Statesman Journal - December 9, 2012 </li></ul>
  <p>Short selection of the 2011 news coverage:</p>
  <ul>
  <li> The Charlotte Observer - March 14, 2011
  <li>The San Francisco Chronicle - March 27, 2011 - <a href="http://www.sfgate.com/cgi-bin/article.cgi?f=/c/a/2011/03/25/HOOD1IEMEG.DTL">link</a>
  <li>Huffington Post - April 1, 2011 - <a href="http://www.huffingtonpost.com/brenda-ekwurzel-phd/curious-observers-lend-a-_b_843333.html?view=print http://www.ucsusa.org/global_warming/science_and_impacts/science/citizen-scientists-research.html">link</a>
  <li>Scientific American - May 24, 2011 - <a href="http://www.scientificamerican.com/citizen-science/project.cfm?id=project-budburst">link</a>
  <li>Colorado Public Radio - September 21, 2011 - <a href="http://www.cpr.org/article/Are_your_trees_turning">link</a>
  <li>USA Today - December 5, 2011 - <a href="http://content.usatoday.com/communities/sciencefair/post/2011/12/bees-plants-pollination-climate-change-global-warming/1">link</a></li></ul>
  
  
    <p>Short selection of the 2010 news coverage:</p>
    <ul>
      <li>National Geographic - October 28, 2010 - <a href="http://press.nationalgeographic.com/2010/10/28/national-science-foundation-awards-grant-to-investigate-learning-through-citizen-science/">link</a></li>
      <li>The Daily Green - December 10, 2010 - <a href="http://www.thedailygreen.com/environmental-news/latest/citizen-science-47121401?src=nl&amp;mag=tdg&amp;list=nl_dgr_got_non_120910_citizen-science&amp;kw=ist">link</a></li>
      <li>Ehow.com - November 6, 2010 - <a href="http://www.ehow.com/list_7455003_environmental-activities-youth.html">link</a></li>
      <li>National Wildlife Federation - November 5, 2010 - <a href="http://www.nwf.org/News-and-Magazines/Media-Center/News-by-Topic/Global-Warming/2010/11-04-10-nasa-and-eco-schools-usa-making-climate-change-connections.aspx">link</a></li>
    </ul>
    <p><strong>2009 Media Coverage Report</strong>: UCAR Media Office - February 24, 2010 - <a href="pdfs/2009BudBurstMediaCoverageReport.pdf" target="_blank" class="maincontent">link</a> <img src="images/pdficon_small.gif" alt="pdf" width="17" height="17" /></p>
    <p><strong></strong><strong>2009 Press Releases</strong>: UCAR Press Release - March 18, 2009 - <a href="pdfs/2009PressReleaseUCAR.pdf" target="_blank" class="maincontent">link</a> <img src="images/pdficon_small.gif" alt="pdf" width="17" height="17" /></p>
    <p><strong></strong><strong>Short selection of the 2009 news coverage</strong>:</p>
    <ul>
      <li>The Missoulian - August 10,  2009 </li>
      <li>The Daily Green - July 30,  2009 </li>
      <li>Centre Daily Times - July 6, 2009 </li>
      <li>HerbalEGgram - June 2009 - <a href="http://cms.herbalgram.org/heg/volume6/06%20June/Project_BudBurst.html?t=1243615997" target="_blank" class="maincontent">link</a></li>
      <li>CNN.com, May 4, 2009 - <a href="http://www.cnn.com/2009/TECH/science/05/04/citizen.science.climate.change/index.html?iref=t2test_techmon" target="_blank" class="maincontent">link</a></li>
      <li>Nature.com, April 22, 2009 - <a href="http://www.nature.com/news/2009/090422/full/458959a.html" target="_blank" class="maincontent">link</a></li>
      <li>Mother Nature Network, April 15, 2009 - <a href="http://www.mnn.com/lifestyle/stories/be-a-citizen-scientist-in-2009" target="_blank" class="maincontent">link</a></li>
      <li>Boulder Daily Camera, April 13, 2009</li>
      <li>Earth &amp; Sky Kids, April 8, 2009</li>
      <li>The Denver Post, March 19, 2009 - <a href="http://www.denverpost.com/rockiesmailbag/ci_11954469" target="_blank" class="maincontent">link</a></li>
      <li>Newswise, March 19, 2009 - <a href="http://www.newswise.com/articles/view/550257/" target="_blank" class="maincontent">link</a></li>
    </ul>
    <p><strong>Short selection of the 2008 news coverage.</strong> View the <a href="pdfs/BudBurstMediaResults.pdf" target="_blank" class="maincontent">full 2008 media coverage</a> <img src="images/pdficon_small.gif" alt="pdf" width="17" height="17" /></p>
    <ul>
      <li>USA Today - April 7, 2008 - <a href="http://www.usatoday.com/tech/science/environment/2008-04-07-budburst_N.htm" target="_blank" class="maincontent">link</a> </li>
      <li>Science News, March 22, 2008 - <a href="http://www.sciencenews.org/articles/20080322/safari.asp" target="_blank" class="maincontent">link</a> </li>
      <li>National Public Radio - All Things Considered, March 21, 2008 - <a href="http://www.npr.org/templates/story/story.php?storyId=88772863" target="_blank" class="maincontent">link</a></li>
      <li>Washington Post Online, March 20, 2008 - <a href="http://www.washingtonpost.com/wp-dyn/content/article/2008/03/19/AR2008031903164.html" target="_blank" class="maincontent">link</a></li>
      <li>Chicago Tribune, March 9, 2008  </li>
      <li>Sacramento Bee, March 8, 2008 </li>
      <li>San Francisco Chronicle Online, February 27, 2008 - <a href="http://www.sfgate.com/cgi-bin/article.cgi?f=/c/a/2008/02/27/HOR4V5S2G.DTL" target="_blank" class="maincontent">link</a> </li>
      <li>Human Flower Project, February 26, 2008 - <a href="http://www.humanflowerproject.com/index.php/weblog/project_budburst_late_to_science/" target="_blank" class="maincontent">link</a></li>
      <li>Discovery Channel: Discovery News, February 25, 2008 - <a href="http://dsc.discovery.com/news/2008/02/25/backyard-climate-change.html" target="_blank" class="maincontent">link</a></li>
      <li>Boulder Daily Camera, February 19, 2008</li>
      <li>Capitol Weather Blog, February 16, 2008  - <a href="http://blog.washingtonpost.com/capitalweathergang/2008/02/bucket_o_bookmarks_budburst.html" target="_blank" class="maincontent">link</a></li>
      <li>Scientific American, February 15, 2008 - <a href="http://science-community.sciam.com/blog-entry/Sciam-Observations/Monitor-Climate-Change-Backyard/300009516" target="_blank" class="maincontent">link</a></li>
      <li>National Public Radio - Living on Earth, February 15, 2008 - <a href="http://www.loe.org/shows/segments.htm?programID=08-P13-00007&amp;segmentID=5" target="_blank" class="maincontent">link</a></li>
      <li>UCAR/NCAR Weather &amp; Climate Podcasts, Febraury 14,2008 - <a href="http://www.ucar.edu/podcasts/" target="_blank" class="maincontent">link</a> </li>
      <li>UCAR News Release, February 14, 2008 - <a href="http://www.ucar.edu/news/releases/2008/bud.jsp" target="_blank" class="maincontent">link</a> </li>
      <li>Science Daily, February 8, 2008 - <a href="http://www.sciencedaily.com/releases/2008/02/080208163620.htm" target="_blank" class="maincontent">link</a></li>
    </ul>
    <p><strong>Selection of the 2007 news coverage:</strong></p>
    <ul>
      <li>Earth &amp; Sky Radio Series, April 2, 2007  </li>
      <li>Earth &amp; Sky Clear Voices podcast <br />
      </li>
      <li class="maincontent">University Corporation for Atmospheric Research Staff Notes, March 2007- <a href="http://www.ucar.edu/communications/staffnotes/0703/budburst.shtml" target="_blank" class="maincontent">link</a> </li>
      <li class="maincontent">The Clark Fork Chronicle, March 31, 2007 </li>
      <li class="maincontent">Tucson Citizen, May 4th - <a href="http://www.tucsoncitizen.com/daily/local/50632.php" target="_blank" class="maincontent">link</a> </li>
      <li class="maincontent">Chicago Tribune Magazine, May 6th</li>
      <li class="maincontent">NPR Morning Edition, May 11th - <a href="http://www.npr.org/templates/story/story.php?storyId=10086723" target="_blank" class="maincontent">link</a></li>
      <li class="maincontent">Santa Barbara Daily Sound, May 15th - <a href="pdfs/SantaBarbaraDailySound5_15_2007Vol2Issue38.pdf" target="_blank" class="maincontent">link</a> </li>
    </ul>
    <p>* Requires the free <span class="maincontent"><a href="http://www.adobe.com/products/acrobat/readstep2.html" target="_blank" class="maincontent">Adobe Reader </a></span></p>
              
              
              
              
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