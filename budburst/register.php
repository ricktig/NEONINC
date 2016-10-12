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
$publickey = "6LdYtNsSAAAAAAspaGyAJ6ESZsaOvZ0-bSN2dztb"; // updated from reCAPTCHA on 1/17/2013
//reCAPTCHA code

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Registration"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script type="text/javascript">

function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+= '- '+nm+' must contain an e-mail address<br/>';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+= '- '+nm+' must contain a number<br/>';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+= '- '+nm+' must contain a number between '+min+' and '+max+'.<br/>';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required<br/>'; }
    } 
	
	if ((errors.length>0))
	{
			$("#popupregistrationerror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');	
			$("#popupregistrationerror").append('We noticed the following errors:<br />');
			$("#popupregistrationerror").append(errors);
			$("#popupregistrationerror").append('Please enter all of the required fields (*).<br />');	
			$("#popupregistrationerror").css('display', 'block');//alert('The following error(s) occurred:\n'+errors);
	}
	    document.MM_returnValue = (errors == '');
} }

</script>

<script type="text/javascript">
var RecaptchaOptions = {
   //theme : 'clean',
   //theme : 'custom',
   tabindex : 9
};
</script>

<script type="text/javascript">
	// document load - assign JavaScript variables from URL PHP variables
	$(function()
	{
		//load site info - if provided from PHP POST when returning to this page from register_do.php page
		
		//check age13 checkbox if returned from register_do.php with value of 'age13'
		<?php if ($_POST['age13']=='age13')
		{
			echo "$('#age13').attr('checked', true);";
		}
		?>

		//$('#age13').val('<?php echo $_POST["age13"];?>');
		$('#firstname').val('<?php echo $_POST["firstname"];?>');
		$('#middlename').val('<?php echo $_POST["middlename"];?>');
		$('#lastname').val('<?php echo $_POST["lastname"];?>');
		$('#suffix').val('<?php echo $_POST["suffix"];?>');
		$('#address1').val('<?php echo $_POST["address1"];?>');
		$('#address2').val('<?php echo $_POST["address2"];?>');
		$('#city').val('<?php echo $_POST["city"];?>');
		$('#state').val('<?php echo $_POST["state"];?>');
		$('#zip').val('<?php echo $_POST["zip"];?>');
		$('#comments').val('<?php echo $_POST["comments"];?>');
		$('#email').val('<?php echo $_POST["email"];?>');
		$('#k12teacher').val('<?php echo $_POST["k12teacher"];?>');
	});//end jQuery DOM load function
	
	//close map help text popup div
	function closeWindow()
	{
		$("#popupregistrationerror").empty();
		$("#popupregistrationerror").css('display', 'none');

	}
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
      
	  <?php
			 if(checklogin($dbh)) {
				echo '<p>Sorry you are already logged in.</p>';
				echo '<p>If you would like to register a new member, please first <a class="maincontent" href="logout_do.php">log out</a>.</p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>
				<p>&nbsp; </p>';
			}
			
			else{ //show form
			?>
			
			<!--hidden missing fields error div-->
			<div id="popupregistrationerror" class="popupmaphelp"></div>
			  
			  <h1>Welcome to the Project BudBurst Community!</h1>
              
              <p>By registering with us,  you can save your observation location(s) and  plant(s) that you are monitoring throughout the year and for coming years. This also allows you to report the phenophical changes as they occur each week!</p>
            <p> If you are under the age of 13, you must have your parent, guardian or teacher register for you. Please note our <a href="policies.php" class="maincontent">privacy policy</a>.</p>
            
            <center><div style="text-align:left; width:80%;">(* = required fields)</div></center>
            <!--(* = required fields)-->
            
            <FORM ACTION="register_do.php" METHOD="POST" name="form1" id="form1" onsubmit="MM_validateForm('firstname','','R','lastname','','R','city','','R','email','','RisEmail','login','','R','password1','','R','password2','','R');return document.MM_returnValue">
             <INPUT TYPE=HIDDEN NAME="authtype" value="local">
			<center>
			<table width="80%" border="0" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form">
                <th style="padding:0;" colspan="3">Project BudBurst Registration</th>
                <tr>
					<td><div align="right"><strong>*I am at least 13 years of age: </strong></div></td>
					<td colspan="2"><input id="age13" name="age13" type="checkbox" value="age13" tabindex="1"/></td>
				</tr>
                <tr>
					<td width="36%" valign="top"><div align="right"><strong>*First Name:</strong></div></td>
					<td colspan="2" valign="top"><input id="firstname" name="firstname" type="text" tabindex="2" size="40"/></td>
                </tr>
                <!--<tr>
                  <td valign="top"><div align="right">Middle Name:</div></td>
                  <td valign="top"><input type="text" id="middlename" name="middlename" size="40" tabindex="3"/></td>
                </tr>-->
                <tr>
					<td valign="top"><div align="right"><strong>*Last Name:</strong></div></td>
					<td colspan="2" valign="top"><input id="lastname" name="lastname" type="text" tabindex="3" size="40"/></td>
                </tr>
                <!--<tr>
                  <td valign="top"><div align="right">Suffix:</div></td>
                  <td valign="top"><input type="text" id="suffix" name="suffix" size="6" tabindex="5"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Address1:</div></td>
                  <td valign="top"><input type="text" id="address1" name="address1" size="40" tabindex="6"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Address2:</div></td>
                  <td valign="top"><input type="text" id="address2" name="address2" size="40" tabindex="7"/></td>
                </tr>-->
                <tr>
					<td valign="top"><div align="right"><strong>*City:</strong></div></td>
					<td colspan="2" valign="top"><input type="text" id="city" name="city" tabindex="4" size="40"/></td>
                </tr>
                <tr>
					<td valign="top"><div align="right"><strong>*State:</strong></div></td>
					<td colspan="2" valign="top">
						<select id="state" name="state" tabindex ="5">
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
                  <td valign="top"><div align="right">Zip Code:</div></td>
                  <td colspan="2" valign="top"><input id="zip" name="zip" type="text" size="12" maxlength="5" tabindex ="6" /></td>
                </tr>
                <!-- <tr>
                  <td valign="top"><div align="right">Country:</div></td>
                  <td valign="top"><select name="country" id="country" tabindex ="12">
                    <option value="us">United States</option>
                  </select></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Comments:</div></td>
                  <td valign="top"><textarea id="comments" name="comments" cols="40" rows="2" tabindex ="11"></textarea></td>
                </tr>-->
                <tr>
                  <td valign="top"><div align="right"><strong>*Email</strong>:</div></td>
                  <td colspan="2" valign="top"><input id="email" name="email" type="text" size="40" tabindex ="7"/></td>
                </tr>
                <tr>
                  <td align="right" valign="top"><strong>I am an Educator:</strong></td>
                  <td width="4%" valign="top"><input id="k12teacher" name="k12teacher" type="checkbox" value="1" tabindex="8"/></td>
                  <td width="60%" valign="top">(Educator accounts allow formal and informal educators to register classrooom sites and create student reporter accounts.)</td>
              </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Type the words <br />
                  that you see:</strong></div></td>
                  <td colspan="2" valign="top"><? echo recaptcha_get_html($publickey); ?></td>
                </tr>
                <tr>
                  <td colspan="3"><hr /></td>
                </tr>
                <tr>
                  <td colspan="3">Your will use  a login and password of your choosing to access your account.</td>
            </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Login: </strong></div></td>
                  <td colspan="2" valign="top">
                  	<p><strong>
                    <input name="login" value="" type="text" id="login" size="40" tabindex="13" />
                  	<br />
                  	</strong>
                  (Please do not use your email address)</p></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Password: </strong></div></td>
                  <td colspan="2" valign="top"><strong>
                    <input name="password1" type="password" id="password1" size="40" tabindex ="14"/>
                  </strong></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>*Retype Password: </strong></div></td>
                  <td colspan="2" valign="top"><strong>
                    <input name="password2" type="password" id="password2" size="40" tabindex ="15"/>
                  </strong></td>
                </tr>
              </table>
		</center>
        
              <p align="center">
                <input type="submit" name="submit" value="Submit" tabindex ="16"/><input type="reset" value="Clear Form" tabindex ="17">
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