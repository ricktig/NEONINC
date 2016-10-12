<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Dennis Ward (NEON)
# Modified by Greg Newman (NewmanDesigns.org)
# Last modified 10/24/11
# Copyright 2008-2010 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>

<?php
HeaderStart("BudBurst Partners"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>
<!--<script type="text/javascript" src="js/cloud-carousel/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/cloud-carousel/jquery.mousewheel.min.js"></script>

<script type="text/javascript" src="../js/cloud-carousel/cloud-carousel.1.0.5.js"></script> 

<style type="text/css">
#title-text {
	display:none;	
	color:#f0b900;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:17px;
	font-weight:bold;
	margin:10px;
	text-transform:uppercase;
	letter-spacing:1px;
	margin-bottom:5px;
	width:80%;
}
#alt-text{
	display:none;	
	color:#ddd;
	margin:10px;
	margin-top:0px;
	font-size:14px;
	font-weight:bold;
	
}

#carousel-wrapper{
	width:480px;
    height:280px;
    background:#00723b;
    border-style:solid;
    border-color:#fff;
    border-top-width:10px;
 }
 
#carousel-header{
    height:40px;
	color:#fff;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:22px;
	font-weight:bold;
	text-align:center;
}

#carousel1{
 	width:480px; 
	height:250px;
	float:left;
	background: url(images/carousel_bg1a.jpg);
	overflow:scroll;
}

#about-refuges{
	width:201px;
    border-style:solid;
	border-width:3px;
    border-color:#348d3d;
	font-size:12px;

}

#about-title{
    color:#348d3d;
	font-size:20px;
	font-weight:bold;
	margin:5px;

}

#about-text{
	font-size:12px;
	margin:5px;

}

img {
border-style: none;
}

</style>

<script>
$(document).ready(function(){
	// This initialises carousels on the container elements specified, in this case, carousel1.
	$("#carousel1").CloudCarousel(		
		{			
			xPos: 240,
			yPos: 72,
			minScale: 0.2,
			reflHeight: 50,
			reflGap: 2,
			FPS: 30,
			mouseWheel: true,
			bringToFront: true,
			speed: 0.05,
			autoRotate: 'left',
			autoRotateDelay: 10000,
			buttonLeft: $("#left-but"),
			buttonRight: $("#right-but"),
			altBox: $("#alt-text"),
			titleBox: $("#title-text")
		}
	);
});
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script> -->
<?php
HeaderEnd();
?>

<body id="Partners" onload="MM_preloadImages('refuges/images/partner-button-a.jpg')">

<div id="wrapper">

 <div id="contentwrapper">
  	
   <!--<div><a href="../index.php"><img src="../images/banner_refuges.jpg" alt="Project BudBurst" width="762" height="184" border="0" title="Project BudBurst" /></a></div> -->
    
	<?php
	WriteTopLogin($dbh);
	?>
		
	<!-- Top Navigation -->
	
	<?php	
	WriteTopNavigation();
	?>
    
	<div id="MainContent">
      
      <div id="SpecialSectionWrapper">
      
          <div id="RightColumnSpecialSection">
            <div id="RightSpecialSection">
				<?php displaysocialmedia();?>
				<!--  <p><img src="images/PBB_refuges_Trans.png" width="220" height="161" alt="PBB At Refuges" /> 
				</p> -->
				<!--  <p><a href="refugelist.php">View full list of refuge partners.</a></p> -->
				<h2> Explore Our National Partners</h2>
				<p><a href="refuges/index.php"><img src="images/pbb_refuges_icon.png" style="width:194px;border:0px" /></a></p>
				<p><a href="parks/index.php"><img src="images/pbb_parks_icon.png" style="width:194px;border:0px" /></a></p>
				<h2> Explore Our Regional and Local Partners</h2>
				<p><a href="gardens/index.php"><img src="images/pbb_gardens_icon.png" style="width:194px;border:0px" /></a></p>
				<p><a href="community/index.php"><img src="images/pbb_community_icon.png" style="width:194px;border:0px" /></a></p>
            </div>
          </div>
          
          <div id="LeftColumnSpecialSection_partners">
            <div id="LeftSpecialSection">

		 <!-- removing the carousel per Sandra's request - LAWasser 9-Nov-2012 <div id="carousel-wrapper">
                                            
              <div id="carousel-header">
              	<img src="images/ slideshow-header.png" width="480" height="40" />
              </div> -->
              
              <!-- This is the container for the actual carousel. -->
          <!--    <div id = "carousel1">       -->     
      
	  
			<?php
			//fetch refuge info from tbl_special_projects - added Rick R. 27-Sep-2012
			// $specialprojecttype = 'REFUGES';
			// $datalist = get_special_project_data_list($specialprojecttype, $dbh);
			// echo $datalist;
			?>
	                 
              <!-- Define elements to accept the alt and title text from the images. -->
            <!--  <div id="title-text" style="display: block;"></div>
              <div id="alt-text" style="display: block;"></div>
                    
      
              
              <!-- Define left and right buttons. -->
         <!--     <input id="left-but"  type="image" src="../js/cloud-carousel/back.png" value="Left" style="position:absolute;bottom:5px;right:45px;"/>
              <input id="right-but" type="image" src="../js/cloud-carousel/forward.png" value="Right" style="position:absolute;bottom:5px;right:5px;"/>
              
              </div> <!-- END OF 'carousel1' DIV -->
        <!-- </div> <!-- END OF 'carousel-wrapper' DIV -->
 <!-- end remove carousel -->
    <!--  <br style="clear:both;" />
                
                <div id="LineSeparator"></div> -->
                                
              
<h1>Project BudBurst Partners</h1>
<p>Partnerships are a key part of the success of Project BudBurst. Our partnership programs engage with and connect to diverse communities throughout the country through a citizen science program that is relevant at both the local and national scales. Project BudBurst has two  national partnership programs, <a href="refuges/index.php">BudBurst at the Refuges</a> and <a href="parks/index.php">BudBurst at the Parks</a>, and two regional and local partnership programs <a href="gardens/index.php">BudBurst at the Gardens</a> and <a href="community/index.php">Community BudBurst</a>. On each of the Partner landing pages (which you can access through the icons to the right), you will find resources for specific refuges, parks,  gardens,  and community Project BudBurst partners. </p>

<!--<h2>BudBurst at the Refuges</h2>
<p>BudBurst at the Refuges was Project BudBurst's first partnership program. It was developed through conversations with hundreds of staff and volunteers from both the US Fish and Wildlife Service (USFWS) and the National Wildlife Refuges. The result was a program designed to meet the citizen science outreach needs of USFWS staff.</p>

<h2>BudBurst at the Gardens</h2>
<p>BudBurst at the Gardens grew out of the instrumental partnership between the Chicago Botanic Garden and Project BudBurst. The program was modeled after the BudBurst at the Refuges program and modified to meet the needs of Garden Education and Outreach staff.</p>

<h2>BudBurst at the Parks</h2>
<p>BudBurst at the Parks, the newest Project BudBurst partnership, began in 2012. BudBurst Park partners use Project BudBurst to introduce plant phenology to their visitors, volunteers, staff, and other park stakeholder groups. </p>-->

<h2>How to Contribute</h2>
<p>Planning to visit one of our partners? You can learn about  plants of interest, download resources to take with you on your visit, and make Single or Regular Reports of plants while you're there.</p>


<h2>Become a Partner</h2>
<p>It's easy to  become a  Project BudBurst Partner. We'll work with you develop customized resources that feature 10 plants of interest. You, your visitors, staff and volunteers can report phenological observations. By contributing observations, you will be able to observe how plants are responding (or not responding) to  changing environments.</p>
<p>You will find information for how to become a partner on each of the Partner program landing pages.</p>

   <!--
 <div><a href="staff.php"><img src="images/staff.png" name="volunteers" width="229" height="232" align="left" id="volunteers"></a></div>
<div><a href="visitors.php"><img src="images/visitors.png" name="visitors" width="210" height="106" align="right" id="visitors" /></a><br />
  <div id="edu" ><a href="educators.php"><img src="images/educators.png" name="educators" width="210" height="115" align="right" id="educators" /></a></div></div>  -->
                <br style="clear:both;" />
                
         
            </div>
          </div>
          
          <br style="clear:both;" />
          
      </div>
      
      <!--<br style="clear:both;" />-->
      
    </div><!-- End MainContent -->
	
	<?php
    WriteFooterNavigation();
    ?>
    
    </div><!-- End contentwrapper -->
</div> <!-- End wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>

</html>