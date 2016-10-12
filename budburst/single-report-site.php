<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/4/2012
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
HeaderStart("Project BudBurst - Enter Single Report - Site Location"); // The first and only parameter is the page title
//
// Parse URL variables
//process personid GET
if(!isset($_GET['personid']))
{
	$personid = '0';
}
else
{
	$personid = $_GET['personid'];
}

//process plantgroupid GET
if(!isset($_GET['plantgroupid']))
{
	$plantgroupid = '0';
}
else
{
	$plantgroupid = $_GET['plantgroupid'];
}

//process speciesid_verified GET
if(!isset($_GET['speciesid_verified']))
{
	$speciesid_verified = "0";
}
else
{
	$speciesid_verified = $_GET['speciesid_verified'];
}

//process speciesid GET
if(!isset($_GET['speciesid']))
{
	$speciesid = "0";
}
else
{
	$speciesid = $_GET['speciesid'];
	//if speciesid=999 (other) fetch common name using speciesid_verified
	if ($speciesid == '999')
	{
		$species=get_Species($speciesid_verified,$dbh);
		if(!mysqli_num_rows($species)) //no common name found
		{
			$commonname='';
		}
		else
		{
			$srow=$species->fetch_object();
			$commonname=$srow->Common_Name;
		}
	}
	else
	//not 'other' species - get common name using speciesid
	{
		$species=get_Species($speciesid,$dbh);
		if(!mysqli_num_rows($species)) //no common name found
		{
			$commonname='';
		}
		else
		{
			$srow=$species->fetch_object();
			$commonname=$srow->Common_Name;
		}
	}//end if else to check if other species and fetch common name
}

?>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	// document load - assign JavaScript variables from URL PHP variables
	$(function()
	{
		var speciesid = <?php echo $speciesid;?>;
		var plantgroupid = <?php echo $plantgroupid;?>;
		var personid = <?php echo $personid;?>;
		
		//load Google Map
		loadMap();
		
		//check for previously entered lat/lon (from return from verify page) and zoom to those coordinates
		<?php
			if ($_POST['lat'] && $_POST['lon'])
			{
				echo 'zoomMap(\'' . $_POST["lat"] . '\', \'' . $_POST["lon"] . '\');';
			}
		?>
		
		//load site info - if provided from PHP POST when returning to this page from site_verify page
		$('#sitename').val('<?php echo $_POST['sitename'];?>');
		$('#city').val('<?php echo $_POST['city'];?>');
		$('#state').val('<?php echo $_POST['state'];?>');
		$('#zip').val('<?php echo $_POST['zip'];?>');
		$('#lat').val('<?php echo $_POST['lat'];?>');
		$('#lon').val('<?php echo $_POST['lon'];?>');
		
		//function to display map help text pop up window
		$("#btnhelp").click(function()
		{
			$("#helptext").css('display', 'block');
		});
	});

	//close map help text popup div
	function closeWindow()
	{
		$(".popupmaphelp").css('display', 'none');

	}

	//Google Maps load
	//initialize variables
	var map;
	var geocoder;
	var marker = null;
	var markersArray = [];
	var myLatLng = null;
	var myLat;
	var myLng;
	var usCenter = new google.maps.LatLng(+40, -100);//variable set globally for use in clearForm()
	
	function loadMap()
	{
		//if (GBrowserIsCompatible()) { -- commented out - no GBrowserIsCompatible function in Google Maps v3

		//var usCenter = new google.maps.LatLng(+40, -100);
		geocoder = new google.maps.Geocoder();
		
		//set map options - zoom level, center, scale control, large zoom control, horizontal type control, terrain style, 
		var mapOptions =
		{
			zoom: 3,
			center: usCenter,
			streetViewControl: false,
			scaleControl: true,
			zoomControl: true,
			zoomControlOptions:
			{
				style: google.maps.ZoomControlStyle.LARGE
			},
			mapTypeControl: true,
			mapTypeControlOptions:
			{
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
			},
			mapTypeId: google.maps.MapTypeId.TERRAIN
		}; // end mapOptions

		//create new map object
		map = new google.maps.Map(document.getElementById('map'), mapOptions);
		
		var zoomMark = 5

		// ====== Create new EventListener to add marker on click ========
		google.maps.event.addListener(map, "click", function(event)
		{
			//capture lat/lng of click location
			myLatLng = event.latLng;
			
			//check to see if visitor is zoomed out to a level not conducive to setting an accurate marker
			if (map.getZoom() < zoomMark)
			{
				//alert ('Zoom in before setting your location');
				//center map on click location
				map.setCenter(myLatLng);
				//zoom in
				map.setZoom(zoomMark);
				//bold zoom label
				$("#zoom").css("font-weight","normal");
				//remove bold for mark label
				$("#mark").css("font-weight","bold");
			}
			else
			{
				//call fx to add marker to markersArray
				addMarker(myLatLng);
			}//end zoom/mark check
		});//end click listener
		
		//event listener to check for zoom level change
		google.maps.event.addListener(map, 'zoom_changed', function()
		{
			//fetch current zoom level
			var zoomLevel = map.getZoom();

			//check for zoom level <6 and toggle mouse function text from zoom to mark
			if(zoomLevel<zoomMark)
			{
				//change text to zoom
				$("#zoom").css("font-weight","bold");				
				$("#mark").css("font-weight","normal");
				//clear map marker
				clearOverlays();
			}
			
			if (zoomLevel>=zoomMark)
			{
				//change text to mark
				$("#zoom").css("font-weight","normal");
				$("#mark").css("font-weight","bold");
			}
		});//end zoom level change listener

	} // end loadMap()
	
	function zoomMap(lat,lng)
	{
			//create map latlng object
			myLatLng = new google.maps.LatLng(lat, lng);
			//center map on latlng object location
			map.setCenter(myLatLng);
			//zoom in
			map.setZoom(5);
			//set marker
			addMarker(myLatLng);
	}

		
	//add marker to markersArray and set lat/lng vars to marker location
	function addMarker(location)
	{
	//create new marker object
		marker = new google.maps.Marker(
		{
			position: location,
			map: map
		});
		//clear previous marker
		clearOverlays();
		
		//add new marker object to markers array
		markersArray.push(marker);
		
		//capture lat/lng of clicked location
		var myLat = Math.round(location.lat()*1000000)/1000000;
		var myLng = Math.round(location.lng()*1000000)/1000000;

		//copy lat/lng in html fields for population of displayed lat/lng html fields
		copygeopoint(myLat, myLng);
	}	// end addMarker()
	
	//remove map markers from markersArray[] and destroy array
	function clearOverlays()
	{
		if(markersArray)
		{
			for (i in markersArray)
			{
				markersArray[i].setMap(null);
			}
			markersArray.length = 0;
		}
	} //end clearOverlays()
		
    // ====== Geocoding ======
    function showAddress()
	{
        var search = document.getElementById("search").value;
		var searchresult;

        // ====== Perform the Geocoding ======        
        //geo.getLocations(search, function (result)
		geocoder.geocode( {'address': search}, function(results, status)
        { 
            // If geocode was successful - status OK
            if (status == google.maps.GeocoderStatus.OK)
			{
				// How many resuts were found
				//document.getElementById("message").innerHTML = "Found " +result.Placemark.length +" result(s)";
				// Loop through the results, placing markers
				//for (var i=0; i<result.Placemark.length; i++)
				//{
				//	var p = result.Placemark[i].Point.coordinates;
				//	var marker = new GMarker(new GLatLng(p[1],p[0]));
				//	document.getElementById("message").innerHTML += "<br>"+(i+1)+": "+ result.Placemark[i].address + marker.getPoint();
				//	document.getElementById("hiddenlat").val =  marker.getPoint().lat();
				//	document.getElementById("hiddenlng").val = marker.getPoint().lng();
				//	addMarker(myLatLng);
				//}
				// centre the map on the first result
				//var p = result.Placemark[0].Point.coordinates;
				//map.setCenter(new GLatLng(p[1],p[0]),3);  // the last number is the zoom factor
				  
				//parse returned coordinates string into lng/lat array
				//coordinates = result.Placemark[0].Point.coordinates;
			  
			  	//create location message for div	  			  
				//var mymsg = "<strong>Location of map's marker:</strong> Latitude: <strong>"+coordinates[1]+"</strong> Longitude: <strong>"+coordinates[0]+"</strong>"; 
				//display location message in div
				//document.getElementById("LatLonMsg").innerHTML = mymsg;
				
				//clear previuos Google Maps overlays to remove map marker
				clearOverlays();
				//set map center to geocoded results
				map.setCenter(results[0].geometry.location);
				//zoom in
				map.setZoom(15);
				//display marker at geocoded results
				var marker = new google.maps.Marker(
				{
					map: map,
					position: results[0].geometry.location
				});
				//add new marker object to markers array so marker can be cleared if map is clicked upon
				markersArray.push(marker);

				//set lat/lng from geocode results
				var myLat = Math.round(results[0].geometry.location.lat()*100000)/100000;
				var myLng = Math.round(results[0].geometry.location.lng()*100000)/100000;		
				
				//copy geocode results to form input fields
				copygeopoint(myLat, myLng);
            }
            // ====== Decode the error status ======
            else
			{
				//var reason="Code "+status;
				//if (reasons[status])
				//{
				//  reason = reasons[status]
				//} 
				//set var to default so if no location entered, it displays text
				if(!search)
				{
					searchresult="Please enter a location.";
				}
				else
				{
					searchresult = 'We couldn\'t find "' + search + '".  Please give us a little more detail about your location.';
					//reset search field to null
					document.getElementById("search").value = "";
				}
				//display error div
				//display red x button
				$("#searcherror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');
				//append search error text w/o deleting red x img
				$("#searcherror").append(searchresult);
				//display search error div
				$("#searcherror").css('display', 'block');
            }
        });
    }
   // }
  



  
    // display a warning if the browser was not compatible
    //else {
    //  alert("Sorry, the Google Maps API is not compatible with this browser");
    //}//end Google Maps load
	
	//Copy geopoint to hidden html inputs for future use
	function copygeopoint(myLat, myLng)
	{
		//check to see if geocoding has produced coordinates
		if(myLat && myLng)
		{
			//assign previous lat/lng values to visible input fields
			document.getElementById("lat").value = myLat;
			document.getElementById("lon").value = myLng;
		}
		else
		{
				//build error message string
				searchresult="We didn't get your coordinates.  Please check the geocoding and try your copy again.";
				//display error div
				//display red x button
				$("#searcherror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');
				//append search error text w/o deleting red x img
				$("#searcherror").append(searchresult);
				//display search error div
				$("#searcherror").css('display', 'block');
		}
	}//end copygeopoint()

	//Clear map marker, current marker text and hidden inputs holding copied geopoints
	function cleargeopoint()
	{
		//clear Google Maps overlays to remove map marker
		clearOverlays();
		//clear user entered address from input box
		document.getElementById("search").value = "";
		//clear any previously saved lat/lng in hidden inputs
		document.getElementById("lat").val="";
		document.getElementById("lng").val="";
	}
	
	//JS function to retrieve cookie data to populate site data on button click
	function readCookie()
	{
		//set variable to test if cookie exists to false
		var cookie = false;
	
		//parse document.cookie object into array
		var cookiearray = document.cookie.split(';');
		
		// loop through cookie array elements
		for(var i=0;i < cookiearray.length;i++)
		{
			//assign name and value variables for each iteration
			var cname = cookiearray[i].split('=')[0];
			//trim leading space from cookie name var
			cname = cname.substring(1, cname.length);
			
			//split cookiearray[value] elements on equal sign
			var cvalue = cookiearray[i].split('=')[1];
			//alert (cvalue);
			// parse cookie data
			switch(cname)
			{
				case "singlereportsitename":
					var csitename = cvalue;
					cookie = true;
					break;
				case "singlereportlat":
					var clatitude = cvalue;
					cookie = true;
					break;
				case "singlereportlon":
					var clongitude = cvalue;
					cookie = true;
					break;
				case "singlereportcity":
					var ccity = cvalue;
					cookie = true;
					break;
				case "singlereportstate":
					var cstate = cvalue;
					cookie = true;
					break;
				case "singlereportzip":
					var czip = cvalue;
					cookie = true;
					break;
				default:
					break;
					// don't assign system cookies;
			}// end switch
		}// end loop through cookie array elements
		
		//if a cookie exists, populate form input fields
		if (cookie)
		{
			if (csitename)
			{
				document.getElementById('sitename').value = csitename;
			}
			
			if(clatitude)
			{
				document.getElementById('lat').value = clatitude;
			}
			
			if(clongitude)
			{
				document.getElementById('lon').value = clongitude;
			}
			
			if(ccity)
			{
				document.getElementById('city').value = ccity;
			}
			
			if(cstate)
			{
				document.getElementById('state').value = cstate;
			}
			
			if(czip)
			{
				document.getElementById('zip').value = czip;
			}
			
			//set Google Map to location provided by cookie
			var location = new google.maps.LatLng(clatitude, clongitude);
			addMarker(location);
			//center map on marker
			map.setCenter(location);
			//zoom in
			map.setZoom(13);
		}
		else
		{//cookie read error
				//build error message string
				searchresult="No recent site data exists.  Please enter your site data again.";
				//display error div
				//display red x button
				$("#searcherror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');
				//append search error text w/o deleting red x img
				$("#searcherror").append(searchresult);
				//display search error div
				$("#searcherror").css('display', 'block');
		}//end cookie read error
	}//end readCookie()

	//clear all input form fields
	function clearForm()
	{
		document.getElementById('sitename').value = "";
		document.getElementById('lat').value = "";
		document.getElementById('lon').value = "";
		document.getElementById('city').value = "";
		document.getElementById('state').value = "";
		document.getElementById('zip').value = "";
		//clear Google Maps overlays to remove map marker
		clearOverlays();
		map.setZoom(3);
		map.setCenter(usCenter);
	}//end clearForm()

	function MM_openBrWindow(theURL,winName,features)
	{ //v2.0
		window.open(theURL,winName,features);
	}
	
	// validate user supplied lat/lon coordinates
	function DoValidateCoordinates()
	{
		var ErrorString1=null;
		var ErrorString2=null;
		
		var X=parseFloat(document.form1.lon.value);
		var Y=parseFloat(document.form1.lat.value);
		
		//alert("X-lon="+X+" Y-lat="+Y);

		if (isNaN(X))
		{
			ErrorString1="You must enter a longitude coordinate.";
		}
		
		if (isNaN(Y)) 
		{
			ErrorString1="You must enter a latitude coordinate.";
		}
		
		if (isNaN(X) && isNaN(Y))
		{
			ErrorString1="You must enter both latitude and longitude coordinates.";
		}
		
		if (isNaN(X) && isNaN(Y)) // both longitude and latitude missing
		{
			ErrorString1 = "You must enter both latitude and longitude coordinates.";
		}

		if ((X<-180)||(X>0)) // we only allow western hemisphere (0 to -180); 0 to +180 is in eastern hemisphere
		{
			ErrorString2="Your longitude coordinate must be between -180 and 0.";
		}
		
		if ((Y<0)||(Y>90)) // we only allow geographic northern hemisphere
		{
			ErrorString2="Your latitude coordinate must be between 0 and +90.";
		}
		
		if (((X<-180)||(X>0))&&((Y<0)||(Y>90))) // both are wrong
		{	
			ErrorString2="Your longitude coordinate must be between -180 and 0 and your latitude coordinate must be between 0 and +90.";
		}
		
		// either report an error or submit the form
		if ((ErrorString1!=null)||(ErrorString2!=null))
		{
			if ((ErrorString1!=null)&&(ErrorString2!=null)) 
			{
			//window.alert(ErrorString1+". "+ErrorString2);
				$("#searcherror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');
				//append search error text w/o deleting red x img
				$("#searcherror").append(ErrorString1+". "+ErrorString2);
				//display search error div
				$("#searcherror").css('display', 'block');
			}
			else if (ErrorString1!=null)
			{
				//window.alert(ErrorString1);
				$("#searcherror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');
				//append search error text w/o deleting red x img
				$("#searcherror").append(ErrorString1);
				//display search error div
				$("#searcherror").css('display', 'block');		
			}
			else if (ErrorString2!=null) 
			{
				//window.alert(ErrorString2);
					$("#searcherror").html('<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>');
				//append search error text w/o deleting red x img
				$("#searcherror").append(ErrorString2);
				//display search error div
				$("#searcherror").css('display', 'block');
			}
		}
		else // go ahead and submit the form
		{	
			document.form1.submit();
		}
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
      
    <h1>Enter Single Report - Site Location</h1>
      
	<?php 
			  
		  //make sure user is logged in
			if(checklogin($dbh))
			{
				// check for missing fields from previous form
				//if(isset($_POST['submit'])&&isset($_GET['plantgroupid'])&&isset($_GET['personid'])&&($_GET['speciesid'] != 0))
				if(isset($_GET['plantgroupid'])&&isset($_GET['personid'])&&($_GET['speciesid'] != 0))
				{
	?>
					
				<p>Select Plant Group <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Select Plant <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> <strong> Site Location</strong> <img src="images/breadcrumbArrow.png" style="vertical-align:middle;" /> Report Observation</p>
				<!-- commented out to remove onsubmit reference to non-used MM_validateForm_Site JS function - Rick R. - Sep-19-2012 -->
				<!--<form action="single-report-site-do.php?personid=<?php echo $personid;?>&plantgroupid=<?php echo $plantgroupid;?>&speciesid=<?php echo $speciesid;?>&speciesid_verified=<?php echo $speciesid_verified;?>" method="post" name="form1" id="form1" onsubmit="MM_validateForm_Site('sitename','','R','lat','','RisNum','lon','','RisNum');return document.MM_returnValue">-->
				<!--div to hold input table and map div-->
				<div id="tableandmapholder" style="background-color:#C3D9A5;height:600px;margin: 0 0 10px 0">
				<div id="sitelocheader">Site Location</div><!--  #7EAF20 -->
					<form action="single-report-site-verify.php?personid=<?php echo $personid;?>&plantgroupid=<?php echo $plantgroupid;?>&speciesid=<?php echo $speciesid;?>&speciesid_verified=<?php echo $speciesid_verified;?>" method="POST" name="form1" id="form1" onsubmit="DoValidateCoordinates();return false;">
						<div id="sitelocationform" class="form" style="width:320px;height:515px;padding: 10px 10px 0 20px;float:left;">
						<div style="font-size:1.3em;margin:0 0 5px 0;text-align:center">Please select the site location<br />for your single report of <br /><?php echo $commonname?>.</div>
						<div>
							<?php
							/*check to see if cookie containing previously entered site data is available.
							If so, display a button allowing user to retrieve those cookie contents to populate
							form input fields*/
							if ($_COOKIE['singlereportsitename'])
							{
								echo '<input type="button" value="Use Information Entered From The Previous Site" onclick="readCookie();" tabindex="1"/>';
							}
							?>
						</div>

						<div class="left10pxtop"><strong>*Site Name:</strong></div>
						<div><input name="sitename" type="text" id="sitename" tabindex ="2"/></div>
						<div>A unique name of your choosing</div>
						<div class="left10pxtop">*<strong>City:</strong></div>
							<input name="city" type="text" id="city" tabindex ="3"/>
						<div class="left10pxtop">
								<strong>*State:</strong>
						</div>
						<select name="state" id="state" tabindex ="4">
							<option value="" selected="selected">Select</option>
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
						</select>
						<div class="left10pxtop"">Zip code: </div>
							<input name="zip" id="zip" type="text" size="8" maxlength="5" tabindex ="5" />
						<div class="left10pxtop"><strong>*Latitude:</strong></div>
							<input name="lat" type="text" id="lat" tabindex ="6"/>
						<div>decimal degrees  (i.e. 39.984712)</div>
						<div class="left10pxtop""><strong>*Longitude:</strong></div>
							<input name="lon" type="text" id="lon" tabindex ="7"/>
						<div>decimal degrees (i.e.-105.268265)</div>
						<div class="left10pxtop" style="width:220px">Latitude and Longitude should be measured at the center of your site.<br />
	 
					</div><!--end sitelocationform div-->
					<p align="center">
						<!--<input name="elevation" type="hidden" value="null" />
						<input name="country" type="hidden" value="us" />
						<input name="human_disturbance" type="hidden" value="null" />
						<input name="shading" type="hidden" value="null" />
						<input name="irrigation" id="irrigation" type="hidden" value="null" />
						<input name="concrete_close" type="hidden" value="null" />
						<input name="habitat_type" type="hidden" value="null" />
						<input name="forest_type" type="hidden" value="null" />
						<input name="slope_direction" type="hidden" value="null" />
						<input name="comments" type="hidden" value="null" />-->
					<input type="button" id="clear" name="clear" value="Clear Site Description" onclick="clearForm()" tabindex="8"/>
					<input type="submit" name="btnsubmit" value="Submit" tabindex ="9" />
					</p>
					</div><!--end sitelocationform div-->
				</form>
				
				<!--display search box-->
				<div id="searchbox" style="width:368px;height:34px;padding:15px 0 0 0;float:right;background-color:#C3D9A5">
				Find Your Location:
				<input type="text" id="search" tabindex ="10"/>
				<input type="button" id="searchsubmit" onclick="showAddress();" value="Search" tabindex ="11"/>
				<img src="images/help.png" style="vertical-align:bottom" id="btnhelp" />
				</div><!--end search box div-->
				<!--hidden help text div -->
				<div id="helptext" class="popupmaphelp">
					<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>
					In addition to street addresses, you can also now find named places such as schools, parks, gardens, and nature preserves! Once you have found your city or town, you can zoom in/out and pan around until you find your location. Double-clicking anywhere on the map will center that location, and its coordinates will be shown.
				</div><!--end hidden help text div-->
				<!--hidden search results error div-->
				<div id="searcherror" class="popupmaphelp">
					<img src="images/red_close_button.png" class="btnclosewindow" onclick="closeWindow()"/>
				</div><!--end hidden search error div-->
				<!--display site selection map-->
				
				<div id="map" style="width:341px;height:450px;float:right;margin:10px 20px 0 0;border:1px solid grey" tabindex ="12"></div><!--end map div-->
				<!--display click functionality text on map-->
				<div id="zoom"  style="font-weight:bold; width: 50px; position: absolute; left: 453px; top:412px; text-align: center; background-color: rgb(255, 255, 255); border: 1px solid grey; height: 19px; padding-bottom:2px">Zoom</div>
				<!--display click functionality text on map-->
				<div id="mark"  style="width: 50px; position: absolute; left: 504px; top: 412px; text-align: center; background-color: rgb(255, 255, 255); border: 1px solid grey; height: 19px; padding-bottom:2px">Mark</div>
			</div><!--end tableandmapholder div-->
		
        <?php
			} //else isset for form variable checking
			else
			{
				// we didn't get correct form variables from report_occ_obs2_do.php
				$maincontent.="<h1>Oops! We're Sorry.</h1>".
				"<h2>You did not fill in all required fields.</h2>".
				"<p>When describing your single report observation site, you will need to fill in all required fields.".
				" Please go back and try again.</p>".
				"<FORM><INPUT TYPE='button' VALUE='Back' onClick='history.go(-1);return true;'></FORM>";
			}
		}//else checklogin
		else
		{
			// you must be logged in to define your site for your occasional observation
			$maincontent .=  '<p>Sorry, you are not logged in.  Please <a href="login.php">login</a> or <a href="register.php">join</a> today!';
			$maincontent .= $spacer;
		}
				
				echo $maincontent;
				echo '<div style="clear:both"></div>';
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