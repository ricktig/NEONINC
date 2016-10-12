<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/7/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON), 	
# Chicago Botanic Garden, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';
//require_once 'cgi-bin/pb_lib_kkm.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<script type="text/javascript" src="js/java.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<script>
	$(document).ready(function()
	{
		//check for number of requested reporter accounts > 0
		$("#btnaddstudents").click(function()
		{
			//if teacher has selected the number of reporter accounts, then proceed to reporter_request.php to add accounts
			if (($('#no_reporters').val())>0)
			{
				//submit form to reporter_request.php
				document.form1.submit();
			}
			else
			{	//if teacher hasn't seleted the number of reporter accounts, display message div
				$("#popuprequestreportererror").css('display', 'block');
			}
		});//end btnaddstudents click
	});//end document load
	
	//close pop up div
	function closeWindow()
	{
		$("#popuprequestreportererror").css('display', 'none');
	}
</script>	
			

<?php
HeaderStart("Project BudBurst - Manage My Classroom"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<?php
//
HeaderEnd();
?>

<body id="MyBudBurst">
<div id="wrapper">

  <div id="contentwrapper">
  	
    <!--<div><a href="index.php"><img src="images/Banner_6.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    
	<?php
		WriteTopLogin($dbh);
	?>
        
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent" style="height:100%;">  
      
	  	<?php
	  				
		$maincontent='';
		$flag=0; 
		 
		 //make sure user is logged in
		if(!checklogin($dbh))
		{
			$maincontent.='<p>Sorry you are not logged in. This area is restricted to registered members.</p>';
			$maincontent.='<p>Continue by <a class="maincontent" href="login.php">logging in</a>.';
			$maincontent.= $spacer;
			$flag=1;
		}
		else
		{
			//if (isset($_POST['submit']))
			//{
				//if a required field is empty, error message
				if ( !($_POST['stationid'] ))
				{
					$maincontent.='<p> Manage Classroom - You did not fill in a required field.</p> 
					<p>Please go back and try again.</p>
					<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM>';
					$flag=1;	
				}
						
				$stationid = $_POST['stationid'];
				$stationname = get_StationName($dbh, $stationid);
						
				//everything should be good at this point
				?>
				
				<h1>Manage Student Accounts for: 
							<span style="color:sienna;font-weight:bold;"><?php  echo $stationname;  ?></span></h1>
				<p>We're excited that you are involving your students in Project BudBurst! Included on this page are some features that  will help you  manage your students' participation and involvement in Project BudBurst.</p>
				<p>You can request accounts on the Project BudBurst Website to allow your students to report their phenophase observations. Note: These accounts will  be a restricted user account, not saving any personal information about the student and only allowing the reporting of observations (adding and deleting plants and managing sites is not available to them).</p>
				

			
				<?php
				//fetch userid from username
				//$personid = get_personID($dbh);
				//fetch classrooms for this teacher (stations for this userid)
				//$sql=sprintf("SELECT Station_Id FROM tbl_stations WHERE Observer_ID = %s", $personid);
				
				//$result=mysql_query($sql);
				
				//check for classroom query result
				//if(mysql_num_rows($result)==0)
				//{
					//no classrooms
					//$maincontent .= 'You don\'t have any classrooms registered yet.  Please click on the Add A Classroom button above.';
				//}
				//else
				//{
					//found classrooms
					//loop through classrooms
					//while($row=mysql_fetch_array($result))
					//{
						//assign stationid
						$stationid = $_POST['stationid'];
						//fetch station name
						$stationname = get_StationName($dbh, $stationid)
					?>
								
					<!--div to display warning if number of requested reporter accounts is 0-->	
					<div id="popuprequestreportererror">
						<img src="images/red_close_button.png" alt="close help window button" class="btnclosewindow" id="btnclosewindow" onclick="closeWindow()"/>
						Please select the number of reporter accounts you're requesting from the drop down menu.
					</div><!--end errorpopup div-->
					
					
							
<div id="studentaccounts" style="height:320px">
									
									<div id="addreporteraccounts" style="width:200px;background-color:#C3D9A5;float:left;margin: 0 10px 0 10px">
										<p><strong>Add Student Reporter Accounts</strong></p>
										
										<form id="form1" name="form1" method="post" action="reporter_request.php">
											<p>Please select number of student reporter accounts requested for <strong><?php  echo $stationname;  ?></strong>:
												<select name="no_reporters" id="no_reporters">
													  <option value="0"selected="selected">select</option>
													  <option value="1" >1</option>
													  <option value="2" >2</option>
													  <option value="3" >3</option>
													  <option value="4" >4</option>
													  <option value="5" >5</option>
													  <option value="6" >6</option>
													  <option value="7" >7</option>
													  <option value="8" >8</option>
													  <option value="9" >9</option>
													  <option value="10" >10</option>
													  <option value="11" >11</option>
													  <option value="12" >12</option>
													  <option value="13" >13</option>
													  <option value="14" >14</option>
													  <option value="15" >15</option>
													  <option value="16" >16</option>
													  <option value="17" >17</option>
													  <option value="18" >18</option>
													  <option value="19" >19</option>
													  <option value="20" >20</option>
													  <option value="21" >21</option>
													  <option value="22" >22</option>
													  <option value="23" >23</option>
													  <option value="24" >24</option>
													  <option value="25" >25</option>
													  <option value="26" >26</option>
													  <option value="27" >27</option>
													  <option value="28" >28</option>
													  <option value="29" >29</option>
													  <option value="30" >30</option>
													  <option value="31" >31</option>
													  <option value="32" >32</option>
													  <option value="33" >33</option>
													  <option value="34" >34</option>
													  <option value="35" >35</option>
													  <option value="36" >36</option>
													  <option value="37" >37</option>
													  <option value="38" >38</option>
													  <option value="39" >39</option>
													  <option value="40" >40</option>
												</select>
												<br />
												<input name="stationid" type="hidden" value="<?php echo $stationid;?>" />
												<div style="margin: 0 auto;width:155px;"><input type="button" name="btnaddstudents" id="btnaddstudents" value="Add Student Accounts" /></div>
											</p>
										</form>
									</div>
								
								<!--display view student reporter accounts div-->	
								<div id="viewreporteraccounts" style="width:200px;background-color:#EDB6BF;float:left;margin: 0 10px 0 10px">
									 <p><strong>View Student Reporter Accounts</strong></p>
										<p>You can view a list of your student reporter accounts for <strong><?php  echo $stationname;  ?></strong>. </p>
									  <form id="form3" name="form3" method="post" action="reporter_view.php">
									 
									<input name="stationid" type="hidden" value="<?php echo $stationid;?>" />
									<div style="margin: 0 auto;width:162px;"><input type="submit" name="submit" id="Submit" value="View Student Accounts " /></div>
									</form>				
								</div>

								<!--display delete student reporter accounts div-->
								<div id="deletreporteraccounts" style="width:200px;background-color:#EDB6BF;float:left;margin: 0 10px 0 10px">
									<form id="form4" name="form4" method="post" action="reporter_delete.php">
										<p><strong>Delete Student Report Accounts</strong></p>
										<p>You can delete the set of student reporter accounts for your <strong><?php  echo $stationname;  ?></strong>. This is usually done at the end of the school year and prior to the next school year of participation in Project BudBurst!</p>
										<input name="stationid" type="hidden" value="<?php echo $stationid;?>" />
										<div style="margin: 0 auto;width:174px;"><input type="submit" name="submit" id="Submit" value="Delete Student Accounts " /></div>
									</form>
								</div>
							</div>
                            <a class="buttons" href="my_regular_reports.php">Return to My Regular Reports</a>
                            <div style="clear:both"></div>
					<?php

			//	} //if $_POST['submit']
			//	else $maincontent.='To view this page one of your myBudBurst sites must first be selected. Please continue to your <a href = "mybudburst.php" class="maincontent">MyBudBurst space</a> and select a site.';
			}//else logged in
			
		//$maincontent.=$spacer;
		echo $maincontent;
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