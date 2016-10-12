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
HeaderStart("Project BudBurst - Register your Classroom"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php
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
      
      	<?php 	  
	  	//make sure user is logged in
		if(!checklogin($dbh))
		{
			echo '<p>Sorry you are not logged in, this area is restricted to registered members. ';
			echo '<a href="login.php">Click here</a> to log in.</p>';
			echo $spacer;		
		}
		else
		{
			//show content
	  	?>
			<h1>My BudBurst Classrooms</h1>
            
            <p><strong>MyBudBurst Classrooms: </strong>Which classrooms are monitoring plants?</p>
            <p> Each of your classrooms below monitoring plant(s) will have their own registered My BudBurst site! Please fill out the information below for each of your classrooms. Please note our <a href="policies.php">privacy</a> policy. (* = required fields)
            <br />
            <br />
            <i>Note: You may have more than one plant at each site/classroom if it is <strong>within a half mile</strong> of the other plant(s) at the site/classroom.</i></p>
<!--            
<p><a href="specialprojects.php">Special Project</a> Participation: If your classroom will be a part of one of the <a href="specialprojects.php">Special Projects</a>, please indicate that in the form below. All plants from this site will then be designated as part of the <a href="specialprojects.php">Special Project</a>.</p>-->
            <!--<p>Please note our <a href="policies.php">privacy</a> policy. (* = required fields)</p>-->
            <br />
            <?php
				if($_POST["classrooms"]){
					$noClassrooms = $_POST["classrooms"];
				} else $noClassrooms = 1;
				
			?>
            <form action="register_site_classroom_do.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm_Site('sitename','','R','city','','R','lat','','RisNum','lon','','RisNum');return document.MM_returnValue">
            <?php
            for ($i=0; $i< $noClassrooms; $i++)
			{
				$counter = $i*9; //counter for tab indices
			?>	
			
              <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form">
                <th colspan="2">Classroom #<?php echo $i+1; // note: this is just for usability ?></th>
                <tr>
                  <td width="29%"><div align="right"><strong>*Classroom  Name:</strong><br />(A unique name of your choosing) </div></td>
                  <td><input name="sitename<?php echo $i; ?>" type="text" id="sitename<?php echo $i; ?>" tabindex ="<? echo $counter+1; ?>"/></td>
                </tr>
                <tr>
                  <td colspan="2"><i>Note: Latitude and Longitude should be measured at site center. For <a tabindex ="" href="participate_latlong.html">help</a> with lat/long, see the
                    <a href="#" tabindex ="" onclick="MM_openBrWindow('geocoder.php','Project BudBurst Geocoder','scrollbars=yes,width=525,height=720')">Project BudBurst Geocoder</a>.</td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*Latitude:</strong></div></td>
                  <td><input name="lat<?php echo $i; ?>" type="text" id="lat<?php echo $i; ?>" tabindex ="<?php echo $counter+2; ?>"/> 
                    decimal degrees  (i.e. 39.9847) </td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*Longitude:</strong></div></td>
                  <td><input name="lon<?php echo $i; ?>" type="text" id="lon<?php echo $i; ?>" tabindex ="<?php echo $counter+3; ?>"/> 
                    decimal degrees (i.e.-105.2682) </td>
                </tr>
                <tr>
                  <td><div align="right">Average elevation: </div></td>
                  <td><input name="elevation<?php echo $i; ?>" type="text" id="elevation<?php echo $i; ?>" tabindex ="<?php echo $counter+4; ?>"/>
                    feet</td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*City:</strong></div></td>
                  <td><input name="city<?php echo $i; ?>" type="text" id="city<?php echo $i; ?>" tabindex ="<?php echo $counter+5; ?>"/></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*State:</strong></div></td>
                  <td><select name="state<?php echo $i; ?>" id="state<?php echo $i; ?>" tabindex ="<?php echo $counter+6; ?>">
                    <option value="" selected="selected">select</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                  </select></td>
                </tr>
                <tr>
                  <td><div align="right">Postal Code: </div></td>
                  <td><input name="zip<?php echo $i; ?>" type="text" size="12" maxlength="5" tabindex ="<?php echo $counter+7; ?>" /></td>
                </tr>
                <tr>
                  <td><div align="right">Country:</div></td>
                  <td><select name="country<?php echo $i; ?>" id="country<?php echo $i; ?>" tabindex ="<?php echo $counter+8; ?>">
                    <option value="us">United States</option>
                  </select></td>
                </tr>
                <tr>
                  <td><div align="right">Comments:<br />
                    (i.e., this location is fertilized and watered regularly)</div></td>
                  <td valign="top"><textarea name="comments<?php echo $i; ?>" cols="40" rows="2" id="comments<?php echo $i; ?>" tabindex ="<?php echo $counter+10; ?>"></textarea></td>
                </tr>
              </table>
              <br />
             <?php
			 	$submit_tab = $counter+11;
             }// end for loop of classrooms
			 ?>
            	<input name="classrooms" type="hidden" value="<?php echo  $noClassrooms ?>">
              <p align="center">
                <input type="submit" name="submit" value="Submit" tabindex ="<?php echo $submit_tab; ?>"/>
              </p>
            </form> 
		<?php
        } //else
        ?>
             
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