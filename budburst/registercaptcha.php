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

//reCAPTCHA code
require_once 'cgi-bin/recaptchalib.php';
//$publickey = "6LdWv7kSAAAAAEgSxIePmZdl-zGwwfS7sWEGjN_M"; // we got this from the signup page on 4/26/2010
$publickey = "6LeMgMUSAAAAADYE2TkIfiNx7MF0kfWTu_P8G-3S"; // updated from reCAPTCHA on 6/22/2011
//reCAPTCHA code

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Registration"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script type="text/javascript">
<!--
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
//-->
</script>

<script type="text/javascript">
var RecaptchaOptions = {
   //theme : 'clean',
   //theme : 'custom',
   tabindex : 15
};
</script>

<style type="text/css">
 .recaptchatable .recaptcha_image_cell, #recaptcha_table {
   background-color:#FF0000 //reCaptcha widget background color
 }
 
 #recaptcha_table {
   border-color: #FF0000 //reCaptcha widget border color
 }
 
 #recaptcha_response_field {
   border-color: #FF0000  //Text input field border color
   background-color:#FF0000 //Text input field background color
 }
</style>

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
			 if(checklogin($dbh)) {
				echo '<p>Sorry you are already logged in.</p>';
				echo '<p>If you would like to register a new member, please first <a class="maincontent" href="logout.php">log out</a>.</p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>';
			}
			
			else{ //show form
			?>
			  
			  <h1>Welcome to the Project BudBurst<sup class="sm">SM</sup> Community!</h1>
              
              <p>By registering with us,  you can save your observation location(s) and  plant(s) that you are monitoring throughout the year and for coming years. This also allows you to report the phenophical changes as they occur each week!</p>
            <p> If you are under the age of 13, you must have your parent, guardian or teacher register for you.Please note our <a href="policies.php" class="maincontent">privacy policy</a>.</p>
            
            <center><div style="text-align:left; width:80%;">(* = required fields)</div></center>
            <!--(* = required fields)-->
            
            <FORM ACTION="registercaptcha_do.php" METHOD="POST" name="form1" id="form1" onsubmit="MM_validateForm('firstname','','R','lastname','','R','city','','R','email','','RisEmail','login','','R','password1','','R','password2','','R');return document.MM_returnValue">
             <INPUT TYPE=HIDDEN NAME="authtype" value="local">
<center>
<table width="80%" border="0" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form">
                <th colspan="2">Project BudBurst<sup class="sm">SM</sup> Registration</th>
                <tr>
                  <td colspan="2"><div align="left"><strong>*I am at least 13 years of age: </strong>
                      <input name="age13" type="checkbox" id="age13" value="checkbox" tabindex="1"/>
                  </div></td>
            </tr>
                <tr>
                  <td width="31%" valign="top"><div align="right"><strong>*First Name:</strong></div></td>
                  <td valign="top"><input name="firstname" type="text" id="firstname" tabindex="2" size="40"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Middle Name:</div></td>
                  <td valign="top"><input type="text" name="middlename" size="40" tabindex="3"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Last Name:</strong></div></td>
                  <td valign="top"><input name="lastname" type="text" id="lastname" tabindex="4" size="40"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Suffix:</div></td>
                  <td valign="top"><input type="text" name="suffix" size="6" tabindex="5"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Address1:</div></td>
                  <td valign="top"><input type="text" name="address1" size="40" tabindex="6"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Address2:</div></td>
                  <td valign="top"><input type="text" name="address2" size="40" tabindex="7"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*City:</strong></div></td>
                  <td valign="top"><input name="city" type="text" id="city" tabindex="8" size="40"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*State:</strong></div></td>
                  <td valign="top">
                  	<select name="state" id="state" tabindex ="9">
                      <option value="" selected="">select</option>
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
                      <option value="HI">Hawaii</option>
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
                  <td valign="top"><div align="right">Postal Code:</div></td>
                  <td valign="top"><input name="zip" type="text" size="12" maxlength="5" tabindex ="10" /></td>
                </tr>
                <!-- <tr>
                  <td valign="top"><div align="right">Country:</div></td>
                  <td valign="top"><select name="country" id="country" tabindex ="12">
                    <option value="us">United States</option>
                  </select></td>
                </tr>-->
                <tr>
                  <td valign="top"><div align="right">Comments:</div></td>
                  <td valign="top"><textarea name="comments" cols="40" rows="2" id="comments" tabindex ="11"></textarea></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Email</strong>:</div></td>
                  <td valign="top"><input name="email" type="text" id="email" size="40" tabindex ="13"/></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><strong>I am a K-12 Teacher:</strong></td>
                  <td valign="top"><input name="k12teacher" type="checkbox" id="k12teacher" value="1" tabindex="14"/></td>
            </tr>
                <tr>
					<td valign="top">
						<div align="right">
							<strong>*Type the words <br />that you see:</strong>
						</div></td>
									<? //echo recaptcha_get_html($publickey); ?>
					<td>
						<form id="captchadiv" action="registercaptcha_do.php" method="post" style="border:1px solid black;height:130px;width:215px">
							<img id="captcha" src="securimage_show.php" alt="CAPTCHA Image" style="float:left; border: 1px solid grey"/>
							
							<div style="float:left; width:100px;height:50px; margin: 10px 0 0 10px; text-align:center">
							
								<!--display audio icon-->
								<object type="application/x-shockwave-flash" data="securimage/securimage_play.swf?bgcol=#C3D9A5&amp;audio_file=securimage/securimage_play.php&amp;icon_file=securimage/images/audio_icon.png" width="32" height="32">
								<param name="movie" value="securimage/securimage_play.swf?audio_file=securimage/securimage_play.php" />
								</object>

								<!--display refresh button-->
								<a onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false" title="Refresh Image" href="#" style="border-style: none;" tabindex="-1">
									<img width="32" height="32" border="0" align="bottom" onclick="this.blur()" alt="Reload Image" src="securimage/images/refresh.png">
								</a>

								<input type="text" name="captcha_code" size="10" maxlength="6" />
							</div>
						</form>
					</td>
                </tr>
                <tr>
                  <td colspan="2"><hr /></td>
                </tr>
                <tr>
                  <td colspan="2">Your member information will be a login and password of your choosing.</td>
            </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Login: </strong></div></td>
                  <td valign="top">
                  	<strong>
                    <input name="login" value="" type="text" id="login" size="40" tabindex="19" />
                  	</strong>
                  </td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Password: </strong></div></td>
                  <td valign="top"><strong>
                    <input name="password1" type="password" id="password1" size="40" tabindex ="20"/>
                  </strong></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Retype Password: </strong></div></td>
                  <td valign="top"><strong>
                    <input name="password2" type="password" id="password2" size="40" tabindex ="21"/>
                  </strong></td>
                </tr>
              </table>
		</center>
        
              <p align="center">
                <input type="submit" name="submit" value="Submit" tabindex ="22"/><input type="reset" value="Clear Form" tabindex ="23">
            </form>  
		    <?php
			  } //else
			  ?>          
            <p>&nbsp; </p>
      
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