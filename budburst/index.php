<?php
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Modified by Rick Rose
# Last modified 12/3/2012
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
HeaderStart("Welcome to Project BudBurst"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<!-- include jQuery library -->
<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
<!-- include Cycle plugin -->
<!--<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.2.72.js"></script>-->
<script type="text/javascript" src="js/cycle/cycle.js"></script>

<!-- slideshow script itself expecting CSS class .slideshow -->
<script type="text/javascript"> 
	$(document).ready(function()
	{
		//initialize jscycle slideshow
		$('.slideshow').cycle({
			//fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		});
		
		$('.StoryBoardSlideShow').cycle({
			//fx: 'slide', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
			autostop: 0, //, // autostop after X slides where X is defined below
			startingSlide: 0, // zero-based 
			speed: 2000,
			pager: '#gallerynav',
			pagerEvent: 'mouseover',
			fastOnEvent: true,
			pagerAnchorBuilder:paginate,
			allowPagerClickBubble: true
			//autostopCount: 6
		});
		
		function paginate(ind, el)
		{
				if (ind==0)
				{
					return '<a href="popclock/index.php">Pop<br/>Clock</a>';
				}
				else if (ind==1)
				{
					return '<a href="cherry/index.php">Cherry Blossom<br/>Blitz</a>';
				}
				else if (ind==2)
				{
					return '<a href="nelop/index.php">New England<br/>Leaf Out</a>';
				}
				else (ind==3)
				{
					return '<a href="website_update.php">What\'s New<br/>For 2013</a>';
				}
		}//end paginate()
	});
</script>


<script type="text/javascript"> 
	function DoChangeStartingSlide(SlideNumber)
	{
		//alert("slide="+SlideNumber);
		
		$('.StoryBoardSlideShow').cycle(
		{
			startingSlide: SlideNumber //, // zero-based 
		});
	};
</script>

<style>
.number {width:24px; height:24px; margin-left:405px;  z-index:8; position:absolute;}
.number:hover {cursor:pointer;}

#Button1 {margin-top:-231px; background-image:url(images/Home/Story_Button_1_00.png);}
#Button1:hover {background-image:url(images/Home/Story_Button_1_01.png); cursor:pointer;}

#Button2 { margin-top:-204px;  background-image:url(images/Home/Story_Button_2_00.png);}
#Button2:hover {background-image:url(images/Home/Story_Button_2_01.png);}

#Button3 { margin-top:-177px;   background-image:url(images/Home/Story_Button_3_00.png);}
#Button3:hover {background-image:url(images/Home/Story_Button_3_01.png);}

#Button4 {margin-top:-150px;  background-image:url(images/Home/Story_Button_4_00.png);}
#Button4:hover {background-image:url(images/Home/Story_Button_4_01.png);}

#Button5 {margin-top:-123px;  background-image:url(images/Home/Story_Button_5_00.png);}
#Button5:hover {background-image:url(images/Home/Story_Button_5_01.png);}

#Button6 {margin-top:-96px;  background-image:url(images/Home/Story_Button_6_00.png);}
#Button6:hover {background-image:url(images/Home/Story_Button_6_01.png);}

ul
{
list-style-image:url(images/1_bannerRedesign/PBBIconBullet.png);
padding:0 5px 0 20px;
}
li{
background-position:0px 5px;
padding-right:2px; 
}

#StoryBoard{
width:450px;
height:100%;
}

.StoryBoardSlideShow img{
border-radius:0;
}

#gallerynav{
width:100%;
height:35px;
}

#gallerynav a{
display:inline-block;
background:#0D6636;
width:112.5px;
height:35px;
text-align:center;
line-height:1.3em;
text-decoration:none;
color:white;
cursor:pointer;
}

#gallerynav a.activeSlide{
background:#70962F;
}

.uparrow { /*arrow added to uparrowdiv DIV*/
content:'';
display:block;
position:absolute;
top:-20px; /*should be set to -border-width x 2 */
left:30px;
width:0;
height:0;
border-color: transparent transparent black transparent; /*border color should be same as div div background color*/
border-style: solid;
border-width: 10px;

}
	

</style>

<?php
//
HeaderEnd();
?>



<body id="Home">

<div id="wrapper">

  <div id="contentwrapper">
  	
    <!-- <div><a href="index.php"><img src="images/Banner_0.jpg" width="762" height="184" alt="Project BudBurst" title="Project BudBurst" border="0" /></a></div> -->
    
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation for Home Page -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">

<div id="RightColumnSpecialSection">
<div id="RightSpecialSection" style="width:226px;padding:12px 5px 12px 5px">
<?php displaysocialmedia();?>

<!-- BEGIN RECENT REPORTS CODE -->
  <div> <!--removed ID="RecentReports" -->
            	<h2>Recent Reports </h2>
                <div id="SectionContainer" style="padding:10px 0 0 0" >
                  <?php 			
					// get most recent 3 observations
					
				$qry=" SELECT * FROM view_RecentObs";
							/*"GROUP BY tbl_observations.Observer_ID ".
							"ORDER BY MAX(tbl_observations.Observation_Date)DESC LIMIT 3";*/

					$RecentReportsSet=$dbh->query($qry);
					
					//if ($result->num_rows>0)
					//{
						while ($row=$RecentReportsSet->fetch_object())
						{
							$Observer_ID=$row->Observer_ID;
							$Phenophase_ID=$row->Phenophase_ID;
							$Phenophase_Name=$row->Phenophase_Name;
							$Observation_Date=$row->Observation_Date;
							$Species_ID=$row->Species_ID;
							$Common_Name=$row->Common_Name;
							$First_Name=$row->First_Name;
							$Last_Name=$row->Last_Name;
							$Station_City=$row->Station_City;
							$Station_State=$row->Station_State;
							$Addr_City=$row->Addr_City;
							$Addr_State=$row->Addr_State;
							$Creation_Date=$row->Creation_Date;
							$Plant_Group_ID=$row->Plant_Group_ID;
							$Plant_Group_Name=$row->Plant_Group_Name;
							
							// convert mysql date to phpdate or timestamp format for display
							$phpdate=strtotime($Observation_Date);
							$DisplayDate=date('M j',$phpdate);
							
							$phpdate2=strtotime($Creation_Date);
							$DisplayCreationDate=date('M j',$phpdate2);
							
							echo("<div>"); // 60? background-color:green; 
							
								//$PhenophaseIconID=substr($Phenophase_ID,1,2);
								echo("<div class='recentOb'>"); // background-color:red;
								
								echo("<img style='float:left; width:32px; height:32px; margin-right:4px;' src='images/1_bannerRedesign/plantGroups/$Plant_Group_ID.png' alt='$Plant_Group_Name' title='$Phenophase_Name' />");
								echo("<div style='color:#1B6120; font-size:9pt; font-weight:bold;'>".$Phenophase_Name." on ".$DisplayDate." </div>");
									//echo("<div style='height:1px; clear:both;'> </div>");
									if (($Station_City!="")&&($Station_State!=""))
									{
										echo("<div class='recentObCont'>".$Common_Name." in ".$Station_City.", ".$Station_State."</div>");
									}
									else if ($Station_State!="")
									{
										echo("<div class='recentObCont'>".$Common_Name." in ".$Station_State."</div>");
									}
									else
									{								
										if (($Addr_City!="anonymous")&&($Addr_State!="anonymous"))
										{
											if (($Addr_City!="")&&($Addr_State!=""))
											{
												echo("<div class='recentObCont'>".$Common_Name." in ".$Addr_City.", ".$Addr_State."</div>");
											}
											else if ($Addr_State!="")
											{
												echo("<div class='recentObCont'>".$Common_Name." in ".$Addr_State."</div>");
											}
										}
										else
										{
											echo("<div class='recentObCont'>".$Common_Name."</div>");
										}
									}
									
									if ($First_Name)
									{
										echo("<div class='recentObCont'>Submitted by ".$First_Name." on ".$DisplayCreationDate."</div>"); // $Observation_Date
									}
									else
									{
										echo("<div class='recentObCont'>Submitted on ".$DisplayCreationDate."</div>"); // $Observation_Date
									}
									
								echo("</div>");
								
								//echo("<br />");
										
							echo("</div>");	
							
							//echo("<br />");		
							echo("<div style='height:10px; clear:both;'> </div>");  //USE THIS DIV TO SET SPACING UNDER EACH REPORT		
						}
					//}
					//else
					//{
						//echo("There are no results to display");
					//}
					
					?>
                </div>
        	</div>
            <!-- END RECENT REPORTS CODE -->
  <H2>Quick Links </H2>
  <ul>
  <li><a href="http://visitor.r20.constantcontact.com/manage/optin/ea?v=001c5Zc9ukCtXZWbXgxoxbbzBKCzT_zyMzw8_2aKX7VksGjQz4pM6Y1fugs80-2zVckjlp6FS-37FN-BBL4lZJpKQZFygaRJGgT" target="_blank">Sign up for our newsletter!</a></li>
</ul>
  <ul>
   <li><a href="http://www.citizenscienceacademy.org/" target="_blank">Citizen Science Academy: Register for courses!</a></li>
  <li><a href="results_data.php">Download Data</a></li>
  </ul>

</div>
</div>

<div id="LeftColumnSpecialSection" style="width:470px;margin:20px 0 0 0">
<div id="LeftSpecialSection">
<!-- START storyboardslideshow -->
<div id="StoryBoard"> 
	<div class="StoryBoardSlideShow" style="width:450px"> <!-- Added an inline width adjustment to force the width... -->
		<a class="slide" href="popclock/index.php"><img src="images/slideshow/popclock_apr2013.jpg" style="width:450px;height:240px" alt="Pop Clock" /></a>
		<a class="slide" href="cherry/index.php"><img src="images/slideshow/cbb_mar2013.jpg" style="width:450px;height:240px" alt="Love is in the air!" /></a>
		<a class="slide" href="nelop/index.php"><img src="images/slideshow/nelop_mar2013.jpg" style="width:450px;height:240px" alt="New England Leaf Out Program" /></a>
		<a class="slide" href="website_update.php"><img src="images/slideshow/growing_feb2013b.jpg" style="width:450px;height:240px" alt="We're growing!" /></a>
		<!--<a class="slide" href="http://citizenscienceacademy.org"><img src="images/slideshow/pd_jan2013.jpg" style="width:450px;height:240px" alt="Professional Development for Educators" /></a>
		<a href="mybudburst.php"><img src="images/slideshow/data_jan2013.jpg" width="450" height="240" alt="Enter your 2012 data today" border="0" /></a>-->
	</div> 
	<div id="gallerynav"></div>
</div>
<!-- END StoryBoard -->

<h1>Welcome to Project BudBurst!</h1>
<p>Every plant tells a story. Whether you have an afternoon, a few weeks, a season, or a whole year, you can make an important contribution to a better understanding of changing climates. Project BudBurst is a network of people across the United States who monitor plants as the seasons change and submit ecological data based on the timing of leafing, flowering, and fruiting of plants. If you would like to make a meaningful contribution to understanding environmental change, join our rapidly growing community today! We are looking forward to learning more about the stories your plants can tell.</p>

<div style="width:450px; margin:30px 15px 0 0; padding:0px;">
<?php 
					//$highlight = date('W') - 14; //highlighting a new plant every week, starting in April
					$highlight = date('W'); //highlighting a new plant every week, based on 52 weeks
					//echo("highlight=$highlight<br>");
					
					//get highlighted species ID, not selecting highlight text, but could later...
					//$qry = sprintf("SELECT Species_ID, Highlight_Text FROM tbl_weekly_plant_haikus WHERE ID = %d", $highlight);	
					//echo("qry=$qry");
					
					
					$qry = sprintf("SELECT Species_ID, Highlight_Text, Haiku_1, Haiku_2, Haiku_3, Credits ".
						"FROM tbl_weekly_plant_haikus WHERE ID = $highlight and Species_ID > 0 ".
						"ORDER BY ID DESC LIMIT 1");
					
					$result = $dbh->query($qry);
					$row = $result->fetch_object();
					//if ($result->num_rows == 0) { 
						//$speciesID=23; //default to dandelion
						//$highlightText="Are trilliums up yet?";
				  	//}
					if ($row->Species_ID==0)
					{ 
						$qry = sprintf("SELECT Species_ID, Highlight_Text, Haiku_1, Haiku_2, Haiku_3, Credits ".
						"FROM tbl_weekly_plant_haikus WHERE ID = $highlight and Species_ID > 0 ".
						"ORDER BY ID DESC LIMIT 1");
						//echo("qry=$qry");
						$result = $dbh->query($qry);
						$row = $result->fetch_object();
						$speciesID = $row->Species_ID;
						$highlightText=$row->Highlight_Text;
						$credits=$row->Credits;
						
						$Haiku_1=$row->Haiku_1;
						$Haiku_2=$row->Haiku_2;
						$Haiku_3=$row->Haiku_3;						
					}
					else
					{
						//$row = $result->fetch_object();
						$speciesID = $row->Species_ID;
						$highlightText=$row->Highlight_Text;
						$credits=$row->Credits;
						
						$Haiku_1=$row->Haiku_1;
						$Haiku_2=$row->Haiku_2;
						$Haiku_3=$row->Haiku_3;	
					}
					
					//get species info
					$qry = sprintf("SELECT Species_ID, Common_Name, Species, Photo_Filename, Photo_Credit 
									FROM tbl_species WHERE Species_ID = %d", $speciesID);
					//echo("qry=$qry");									
					$result = $dbh->query($qry);
					
					if ($result->num_rows == 0)
					{ 
						//can fail silently
					}
					else
					{
						$row = $result->fetch_object();
						$commonName = $row->Common_Name;
						$speciesName = $row->Species;
						$photoFileName= $row->Species_ID; //not using Photo_Filename field yet still using Species_ID
						$photoCredit = $row->Photo_Credit;
					}
					
					//if ($highlightText!='NULL') $Text=$highlightText;
					//else $Text=$commonName;
					
					?>
                    
              <div style="float:left; margin-top:20px;"> <!-- float:left; -->
              <a href="plantresources_speciesinfo.php?speciesid=<?php echo $speciesID; ?>"><img width="160" style="border-radius:10px; border:solid 2px #666; box-shadow: 5px 5px 5px #ccc;" src="images/<?php echo $speciesID; ?>_m.jpg" alt="<?php echo $commonName; ?>" title="<?php echo $commonName; ?>" /></a></div>
            
            <!--NEW DIV for Plant of the week test -->        
            <div style="padding:0 px; margin-left:180px;">
            	<h3 style="color:#306848; font-size:1.3em; margin:0 0 8px 0;border-bottom:5px solid #9BCE46"><?php echo("$commonName");?></h3>
                   <?php
					echo("<p style='padding-left:5px; margin:0px; font-size:1.2em; color:#306848; font-style:italic;'>$speciesName</br>"); // $Text
					?>
           <!--< p>-->
                
            	<!-- Write out the Haiku -->
               <div style="font-size:1.2em; padding-left:7px;"><br />                      
 				<?php  echo $Haiku_1;?> <br />
			    <?php echo $Haiku_2;?><br />
			    <?php echo $Haiku_3;?><br />
				<?php 
					if($credits)
					{
						echo '<div style="font-size:0.8em; float:right; font-style:italic;">&ndash; Haiku submitted by ';
						echo $credits;
						echo '</div>';
					}
				?>
                <br /> <!-- spacing between haiku and learn more -->
                <?php echo("<span style='float:left; font-size:0.8em; padding-top:5px;'><a href='plantresources_speciesinfo.php?speciesid=$speciesID'>Learn more about the Plant of the Week...</a></span>");?></p>
                
                
                </div>
            </div>
		    <!--<span style="font-size:.7em; line-height:1em; color:#666"> <?php // echo $photoCredit;?></span>
-->
</div>
</div>
</div>

<div id="RightColumn">            
	<div id="SpecialSections" >
    </div>            
</div><!-- right col -->
        
<div id="LeftColumn">
<br />            
<br />
</div><!-- left col -->
<br style="clear:both;" /><!--<br class="clearFloat" />-->
</div><!-- MainContent -->

<?php	
WriteFooterNavigation();
?>

</div> <!-- contentwrapper -->
</div> 
<!--wrapper -->

<?php
mysqli_close($dbh);
WriteGoogleAnalytics();
?>

</body>
</html>