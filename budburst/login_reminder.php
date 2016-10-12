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
HeaderStart("Login Reminder"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
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
<h1>Login Reminder</h1>
			<!--image holder-->
			<div class="picture right" style="width:200px">
				<img width="200px" src="images/161_m.jpg" alt="Nannyberry" title="Nannyberry" />
                Nannyberry photo courtesy of the USFWS		
			</div><!--end image holder-->
      <p>
		  <?php  
             $msg = '';
             $email_text =  '';
                
            if ( $_POST["submit"] ) {

                $personid = get_personID_byEmail($_POST["email"],$dbh ); // ~line 1134 in pb_lib
                //echo "\$personid= " . $personid;
                
                if ($personid){
                    $result = get_username_byPersonID($personid, $dbh);  // ~line 1066 in pb_lib
                    // "  \$result= " . $result;
					//";
                    if ( $result === false ) {
                        $msg .= '<p>Sorry, we could not retrieve your information [ERROR #63].
                        <p>Please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.</p>';
                    } elseif ( $result === 0 ) {
                        $msg .= '<p>Sorry, your login could not be found in our database. [ERROR #66]</p>
                                <p>Please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.</p>';
                        } //elseif
                        else { //good to go
                            //$row = $result->fetch_object();
                           // $login = $row->UserName;
						   $login = $result;
                            
                            //email out information
                            $email_text .= "Project BudBurst Login reminder\n\n";
                            $email_text .= "Login: " . $login . "\n\n";
                            $email_text .= "If you continue to experience problems, please contact the Web manager at budburstweb@neoninc.org\n\nEnjoy Project BudBurst!";
                            mail( $_POST["email"], "Project BudBurst Login reminder", $email_text, 'From: budburstweb@neoninc.org');
                            $msg .="<p>Thank you. The reminder has been sent to " .$_POST["email"] .".</p>";
                            $msg.='<p>If you continue to experience problems please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.</p>';
                        } //else good to go 
                        
                } //if personid ok
                else {
                    $msg.='<p>Sorry your email was not found in our database. [ERROR #84]</p><p>Please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a>.</p>';
                    
                } //else
                
            }//post submit
            
            
            else{  //display form  
            ?>
        
                Please enter the email address you provided during registration to receive an automated reminder 
                of your Project BudBurst login. This reminder will be sent through email. </p>
      <p>If you have registered more than one user account using the same email address, the system will only send your original (first) login. If it isn't the one you were expecting, please <a href="mailto:budburstweb@neoninc.org?subject=Project BudBurst Login Reminder Request"><strong>email us</strong></a> and we'll help you find the right one.</p>
      <p>Please note our <a href="policies.php" class="maincontent">privacy policy</a>. (* = required fields) </p><br /><br /><br />
                  <form id="form1" name="form1" method="post" action="">
                    <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#C3D9A5" class="form" 
                            summary="login reminder">
                        <th colspan="2">Login Reminder</th>
                      <tr>
                        <td><div align="right"><strong>*<span class="maincontent">Email</span>:</strong></div></td>
                        <td><input name="email" type="text" id="email" size="40"/></td>
                      </tr>
    
                      <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" value="Submit" /></td>
                      </tr>
                    </table>
                  </form>
            <?php
            }//else
            echo $msg;
            echo $spacer;
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