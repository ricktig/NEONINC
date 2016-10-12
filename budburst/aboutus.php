<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Dennis Ward as Leah Wasser
# Last modified 1/4/13
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
      <h1>About Project BudBurst</h1>
      <h2>What is Project BudBurst</h2>
       <div class="picture right" style="width:300px;"> <img src="images/59_ACRU_FFL_01_PA.png" width="300" height="225" alt="Strawberry" /> <br />
      Red Maple (Acer rubrum) - Full Flower. Red Maple is a Project BudBurst Top Ten Species! Photo: Paul Alaback</div>
     
      <p>We are a network of people  across the United States who monitor plants as the seasons change. We are a national field campaign designed to  engage the public in the collection of important ecological data based on the timing of leafing, flowering, and  fruiting of plants (<em>plant phenophases</em>). Project BudBurst participants make careful observations of these plant  phenophases. The data are being collected in a consistent manner across the country so that scientists can use the data to learn more about the responsiveness of individual plant species to changes in climate locally, regionally, and nationally. Thousands of people from all 50 states have participated. Project BudBurst began in 2007 in response to requests from people like you who wanted to make a meaningful contribution to understanding changes in our environment. </p>
      </p>
      <h2>What do you do with the Project BudBurst data?</h2> 
      We  make our data freely available to all in several formats on the View Results  page. The data is currently being used  by scientists and educators in the Project BudBurst network. The bigger question is what can YOU do with the data? We would like to know what  data you think would be useful and how you would like to use it. Share your  ideas at <a href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a></p>
      <p>Project BudBurst data is freely available for anyone to download and use.  The data is provided by thousands of observers from across the country.  If you use data submitted by Project BudBurst observers for analysis, reports, or presentations, we ask that you link to our <a href="results_attribution.php">Community Attribution page</a> to recognize the efforts of our dedicated volunteers. </p>
      
      <h2>How do I reference Project BudBurst?</h2>
      Project BudBurst is our official name. Please use "Project BudBurst" in  writings, publications, presentations, and other formal venues. 
      <h2>Who Can Participate?</h2>
      Project BudBurst is open to people of all ages and abilities. To better understand the stories that plants  tell, we need people from all over the United States representing diverse plant communities. Since 2007, participants have included school groups, backyard naturalists, gardeners, seniors in  retirement communities, scout groups, college professors and their students, hikers, professional botanists and ecologists, visitors to botanic gardens,  visitors to Wildlife Refuges and National Parks, and others interested in contributing to a better understanding of plants and climate change.</p>
      <h2>Is there a cost to participate? </h2>
      <div class="picture right" style="width:300px;"> <img src="images/38_POTR5_FLF_01_PA.png" width="300" height="300" alt="Strawberry" /> <br />
      Quaking Aspen (<em>Populus deltoides</em>) - First Leaf. Photo: Paul Alaback</div>
      <p>
      No. Everything you need to participate is on our website and freely downloadable. We will not try to sell you anything or ask you to enroll in costly training classes. In fact, it is our intent to provide you with materials that will make it easy for you to join the Project BudBurst community and share your observations with others.
      </p>
        <h2>Is special training needed to participate?</h2> 
      <p>No. All the information you need to participate can be found on our web site. We will guide you through the  simple steps to participate and the Project BudBurst team will try and answer your questions as they come up.</p>
      
        <h2>May I help spread the word about Project BudBurst?</h2> 
      <p>Absolutely! We have set up the <a href="getstarted_Media.php">Project BudBurst Media Resources</a> page with materials that can be used for media articles, newsletter, and other publications when discussing Project BudBurst.</p>
   
      <h2>Is there a Project BudBurst Mission Statement?</h2>
      <p>There sure is! Any national scale project worth its salt has to have a mission statement. Here is ours: </p>
      <p>&ldquo;Engage people from all walks of life in ecological research  by asking them to share their observations of changes in plants through the  seasons.&rdquo;</p>
      <p>Sometimes it is easier to remember a shorter version. You  might prefer our mission statement in the form of a haiku:</p>
      <center><i><p>People watching plants<br />
        Contributing to research<br />
        Join Project BudBurst</p></i></center>

      <p>Consider this an invitation to be part of the growing  Project BudBurst community. You can lend  your voice to a plant so they can share their stories with others. You can make a difference. Sign up today and get started.</p>
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