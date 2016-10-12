<?php 
/*------------------------------------------------
# Author: Dennis Ward
# Last modified 5/6/11
# Copyright 2008-2011 All Rights Reserved	
# NEON, INC
# Chicago Botanic Gardens, & University of Montana	
--------------------------------------------------*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://www.w3.org/2005/10/profile">
<link rel="icon" type="image/png" href="images/favicon.png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="expires" content="FRI, 13 APR 1999 01:00:00 GMT">
<title>Project BudBurst Geocoder</title>
<!-- <link href="stylesheets/Project_BudBurst.css" rel="stylesheet" type="text/css" media="screen"/> -->

<style type="text/css">
h1
{
	background-image:url(images/_H1_Icon.gif);
	background-repeat:no-repeat;
	padding-left:24px;
	font-size:13pt;
	font-weight:bold;
	border-bottom:solid #7EAF20 2px; /* #6A9665 */
	width:55%; /* was 55% */
	color:#306848;
}

h2
{
	color:#306848;
	font-size:12pt;
}
</style>

<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAA6aLMcWMw45FabGlLNBTZmxRB_-4-JSfDxxGI-96RrkKvvEbKyBQBFw7qZz3FCt-Zz4rWi1L2p2FQtg" type="text/javascript"></script>
</head>

<body onload="document.getElementById('search').value = ''; return false;" onunload="GUnload();">

<div id="wrapper" style="width:500px; height:100%">
    <div><a href="index.php">
	<!--<img src="images/pbb_compass.jpg" width="500" height="120" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div>-->
    <a href='<?php echo $Action ?>' alt='<?php echo $ButtonClass ?>' title='<?php echo $ButtonClass ?>'><div id='<?php echo $ButtonClass ?>'></div></a>
    
	<h1 id="geo">Project BudBurst Geocoder</h1>

	<h2>Determine your Latitude &amp; Longitude</h2>
    
    <p align="left">In addition to street addresses, you can also now find named places 
    such as schools, parks, gardens, and nature preserves! Once you have found your city
	or town, you can zoom in/out and pan around until you find your location. Double-clicking
	anywhere on the map will center that location, and its coordinates will be shown.</p>
	<form onsubmit="showAddress(); return false">
		<input type="hidden" name="hiddenlat" id="hiddenlat" />
		<input type="hidden" name="hiddenlng" id="hiddenlng" />
	  <h3>Enter your location into the box below:</h3>
	  <input name="search" type="text" id="search" size="55" />
	  <br /><br />
	  <input name="submit" type="submit" value="Geocode!" />
	  <input name="copylatlng" type="button" onclick="copygeopoint()" value="Copy Lat/Lng To Site Description" />
	  <input name="button" type="button" onclick="cleargeopoint()" value="Clear Map Results" />
	  <br />

	</form>
	<div id="message"> </div> 
          <br />
	<div id="LatLonMsg" style="width: 500; height: 75"></div>
	<div id="map" style="width: 500px; height: 400px"></div>

	<noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
		  However, it seems JavaScript is either disabled or not supported by your browser. 
		  To view Google Maps, enable JavaScript by changing your browser options, and then 
		  try again.
	</noscript>
</div>
<script type="text/javascript">
	if (GBrowserIsCompatible()) { 
	  var marker = null;
	  var markers = [];
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(41,-100),3);
	  map.removeMapType(G_SATELLITE_MAP);
	  map.addMapType(G_PHYSICAL_MAP);
	  map.setMapType(G_PHYSICAL_MAP);        //  ======= Set Map Type to TERRAIN ============
	  map.enableScrollWheelZoom();          //  ======= Enabled Scroll Wheel Zoom =========
	  map.enableContinuousZoom();
	  map.getContainer().style.overflow="hidden"; // hides any copyright overflow

	 /* GEvent.addListener(map, "moveend", function() {  //  ======= EventListener to display center coordinates ============
	     var center2 = map.getCenter();
		 var Lat5 = Math.round(center2.y*100000)/100000; 
		 var Lng5 = Math.round(center2.x*100000)/100000; 
		 document.getElementById("hiddenlat").val = Lat5;
		 document.getElementById("hiddenlng").val = Lng5;
	     var mymsg = "<strong>Location of map's center:</strong> Latitude: <strong>"+Lat5+"</strong> Longitude: <strong>"+Lng5+"</strong>"; 
		 document.getElementById("LatLonMsg").innerHTML = mymsg;
	  });*/
	  
	  // ====== EventListener to add marker on click ========
	  GEvent.addListener(map, "click", function(overlay, latlng) {  //  ======= EventListener to display center coordinates ============
		//init vars
		var lat = latlng.lat();
		var lon = latlng.lng();
		//round to three decimals
		Lat5 = Math.round(lat*1000)/1000;
		Lng5 = Math.round(lon*1000)/1000;
		var latOffset = 0.01;
		var lonOffset = 0.01;
		//zoom in
		//map.setZoom(8);
		//capture point clicked
		var point = new GLatLng(lat, lon);
		//clear previous marker
		map.clearOverlays();
		//center map
		//map.setCenter(new GLatLng(lat,lon),6);
		//create new marker object
        marker = new GMarker(point);
		//add new marker obejct to markers array
        markers.push(marker);
		//add marker to overlay as overlay object
        map.addOverlay(new GMarker(point));
		//store lat/lng in hidden html fields for population of displayed lat/lng html fields on button click
		document.getElementById("hiddenlat").val = Lat5;
		document.getElementById("hiddenlng").val = Lng5;
		//build location message w/ marker coordinates
	    var mymsg = "<strong>Location of map's marker:</strong> Latitude: <strong>"+Lat5+"</strong> Longitude: <strong>"+Lng5+"</strong>"; 
		//display location message in div
		document.getElementById("LatLonMsg").innerHTML = mymsg;
	  });	  
      // ====== Create a Client Geocoder ======
      var geo = new GClientGeocoder(); 

      // ====== Array for decoding the failure codes ======
      var reasons=[];
      reasons[G_GEO_SUCCESS]            = "Success";
      reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
      reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
      reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
      reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
      reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
      reasons[G_GEO_SERVER_ERROR]       = "Server error: The geocoding request could not be successfully processed.";
      
      // ====== Geocoding ======
      function showAddress()
	  {
        var search = document.getElementById("search").value;
		//clear previuos Google Maps overlays to remove map marker
		map.clearOverlays();
        // ====== Perform the Geocoding ======        
        geo.getLocations(search, function (result)
          { 
            // If that was successful
            if (result.Status.code == G_GEO_SUCCESS)
			{
				// How many resuts were found
				document.getElementById("message").innerHTML = "Found " +result.Placemark.length +" result(s)";
				// Loop through the results, placing markers
				for (var i=0; i<result.Placemark.length; i++)
				{
					var p = result.Placemark[i].Point.coordinates;
					var marker = new GMarker(new GLatLng(p[1],p[0]));
					document.getElementById("message").innerHTML += "<br>"+(i+1)+": "+ result.Placemark[i].address + marker.getPoint();
					document.getElementById("hiddenlat").val =  marker.getPoint().lat();
					document.getElementById("hiddenlng").val = marker.getPoint().lng();
					map.addOverlay(marker);
				}
				// centre the map on the first result
				var p = result.Placemark[0].Point.coordinates;
				map.setCenter(new GLatLng(p[1],p[0]),3);  // the last number is the zoom factor
				  
				//parse returned coordinates string into lng/lat array
				coordinates = result.Placemark[0].Point.coordinates;
			  
			  	//create location message for div	  			  
				var mymsg = "<strong>Location of map's marker:</strong> Latitude: <strong>"+coordinates[1]+"</strong> Longitude: <strong>"+coordinates[0]+"</strong>"; 
				//display location message in div
				document.getElementById("LatLonMsg").innerHTML = mymsg;
            }
            // ====== Decode the error status ======
            else
			{
              var reason="Code "+result.Status.code;
              if (reasons[result.Status.code])
			  {
                reason = reasons[result.Status.code]
              } 
              alert('Could not find "'+search+ '" ' + reason);
            }
          }
        );
      }
    }
    
    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
	
	function copygeopoint()
	{
		//assign previous lat/lng saved in hidden inputs to vars
		var hiddenlat = document.getElementById("hiddenlat").val;
		var hiddenlng = document.getElementById("hiddenlng").val;
		//check to see if geocoding has produced coordinates
		if(hiddenlat && hiddenlng)
		{
			//assign previous lat/lng values to visible input fields
			document.getElementById("lat").value = hiddenlat;
			document.getElementById("lon").value = hiddenlng;
		}
		else
		{
			alert("We didn't get your coordinates.  Please check the geocoding and try your copy again.");
		}
	}

	
	function cleargeopoint()
	{
		//clear Google Maps overlays to remove map marker
		map.clearOverlays();
		//clear geocoding message results div
		document.getElementById("message").innerHTML = "";
		document.getElementById("LatLonMsg").innerHTML = "";
		//clear user entered address from input box
		document.getElementById("search").value = "";
		//clear any previously saved lat/lng in hidden inputs
		document.getElementById("hiddenlat").val="";
		document.getElementById("hiddenlng").val="";
	}
		
		
</script>




</div> <!-- wrapper -->

</body>

</html>