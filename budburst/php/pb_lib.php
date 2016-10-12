

<?php
/*----------------------------------------
#                                         
# Author: Kirsten K. Meymaris (UCAR)
# Last modified 1/4/13	
# by L. A. Wasser, Rick Rose, Dennis Ward   
# Copyright 2008-2013 All Rights Reserved	
			  
#  National Ecological Observatory Network                                        
# Library of general functions for 	      
# Project BudBurst						 
#----------------------------------------*/

define('BASE_URL',dirname($_SERVER["SCRIPT_NAME"]));
ini_set('display_errors', 0);
$maincontent='';
$spacer = '	<p>&nbsp; </p>
			<p>&nbsp; </p>
			<p>&nbsp; </p>
			<p>&nbsp; </p>
			<p>&nbsp; </p>';

$anonymous_user = 1; //todo account in database
$anonymous_site = 'anonymous_site';
$anonymous_sessionid = 1; //todo account in database
$protocol_id = 1; //set budburst protocol id = 1
$no_species = get_no_PBBspecies($dbh);
//76; //set species total (non-user-defined), 999=other
//$other_ID = 999;
$current_year = date("Y");
$cite_today = date("F j, Y");
$basic_PBB_protocol_ID = 9;
$otherID = get_other_speciesID($dbh);

//general error messages
$error_web='<p>Please contact the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with this error.</p>';
$already_logged_in_msg='<p>You are already logged in. Please continue at <a class="maincontent" href="mybudburst.php">MyBudBurst Space</a>!</p>';
$not_logged_in_msg='<p>Sorry you must be logged in to view this page.</p>  
					<p>Please continue by <a class="maincontent" href="login.php">logging in</a>!</p><br><br>
					<p>If you continue to expeience this error message, please try: <br>
					1) first <a class="maincontent" href="browser_howto.php">deleting your browser cookies & cache</a> 
					and then <a class="maincontent" href="login.php">logging in</a><br>
					or 2) contacting the <a href="mailto:budburstweb@neoninc.org" class="maincontent">Web manager</a></p>';
$missing_fields='<p>You did not fill in a required field - please go back and try again.</p>
				<p><FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM></p>';

/*********************************************************/
// log user in by creating session
// args username entered from a login/registration script 
// and database handler
/*********************************************************/

function log_user($p_uname, $p_dbh)
{
	//session_start();
	
	//echo "log_user function<br>";

	//Get UserID
    $qry = sprintf("SELECT User_ID from tbl_users WHERE BINARY UserName = '%s'",$p_dbh->real_escape_string($p_uname));
	
    $check = $p_dbh->query($qry);
	if ($p_dbh->affected_rows == 0)
	{
        die('That username does not exist in our database.');
    }
	
    while ($row = $check->fetch_object())
	{
        $userid = $row->User_ID;
    }
	
    //set active to yes
    $active = 1;	
    //get IP
    $ip = $_SERVER['REMOTE_ADDR'];
    //Now create a session entry in the database
    start_sql_session($ip,$active,$userid,$p_dbh);
	
    //Get Session_ID
    $qry = sprintf("SELECT Session_ID from tbl_sessions WHERE User_ID = %d and Active = 1",$p_dbh->real_escape_string($userid));
    $check = $p_dbh->query($qry);
    while ($row = $check->fetch_object()) {
        $uuid = $row->Session_ID;
		//echo("uuid=$uuid");
    }

    //register session variables
	$_SESSION['username'] = $p_uname;
    $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['UUID'] = $uuid;
	
	//check session info
	/*echo "<br>This is the log_user script<br><pre>";
	print_r($_SESSION);
	echo "</pre>";*/
	
    //clean up
    unset($userid);
    unset($ip);
    unset($uuid);
	unset($p_uname);
	unset($p_dbh);

	return true;
}

// added from old procedures file to combine and eventually remove need for old preocedures.php file

/*--===============Procedure 'store_user'===============--
  --This will store a user's information in the database--
  --This stores data in 'tbl_people' and 'tbl_users' tables      --
  --====================================================--*/

function store_user($login,$password_hash,$firstname,$middlename,$lastname,
                    $suffix,$address1,$address2,$city,$state,$zip,$country,
                    $comments,   $email , $k12teacher, $authtype, $p_dbh) 
{
		  
    //prepare statement
    $qry = sprintf("INSERT INTO tbl_people 
        (
        First_Name, 
        Middle_Name, 
        Last_Name, 
        Name_Suffix, 
        Addr_Street1, 
        Addr_Street2, 
        Addr_City, 
        Addr_State, 
        Addr_PostalCode, 
        Addr_Country, 
        Create_Date, 
        Comments, 
		K12teacher,
        email
        )	
        values 
        ( 
        '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d, '%s', NOW(), '%s', '%d', '%s'
        )
        ",$p_dbh->real_escape_string($firstname),
          $p_dbh->real_escape_string($middlename), 
          $p_dbh->real_escape_string($lastname), 
          $p_dbh->real_escape_string($suffix), 
          $p_dbh->real_escape_string($address1),
          $p_dbh->real_escape_string($address2),
          $p_dbh->real_escape_string($city), 
          $p_dbh->real_escape_string($state), 
          $p_dbh->real_escape_string($zip), 
          $p_dbh->real_escape_string($country), 
          $p_dbh->real_escape_string($comments),
		  $p_dbh->real_escape_string($k12teacher),
          $p_dbh->real_escape_string($email));
    //execute staement

    $p_dbh->query($qry);

    $qry = "SELECT MAX(Person_ID) FROM tbl_people INTO @key";
    $p_dbh->query($qry);
    $qry = sprintf("INSERT INTO tbl_users
        (
        UserName, Passwd_Hash, Create_Date, Person_ID, Authentication_Mechanism, Comments
        )
        values
        (
        '%s', '%s', NOW(), @key, '%s', '%s'
        )"
        ,$p_dbh->real_escape_string($login),
         $p_dbh->real_escape_string($password_hash),
         $p_dbh->real_escape_string($authtype), 
         $p_dbh->real_escape_string($comments));
    $p_dbh->query($qry);


	// #######################################################################
	//      send registration data to the CENS database for BudBurst Mobile
	//      WRITTEN BY CENS, ADDED BY DLW ON 27SEP2011
	// #######################################################################
	   
      // Dennis added this code on 9/29/2011 to grab the max value from the users table.
			if ($result = mysqli_query($p_dbh,"SELECT MAX(User_ID) FROM tbl_users")){
			  while($row = mysqli_fetch_assoc($result) ){
				  $max_user_id = $row['MAX(User_ID)'];
				  //printf("Max (from tbl_users) = %s\n", $max_user_id );
			  } //END WHILE
			} //END IF

	/*		$qry = "SELECT MAX(Person_ID) FROM tbl_people INTO @key";  // get the new User_ID and Person_ID values
			$result_ID = $p_dbh->query($qry);
			$ID = mysql_fetch_array($result_ID);	// note that the db returns an array for the user_id
	*/	
			//create array of data to be posted
			$post_data['authtype'] = $authtype;
			$post_data['ID'] = $max_user_id; // added dennis' result to this POST
			$post_data['login'] =$login;
			$post_data['password_hash'] =$password_hash;
			$post_data['firstname'] =$firstname;
			$post_data['middlename'] =$middlename;
			$post_data['lastname'] =$lastname;
			$post_data['suffix'] =$suffix;
			$post_data['address1'] =$address1;
			$post_data['address2'] =$address2;
			$post_data['city'] =$city;
			$post_data['state'] =$state;
			$post_data['zip'] =$zip;
			$post_data['country'] =$country;
			$post_data['email'] =$email;
			$post_data['comments'] =$comments;
			$post_data['K12teacher'] =$k12teacher;
			 
			//traverse array and prepare data for posting (key1=value1)
			foreach ( $post_data as $key => $value) {
				$post_items[] = $key . '=' . $value;
			}
			 
			//create the final string to be posted using implode()
			$post_string = implode ('&', $post_items);
			 
			//create cURL connection
			$curl_connection =
			  curl_init('http://cens.solidnetdns.com/~kshan/PBB/PBsite_CENS/register_from_NEON.php');
			 
			//set options
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_USERAGENT,
			  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
			 
			//set data to be posted
			curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
			 
			//perform our request
			$result = curl_exec($curl_connection);
			//print_r($result);
			 
			//show information regarding the request
			//print_r(curl_getinfo($curl_connection));
			//echo curl_errno($curl_connection) . '-' .
			//				curl_error($curl_connection);
			 
			//close the connection
			curl_close($curl_connection);
	
	// ######################### END sending data to CENS ############################



	
	unset($login);
	unset($password_hash);
	unset($firstname);
	unset($middlename);
	unset($lastname);
	unset($suffix);
	unset($address1);
	unset($address2);
	unset($city);
	unset($state);
	unset($zip);
	unset($country);
	unset($email);
	unset($city);
	unset($comments);
	unset($authtype);
	unset($p_dbh);
}

/*--This will keep track of session starts and ends*/

function start_sql_session($ip,$active,$userid, $p_dbh)
{
	//generate random number as session id
	$uuid=rand(1,99999999999999999);
	
	$qry = sprintf("INSERT INTO tbl_sessions
        (
         Session_ID, User_ID, IP_Address, Create_DateTime, Active 
        )	
        values 
        ( 
         %s, %d, '%s', NOW(), %d
        )"
        ,$p_dbh->real_escape_string($uuid),
		$p_dbh->real_escape_string($userid),
         $p_dbh->real_escape_string($ip),
         $p_dbh->real_escape_string($active)
        );
   
    $p_dbh->query($qry);
	
	unset($ip);
	unset($active);
	unset($userid);
	unset($p_dbh);
}

/*********************************************************/
// Written by Benjamin Crom, November 2007 Oak Ridge 
// National Laboratory  All Rights Reserved
// Modified by Kirsten K. Meymaris University Corporation 
// for Atmospheric Research 
// Copyright 2008 All Rights Reserved
//
// Check and see if user is logged in by comparing session 
// cookies to database  
// args: database handler 
// returns true or false
/*********************************************************/

function checklogin($p_dbh){
	
	//echo "<br>check login<br>";
	// Check to see if the correct session variables are set
	// If not, set user as logged out
	
	//session_start();
	
	if (!isset($_SESSION['IP']) || !isset($_SESSION['UUID'])) {
		$GLOBALS['logged_in'] = 0;
	} else {  //END OF THIS ELSE IS NEAR LINE 156
				
		// Get user's Session UUID find corresponding IP address in database
		$qry = sprintf("SELECT IP_Address FROM tbl_sessions WHERE Session_ID = %d and Active",$p_dbh->real_escape_string($_SESSION['UUID']));
		$result = $p_dbh->query($qry);
		while ($row = $result->fetch_object()) {
		$ip = $row->IP_Address;
		} 

// SECTION BELOW MODIFIED BY DLW ON 3/8/2010 TO REMOVE IP ADDRESS CHECK
/*  BEGIN TEST BLOCK WHAT ENDS ABOUT LINE 155
		// If UUID in not in database
		// kill incorrect session variables.
		if($p_dbh->affected_rows != 1) {
			$GLOBALS['logged_in'] = 0;
			unset($_SESSION['IP']);
			unset($_SESSION['UUID']);
		}	
		// If the IP address corresponding to UUID in database
		// matches user's browser IP address then
		// user has correct info in session variables
		if($_SERVER['REMOTE_ADDR'] == $ip) { 
			$GLOBALS['logged_in'] = 1;
		} else {
			// If not, the Session UUID and IP are incorrect, kill them
			$GLOBALS['logged_in'] = 0;
			unset($_SESSION['IP']); 
			unset($_SESSION['UUID']);
		}
*/ //END OF TEST BLOCK, NEXT COMMAND MANUALLY SETS $GLOBALS['logged_in'] = 1 FOR TESTING
		$GLOBALS['logged_in'] = 1;
		
	} // END ELSE FROM LINE 126 
	
	//echo "<br> check login logged in: " .$GLOBALS['logged_in'];
	
	// clean up
	unset($ip);
	unset($p_dbh);
	return $GLOBALS['logged_in'];
}

/*********************************************************/
// Get functions
/*********************************************************/

// get all sites registered by person id
// return array or sites

function get_myBudBurst_sites($p_personid, $p_dbh)
{
	$qry = sprintf("SELECT * FROM tbl_stations WHERE Observer_ID = '%d' ",$p_dbh->real_escape_string($p_personid) );
	$result = $p_dbh->query($qry);
	return $result;
}

function get_myBudBurst_plants($p_stationid, $p_dbh)
{
	$qry = sprintf("SELECT * FROM rel_station_species WHERE Station_ID = '%d' AND active=1",
			$p_dbh->real_escape_string($p_stationid) );
	$result = $p_dbh->query($qry);
	return $result;
}

//build plant selection dynamic drop down menu based on specieslist
//todo for now not showing user-defined plants

function build_species_menu($p_dbh)
{							
	$plant_menu='';
	$qry = "SELECT * from tbl_species WHERE User_Defined LIKE '%0%' ORDER BY Common_Name";
	$check = $p_dbh->query($qry);
	
	if ($check->num_rows == 0)
	{
		return $plant_menu; //return empty string
	}
	
	$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2" 
					onchange="showImage(this.options[this.selectedIndex].value);">
					<option value="" selected="selected">Select</option>';
					
	while ($row = $check->fetch_object())
	{
		//todo if (user_defined flag) then add spacer
		$plant_menu .= '<option value="';
		$plant_menu .= $row->Species_ID;
		$plant_menu .= '">';
		$plant_menu .= $row->Common_Name;
		$plant_menu .= '</option>';
	 } 
	$plant_menu .= '</select>';
					
	return $plant_menu;
}

//build plant selection dynamic drop down menu based on specieslist
//todo for now not showing user-defined plants
function build_species_menu_new($p_dbh, $p_speciesid)
{							
	$plant_menu='';
		
	//commented out to allow for users to choose all species < 999 and those not excluded by user_defined of -1
	//$qry = "SELECT * from tbl_species WHERE User_Defined LIKE '%0%' ORDER BY Common_Name";
	$qry = "SELECT * from tbl_species WHERE Species_ID <999 AND User_Defined >=0 ORDER BY Common_Name";
	$check = $p_dbh->query($qry);
	if ($check->num_rows == 0) {
			return $plant_menu; //return empty string
	}
	/*$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2" onchange="
	plant_onchange(this.options[this.selectedIndex].value);">
					<option value="" selected="selected">Select</option>';*/
												
	$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2" 
												onchange="reload(this.form)">
												<option value="0" selected="selected">Select</option>';
	while ($row = $check->fetch_object())
	{
		//skip over species 999-Other in tbl_species because it sorts by alpha to the top of the pull down menu
		if($row->Species_ID == "999")
		{
		// skip record index 999 - Other
		}
		else
		{
			//todo if (user_defined flag) then add spacer
			$plant_menu .= '<option value="';
			$plant_menu .= $row->Species_ID;
			$plant_menu .= '"';
			//if already selected
			if ($p_speciesid == $row->Species_ID) {
				$plant_menu .= 'selected="selected"';
			}	
			$plant_menu.='>';
			$plant_menu .= $row->Common_Name;
			$plant_menu .= '</option>';
		}
	 }
	//add select option for species '--Other--' to bottom of pull down list
	$plant_menu .= '<option value="999">-- Other --</option>';
	$plant_menu .= '</select>';
					
	return $plant_menu;
}

//EDITED BY DENNIS WARD ON 13OCT2011 TO FIX "RACHEL CARSON" BUG 
//build plant selection dynamic drop down menu based on specieslist and Special Projects ID
//todo for now not showing user-defined plants

function build_species_menu_new_special($p_dbh, $p_speciesid, $p_specialprojectstring)
{		
	$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2" 
												onchange="reload(this.form)">
												<option value="0" selected="selected">Select</option>';
	//check if user is participation in a special project
	//if so, show only special project plants (all in one drop down)
	//todo separate out the drop down menus by special project
	
	//todo dynamically get number of special projects, right now hard code for loop to 
	//start at 2 and end before 999 for special project ids
	//$specialprojectsid = '0';  //default value in case no special project participation
	$specialprojectsid = '0';  //default value in case no special project participation
	
	//if special project ==>
	for ($i=2; $i<999; $i++){
		//$pos = strpos($p_specialprojectstring, "$i");
		$pos = strcmp($p_specialprojectstring, "$i"); //changed to strcmp() to get exact match
		//if ($pos !== false) {
		if ($pos == 0) {
			$specialprojectsid = $i;

			//$qry = sprintf("SELECT * from tbl_species WHERE User_Defined LIKE '%s' ORDER BY Common_Name", $specialprojectsid);
			
			//commented out to add 'and' to select statement which filters User_Defined to >=0
			$qry = sprintf("SELECT * from tbl_species WHERE FIND_IN_SET('%s', User_Defined)  ORDER BY Common_Name", $specialprojectsid);
			$result = $p_dbh->query($qry);
			if ($result->num_rows == 0) {
					return 0; //return empty string
			}

			while ($row = $result->fetch_object()) {
				//todo if (user_defined flag) then add spacer
				$plant_menu .= '<option value="';
				$plant_menu .= $row->Species_ID;
				$plant_menu .= '"';
				//if already selected
				if ($p_speciesid == $row->Species_ID) {
					$plant_menu .= 'selected="selected"';
				}	
				$plant_menu.='>';
				$plant_menu .= $row->Common_Name;
				$plant_menu .= '</option>';
			 } 
			 //spacer for a new project
			 //todo add Special Project Name
			//$plant_menu .= '<option value="NULL">------</option>';
		} //if user is participating in special project
		
	} //for looping through all special projects
	$plant_menu .= '</select>';
	
	//no special participation?? then get PBB General species list
	//if 	($specialprojectsid == "%0%"){	
	if 	($specialprojectsid == "0"){	
		$plant_menu = build_species_menu_new($p_dbh, $p_speciesid);
	}		
	return $plant_menu;
}

//STILL TO DO - clean up user defined species a little bit
//build a drop-down menu of user-defined species...
function build_user_defined_species_menu($p_dbh) {
							
			$plant_menu='';
			$qry = "SELECT DISTINCT Common_Name from tbl_species WHERE User_Defined LIKE '%1%' ORDER BY Common_Name";
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
					return $plant_menu; //return empty string
			}
			$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2">
														<option value="" selected="selected">Select</option>';
			while ($row = $check->fetch_object()) {
				//todo if (user_defined flag) then add spacer
				$plant_menu .= '<option value="';
				$plant_menu .= $row->Species_ID;
				$plant_menu .= '">';
				$plant_menu .= $row->Common_Name;
				$plant_menu .= '</option>';
			 } 
			$plant_menu .= '</select>';
							
			return $plant_menu;
}

//function to build a drop down menu of plant groups
function build_plant_groups_menu($p_dbh) {
							
			$plant_group_menu='';
			$qry = "SELECT Plant_Group_Name, Plant_Group_ID FROM tbl_plant_groups ORDER BY Plant_Group_ID ASC";
			$result = $p_dbh->query($qry);
			if ($result->num_rows == 0) {
					return $plant_group_menu; //return empty string
			}
			$plant_group_menu = '<select name="plantgroupid" class="select" id="plantgroupid" tabindex="">
														<option value="" selected="selected">Select</option>';
			while ($row = $result->fetch_object()) {			
				$plant_group_menu .= '<option value="';
				$plant_group_menu .= $row->Plant_Group_ID;
				$plant_group_menu .= '">';
				$plant_group_menu .= $row->Plant_Group_Name;
				$plant_group_menu .= '</option>';
			 } 
			$plant_group_menu .= '</select>';
							
			return $plant_group_menu;
}

//TODO function to build a drop down menu of plant groups
function build_protocol_groups_menu($p_dbh) {
							
			$protocol_group_menu='';
			
}


function build_user_species_menu($p_stationid,$p_dbh){
			$plant_menu='';

			$qry = sprintf("SELECT * from rel_station_species WHERE Station_ID= %d AND active=1", $p_stationid);
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
					return $plant_menu; //return empty string
			}
			
			//$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2" 
			//											onchange="showImage(this.options[this.selectedIndex].value);">
			//											<option value="" selected="selected">Select</option>';
														
			$plant_menu = '<select name="radiospeciesid" class="select" id="radiospeciesid" tabindex="2"><option value="" selected="selected">Select</option>';
														
			while ($row = $check->fetch_object()) {
				$speciesid = $row->Species_ID;
				
				//get species common name to display
				$qry2 = sprintf("SELECT Common_Name from tbl_species WHERE Species_ID= %d", $speciesid);
				$check2 = $p_dbh->query($qry2);
				if(!$check2){
					return  $plant_menu; //return empty string
				}
				
				$row2 = $check2->fetch_object();
				$plant_menu .= '<option value="';
				$plant_menu .= $speciesid;
				$plant_menu .= '">';
				$plant_menu .= $row2->Common_Name;
				$plant_menu .= '</option>';
			 } //while
			$plant_menu .= '</select>';
							
			return $plant_menu;

}

function build_plantgroup_species_menu($p_plantgroupid,$p_dbh)
		{
			$plant_menu='';
			
			//get list of budburst plants from selected PlantGroupID
			$plant_group_set = get_plants_in_plant_group($p_dbh,$p_plantgroupid);
			
			if ($plant_group_set->num_rows == 0)
			{
					return $plant_menu; //return empty string
			}
			else
			{
				$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2" 
															onchange="showImage(this.options[this.selectedIndex].value);">
															<option value="" selected="selected">Select</option>';
				while ($row = $plant_group_set->fetch_object())
				{
					$speciesid = $row->Species_ID;
					
					//get species common name to display
					$qry2 = sprintf("SELECT Common_Name from tbl_species WHERE Species_ID= %d", $speciesid);
					$check2 = $p_dbh->query($qry2);
					if(!$check2)
					{
						return  $plant_menu; //return empty string
					}
					
					$row2 = $check2->fetch_object();
					$plant_menu .= '<option value="';
					$plant_menu .= $speciesid;
					$plant_menu .= '">';
					$plant_menu .= $row2->Common_Name;
					$plant_menu .= '</option>';
				 } //while
				$plant_menu .= '</select>';
			}			
			return $plant_menu;
}

//build list of ALL PBB-entered SP (including special projects) by selected plant group -- ADDED BY DLW ON 9/17/2011
function build_single_report_pg_spp_menu($p_plantgroupid,$p_dbh)
		{
			$plant_menu='';
			
			//get list of budburst plants from selected PlantGroupID
			$plant_group_set = get_plants_in_single_report_plant_groups($p_dbh,$p_plantgroupid);
			
			if ($plant_group_set->num_rows == 0)
			{
					return $plant_menu; //return empty string
			}
			else
			{
				$plant_menu = '<select name="speciesid" class="select" id="speciesid" tabindex="2">
				<option value="0" selected="selected">Select</option>';
				while ($row = $plant_group_set->fetch_object())
				{
					$speciesid = $row->Species_ID;
					
					//get species common name to display
					$qry2 = sprintf("SELECT Common_Name from tbl_species WHERE Species_ID= %d", $speciesid);
					$check2 = $p_dbh->query($qry2);
					if(!$check2)
					{
						return  $plant_menu; //return empty string
					}
					
					$row2 = $check2->fetch_object();
					$plant_menu .= '<option value="';
					$plant_menu .= $speciesid;
					$plant_menu .= '">';
					$plant_menu .= $row2->Common_Name;
					$plant_menu .= '</option>';
				 } //while
				 // add --Other-- option at end of list
				 $plant_menu .= '<option value="999">-- Other --</option>';
				$plant_menu .= '</select>';
			}			
			return $plant_menu;
}

//get plants in plant group including user-defined ones
function get_plants_in_single_report_plant_groups($p_dbh, $p_plantgroupid){
	$qry = sprintf("SELECT DISTINCT PG.Plant_Group_Name, PG.Plant_Group_ID, S.Common_Name, S.Species_ID  
					FROM tbl_plant_groups as PG
					JOIN rel_plantgroup_protocol as PGP on (PG.Plant_Group_ID = PGP.Plant_Group_ID)
					JOIN tbl_protocols as P on (PGP.Protocol_ID = P.Protocol_ID) 
					JOIN rel_species_protocol as SP on (P.Protocol_ID = SP.Protocol_ID)
					JOIN tbl_species as S on (SP.Species_ID = S.Species_ID)
					WHERE PG.Plant_Group_ID = '%d' AND S.Species_ID < 999 ORDER BY S.Common_Name ASC", $p_plantgroupid,'%0%');
	//echo($qry);
	$result = $p_dbh->query($qry);
	return $result;
}

/*function build_state_menu($p_state,$p_dbh){
	if $p_state != '')
		$qry="SELECT State_Name from tbl_states WHERE State_Code='$p_state' ";
		$check = $p_dbh->query($qry);
		while ($row = $check->fetch_object()) {
			$statename= $row->State_Name;
		}
}*/

function get_other_speciesID($p_dbh){
	$speciesid=0; 

	$qry = "SELECT Species_ID from tbl_species WHERE Common_Name='--Other--' ";
	$check = $p_dbh->query($qry);
	while ($row = $check->fetch_object()) {
		$speciesid = $row->Species_ID;
	}
	return $speciesid;
}

// EDITED BY DENNIS WARD ON 13 OCT 2011 TO GET RID OF THE 3, 13 "RACHAEL CARSON" BUG 
//returns listing of special project species
function get_specialproject_species($p_dbh, $p_spID){
		$sp_ID_wildcard = '%' . $p_spID . '%';
		$qry = sprintf("SELECT * from tbl_species WHERE FIND_IN_SET('%s', User_Defined) ORDER BY Common_Name", $p_spID);
		//$qry = sprintf("SELECT * from tbl_species WHERE User_Defined LIKE '%s' ORDER BY Common_Name", $sp_ID_wildcard);
		//echo $qry;
		$result = $p_dbh->query($qry);
		if ($result->num_rows == 0) {
				return 0; //return empty string
		}
		else return $result;

}

//get number of PBB targeted species
function get_no_PBBspecies($p_dbh){
	//remove comment from next line - RR 2012-09-05
	$otherID = get_other_speciesID($p_dbh);
 	$qry = sprintf("SELECT Count(*) as C FROM tbl_species Where Species_ID< %d AND User_Defined LIKE '%s'", $otherID, '%0%');
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return 0;}
		else {
			$row = $result->fetch_object();
			$count = $row->C;
			return $count;
		}	 
}

//get number of ALL PBB species
function get_all_PBBspecies($p_dbh){
 	$qry = sprintf("SELECT Count(*) as C FROM tbl_species Where Species_ID< '999' ");
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return 0;}
		else {
			$row = $result->fetch_object();
			$count = $row->C;
			return $count;
		}	 
}

//get plant groups
function get_plant_groups($p_dbh){
	$qry = "SELECT Plant_Group_Name, Plant_Group_ID, Definition FROM tbl_plant_groups Where Display_Flag = 1";
	$result = $p_dbh->query($qry);
	return $result;
}

function get_plant_groups_all($p_dbh){
	$qry = "SELECT Plant_Group_Name, Plant_Group_ID, Definition FROM tbl_plant_groups ORDER By Plant_Group_ID ASC";
	$result = $p_dbh->query($qry);
	return $result;


}

//get plant groups
function get_plant_group($p_dbh, $p_plantGroupID)
{
	//$qry = sprintf("SELECT Plant_Group_Name, Plant_Group_ID, Definition FROM tbl_plant_groups Where Plant_Group_ID = %d", $p_plantGroupID);
	$qry=("SELECT Plant_Group_Name, Plant_Group_ID, Definition FROM tbl_plant_groups Where Plant_Group_ID = ".$p_plantGroupID);
	//echo("qry=$qry;");
	$result = $p_dbh->query($qry);
	return $result;
}

//Display_Flag = 1 AND 

//get number of plant groups
function get_plant_group_no($p_dbh){
$qry = "SELECT Count(*) as C FROM tbl_plant_groups Where Display_Flag = 1";
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return 0;}
		else {
			$row = $result->fetch_object();
			$count = $row->C;
			return $count;
		}	 
}

function get_plant_group_imageID($p_dbh, $p_plantGroupID)
{
	$qry = sprintf(" SELECT S.Species_ID
	FROM tbl_plant_groups AS PG
	JOIN rel_plantgroup_protocol AS PGP ON ( PG.Plant_Group_ID = PGP.Plant_Group_ID )
	JOIN tbl_protocols AS P ON ( PGP.Protocol_ID = P.Protocol_ID )
	JOIN rel_species_protocol AS SP ON ( P.Protocol_ID = SP.Protocol_ID )
	JOIN tbl_species AS S ON ( SP.Species_ID = S.Species_ID )
	WHERE PG.Plant_Group_ID =%d
	ORDER BY S.Common_Name ASC
	LIMIT 1 ", $p_plantGroupID);
		$result = $p_dbh->query($qry);
		if ($result->num_rows == 0) { return 0;}
			else {
				$row = $result->fetch_object();
				$imgID = $row->Species_ID;
				return $imgID;
			}	
}

//get plant group ID for specific plant
function get_plant_group_ID($p_dbh, $p_speciesid){
	$qry = sprintf("SELECT PG.Plant_Group_ID
				FROM tbl_plant_groups as PG
				JOIN rel_plantgroup_protocol as PGP on (PG.Plant_Group_ID = PGP.Plant_Group_ID)
				JOIN tbl_protocols as P on (PGP.Protocol_ID = P.Protocol_ID) 
				JOIN rel_species_protocol as SP on (P.Protocol_ID = SP.Protocol_ID)
				JOIN tbl_species as S on (SP.Species_ID = S.Species_ID)
				WHERE S.Species_ID = '%d'", $p_speciesid);
	//echo("qry=$qry");
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return NULL;}
	else {
		$row = $result->fetch_object();
		return $row->Plant_Group_ID;
	}	 
}

//get plant group definition
function get_plant_group_defn($p_dbh, $p_plantgroupID){

}

//get plants in plant group including user-defined ones
function get_PBBplants_in_plant_group($p_dbh, $p_plantgroupid){
	//removed $qry to remove reference to User_Defined field
	//$qry = sprintf("SELECT PG.Plant_Group_Name, PG.Plant_Group_ID, S.Common_Name, S.Species_ID  
	//				FROM tbl_plant_groups as PG
	//				JOIN rel_plantgroup_protocol as PGP on (PG.Plant_Group_ID = PGP.Plant_Group_ID)
	//				JOIN tbl_protocols as P on (PGP.Protocol_ID = P.Protocol_ID) 
	//				JOIN rel_species_protocol as SP on (P.Protocol_ID = SP.Protocol_ID)
	//				JOIN tbl_species as S on (SP.Species_ID = S.Species_ID)
	//				WHERE S.Species_ID < '999' AND PG.Plant_Group_ID = '%d' AND S.User_Defined LIKE '%s' ORDER BY S.Common_Name ASC", $p_plantgroupid,'0%');
	
	$qry = sprintf("SELECT DISTINCT PG.Plant_Group_Name, PG.Plant_Group_ID, S.Common_Name, S.Species_ID  
					FROM tbl_plant_groups as PG
					JOIN rel_plantgroup_protocol as PGP on (PG.Plant_Group_ID = PGP.Plant_Group_ID)
					JOIN tbl_protocols as P on (PGP.Protocol_ID = P.Protocol_ID) 
					JOIN rel_species_protocol as SP on (P.Protocol_ID = SP.Protocol_ID)
					JOIN tbl_species as S on (SP.Species_ID = S.Species_ID)
					WHERE PG.Plant_Group_ID = '%d' AND S.Species_ID < 999 ORDER BY S.Common_Name ASC", $p_plantgroupid,'%0%');
	
	$result = $p_dbh->query($qry);
	return $result;
}

//get plants in plant group including user-defined ones
function get_plants_in_plant_group($p_dbh, $p_plantgroupid){
	$qry = sprintf("SELECT DISTINCT PG.Plant_Group_Name, PG.Plant_Group_ID, S.Common_Name, S.Species_ID  
					FROM tbl_plant_groups as PG
					JOIN rel_plantgroup_protocol as PGP on (PG.Plant_Group_ID = PGP.Plant_Group_ID)
					JOIN tbl_protocols as P on (PGP.Protocol_ID = P.Protocol_ID) 
					JOIN rel_species_protocol as SP on (P.Protocol_ID = SP.Protocol_ID)
					JOIN tbl_species as S on (SP.Species_ID = S.Species_ID)
					WHERE PG.Plant_Group_ID = '%d' AND S.User_Defined LIKE '%s' ORDER BY S.Common_Name ASC", $p_plantgroupid,'%0%');
	//echo($qry);
	$result = $p_dbh->query($qry);
	return $result;
}

//get protocol id based on plant group id - default to insect pollination
function get_protocol_id($p_dhb, $p_plantgroupid){
	$qry = sprintf("SELECT Min(P.Protocol_ID) as Protocol_ID FROM `tbl_protocols` as P
		JOIN rel_plantgroup_protocol as PGP on (P.Protocol_ID=PGP.Protocol_ID)
		JOIN tbl_plant_groups as PG using (Plant_Group_ID)
		WHERE PG.Plant_Group_ID = %d", $p_plantgroupid);
	//echo $qry;
	$result = $p_dhb->query($qry);
	if ($result->num_rows == 0) { return NULL;}
		else {
			$row = $result->fetch_object();
			return $row->Protocol_ID;
		}	 
}

function get_other_protocol_id($p_dbh){
	$qry = 'SELECT P.Protocol_ID FROM `tbl_protocols` as P
JOIN rel_plantgroup_protocol as PGP on (P.Protocol_ID=PGP.Protocol_ID)
		JOIN tbl_plant_groups as PG using (Plant_Group_ID)
		WHERE PG.Plant_Group_Name LIKE "%Other%"';
		//echo $qry;
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return NULL;}
		else {
			$row = $result->fetch_object();
			return $row->Protocol_ID;
		}	 

}

//get common name for plant by Species_ID
function get_common_name($p_dbh, $p_speciesid){
	$qry = sprintf("SELECT Common_Name, Species FROM tbl_species WHERE Species_ID ='%d'", $p_speciesid);
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return NULL;}
		else {
			$row = $result->fetch_object();
			return $row->Common_Name;
		}
}

//get scientific name for plant by Species_ID
function get_scientific_name($p_dbh, $p_speciesid){
	$qry = sprintf("SELECT Common_Name, Species FROM tbl_species WHERE Species_ID ='%d'", $p_speciesid);
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return NULL;}
		else {
			$row = $result->fetch_object();
			return $row->Species;
		}
}

//get common name for plant by Species_ID
function get_plant($p_dbh, $p_speciesid){
	$qry = sprintf("SELECT Common_Name, Species FROM tbl_species WHERE Species_ID ='%d'", $p_speciesid);
	$result = $p_dbh->query($qry);
	return $result;
}

//get phenophases for specific Protocol
function get_phenophases_protocol($p_dbh, $p_protocol)
{
	$qry = sprintf("SELECT * FROM tbl_phenophases as P JOIN rel_protocol_phenophase as PP on ( P.Phenophase_ID= PP.Phenophase_ID) WHERE PP.Protocol_ID = %d ORDER BY P.Chrono_Order ASC", $p_protocol);
	
	//echo $qry;
	//echo "Error message = " . mysqli_error($p_dbh) . "<br>";
	
	$result = $p_dbh->query($qry);

	return $result;
}

//get phenophases for specific species
function get_phenophase_species($p_dbh, $p_speciesid)
{
	$qry = sprintf("SELECT PP.Phenophase_Name, PP.Comment, PP.Chrono_Order, PP.Phenophase_ID, PP.Protocol_ID  
					FROM tbl_phenophases as PP
					JOIN rel_species_protocol as SP on (PP.Protocol_ID = SP.Protocol_ID)
					WHERE SP.Species_ID = '%d' ORDER BY PP.Chrono_Order ASC", $p_speciesid);	
	//echo("qry=$qry");
	$result = $p_dbh->query($qry);
	return $result;
}

//get phenophases for specific species
function get_phenophasename_species($p_dbh, $p_speciesid)
{
	$qry = sprintf("SELECT * FROM tbl_phenophases WHERE Phenophase_ID =' $p_speciesid'");	
	//echo("qry=$qry");
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return NULL;}
		else {
			$row = $result->fetch_object();
			return $row->Phenophase_Name;
		}
}

// get phenophases by plant group
function get_phenophase_plant_group($p_dbh, $p_plantGroupId)
{			
	$qry = sprintf("SELECT DISTINCT P.Phenophase_Name, P.Comment, P.Phenophase_ID, Plant_Group_ID, P.Chrono_Order 
			FROM tbl_phenophases as P
			WHERE P.Plant_Group_ID = %d
			ORDER BY Chrono_Order ASC", $p_plantGroupId);
	$result = $p_dbh->query($qry);
	return $result;
}

function get_phenophases_plant_group_name($p_dbh, $p_plantgroupname){
	// get phenophases based on plant group name (built for occosional obs)
	// gjn, note there are no plantgroupid values for occ obs phenophases (values greater than 100) so we match on name
	//echo("qry=$p_plantgroupname");
	/*
	$qry = sprintf("SELECT P.Phenophase_Name, P.Comment, P.Phenophase_ID, Plant_Group_ID FROM tbl_phenophases as P
			WHERE P.Phenophase_Name = '%d'
			ORDER BY Chrono_Order ASC", $p_plantgroupname);
	*/
	$qry = "SELECT P.Phenophase_Name, P.Comment, P.Phenophase_ID, Plant_Group_ID FROM tbl_phenophases as P
			WHERE P.Plant_Group = '".$p_plantgroupname."'
			ORDER BY Chrono_Order ASC";
	
	//echo("qry=$qry");
	$result = $p_dbh->query($qry);
	return $result;
}

function get_phenophase_all_2011($p_dbh)
{
	$qry = "SELECT P.Phenophase_Name, P.Comment, P.Chrono_Order, P.Phenophase_ID FROM tbl_phenophases as P
			ORDER BY Chrono_Order ASC";
	$result = $p_dbh->query($qry);
	return $result;
}

//get protocol id
function get_protocol_byspecies($p_dbh, $p_speciesid){
	$qry = sprintf("SELECT Protocol_ID FROM rel_species_protocol WHERE Species_ID = %d", $p_speciesid);
	//echo $qry;
	//echo "<br>";
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { return 0;}
	else {
			$row = $result->fetch_object();
			$id= $row->Protocol_ID;
			return $id;
	}	

}

//get Identification Guide content for specific specie
function get_id_guide($p_dbh, $p_speciesid)
{
	$qry = sprintf("SELECT * FROM tbl_id_guides WHERE Species_ID =%d", $p_speciesid);
	$result = $p_dbh->query($qry);
	return $result;
}

//assumed logged in before calling this function
//returns a string of special ids 
function get_SpecialProjectsID($p_stationid, $p_dbh){
	
	$qry = sprintf("SELECT Special_Project_Participation FROM tbl_stations WHERE Station_ID = %d ", $p_stationid);
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0) { 
		return 0 ;//default PBB General participation
	}
		else {
			$row = $result->fetch_object();
			$spID = $row->Special_Project_Participation;
			return $spID;
		}

}

//assumed logged in before calling this function
function get_personID($p_dbh){

			$qry = sprintf("SELECT Person_ID from tbl_users WHERE BINARY UserName = '%s'",
			$p_dbh->real_escape_string($_SESSION['username']) );
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$personid = $row->Person_ID;
			return $personid;
}

//
function get_k12teacher($p_dbh){

			$qry = sprintf("SELECT K12teacher from tbl_people as P JOIN tbl_users as U on (P.Person_ID = U.Person_ID) WHERE BINARY UserName = '%s'",
								$p_dbh->real_escape_string($_SESSION['username']) );
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			} 
			$row = $check->fetch_object();
			$teacher = $row->K12teacher;
			return $teacher;
}

//K42110 added function to determine member level (teacher, reporter, ...) based on logged in Username
function get_MemberLevel($p_dbh){

			$qry = sprintf("SELECT Member_Level from tbl_people as P JOIN tbl_users as U on (P.Person_ID = U.Person_ID) WHERE BINARY UserName = '%s'",
								$p_dbh->real_escape_string($_SESSION['username']) );
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$MemberLevel = $row->Member_Level;
			return $MemberLevel;
}

//get station name
function get_StationName($p_dbh, $p_stationid){

			$qry = sprintf("SELECT Station_Name from tbl_stations WHERE Station_ID = %d",$p_stationid);
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$statioName = $row->Station_Name;
			return $statioName;
}

function get_username_byPersonID($p_personid, $p_dbh){
			$qry = sprintf("SELECT UserName from tbl_users WHERE Person_ID = %d",$p_personid );
			
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$username = $row->UserName;
			return $username;
}

//added on 4/25/2012 for password update page
function get_PersonID_byUserName($p_personid, $p_dbh){
			$qry = sprintf("SELECT Person_ID from tbl_users WHERE BINARY UserName = %d",$p_personid );
			
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$username = $row->UserName;

			return $username;
}

//added to fetch user_id from username - Rick R. 20-Nov-2012
function get_UserID_byUserName($p_username, $p_dbh){
			$qry = sprintf("SELECT User_ID from tbl_users WHERE BINARY UserName = '%s'", $p_dbh->real_escape_string($p_username) );
			
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$userid = $row->User_ID;

			return $userid;
}



function get_user_obs($p_personid, $p_stationid, $p_speciesid, $p_dbh)
{		   
    $qry=sprintf("SELECT * from tbl_observations WHERE Observer_ID = %d AND Station_ID = %d AND Species_ID = %d ORDER BY Phenophase_ID",$p_personid,$p_stationid,$p_speciesid);
			
	echo $qry;
	$result = $p_dbh->query($qry);
	return $result;
}

// GJN get all user ids for a given station and given species and given phenophase
function get_user_obs_pp($p_personid, $p_stationid, $p_speciesid, $p_ppid, $p_dbh)
{		   
    $qry=sprintf("SELECT * from tbl_observations WHERE Observer_ID = %d AND Station_ID = %d AND Species_ID = %d AND Phenophase_ID = %d ORDER BY Observation_Date DESC LIMIT 0,1 ",$p_personid,$p_stationid,$p_speciesid,$p_ppid);
			
	//echo $qry;
	$result = $p_dbh->query($qry);
	return $result;
}

//KKM get observations based only on station ID and species ID - independent of user who reported
//re-ordered the reported observations by Phenophase_Order instead of Phenophase_ID
function get_station_obs($p_stationid, $p_speciesid, $p_dbh){
	$qry = sprintf("
	SELECT O.* from tbl_observations as O 
	JOIN rel_species_protocol as SP on (O.Species_ID = SP.Species_ID)
	LEFT JOIN rel_protocol_phenophase as PP on (O.Phenophase_ID = PP.Phenophase_ID AND SP.Protocol_ID = PP.Protocol_ID)
	WHERE O.Station_ID = %d AND O.Species_ID = %d 
	ORDER BY PP.Phenophase_Order", $p_stationid, $p_speciesid);

			//echo $qry;
			$result = $p_dbh->query($qry);
			return $result;
}

function get_user_current_obs($p_personid, $p_stationid, $p_speciesid, $p_dbh){
		   
		    $qry = sprintf("SELECT * from tbl_observations WHERE Observer_ID = %d 
							AND Station_ID = %d AND Species_ID = %d 
							AND Observation_Date >= %s 
							ORDER BY Phenophase_ID",
							$current_year, $p_personid, $p_stationid, $p_speciesid);
			
			//echo $qry;
			$result = $p_dbh->query($qry);
			return $result;

}

function get_Species($p_speciesid,$p_dbh){
		$qry = sprintf("SELECT * from tbl_species WHERE Species_ID = %d",$p_speciesid );
		$result = $p_dbh->query($qry);
		return $result;

}

function get_personID_byEmail($p_email, $p_dbh){
			$qry = sprintf("SELECT Person_ID from tbl_people WHERE email = '%s'",
								$p_dbh->real_escape_string($p_email) );
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			}
			$row = $check->fetch_object();
			$personid = $row->Person_ID;
			return $personid;
}

function get_email_byUsername($p_dbh){

			$qry = sprintf("SELECT email from tbl_people as P JOIN User as U on (P.Person_ID = U.Person_ID) WHERE BINARY UserName = '%s'",
								$p_dbh->real_escape_string($_SESSION['username']) );
			$check = $p_dbh->query($qry);
			if ($check->num_rows == 0) {
				return 0;
			} 
			$row = $check->fetch_object();
			$email = $row->email;
			return $email;
}

/** code courtesy of http://www.totallyphp.co.uk
 * The letter l (lowercase L) and the number 1
 * have been removed, as they can be mistaken
 * for each other.
 */
function createRandomPassword() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
       $i++;
    }

    return $pass;
}

function update_userPassword($p_personid, $p_newpasswd, $p_dbh){
	//hash new password
	$newpassword_hash = hash("sha512",$p_newpasswd);
	
	//update User table
	$qry = sprintf("UPDATE tbl_users SET Passwd_Hash = '%s' WHERE Person_ID='%s'", 
							$p_dbh->real_escape_string($newpassword_hash),
							$p_dbh->real_escape_string($p_personid));	
	$result = $p_dbh->query($qry);
	return $result;
}

function check_Active_User($p_uname, $p_dbh)
{

}

/*********************************************************/
// Main webpage functions for Project Budburst
// Written by: Greg Newman / Newman Designs
/*********************************************************/

function GetBaseURL()
{
	//  BE SURE THAT THE - AND + VALUES IN THE LINE BELOW MATCH THE LENGTH OF THE PATH STRING !!!
	$root=substr_compare(BASE_URL,"/budburst2",-10,10); // 0 if at root; 1 if not at root and instead one level deeper
	
	if ($root===0) // if at root for budburst folder
	{
		$base_url="";
	}
	else
	{
		$base_url="../";
	}
	
	return $base_url;
}

function HeaderStart($page_title)
{

$base_url=GetBaseURL();

echo("<head profile='http://www.w3.org/2005/10/profile'>
\t<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
\t<meta http-equiv='Cache-Control' content='no-cache'>
\t<meta http-equiv='Pragma' content='no-cache'>
\t<meta http-equiv='expires' content='FRI, 13 APR 1999 01:00:00 GMT'>
\t<meta name='keywords' content='Project BudBurst,BudBurst,Phenology,Plant Phenology,Citizen Science,Climate Change,BudBurst Buddies,NEON,Chicago Botanic Gardens' />
\t<title>".$page_title."</title>
\t<link rel='icon' type='image/png' href='".$base_url."images/favicon.png'>
\t<link href='".$base_url."stylesheets/Project_BudBurst.css' rel='stylesheet' type='text/css' media='screen'/>
\t<link href='".$base_url."stylesheets/dropdown.css' media='screen' rel='stylesheet' type='text/css' />
\t<link href='".$base_url."stylesheets/plantresourceredesign.css' media='screen' rel='stylesheet' type='text/css' />
\t<link href='".$base_url."stylesheets/PBB_PageSectionStyles.css' media='screen' rel='stylesheet' type='text/css' />");

}

function HeaderEnd()
{
echo("\n</head>\n");
}

function WriteTopLogin($dbh)
//
// This function writes out the login/logout button in the 
// upper right hand corner depending on login/logout status
//
{
	$base_url=GetBaseURL();
	
	if(!checklogin($dbh))
    {
		$welcome_text="Welcome guest";
		
		$button_class="Login";
		$action=$base_url."login.php";
	}
	else
	{
		$welcome_text="Welcome ";
        $welcome_text.=$_SESSION['username'];
        
		$button_class="Logout";
		$action=$base_url."logout_do.php";
	}
	
	echo("<div id='TopBanner'><a  href='".$base_url."index.php'><h1>Project BudBurst</h1></a></div>");
	echo(" <div id='NEONCS'><span class='CSAdjust'><a href='http://neoninc.org'><img src='".$base_url."./images/NEON_WhiteLogo.png' width='50' height='15' alt='The National Ecological Observatory Network' /> Citizen Science </a>|</span><a href='http://www.nsf.gov' target='_blank'> <span class='CSAdjust'>Sponsored by the National Science Foundation </span><img src='".$base_url."./images/nsfLogo_White.png' width='22' height='22' alt='The National Science Foundation' /></a></div>");
	echo("<div id='LoginText'>".$welcome_text."</div>");
    
    echo("<a href='".$action."' alt='".$button_class."' title='".$button_class."'><div id='".$button_class."'></div></a>");
	
	echo("\n");
}

/*********************************************************/
// Edited  by L. A. Wasser - October 2012
// With support from Chaya de Cacao
// converted graphic based links to text based.
/*********************************************************/

function WriteTopNavigation()
{
	$base_url=GetBaseURL();
	
	echo("<div id='TopNavigation'>
			<ul class='dropdown dropdown-horizontal'>
				<li><a href='".$base_url."getstarted.php' id='TopNavigation_AboutUs' alt='Get Started' title='About'>Get Started</a>
					<ul>
						<li class='AboutUs'><a href='".$base_url."getstarted.php' alt='Home' title='Home'><span id='SubNavElement'>Get Started</span></a></li>
						<li class='AboutUs'><a href='".$base_url."getstarted-regular-report.php' alt='Regular Observation' title='Regular Report'><span id='SubNavElement'>&ndash;&#8202;Regular Report</span></a></li>
						<li class='AboutUs'><a href='".$base_url."getstarted-single-report.php' alt='Single Report' title='Single Report'><span id='SubNavElement'>&ndash;&#8202;Single Report</span></a></li>
						<li class='AboutUs'><a href='".$base_url."cherry/index.php' alt='Cherry Blossom Blitz' title='Cherry Blossom Blitz'><span id='SubNavElement'>Cherry Blossom Blitz</span></a></li>
						<li class='AboutUs'><a href='".$base_url."summer/index.php' alt='Summer Solstice Snapshot' title='Summer Solstice Snapshot'><span id='SubNavElement'>Summer Solstice Snapshop</span></a></li>
						<li class='AboutUs'><a href='".$base_url."fall/index.php' alt='Fall into Phenology' title='Fall into Phenology'><span id='SubNavElement'>Fall into Phenology</span></a></li>
						<li class='AboutUs'><a href='".$base_url."aboutus.php' alt='Home' title='Home'><span id='SubNavElement'>About Project BudBurst</span></a></li>
						<li class='AboutUs'><a href='".$base_url."getstarted_Media.php' alt='PBB Media' title='PBB Media'><span id='SubNavElement'>&ndash;&#8202;Media </span></a></li>
						<li class='AboutUs'><a href='".$base_url."gomobile.php' alt='Go Mobile' title='Go Mobile'><span id='SubNavElement'>&ndash;&#8202;Android Mobile App</span></a></li>				
						
					</ul>
				</li>
				<li><a href='".$base_url."choose.php' id='TopNavigation_PlantResources' alt='Plant Resources' title='Plant Resources'>Choose a Plant</a>
					<ul>
						<li class='PlantResources'><a href='".$base_url."choose.php' alt='Plant Resources' title='Plant Resources'><span id='SubNavElement'>Choose a Plant</span></a></li>
						<li class='PlantResources'><a href='".$base_url."display_all_plants_list.php' alt='All Plants' title='All Plants'><span id='SubNavElement'>View All Plants</span></a></li>						
						<li class='PlantResources'><a href='".$base_url."plantresources_list.php?PlantGroupID=1' alt='Wildflowers and Herbs' title='Wildflowers and Herbs'><span id='SubNavElement'>&ndash;&#8202;Wildflowers &amp; Herbs</span></a></li>
						<li class='PlantResources'><a href='".$base_url."plantresources_list.php?PlantGroupID=2' alt='Grasses' title='Grasses'><span id='SubNavElement'>&ndash;&#8202;Grasses</span></a></li>
						<li class='PlantResources'><a href='".$base_url."plantresources_list.php?PlantGroupID=3' alt='Deciduous Trees and Shrubs' title='Deciduous Trees and Shrubs'><span id='SubNavElement'>&ndash;&#8202;Deciduous</span></a></li>
						<li class='PlantResources'><a href='".$base_url."plantresources_list.php?PlantGroupID=4' alt='Evergreen Trees and Shrubs' title='Evergreen Trees and Shrubs'><span id='SubNavElement'>&ndash;&#8202;Evergreens</span></a></li>
						<li class='PlantResources'><a href='".$base_url."plantresources_list.php?PlantGroupID=5' alt='Conifers' title='Conifers'><span id='SubNavElement'>&ndash;&#8202;Conifers</span></a></li>
						<li class='PlantResources'><a href='".$base_url."plantresources_list_bystate.php' alt='Plants By State' title='PLants By State'><span id='SubNavElement'>Plants By State</span></a></li>
						<li class='PlantResources'><a href='".$base_url."mostwanted.php' alt='Top Ten Species' title='Top Ten Species'><span id='SubNavElement'>10 Most Wanted</span></a></li>
					</ul>
				</li>
				<li><a href='".$base_url."partners.php' id='TopNavigation_Partners' alt='PBB Partners' title='PBB Partners!'>Partners</a>
					<ul>
						<li class='Partners'><a href='".$base_url."partners.php' alt='PBB Partners' title='PBB Partners'><span id='SubNavElement'>Partners</span></a></li>
						<li class='Partners'><a href='".$base_url."refuges/index.php' alt='Wildlife Refuges' title='Wildlife Refuges'><span id='SubNavElement'>Wildlife Refuges</span></a></li>
						<li class='Partners'><a href='".$base_url."gardens/index.php' alt='Botanic Gardens' title='Botanic Gardens'><span id='SubNavElement'>Botanic Gardens</span></a></li>
						<li class='Partners'><a href='".$base_url."parks/index.php' alt='National Parks' title='National Parks'><span id='SubNavElement'>National Parks</span></a></li>
						<li class='Partners'><a href='".$base_url."community/index.php' alt='Community BudBurst' title='Community BudBurst'><span id='SubNavElement'>Community BudBurst</span></a></li>
						<li class='Partners'><a href='".$base_url."urbantree/index.php' alt='Urban Trees' title='Urban Trees'><span id='SubNavElement'>Urban Trees</span></a></li>
					</ul>
				</li>
				
				<li><a href='".$base_url."educators/index.php' id='TopNavigation_Education' alt='Education' title='Education'>Education</a>
					<ul>
						<li class='Education'><a href='".$base_url."educators/index.php' alt='Home' title='Home'><span id='SubNavElement'>Education</span></a></li>
						<li class='Education'><a href='".$base_url."educators/educator_K_4.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Grade K-4 </span></a></li>
						<li class='Education'><a href='".$base_url."educators/educator_5_8.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Grade 5-8 </span></a></li>
						<li class='Education'><a href='".$base_url."educators/educator_9_12.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Grade 9-12 </span></a></li>
						<li class='Education'><a href='".$base_url."educators/educator_informal.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;Informal Ed </span></a></li>
						<li class='Education'><a href='".$base_url."educators/educator_uni.php' alt='Home' title='Home'><span id='SubNavElement'>&ndash;&#8202;University Ed </span></a></li>
						<li class='Education'><a href='".$base_url."educators/educators_CSA.php' alt='Home' title='Home'><span id='SubNavElement'>Academy Online</span></a></li>
					<!--	<li class='Education'><a href='".$base_url."educators/edu_resources.php' alt='Home' title='Home'><span id='SubNavElement'>Educator Resources</span></a></li> -->
						<li class='Education'><a href='".$base_url."buddies/index.php' target='NewWindow' alt='BudBurst Buddies' title='BudBurst Buddies'><span id='SubNavElement'>BudBurst Buddies</span></a></li>
					</ul>
				</li>
				
				<li><a href='".$base_url."science/phenology.php' id='TopNavigation_Phenology' alt='Phenology' title='Phenology'>Science</a>
					<ul>
						<li class='Phenology'><a href='".$base_url."science/phenology.php' alt='Phenology Defined' title='Phenology Defined'><span id='SubNavElement'>Science</span></a></li>
						<li class='Phenology'><a href='".$base_url."science/phenology_defined.php' alt='Phenology Defined' title='Phenology Defined'><span id='SubNavElement'>Phenology Defined</span></a></li>
						<li class='Phenology'><a href='".$base_url."science/phenology_climatechange.php' alt='Climate Change' title='Climate Change'><span id='SubNavElement'>Climate Change</span></a></li>
						<li class='Phenology'><a href='".$base_url."science/phenology_whyphenology.php' alt='Why Phenology?' title='Why Phenology?'><span id='SubNavElement'>Why Phenology?</span></a></li>
						<li class='Phenology'><a href='".$base_url."science/phenology_history.php' alt='History' title='History'><span id='SubNavElement'>History</span></a></li>
						<li class='Phenology'><a href='".$base_url."science/phenology_phenologytoday.php' alt='Phenology Today' title='Phenology Today'><span id='SubNavElement'>Phenology Today</span></a></li>
					</ul>
				</li>
				
				<li><a href='".$base_url."results_data.php' id='TopNavigation_Data' alt='View Results' title='View Results'>Data</a>
					<ul>
						<li class='Data'><a href='".$base_url."results_data.php' alt='Data' title='Data'><span id='SubNavElement'>Data</span></a></li>
						<li class='Data'><a href='".$base_url."results.php' alt='Data' title='Data'><span id='SubNavElement'>Data Map</span></a></li>
						<!-- <li class='Data'><a href='".$base_url."results_data.php' alt='Data' title='Data'><span id='SubNavElement'>About Our Data</span></a></li> -->
						<li class='Data'><a href='".$base_url."results_byphenophase.php?Phenophase_ID=flower' alt='By Phenophase' title='By Phenophase'><span id='SubNavElement'>Map By Phenophase</span></a></li>
						<li class='Data'><a href='".$base_url."results_attribution.php' alt='Data' title='Data'><span id='SubNavElement'>Community Attribution</span></a></li>
						<li class='Data'><a href='".$base_url."fieldscope.php' alt='Data' title='Data'><span id='SubNavElement'>NGS FieldScope</span></a></li>
						<li class='Data'><a href='".$base_url."fieldscope.php' alt='Data' title='Data'><span id='SubNavElement'>&ndash;&#8202;Open Viewer</span></a></li>
						<li class='Data'><a href='".$base_url."fieldscope_seasons.php' alt='Data' title='Data'><span id='SubNavElement'>&ndash;&#8202;Seasonality</span></a></li>
					</ul>
				</li>
				<li><a href='".$base_url."mybudburst.php' id='TopNavigation_MyBudBurst' alt='My BudBurst' title='My BudBurst'>My BudBurst</a>
				<ul>
						<li class='MyBudBurst'><a href='".$base_url."mybudburst.php' alt='Data' title='Data'><span id='SubNavElement'>My BudBurst</span></a></li>
						<li class='MyBudBurst'><a href='".$base_url."my_regular_reports.php' alt='Data' title='Data'><span id='SubNavElement'>Regular Reports Page</span></a></li>
						<li class='MyBudBurst'><a href='".$base_url."my_account.php' alt='Data' title='Data'><span id='SubNavElement'>Manage Account</span></a></li>
					</ul>
				</li>
			</ul>
		</div>");
}

function WriteFooterNavigation()
{
	$base_url=GetBaseURL();
	$current_year = date("Y");
	echo("
    <div id='FooterNavigation'>
        <ul>
            <li><a href='".$base_url."staff.php' id='FooterNavigation_Staff' alt='Staff' title='Staff'>Staff</a></li>
            <li><a href='".$base_url."contactus.php' id='FooterNavigation_ContactUs' alt='Contact Us' title='Contact Us'>Contact Us</a></li>
            <li><a href='".$base_url."sponsors.php' id='FooterNavigation_Partners' alt='Sponsors' title='Sponsors'>Sponsors</a></li>
            <li><a href='".$base_url."policies.php' id='FooterNavigation_Policies' alt='Policies' title='Policies'>Policies</a></li>
            <li><a href='".$base_url."credits.php' id='FooterNavigation_Credits' alt='Credits' title='Credits'>Credits</a></li>
            <li><a href='".$base_url."sitemap.php' id='FooterNavigation_SiteMap' alt='Site Map' title='Site Map'>Site Map</a></li>
        </ul>
        <br />
        <br />
        Project Budburst<sup class='sm'>SM</sup> is co-managed by NEON and the Chicago Botanic Garden<br />&copy; ".$current_year. " <a style=\"color:white;\" href='http://neoninc.org'>National Ecological Observatory Network, Inc.</a> All rights reserved. 
    </div>");
}

function WriteGoogleAnalytics()
{
	echo("<!-- Google Analytics -->
<script type=\"text/javascript\">
var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
</script>
<script type=\"text/javascript\">
try {
\tvar pageTracker = _gat._getTracker(\"UA-37863348-1\");
\tpageTracker._trackPageview();
} catch(err) {}
</script>
<!-- Google Analytics -->

<!-- Google Analytics -->
<script type=\"text/javascript\">
var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
</script>
<script type=\"text/javascript\">
try {
\tvar benchmarkTracker = _gat._getTracker(\"UA-10666744-1\");
\tbenchmarkTracker._trackPageview();
\tvar siteTracker = _gat._getTracker(\"UA-10666744-1\");
\tsiteTracker._trackPageview();
} catch(err) {}
</script>
<!-- end Google Analytics -->\n");
}

//added - Rick Rose - 17-Sep-2012
//for single report - builds JSON string of species passed to jQuery for jQuery UI autocomplete functionality
function build_species_JSON_single_report($p_dbh, $p_plantgroupid)
{
	$plant_menu='';
	
	//get list of budburst plants from selected PlantGroupID
	$plant_group_set = get_plants_in_single_report_plant_groups($p_dbh,$p_plantgroupid);
	
	if ($plant_group_set->num_rows == 0)
	{
			return $plant_menu; //return empty string
	}
	else
	{
		$plant_menu = '[';
		
		while ($row = $plant_group_set->fetch_object())
		{
			$speciesid = $row->Species_ID;
			
			//get species common name to display
			$qry2 = sprintf("SELECT * from tbl_species WHERE Species_ID= %d", $speciesid);
			$check2 = $p_dbh->query($qry2);
			if(!$check2)
			{
				return  $plant_menu; //return empty string
			}
			
			//fetch a row
			$row2 = $check2->fetch_object();
			
			//skip over species 999-Other in tbl_species because it sorts by alpha to the top of the pull down menu
			if($row2->Species_ID == "999")
			{
			// skip record index 999 - Other
			}
			else
			{
				//todo if (user_defined flag) then add spacer
				$plant_menu .= '{value: ';
				$plant_menu .= $row2->Species_ID;
				$plant_menu .= ', label: "';
				$plant_menu .= $row2->Common_Name;
				$plant_menu .= '", description: "(';
				$plant_menu .= $row2->Species;
				$plant_menu .= ')"},';
			}//end if speciesid = 999
		}//end loop through each species for the plant group
		//add select option for species '--Other--' to bottom of pull down list
		$plant_menu = substr_replace($plant_menu ,"",-1);
		$plant_menu .= '];';
	}		
	return $plant_menu;
}//end build_species_JSON_occasional

//added - Rick Rose - 08-Oct-2012
//for choose a plant - choose.php - builds JSON string of all common names and then all scientific names for jQuery UI autocomplete functionality for choose.php
function build_species_JSON_allspecies($p_dbh)
{
	$plant_menu='';
	
	$qry2 = sprintf("SELECT * from tbl_species WHERE Species_ID<999 AND User_Defined >=0 ORDER BY Common_Name");
		$check2 = $p_dbh->query($qry2);
		if(!$check2)
		{
			return  $plant_menu; //return empty string
		}
		else
		{
			$plant_menu = '[';
			
			while ($row2 = $check2->fetch_object())
			{
				//fetch a row
				//$row2 = $check2->fetch_object();
				
				//skip over species 999-Other since we're building a JSON object to allow users to select a species other than 'other'
				if($row2->Species_ID == "999")
				{
				// skip record index 999 - Other
				}
				else
				{
					//echo speciesid and common name
					$plant_menu .= '{value: ';
					$plant_menu .= $row2->Species_ID;
					$plant_menu .= ', label: "';
					$plant_menu .= $row2->Common_Name;
					$plant_menu .= '", description: "(';
					$plant_menu .= $row2->Species;
					$plant_menu .= ')"},';
				}//end create JSON element
			}//end loop through each found species
			//add select option for species '--Other--' to bottom of pull down list
			$plant_menu = substr_replace($plant_menu ,"",-1);
			$plant_menu .= '];';
		}//end species found
	return $plant_menu;
}//end build_species_JSON_allspecies

//Get list of special projects from tbl_special_projects used for photo carousel
//Added: Rick Rose - 27-Sep-2012
function get_special_project_data_list($p_specialprojecttype, $p_dbh)
{
//assumed logged in before calling this function
//returns a string of special project data 
	$special_project_list = "";

	$qry = sprintf("SELECT * FROM tbl_special_projects WHERE type ='%s' AND visible = '1'", $p_dbh->real_escape_string($p_specialprojecttype));
	
	$result = $p_dbh->query($qry);
	if ($result->num_rows == 0)
	{ 
		return $special_project_list;//no matching special projects found
	}

	while ($row = $result->fetch_object())
	{
		//todo if (user_defined flag) then add spacer
		$special_project_list .= '<a href="';
		$special_project_list .= $row->page_url;
		$special_project_list .= '"><img class="cloudcarousel" src="';
		$special_project_list .= $row->image_url;
		$special_project_list .= '" alt="';
		$special_project_list .= $row->tagline;
		$special_project_list .= '" title="';
		$special_project_list .= $row->name;
		$special_project_list .= '" /></a>';
	 } 
						
	return $special_project_list;
}//end get_special_project_data_list

//added - Rick Rose - 19-Oct-2012
//fetch special project name and type for a particular speciesid
//used for badges on speciesinfo page
function get_special_projects_for_speciesid($p_speciesid, $p_dbh)
{
//returns a set of objects containing special project name, type
	$qry = sprintf("SELECT tbl_special_projects.ID, tbl_special_projects.type, tbl_species.Species_ID
									FROM (tbl_special_projects RIGHT JOIN rel_species_special_projects ON tbl_special_projects.ID=rel_species_special_projects.Special_Project_ID)
									LEFT JOIN tbl_species ON rel_species_special_projects.Species_ID=tbl_species.Species_ID
									WHERE tbl_species.Species_ID = '%s'", $p_speciesid);
	$result = $p_dbh->query($qry);

	return $result;//return object

}//end get_special_projects_for_speciesid

//added - Rick Rose - 22-Oct-2012
//fetch speciesids for special project id
//used on mostwanted.php and the index.php pages for each special project
// page to fetch top ten and special project species
function get_speciesid_for_special_projects($p_specialprojectid, $p_dbh)
{
//returns a set of objects containing special project name, type
	$qry = sprintf("SELECT tbl_species.Species_ID, tbl_species.Common_Name, tbl_species.Species, tbl_species.Short_Description, tbl_special_projects.ID
						FROM (tbl_special_projects RIGHT JOIN rel_species_special_projects ON tbl_special_projects.ID = rel_species_special_projects.Special_Project_ID) LEFT JOIN tbl_species ON rel_species_special_projects.Species_ID = tbl_species.Species_ID
						WHERE tbl_special_projects.ID = '%s' ORDER BY tbl_species.Common_Name", $p_specialprojectid);

	$result = $p_dbh->query($qry);

	return $result;//return object

}//end get_special_projects_for_speciesid

//added - Rick Rose - 24-Oct-2012
//get plants in plant group for specific state
function get_speciesid_select_state_orderby_plantgroupid($p_dbh, $p_plantgroupid, $p_statecode)
{
$p_statecode = '%' . $p_statecode . '%';
//returns a set of objects containing plant group id, plant group name, common name, speciesid, and state distribution
	$qry = sprintf("SELECT DISTINCT PG.Plant_Group_Name, PG.Plant_Group_ID, S.Common_Name, S.Species_ID, S.Distribution
					FROM tbl_plant_groups as PG
					JOIN rel_plantgroup_protocol as PGP on (PG.Plant_Group_ID = PGP.Plant_Group_ID)
					JOIN tbl_protocols as P on (PGP.Protocol_ID = P.Protocol_ID) 
					JOIN rel_species_protocol as SP on (P.Protocol_ID = SP.Protocol_ID)
					JOIN tbl_species as S on (SP.Species_ID = S.Species_ID)
					WHERE PG.Plant_Group_ID = '%d' AND S.Species_ID < 999 AND S.Distribution LIKE '%s' AND S.User_Defined >= 0 ORDER BY S.Common_Name ASC", $p_plantgroupid, $p_statecode);
	//echo $qry;
	$result = $p_dbh->query($qry);
	return $result;
}

//added - Rick Rose - 30-Oct-2012
//get all PBB species (speciesid<999) and return common name
function get_PBB_species($p_dbh)
{
//returns a set of objects containing speciesid and common name
	$qry = sprintf("SELECT Species_ID, Common_Name
					FROM tbl_species
					WHERE Species_ID <999");
	//echo $qry;
	$result = $p_dbh->query($qry);
	return $result;
}

//functions moved from pb_lib_kkm.php - Rick R. 15-Nov-2012
//returns the last insert auto-generated id
function get_lastInsertID($p_dbh)
{
	 return $p_dbh->insert_id; 
}

//update the tbl_people table to indicate student account
function update_Student($p_id, $p_dbh)
{
	$qry = sprintf("UPDATE tbl_people SET Student = 1 Where Person_ID = %d", $p_id);
	$result = $p_dbh->query($qry);
	return $result;
}
	
//store all IDs for the teacher, student and associated station (classroom)	
function store_student($p_teacherID, $p_studentID, $p_stationID, $p_dbh)	
{

    $qry = sprintf("INSERT INTO rel_teacher_student_station 
        (
        Teacher_ID, 
        Student_ID, 
        Station_ID 
        )	
        values 
        ( 
        %d, 
		%d, 
		%d
        )",
		$p_teacherID, 
		$p_studentID,
		$p_stationID
		);
		
	
    $result = $p_dbh->query($qry);
	//echo $qry;
	//echo $p_dbh->mysql_errno . ": " . $p_dbh->mysql_error . "\n";
	
	if ($result->num_rows == 0) { 
		return 0; //didn't insert!
	}
		else { 
		return 1; //a-okay!
		}
}

//fetch object containing all stationids (classrooms) for a studentid
function get_studentBudBurst_sites($p_personid, $p_dbh)
{
	    $qry = sprintf("SELECT * FROM rel_teacher_student_station WHERE Student_ID = '%d' ",$p_dbh->real_escape_string($p_personid) );
		//echo $qry;	
		$result = $p_dbh->query($qry);
		return $result;

}

//fetch object if student exists in people table
function check_Student($p_personid, $p_dbh)
{
	$qry = sprintf("SELECT Student FROM tbl_people WHERE Person_ID = '%d' ",$p_dbh->real_escape_string($p_personid) );
	$result = $p_dbh->query($qry);
	
	if ($result->num_rows == 0) { 
		return 0; 
	}
	else { 
		$row = $result->fetch_object();								
		return $row->Student;
	}
	
}

//fetch object containing all students for a particular station (classroom)
function get_Students_byStation($p_personid, $p_stationid, $p_dbh)
{
	$qry = sprintf("SELECT * FROM rel_teacher_student_station WHERE Teacher_ID = %d AND Station_ID = %d ",$p_dbh->real_escape_string($p_personid), $p_dbh->real_escape_string($p_stationid) );

	$check = $p_dbh->query($qry);
	if ($check->num_rows == 0) {
		return 0;
	}
	/*
	$row = $check->fetch_object();
	$username = $row->UserName;*/
	return $check;
	
}

//build div for special projects species for jQueryUI accordion
//passing in specialprojectid - used on plantresources_speciesinfo.php
function get_specialproject_speciesaccordion($dbh,$special_projectsid)
{
	//fetch species for special project
	//$specialproject_speciesset = get_specialproject_species($dbh, $special_projectsid);
	
	$specialproject_speciesset = get_speciesid_for_special_projects($special_projectsid, $dbh);
	
	//build div to meet jQueryUI accordion requirements
	while($specialproject_speciesrow = $specialproject_speciesset->fetch_object())
	{
		$result .= '<h3>';
		$result .= '<div class="verticalcenter">';
		$result .= '<p>';
		$result .= $specialproject_speciesrow->Common_Name;
		$result .= '<br/>';
		$result .= ' <em>';
		$result .= $specialproject_speciesrow->Species;
		$result .= '</em>';
		$result .= '</p>';
		$result .= '</div>';
		$result .= '</h3>';
		$result .= '<div>';					
		$result .= '<img src="../images/'. $specialproject_speciesrow->Species_ID . '.jpg" style="width:100px;height:100px;float:left;margin-top:5px" />';
		$result .= '<div style="line-height:1.35em;margin-top:2px;padding:0 5px 0 5px">';
		$result .= $specialproject_speciesrow->Short_Description;
		$result .= '<br><br>';
		$result .= 'Read more on the ';
		$result .= '<a href="../plantresources_speciesinfo.php?speciesid='.$specialproject_speciesrow->Species_ID .'" class="maincontent">';
		$result .= 'species info page';
		$result .= '</a>.';
		$result .= '</div>';
		$result .= '</div>';
	} //for
	
	echo $result;
}//end get_specialproject_speciesaccordion()


//build div for special projects species for listing species in leiu of accordion
//passing in specialprojectid - used on plantresources_speciesinfo.php
function get_specialproject_specieslist($dbh,$special_projectsid)
{
	//fetch species for special project
	//$specialproject_speciesset = get_specialproject_species($dbh, $special_projectsid);
	
	$specialproject_speciesset = get_speciesid_for_special_projects($special_projectsid, $dbh);
	
	//build div to meet jQueryUI accordion requirements
	while($specialproject_speciesrow = $specialproject_speciesset->fetch_object())
	{
		$result .= '<h3>';
		$result .= '<div>';
		$result .= '<p style="font-weight:bold">';
		$result .= $specialproject_speciesrow->Common_Name;
		$result .= '<br/>';
		$result .= ' <em>';
		$result .= $specialproject_speciesrow->Species;
		$result .= '</em>';
		$result .= '</p>';
		$result .= '</div>';
		$result .= '</h3>';
		$result .= '<div>';					
		$result .= '<img src="../images/'. $specialproject_speciesrow->Species_ID . '.jpg" style="width:100px;height:100px;float:left;margin:5px 5px 0 0" />';
		$result .= '<div style="line-height:1.35em;margin-top:2px;padding:0 5px 0 5px">';
		$result .= $specialproject_speciesrow->Short_Description;
		$result .= '<br><br>';
		$result .= 'Read more on the ';
		$result .= '<a href="../plantresources_speciesinfo.php?speciesid='.$specialproject_speciesrow->Species_ID .'" class="maincontent">';
		$result .= 'species info page';
		$result .= '</a>.';
		$result .= '</div>';
		$result .= '<div id="LineSeparator" style="margin-top:10px"></div>';
		$result .= '</div>';
	} //for
	
	echo $result;
}//end get_specialproject_specieslist()


function displaysocialmedia()
{
	$base_url=GetBaseURL();

	//social media icons
	$result .=	'<div id="SocialMediaIcons" style="width:150px;height:30px;margin:5px auto 0">';
	$result .=  '<a href="http://www.facebook.com/ProjectBudBurst">';
	$result .= '<img src="' . $base_url . 'images/facebook_32.png" style="width:30px;height:30px;margin: 0 10px 0 0;border:none" alt="Follow us on Facebook!" title="Facebook"/>';
	$result .= '</a>';
	$result .= '<a href="http://www.flickr.com/groups/projectbudburst/">';
	$result .= '<img src="' . $base_url . 'images/flickr_32.png" style="width:30px;height:30px;margin: 0 10px 0 0;border:none" alt="Add your plant photos to our Flickr album!" title="Flickr"/>';
	$result .= '</a>';
	$result .= '<a href="http://projectbudburst.blogspot.com/">';
	$result .= '<img src="' . $base_url . 'images/blog_32.png" alt="Visit our blog!" style="width:30px;height:30px;margin: 0 10px 0 0;border:none" title="Our Blog" />';
	$result .= '</a>';
	$result .= '<a href="https://twitter.com/#!/PBudBurst">';
	$result .= '<img src="' . $base_url . 'images/twitter_32.png" alt="Find us on Twitter!" style="width:30px;height:30px;border:none" title="Twitter" />';
	$result .= '</a>';
	$result .= '</div>';
	
	//newsletter div
	$result .= '<a style="width:150px;height:25px;background-color:#70972C;padding:5px 0 0 0;margin: 15px auto 0 auto;display:block;color:#FFFFFF" class="buttons" href="http://visitor.r20.constantcontact.com/manage/optin/ea?v=001c5Zc9ukCtXZWbXgxoxbbzBKCzT_zyMzw8_2aKX7VksGjQz4pM6Y1fugs80-2zVckjlp6FS-37FN-BBL4lZJpKQZFygaRJGgT" target="_blank">Newsletter Signup!</a>';

	echo $result;
}//end displaysocialmedia()

function sendEmailAlertToWebmaster($errorfilename, $errortablename, $errordescription)
{
	//assign current datestamp
	$errordatestamp = date('Y-m-d h:m');
	
	/* FIRST, SEND THE ERROR EMAIL
		  // recipient
		  //$to = 'budburstweb@neoninc.org';*/
		  $to = 'rrose@neoninc.org';
		  
		  // subject
		  $subject = 'Database insert error';
		  // message
		  $message = '<html>
		  <head>
			<h2>Database Insert Error</h2>
		  </head>
		  <body>
		  	  <p>An error has occurred:</p>
			  <blockquote>
				File: ' . $errorfilename .'
				<br />Table: ' . $errortablename .'
				<br />Error: ' . $errordescription .'
				<br />User name: '. $_SESSION['username'] .'
				<br />Submitted at: '. $errordatestamp .'</p>
			  </blockquote>
			  
		  </body>
		  </html>';
		  
		  // To send HTML mail, the Content-type header must be set
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  // Additional headers
		  $headers .= 'To: BudBurst Helpdesk <'. $to .'>' . "\r\n";
		  $headers .= 'From: NEON <noreply@neoninc.org>' . "\r\n";
		  //$headers .= 'Bcc: dward@neoninc.org' . "\r\n";
		  
		  //debug
		  //print $headers;
		  //print $message;
		  
		  // Mail it
		  mail($to, $subject, $message, $headers);
}//end sendEmailAlertToWebmaster()

?>
