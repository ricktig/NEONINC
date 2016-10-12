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

//Thanks to OldSite on http://www.free2code.net for the basic framework of this code

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Login"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script type="text/javascript">
	// document load - set focus on login name input
	$(function()
	{
		//function to display map help text pop up window
		$(":input[name=uname]").focus();
		
	});
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm_Site.arguments;
	  
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }

	}
	
	if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}


</script>
<?php
//
HeaderEnd();
?>

<body id="MyBudBurst">

<div id="wrapper">

  <div id="contentwrapper">
  	
    <!--<div><a href="index.php"><img src="images/Banner_1.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
	<?php
		WriteTopLogin($dbh);
	?>
        
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">  
      <?php // Check if user is logged in
		//if(checklogin($dbh))
		//{
			//$maincontent.=$already_logged_in_msg;
			/*echo "<p>You are already logged in.  
			Please continue your <a class=\"maincontent\" href=\"mybudburst.php\">MyBudBurst Space</a>!</p>";*/
			//$maincontent.=$spacer;
		//} //not logged in
		//else {
		?>
					<h1>Project BudBurst Login</h1>
                    Be a part of this national citizen science field campaign.
                    Do your part to monitor climate change by observing and reporting phenological changes in your area!
					Internet browser cookies must be enabled to login.<br><br>
					<form action="login_do.php" method="post" name="login" id="login" onsubmit="MM_validateForm_General('login','','R','passwd','','R');return document.MM_returnValue">
					  
					  <table class="form" width="200" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5"><!--  #E38896 #EDB6BF -->
						<th colspan="2"><div style="height:26px; margin-bottom:4px;">Already a Project BudBurst Member?</div></th><!-- bgcolor="#7EAF20" -->
						<tr>
						  <td valign="top"><div align="right"><strong>Login: </strong></div></td>
						  <td valign="top">
							<input name="uname" type="text" id="login" size="40" tabindex="1"/>
						    <br />
					      <a href="login_reminder.php" class="maincontent"tabindex="4" >Help</a>, I've forgotten my login! </td>
						</tr>
						<tr>
						  <td valign="top"><div align="right"><strong>Password: </strong></div></td>
						  <td valign="top">
							<input name="passwd" type="password" id="passwd" size="40" tabindex="2"/>
							<a href="password_reminder.php" class="maincontent" tabindex="5"><br />
						  Help</a>, I've forgotten my password! </td>
						</tr>
						
						<tr>
						  <td>&nbsp;</td>
						  <td><input type="submit" name="submit" value="Login" tabindex="3"/></td>
						</tr>
					  </table>
		    </form>	  
					<br>   
					<h1>New Member? Register Now!</h1>
                    <a href="register.php" style="color:#fff">
                   <div class="buttons" style="width:150px; height:50px; float:left; font-size:1.3em; border-radius:5px; color:#fff; margin:0 10px 0 0; padding:5px;"><img src="images/icons/reportStepsIcons/Register_White.png" alt="Register Now" width="40" height="40" hspace="5" vspace="3" align="left" />Register <br />
                   now! </div></a>
      <a href="register.php">Register now</a> and become part of the Project BudBurst community! By registering with us,  you can save your observation site(s) and  plant(s) that you are monitoring throughout the year and for coming years. This also allows you to report the phenological changes as they occur every day!
</p>
                    <p>Please note our <a href="policies.php" class="maincontent">privacy policy</a>. If you are under the age of 13, you must have your parent, guardian or teacher register for you. 
					</td>

					
	<?php
    //} //else not logged in
    //echo $maincontent;
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