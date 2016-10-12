<?php 
/*------------------------------------------------
# Author: Rick Rose
# Last modified 3/5/2012
# Copyright 2008-2013 All Rights Reserved	
# National Ecological Observation Network (NEON)
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

//check for proper authorization key
if ($_GET['authkey']=='aaaaa')
{
	//check for userid
	if (isset($_GET['userid']))
	{

		
		//build sql string to fetch reports for userid
		$sql = "SELECT * FROM tbl_observations WHERE Observer_ID = " . $_GET['userid'];
		
		if ($result = $dbh->query($sql))
		{
			//stage initial xml
			$xmlstring .= '<?xml version="1.0"?>';
			$xmlstring .= "<reports>";
			$xmlstring .= "<userid>" . $_GET['userid'] . "</userid>";
			$xmlstring .= "<username>" . $username . "</username>";
				
			while ($row = $result->fetch_object())
			{	
				$username = get_username_byPersonID($_GET['userid'], $dbh);
				
				$xmlstring .= "<report>";
				$xmlstring .= "<reportdate>" . $row->Observation_Date . "</reportdate>";
				$xmlstring .= "</report>";
			}
		
			$xmlstring .= "</reports>";
			
			echo $xmlstring;
		}//end if observations results
		else
		{
			echo "No reports found";
		}
	}
	else
	//no proper userid
	{
		echo "userid error";
	}


}
else
//no proper authorization key
{
echo "Authkey error";
}





?>