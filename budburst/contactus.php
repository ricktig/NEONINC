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
HeaderStart("Contact Project BudBurst"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!-- <div><a href="index.php"><img src="images/Banner_2.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
        WriteTopLogin($dbh);
    ?>
    
    <!-- Top Navigation -->
	
	<?php	
		WriteTopNavigation();
	?>
    
    <div id="MainContent">
      <h1>Contact Project BudBurst</h1>
      <h2>We want to hear from you!</h2>
      <p>To request more information about Project BudBurst or to share your suggestions or comments with us, please contact us at: <a class="maincontent" href="mailto:budburstinfo@neoninc.org">budburstinfo@neoninc.org</a>.</p>
      <h2>Sponsors</h2>
      	<p>For information about our sponsors,  please visit our <a href="sponsors.php" class="maincontent">Sponsors</a> page.</p>
    <h2>Mailing List</h2>
 		<p><a href="http://visitor.r20.constantcontact.com/manage/optin/ea?v=001c5Zc9ukCtXZWbXgxoxbbzBKCzT_zyMzw8_2aKX7VksGjQz4pM6Y1fugs80-2zVckjlp6FS-37FN-BBL4lZJpKQZFygaRJGgT" target="NewWindow">Subscribe</a> to our mailing list to receive updates, announcements and results of this campaign!</p>

        <h2> Media Resources</h2> 
      <p>We have set up the <a href="getstarted_Media.php">Project BudBurst Media Resources</a> page with materials that can be used for media articles, newsletter, and other publications when discussing Project BudBurst.</p>

  <h2>Website</h2>
 		<p>For comments about our Website, please contact the Website manager at <a class="maincontent" href="mailto:budburstweb@neoninc.org">budburstweb@neoninc.org</a>. </p>
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