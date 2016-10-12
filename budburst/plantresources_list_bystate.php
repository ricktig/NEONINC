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
HeaderStart("Project BudBurst - Plant Resources By State"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="PlantResources">

<div id="wrapper">
  
  <div id="contentwrapper">
  
   <!-- <div><a href="index.php"><img src="images/Banner_3.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation for Home Page -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
    
    <script type="text/javascript">
		function map_on(state_name)
		{
			//alert(state_name);
			document.getElementById('map_roll_div').innerHTML = state_name.title;
		}
		
		function map_off()
		{
			document.getElementById('map_roll_div').innerHTML = '&nbsp;';
		}
		
		function state_drop()
		{
			var state_id = document.getElementById('state_select').value;
			document.getElementById('state_select_form').submit();
		}
		
		function mapState(addon)
		{
			window.location = "plantresources_list_bystate.php?Distribution=" + addon+ "#list";
		}
	</script>
    	
        <h1>Plants by State</h1>
        
    	<center>
 		  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="main content"><!-- cellpadding was 10 width was 580 -->
              <tr>
                <td align="left" valign="top"><span><a name="top" id="top"></a>What native trees, shrubs, and flowers grow in your area? What common ornamentals and weeds might you find in your backyard? Click on the map below or select your state to see which of our targeted plants grow near you.</span>
                  <center><p align="center">
                  <form id="state_select_form" method="get" action="plantresources_list_bystate.php#list">
                    <select id="state_select" name="Distribution" onchange="state_drop()">
                      <option value="">-- Select a State --</option>
                      <option value="AL">Alabama </option>
                      <option value="AK">Alaska </option>
                      <option value="AZ">Arizona </option>
                      <option value="AR">Arkansas </option>
                      <option value="CA">California </option>
                      <option value="CO">Colorado </option>
                      <option value="CT">Connecticut </option>
    				  <!--<option value="DC">District of Columbia </option>-->
                      <option value="DE">Delaware </option>
                      <option value="FL">Florida </option>
                      <option value="GA">Georgia </option>
                      <option value="HI">Hawaii </option>
                      <option value="ID">Idaho </option>
                      <option value="IL">Illinois </option>
                      <option value="IN">Indiana </option>
                      <option value="IA">Iowa </option>
                      <option value="KS">Kansas </option>
                      <option value="KY">Kentucky </option>
                      <option value="LA">Louisiana </option>
                      <option value="ME">Maine </option>
                      <option value="MD">Maryland </option>
                      <option value="MA">Massachusetts </option>
                      <option value="MI">Michigan </option>
                      <option value="MN">Minnesota </option>
                      <option value="MS">Mississippi </option>
                      <option value="MO">Missouri </option>
                      <option value="MT">Montana </option>
                      <option value="NE">Nebraska </option>
                      <option value="NV">Nevada </option>
                      <option value="NH">New Hampshire </option>
                      <option value="NJ">New Jersey </option>
                      <option value="NM">New Mexico </option>
                      <option value="NY">New York </option>
                      <option value="NC">North Carolina </option>
                      <option value="ND">North Dakota </option>
                      <option value="OH">Ohio </option>
                      <option value="OK">Oklahoma </option>
                      <option value="OR">Oregon </option>
                      <option value="PA">Pennsylvania </option>
                      <option value="RI">Rhode Island </option>
                      <option value="SC">South Carolina </option>
                      <option value="SD">South Dakota </option>
                      <option value="TN">Tennessee </option>
                      <option value="TX">Texas </option>
                      <option value="UT">Utah </option>
                      <option value="VT">Vermont </option>
                      <option value="VA">Virginia </option>
                      <option value="WA">Washington </option>
                      <option value="WV">West Virginia </option>
    
                      <option value="WI">Wisconsin </option>
                      <option value="WY">Wyoming </option>
                    </select>
                  Select a State or Click on the Map
                  </form>
                  </p></center>
                  
                  <center>
                  <img name="blankmap" src="images/blankmap.gif" width="400" height="300" border="0" id="blankmap" usemap="#map_states" alt="" style="margin-top:4px;" />
                  <input type="hidden" name="hiddenField" />
                  <map name="map_states" id="map_states">
                    <area shape="poly" coords="25,29,39,26,74,36,67,61,64,61,58,61,48,61,38,61,29,60,27,50,24,50" href="javascript:mapState('WA');" title="Washington" alt="Washington" />
                    <area shape="poly" coords="73,36,78,38,78,50,83,63,83,71,91,83,102,83,98,109,58,99" href="javascript:mapState('ID');" alt="Idaho" />
                    <area shape="poly" coords="23,49,8,87,57,99,67,60,30,61,23,48" href="javascript:mapState('OR');" />
                    <area shape="poly" coords="10,87,36,94,31,122,60,167,63,176,57,187,39,188,35,179,22,165,14,162,15,153,10,146,11,141,13,139,9,135,9,128,4,116,6,107,3,101,9,86" href="javascript:mapState('CA');" alt="California"/>
                    <area shape="poly" coords="36,93,78,104,67,159,63,159,61,167,31,122,35,93" href="javascript:mapState('NV');" alt="Nevada" />
                    <area shape="poly" coords="79,38,152,50,150,87,103,82,101,84,92,84,83,72,83,61,78,51" href="javascript:mapState('MT');" alt="Montana" />
                    <area shape="poly" coords="78,104,99,108,96,117,111,121,106,158,69,153" href="javascript:mapState('UT');" alt="Utah" />
                    <area shape="poly" coords="69,153,106,157,98,210,80,207,65,198,57,193,56,186,63,175,60,167" href="javascript:mapState('AZ');" alt="Arizona" />
                    <area shape="poly" coords="104,81,151,86,147,124,97,117" href="javascript:mapState('WY');" alt="Wyoming" />
                    <area shape="poly" coords="111,120,161,126,159,161,106,158" href="javascript:mapState('CO');" alt="Colorado" />
                    <area shape="poly" coords="105,158,151,162,147,209,116,208,98,210" href="javascript:mapState('NM');" alt="New Mexico" />
                    <area shape="poly" coords="151,168,173,168,175,189,194,194,209,193,219,197,219,211,223,219,220,233,189,255,193,267,177,264,173,253,158,231,148,232,143,238,133,230,132,224,119,209,147,209" href="javascript:mapState('TX');" alt="Texas" />
                    <area shape="poly" coords="152,49,195,51,199,63,199,80,151,77" href="javascript:mapState('ND');" alt="North Dakota" />
                    <area shape="poly" coords="151,77,200,80,199,111,194,109,149,106" href="javascript:mapState('SD');" alt="South Dakota" />
                    <area shape="poly" coords="149,106,197,110,203,118,205,127,208,136,161,136,162,125,147,124" href="javascript:mapState('NE');" alt="Nebraska" />
                    <area shape="poly" coords="161,135,209,137,214,144,213,165,160,163" href="javascript:mapState('KS');" alt="Kansas" />
                    <area shape="poly" coords="151,162,213,166,215,196,211,194,202,193,194,195,187,192,175,189,174,168,151,167" href="javascript:mapState('OK');" alt="Oklahoma" />
                    <area shape="poly" coords="195,51,208,51,209,47,213,52,225,55,235,58,244,60,230,73,224,83,235,103,201,103" href="javascript:mapState('MN');" alt="Minnesota" />
                    <area shape="poly" coords="201,103,236,103,244,117,239,121,239,128,236,129,205,128,203,116,199,112" href="javascript:mapState('IA');" alt="Iowa" />
                    <area shape="poly" coords="206,129,237,129,242,146,246,146,246,150,248,155,250,156,253,161,257,161,252,173,247,173,248,169,214,168,215,144,209,136" href="javascript:mapState('MO');" alt="Missouri" />
                    <area shape="poly" coords="214,169,248,169,247,173,252,173,248,178,249,182,241,201,220,202,220,198,215,196" href="javascript:mapState('AR');" alt="Arkansas" />
                    <area shape="poly" coords="219,201,241,201,244,210,238,220,255,221,255,227,258,228,260,237,246,238,221,232,224,219,219,211" href="javascript:mapState('LA');" alt="Louisiana" />
                    <area shape="poly" coords="249,183,264,181,265,224,256,227,256,221,239,220,239,217,245,210,241,201" href="javascript:mapState('MS');" alt="Mississippi" />
                    <area shape="poly" coords="265,182,282,179,292,206,291,217,272,218,273,225,266,224" href="javascript:mapState('AL');" alt="Alabama" />
                    <area shape="poly" coords="272,219,275,225,292,229,303,224,313,241,326,272,339,262,340,253,320,215" href="javascript:mapState('FL');" alt="Florida" />
                    <area shape="poly" coords="299,178,283,180,292,204,291,216,301,219,321,215,323,202" href="javascript:mapState('GA');" alt="Georgia" />
                    <area shape="poly" coords="255,168,310,161,292,179,249,182" href="javascript:mapState('TN');" alt="Tennessee" />
                    <area shape="poly" coords="299,177,312,174,323,176,329,176,339,183,324,202" href="javascript:mapState('SC');" alt="South Carolina" />
                    <area shape="poly" coords="310,161,293,177,300,177,317,174,329,176,339,182,354,169,353,154" href="javascript:mapState('NC');" alt="North Carolina" />
                    <area shape="poly" coords="232,73,238,69,242,74,248,77,257,78,260,84,264,85,260,110,242,112,226,83" href="javascript:mapState('WI');" alt="Wisconsin" />
                    <area shape="poly" coords="243,111,260,111,265,125,265,146,262,157,257,160,252,161,237,130" href="javascript:mapState('IL');" alt="Illinois" />
                    <area shape="poly" coords="242,73,255,63,283,75,290,87,297,100,297,105,291,115,268,117,272,107,268,93,270,88,244,74,244,74,244,74,246,78" href="javascript:mapState('MI');" alt="Michigan" />
                    <area shape="poly" coords="263,116,281,116,286,140,285,144,276,152,264,156" href="javascript:mapState('IN');" alt="Indiana" />
                    <area shape="poly" coords="255,167,264,155,276,153,287,141,292,143,297,141,303,146,307,155,300,162" href="javascript:mapState('KY');" alt="Kentucky" />
                    <area shape="poly" coords="283,116,297,115,300,117,311,108,314,129,302,146,296,141,291,143,287,140" href="javascript:mapState('OH');" alt="Ohio" />
                    <area shape="poly" coords="315,105,313,110,314,129,324,129,350,126,349,122,354,121,354,117,351,116,350,104,342,102" href="javascript:mapState('PA');" alt="Pennsylvania" />
                    <area shape="poly" coords="324,129,350,126,350,136,354,136,355,149,347,141,338,131,327,130,324,133" href="javascript:mapState('MD');" alt="Maryland" />
                    <area shape="poly" coords="314,128,324,129,323,133,327,130,335,131,325,141,322,141,320,152,312,155,308,154,303,145" href="javascript:mapState('WV');" alt="West Virginia" />
                    <area shape="poly" coords="301,162,308,155,313,155,320,152,322,141,326,141,336,131,348,144,354,154" href="javascript:mapState('VA');" alt="Virginia" />
                    <area shape="poly" coords="350,125,357,134,355,136,350,136" href="javascript:mapState('DE');" alt="Delaware" />
                    <area shape="poly" coords="351,110,352,107,359,111,361,117,357,129,352,127,349,122,355,121" href="javascript:mapState('NJ');" alt="New Jersey" />
                    <area shape="poly" coords="318,104,320,95,335,93,338,88,337,84,344,73,355,72,360,92,361,109,371,106,372,109,360,113,357,108,353,108,352,109,350,103,338,102,334,104" href="javascript:mapState('NY');" alt="New York" />
                    <area shape="poly" coords="361,99,372,96,371,103,361,108" href="javascript:mapState('CT');" alt="Connecticut" />
                    <area shape="poly" coords="373,97" href="#" />
                    <area shape="poly" coords="371,96,379,100,371,103" href="javascript:mapState('RI');" alt="Rhode Island" />
                    <area shape="poly" coords="382,40,395,61,387,69,376,84,368,65,373,44" href="javascript:mapState('ME');" alt="Maine" />
                    <area shape="poly" coords="368,64,366,90,377,86" href="javascript:mapState('NH');" alt="New Hamsphire" />
                    <area shape="poly" coords="354,71,366,67,365,90,360,92" href="javascript:mapState('VT');" alt="Vermont" />
                    <area shape="poly" coords="361,92,376,87,386,95,384,102,374,98,368,96,362,98" href="javascript:mapState('MA');" alt="Massachusetts" />
                    <area shape="poly" coords="76,230,72,218,13,221,13,230" href="javascript:mapState('AK');" alt="Alaska" />
                    <area shape="rect" coords="14,234,72,248" href="javascript:mapState('HI');" />
                  </map>
                  <span class="style1"><br />
                  Map courtesy of USDA-NRCS PLANTS Database (<a href="http://plants.usda.gov/index.html" target="_blank" class="maincontent">plants.usda.gov</a>)
                  </span>
                  </center>
                </td>
              </tr>
          </table>
      	</center>
		<!--<p>-->
		<?php 
		// check for state code
		if (isset($_GET['Distribution']))
		{
			$stateCode=$_GET['Distribution'];
			$query2 = "SELECT * FROM tbl_states WHERE state_abbr = '$stateCode'";
			
			$StateNameSet = $dbh->query($query2);
			$StateNameRow = $StateNameSet->fetch_object();
			
			// close connection 
			//$dbh->close(); 
			?>
			
			<?php
			//fetch state name
			echo '<h1>' . $StateNameRow->state . '</h1>';
			
			//fetch species in plant groups 1 through 5
			$i=0;

			//array to provide 'sort' order of how plant groups are displayed
			$sortorder=array(1,2,5,3,4);

			while ($i<5)
			{
				$PlantGroupID=$sortorder[$i];
				$PlantGroupSet=get_plant_group($dbh,$PlantGroupID);
				$PlantGroupRow=$PlantGroupSet->fetch_object();
				$PlantGroupName=$PlantGroupRow->Plant_Group_Name;
				$plantCount=1;
				
				//$RecordSet=get_PBBplants_in_plant_group($dbh,$PlantGroupID);
				$RecordSet=get_speciesid_select_state_orderby_plantgroupid($dbh, $PlantGroupID, $stateCode);
				
				//check for returned dataset
				$noPlantsInGroup=$RecordSet->num_rows;
				
				echo '<div id="greenheader"><img src="images/plantGroups/' . $PlantGroupID . 'i.png" style="margin: -6px 10px 0 10px; float:left"/>' . $PlantGroupName . '</div>';

				//echo left div
				echo '<div id="leftcolumn" style="float:left; width:350px; margin:0 10px 5px 20px">';
				while($row_plants = $RecordSet->fetch_object())
				{
					$speciesid	= $row_plants->Species_ID;
					//get common and scientific name for species id
					$result_plantNames = get_plant($dbh, $speciesid);
					
					//loop through each set of plants in plantgroup
					while($row_plantName = $result_plantNames->fetch_object())
					{
						$commonName = $row_plantName->Common_Name;
						$scientificName = $row_plantName->Species;
						//echo $plantCount;
						//uncomment to view images
						//echo '<img src="images/' . $speciesid . '.jpg" alt="' . $commonName . '" width="50" />';
						echo '<div style="margin: 3px 0 0 0"><a href="plantresources_speciesinfo.php?speciesid='.$speciesid.'" class="maincontent">'.$commonName.'</a><span style="font-size:0.85em"> (<em>' . $scientificName.'</em>)<br /></span></div>';
					}//while common and scientific name

					//switch content to right column half way through species list - rounds so odd number of species won't compare integer to .5 value (odd/2)
					if ($plantCount==round((($noPlantsInGroup)/2)))
					{
						echo '</div>'; //end leftcolumn
			
						//display species in right hand column
						echo '<div id="rightcolumn" style="float:left; width:300px; margin:0 0 10px 0">';
					} // end if 
					//increment plantcount by 1
					$plantCount++;
				}//while get plant id
				
				//increment plantgroupid by 1
				$i++;
				echo "</div><!--end rightcolumn div-->";
				echo "<div style='clear:both'></div>";
			}// end while to fetch all plant groups
		}
		else
		{ // no state code found
			//echo('<h3>Select a state to see available plants</h3>');
			echo "<br />";
			$stateCode="";
		} //end if state code
		?>

    </div><!-- MainContent -->
	<div style="clear:both"></div><!--clear floats for footer-->
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