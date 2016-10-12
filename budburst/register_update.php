<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org) 
# Modified by Rick Rose
# Last modified 12/11/2012
# Copyright 2008-2011 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

//reCAPTCHA code
require_once 'cgi-bin/recaptchalib.php';
$publickey = "6LdWv7kSAAAAAEgSxIePmZdl-zGwwfS7sWEGjN_M"; // we got this from the signup page on 4/26/2010
//reCAPTCHA code

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst - Update your Registration"); // The first and only parameter is the page title
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
				//make sure user is logged in
				if(!checklogin($dbh)) {
						$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
						$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.';
						$maincontent.= $spacer;
				} 
				else {
					//Get PersonID
					$personid = get_personID($dbh);
					//echo("personid=$personid");
					//get registration information based on Person ID
					$qry = sprintf("SELECT * FROM tbl_people WHERE Person_ID='%s'",$dbh->real_escape_string($personid));
					
					//echo("qry=$qry");
					
					$check = $dbh->query($qry);
					
					if (!$check) {
						$maincontent.= '<p>Registration information not found in database. Please contact the Web Manager at <a href="mailto:budburstweb@neoninc.org">budburstweb@neoninc</a> with this error.</p>';
					} 
					else{
						while ($row = $check->fetch_object()) {
							$firstname = $row->First_Name;
							$middlename = $row->Middle_Name;
							$lastname = $row->Last_Name;
							$suffix = $row->Name_Suffix;
							$address1 = $row->Addr_Street1;
							$address2 = $row->Addr_Street2;
							$city= $row->Addr_City;
							$state = $row->Addr_State;
							$postalcode = $row->Addr_PostalCode;
							
							// set postal code to null if set to zero to prevent display of zero on form
							if($postalcode==0)
							{
								$postalcode="";
							}
							$country = $row->Addr_Country;
							$comments = $row->Comments;
							$special_project = $row->Special_Project_Participation;
							$email = $row->email;	
						}//while
					
					//show form
					?>
					<p>Please update your Project BudBurst membership by correcting any information below.<br/>Please note our <a href="policies.php" class="maincontent">privacy policy</a>. (* = required fields)</p>
			<FORM ACTION="register_update_do.php" METHOD="POST" name="form1" id="form1" onsubmit="MM_validateForm('email','','RisEmail');return document.MM_returnValue">
            <INPUT TYPE=HIDDEN NAME="authtype" value="local"><br />
			<table class="form" width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#C3D9A5"> <!-- bgcolor="#DAE8C8" -->
                <th colspan="2">Registration Information</th>
                <tr>
                  <td width="28%"><div align="right"><strong>*First Name:</strong></div></td>
                  <td><input name="firstname" type="text" tabindex="2" value="<?php echo $firstname; ?>" size="40"/></td>
                </tr>
                <tr>
                  <td><div align="right">Middle Name:</div></td>
                  <td><input type="text" name="middlename" size="40" value="<?php echo $middlename; ?>" tabindex="3"/></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*Last Name:</strong></div></td>
                  <td><input type="text" name="lastname" size="40" value="<?php echo $lastname; ?>" tabindex="4"/></td>
                </tr>
                <tr>
                  <td><div align="right">Suffix:</div></td>
                  <td><input type="text" name="suffix" size="6" value="<?php echo $suffix; ?>" tabindex="5"/></td>
                </tr>
                <tr>
                  <td><div align="right">Address1:</div></td>
                  <td><input type="text" name="address1" size="40"  value="<?php echo $address1; ?>" tabindex="6"/></td>
                </tr>
                <tr>
                  <td><div align="right">Address2:</div></td>
                  <td><input type="text" name="address2" size="40" value="<?php echo $address2; ?>" tabindex="7"/></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*City:</strong></div></td>
                  <td><input type="text" name="city" size="40" value="<?php echo $city; ?>" tabindex="8"/></td>
                </tr>
                <tr>
                  <td><div align="right"><strong>*State:</strong></div></td>
                  <td><select name="state" id="state" tabindex ="10">
          <option value="">select</option>
          <option value="AL" <?php  if ($state == 'AL') echo 'selected="selected"'; ?> >Alabama</option>
          <option value="AK" <?php  if ($state == 'AK') echo 'selected="selected"'; ?> >Alaska</option>
          <option value="AZ" <?php  if ($state == 'AZ') echo 'selected="selected"'; ?> >Arizona</option>
          <option value="AR" <?php  if ($state == 'AR') echo 'selected="selected"'; ?> >Arkansas</option>
          <option value="CA" <?php  if ($state == 'CA') echo 'selected="selected"'; ?> >California</option>
          <option value="CO" <?php  if ($state == 'CO') echo 'selected="selected"'; ?> >Colorado</option>
          <option value="CT" <?php  if ($state == 'CT') echo 'selected="selected"'; ?> >Connecticut</option>
          <option value="DE" <?php  if ($state == 'DE') echo 'selected="selected"'; ?> >Delaware</option>
          <option value="DC" <?php  if ($state == 'DC') echo 'selected="selected"'; ?> >District of Columbia</option>
          <option value="FL" <?php  if ($state == 'FL') echo 'selected="selected"'; ?> >Florida</option>
          <option value="GA" <?php  if ($state == 'GA') echo 'selected="selected"'; ?> >Georgia</option>
		  <option value="HI" <?php  if ($state == 'HI') echo 'selected="selected"'; ?> >Hawaii</option>
          <option value="ID" <?php  if ($state == 'ID') echo 'selected="selected"'; ?> >Idaho</option>
          <option value="IL" <?php  if ($state == 'IL') echo 'selected="selected"'; ?> >Illinois</option>
          <option value="IN" <?php  if ($state == 'IN') echo 'selected="selected"'; ?> >Indiana</option>
          <option value="IA" <?php  if ($state == 'IA') echo 'selected="selected"'; ?> >Iowa</option>
          <option value="KS" <?php  if ($state == 'KS') echo 'selected="selected"'; ?> >Kansas</option>
          <option value="KY" <?php  if ($state == 'KY') echo 'selected="selected"'; ?> >Kentucky</option>
          <option value="LA" <?php  if ($state == 'LA') echo 'selected="selected"'; ?> >Louisiana</option>
          <option value="ME" <?php  if ($state == 'ME') echo 'selected="selected"'; ?> >Maine</option>
          <option value="MD" <?php  if ($state == 'MD') echo 'selected="selected"'; ?> >Maryland</option>
          <option value="MA" <?php  if ($state == 'MA') echo 'selected="selected"'; ?> >Massachusetts</option>
          <option value="MI" <?php  if ($state == 'MI') echo 'selected="selected"'; ?> >Michigan</option>
          <option value="MN" <?php  if ($state == 'MN') echo 'selected="selected"'; ?> >Minnesota</option>
          <option value="MS" <?php  if ($state == 'MS') echo 'selected="selected"'; ?> >Mississippi</option>
          <option value="MO" <?php  if ($state == 'MO') echo 'selected="selected"'; ?> >Missouri</option>
          <option value="MT" <?php  if ($state == 'MT') echo 'selected="selected"'; ?> >Montana</option>
          <option value="NE" <?php  if ($state == 'NE') echo 'selected="selected"'; ?> >Nebraska</option>
          <option value="NV" <?php  if ($state == 'NV') echo 'selected="selected"'; ?> >Nevada</option>
          <option value="NH" <?php  if ($state == 'NH') echo 'selected="selected"'; ?> >New Hampshire</option>
          <option value="NJ" <?php  if ($state == 'NJ') echo 'selected="selected"'; ?> >New Jersey</option>
          <option value="NM" <?php  if ($state == 'NM') echo 'selected="selected"'; ?> >New Mexico</option>
          <option value="NY" <?php  if ($state == 'NY') echo 'selected="selected"'; ?> >New York</option>
          <option value="NC" <?php  if ($state == 'NC') echo 'selected="selected"'; ?> >North Carolina</option>
          <option value="ND" <?php  if ($state == 'ND') echo 'selected="selected"'; ?> >North Dakota</option>
          <option value="OH" <?php  if ($state == 'OH') echo 'selected="selected"'; ?> >Ohio</option>
          <option value="OK" <?php  if ($state == 'OK') echo 'selected="selected"'; ?> >Oklahoma</option>
          <option value="OR" <?php  if ($state == 'OR') echo 'selected="selected"'; ?> >Oregon</option>
          <option value="PA" <?php  if ($state == 'PA') echo 'selected="selected"'; ?> >Pennsylvania</option>
          <option value="RI" <?php  if ($state == 'RI') echo 'selected="selected"'; ?> >Rhode Island</option>
          <option value="SC" <?php  if ($state == 'SC') echo 'selected="selected"'; ?> >South Carolina</option>
          <option value="SD" <?php  if ($state == 'SD') echo 'selected="selected"'; ?> >South Dakota</option>
          <option value="TN" <?php  if ($state == 'TN') echo 'selected="selected"'; ?> >Tennessee</option>
          <option value="TX" <?php  if ($state == 'TX') echo 'selected="selected"'; ?> >Texas</option>
          <option value="UT" <?php  if ($state == 'UT') echo 'selected="selected"'; ?> >Utah</option>
          <option value="VT" <?php  if ($state == 'VT') echo 'selected="selected"'; ?> >Vermont</option>
          <option value="VA" <?php  if ($state == 'VA') echo 'selected="selected"'; ?> >Virginia</option>
          <option value="WA" <?php  if ($state == 'WA') echo 'selected="selected"'; ?> >Washington</option>
          <option value="WV" <?php  if ($state == 'WV') echo 'selected="selected"'; ?> >West Virginia</option>
          <option value="WI" <?php  if ($state == 'WI') echo 'selected="selected"'; ?> >Wisconsin</option>
          <option value="WY" <?php  if ($state == 'WY') echo 'selected="selected"'; ?> >Wyoming</option>
                  </select></td>
                </tr>
                <tr>
                  <td valign="top"><div align="right">Zip Code:</div></td>
                  <td valign="top">
				  <input name="zip" type="text" size="12" maxlength="5" value="<?php echo $postalcode;?>" tabindex ="11" /></td>
                </tr>
               <!-- <tr>
                  <td><div align="right">Country:</div></td>
                  <td><select name="country" id="country" tabindex ="12">
                    <option value="us">United States</option>
                  </select></td>
                </tr>-->
                
                <tr>
                  <td><div align="right">Comments:</div></td>
                  <td><textarea name="comments" cols="40" rows="2" id="comments" value="<?php echo $comments; ?>" tabindex ="12"></textarea></td>
                </tr>
               
                <!--<tr>
                  <td valign="top"><div align="right">Participating in one <br />
                  of our <a href="specialprojects.php" target="_blank" class="maincontent">Special Projects</a>?</div></td>
                  <td width="32%" valign="top"><label></label>
                      <label>
                      <select name="special_project_participation_array[]" size="3" multiple="MULTIPLE" id="special_project_participation"  tabindex ="13">
                        <option value="0">--Select if applicable--</option>
                        <option value="2" <?php  
									$pos =  strpos($special_project, '2');
									if ($pos !== false) {
									//echo 'selected="selected"'
									;} 
									?> >Urban Tree Phenology</option>
                        <option value="3" <?php  
									$pos =  strpos($special_project, '3');
									if ($pos !== false) {
									//echo 'selected="selected"'
									;}  
									?> >BudBurst at the Refuges</option>
                        <option value="cens" >The Networked Naturatlist</option>
                                            </select>
                      </label></td>
                  <td width="40%" valign="top" ><span class="photocredit">(Note: To select multiple projects, hold down the control key while selecting.)</span></td>
                </tr>-->
                
                <tr>
                  <td><div align="right"><strong>*Email</strong>:</div></td>
                  <td><input name="email" type="text" id="email" size="40" value="<?php echo $email; ?>" tabindex ="14"/></td>
                </tr>
              </table>
              <p align="center">
                <input type="submit" name="submit" value="Submit" tabindex ="18"/>
              </p>
              </form>
					
					<?php
					} //else 
					
				}//else personid
				echo $maincontent;
				//echo $spacer;
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