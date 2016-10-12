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
HeaderStart("Project BudBurst Goes Mobile!"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_1.jpg" alt="Project BudBurst" width="762" height="184" border="0" align="absmiddle" title="Project BudBurst" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      <h1>Go Mobile!</h1>
      <table border="0" cols="2">
        <tbody>
          <tr>
            <td valign="top"><h2>The Project BudBurst Mobile Android phone app</h2>
              <p>UCLA's <a href="http://cens.ucla.edu">Center for Embedded Networked Sensing</a> developed a mobile phone app for the Android platform.  The app makes it even easier to report on the plants you observe as they are changing through the seasons from the first flowers on spring trees to autumn's falling leaves. </p>
      
              <p> Visit the <a href="http://market.android.com/details?id=edu.ucla.cens.budburstmobile">Android Market on the Web</a> to view the features of the app. </p>
              <p><strong>Just follow these simple steps to install the app:</strong></p>
              <ol>
                <li>Using the Market app on your Android phone, visit the Market and search for the BudBurst Mobile app using the word &quot;budburst&quot;. </li>
                <li>Select to install the app.  You will be automatically notified of updates as they are made!</li>
                <li>Once the BudBurst Mobile app is installed, start the app and log in using your registered login name and password*</li>
                <li>Read the Help pages and then click &quot;Done&quot; to get to the main page of the app.</li>
              </ol>
              </p>
              <p> Currently, observations made from the Android app do NOT go to the official Project BudBurst website and database, but rather to a separate server (this is only temporary).  Please visit <a href="http://networkednaturalist.org/budburstmobile/">http://networkednaturalist.org/budburstmobile</a> to view your data. </p>
              <p> <strong>Once you have the app installed, it's easy to participate with Project BudBurst Mobile!</strong><br />
                <br />
            <strong>Download the <a href="pdfs/BudBurst_Mobile_Web_Instructions.pdf">PDF set of instructions</a> [3 Mb] for the app to explore its many features!</strong></p></td>
            <td valign="top"><img src="images/G1_small.png" alt="mobile app" hspace="0" vspace="0" /></td>
          </tr>
        </tbody>
      </table>
      <hr />
      <p><strong>To make a <a href="getstarted-single-report.php">Single Report</a> on any plant:</strong></p>
      <ol>
        <li>From either the Main page or the &quot;My BudBurst&quot; page, push Add &quot;Single Report&quot; button.</li>
        <li>Take a photo of your plant!</li>
        <li>Select the Project BudBurst list of plants and pick a plant from the list.</li>
        <li>Select the phenophase that you observe and follow the prompts.</li>
        <li>The last step is to Synchronize your phone with the BudBurst database.  Push the &quot;Synch&quot; icon from the main page or from the Menu on the My BudBurst page</li>
        <li>You are done!</li>
      </ol>
      <p><strong>To establish a <a href="getstarted-regular-report.php">Regular Observation</a> (Report) plant:</strong></p>
      <ol>
        <li>Touch the &quot;My BudBurst&quot; icon on the main screen.</li>
        <li>Select &quot;Add Regular&quot; button at the top.</li>
        <li>Select the Project BudBurst list of plants and pick a plant from the list.</li>
        <li>A pop-up will ask you to add the plant to a new site.</li>
        <li>Add the plant to a New Site.  Don't forget to give the site a name!</li>
        <li>Now you are ready to make observations on your Regular Observation (Report) plant by touching its entry on the list, selecting the phenophase, and following the prompts.</li>
        <li>The last step is to Synchronize your phone with the BudBurst database.  Push the &quot;Synch&quot; icon from the main page or from the Menu on the My BudBurst page</li>
        <li>You are done!</li>
      </ol>
      <p><strong>A few hints:</strong></p>
      <ul>
        <li>Download the <a href="pdfs/BudBurst_Mobile_Web_Instructions.pdf">PDF set of instructions</a> [3 Mb] because pictures are the easiest way to see how to navigate the app!</li>
        <li>You don't have to synchronize if you are in an area of low connectivity or want to save battery life -- just wait until you are connected because the phone will keep all your observations.  (note: observations on &quot;Unknown&quot; plants require synchronization for the database to keep track of these special-case plants)</li>
        <li>Your comments and suggestions will improve the next versions. Send your comments to <a href="mailto:budburstweb@neoninc.org">budburstweb@neoninc.org</a></li>
      </ul>
</div>

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