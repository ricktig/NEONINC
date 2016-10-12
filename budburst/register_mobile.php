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

<head>

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
</head>

<body>

<div id="MainContent" style="width:100%;margin:0 auto">
            
      <FORM ACTION="register_mobile_do.php" METHOD="POST" name="form1" id="form1" onsubmit="MM_validateForm('firstname','','R','lastname','','R','city','','R','email','','RisEmail','login','','R','password1','','R','password2','','R');return document.MM_returnValue">
             <INPUT TYPE=HIDDEN NAME="authtype" value="local">
<center>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form">
                  <th colspan="2" style="font-size: large; font-family: Verdana, Geneva, sans-serif;">Project BudBurst<sup class="sm">SM</sup> <br />
                    Mobile Registration</th>
                <tr>
                  <td colspan="2"><div align="left"><strong>I am at least 13 years of age: </strong>
                      <input name="age13" type="checkbox" id="age13" value="checkbox" tabindex="1"/>
                  </div></td>
            </tr>
                <tr>
                  <td width="31%" valign="top"><div align="right"><strong>First Name:</strong></div></td>
                  <td valign="top"><input name="firstname" type="text" id="firstname" tabindex="2" size="20"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>Last Name:</strong></div></td>
                  <td valign="top"><input name="lastname" type="text" id="lastname" tabindex="4" size="20"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>City:</strong></div></td>
                  <td valign="top"><input name="city" type="text" id="city" tabindex="8" size="20"/></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>State:</strong></div></td>
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
                  <td valign="top"><div align="right"><strong>Zip Code:</strong></div></td>
                  <td valign="top"><input name="zip" type="text" size="12" maxlength="5" tabindex ="10" /></td>
                </tr>
                <!-- <tr>
                  <td valign="top"><div align="right">Country:</div></td>
                  <td valign="top"><select name="country" id="country" tabindex ="12">
                    <option value="us">United States</option>
                  </select></td>
                </tr>-->
                <tr>
                  <td valign="top"><div align="right"><strong>Email</strong>:</div></td>
                  <td valign="top"><input name="email" type="text" id="email" size="20" tabindex ="13"/></td>
                </tr>
                <tr>
                  <td colspan="2"><hr /></td>
                </tr>
                <tr>
                  <td colspan="2">Please enter a login and password of your choosing.</td>
            </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>Login: </strong></div></td>
                  <td valign="top">
                  	<strong>
                    <input name="login" value="" type="text" id="login" size="20" tabindex="16" />
                  	</strong>
                  </td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>Password: </strong></div></td>
                  <td valign="top"><strong>
                    <input name="password1" type="password" id="password1" size="20" tabindex ="17"/>
                  </strong></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right"><strong>Retype Password: </strong></div></td>
                  <td valign="top"><strong>
                    <input name="password2" type="password" id="password2" size="20" tabindex ="18"/>
                  </strong></td>
                </tr>
          </table>
  </center>
        
              <p align="center">
                <input type="submit" name="submit" value="Submit" tabindex ="18"/><input type="reset" value="Clear Form" tabindex ="20">
      </form>  
    </div><!-- MainContent -->
<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>