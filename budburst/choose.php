<?php 
require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Choose A Plant"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
?>

<script src="jquery-ui-1.9.0.custom/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.min.js"></script>
<link rel="stylesheet" href="jquery-ui-1.9.0.custom/css/ui-lightness/jquery-ui-1.9.0.custom.min.css" />
<script language="javascript" src="js/showhide.js"></script>

<script type="text/javascript">
var newspeciesid;

 $(document).ready(function()
 {
	//clear input box text on page load - Firefox won't do this automatically
	$('#searchbox').val("");
	$('#commonName').val("");
	$('#scientificName').val("");
	$('#plantGroup').val("");
 
	//build json string for jQueryUI autocomplete which autocompletes 
	//species common name when visitor enters three or more characters in input box
	var source = <?php 
	$plant_menu_json = build_species_JSON_allspecies($dbh);
	echo $plant_menu_json;
	?>
	
	//load jQueryUI autocomplete into input box where visitor can enter species name
	$( "#searchbox" ).autocomplete(
	{
			//set number of characters required before matches are returned
			minLength: 3,
			//set source to both common name and scientific name
			source: function(request, response)
			{
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex( request.term ), "i" );
				response($.grep(source, function(value)
				{
					return matcher.test(value.label) || matcher.test(value.description);
				}));
			},
			
			//check for response matches - if none, display div indicating no matches
			response: function(event, ui)
			{
				if(ui.content.length===0)
				{
					//alert('We didn\'t find any matches');
					$('#nomatchesbox').css('display','block');
					$('#nomatchesbox').css('float','left');
				}
				return false;
			},

			//on select, call function to update input fields and image
			select: function(event, ui)
			{
				newspeciesid=ui.item.value;
				selectSpecies(newspeciesid);
				//clear searchbox text on selection of species
				$('#searchbox').val("");
				return false;
			},
			
			//left align results list when opened and set label and description fields to display with <a> tag for clickability - must have <a> to allow click to work!
			open: function(event, ui)
			{
				$('.ui-autocomplete').css('text-align', 'left');
			}			
	}).data( "autocomplete" )._renderItem = function( ul, item )
	{
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( "<a>" + item.label + "<em> " + item.description + "</em></a>" )
			.appendTo( ul );
	};//end autocomplete function
	
	//clear no matches found box on keyup (keypress doesn't react to backspace key, keyup does)
	$("#searchbox").keyup(function()
	{
		$('#nomatchesbox').css('display','none');
	});
		
	//load jQueryUI accordion for questions tabbing functionality
	$( "#accordion" ).accordion(
	{

	});
}); //end document ready function

//function to fetch selected species data via AJAX call to PHP query
//and assign results to HTML elements and update image
function selectSpecies(newspeciesid)
{
	$.ajax(
	{
		type: "POST",
		url:"choose_select_plant.php",
		data: "newspeciesid=" + newspeciesid,
		dataType: "json",
		success:function(result)
		{
			document.getElementById('commonName').value = result.commonName;
			document.getElementById('scientificName').value = result.scientificName;
			document.getElementById('plantGroup').value = result.plantGroupName;	
			//load species image
			$("#plantIMG").attr("src", "images/" + newspeciesid + ".jpg");
			//display continue button
			$('#goButton').show();
		}//end success
	});//end ajax
}//end selectSpecies()
</script>

<!--set width of three display boxes for common name, scientific name, and plant group name-->
<style type="text/css">
input[type=text]
{
width:300px;
}

#accordion .ui-accordion-header{
color:black
}

#accordion .ui-state-hover{
border:1px solid #D3D3D3; 
background-color:#FFFFFF;  
}

#accordion .ui-accordion-header-active{
border:1px solid #D3D3D3;
}

#accordion .ui-accordion-header-icon{
color:#D3D3D3;
}

#accordion .ui-state-default{
background-color:#FFFFFF;
}

h3:hover{
background-color:#FFFFFF;
}

</style>

<?php
//
HeaderEnd();
?>

<body id="PlantResources">
<div id="wrapper">
	<div id="contentwrapper">
		<!-- <div> 			<a href="index.php"><img src="images/Banner_3.jpg" width="762" height="165" alt="Project BudBurst" title="Project BudBurst" border="0" /></a>		</div> -->
		
		<?php
			WriteTopLogin($dbh);
		?>
			
		<!-- Top Navigation for Home Page -->

		<?php	
			WriteTopNavigation();
		?>

			<div id="MainContent">
				<div id="SpecialSectionWrapper" style="height:1500px">
					<div id="RightColumnSpecialSection" style="width:276px">
						<div id="RightSpecialSection" style="width:264px;">
							<br />
							<div id="SectionHeaderRefugePage">
								Project BudBurst's<br />
								10 Most Wanted Species
							</div>
							<div id="Top10HeaderText" style="margin: 10px 0 10px 0;">
								Have you seen any of the species below?  If you have any information regarding the whereabouts of these plants, please report them to the proper authorities &ndash; the Project BudBurst community! 
								<a href="mostwanted.php" tabindex="1">Learn more&hellip;</a>
							</div>
							<div id="Top10DivHolder">
						 
								 <?php 
									$result_sp = get_speciesid_for_special_projects(21, $dbh); //21=PBB TOP TEN WANTED
									$specialSpeciesIDArray = array();
									$specialSpeciesCommonNameArray = array();
									$specialSpeciesSciNameArray = array();
									$specialSpeciesShortDescriptionArray = array();
									
									if ($result_sp->num_rows == 0) {
									$error.='<p>Sorry, no species could be found in the database.<br>
									Please contact the <a href = "mailto:budburstweb@neoninc.org" class="maincontent">Web Manager</a> with the following error:<br>choose.php - no top ten species information found</p>';
									}
										
									while($row_sp = $result_sp->fetch_object()){
										array_push($specialSpeciesIDArray, $row_sp->Species_ID);
										array_push($specialSpeciesCommonNameArray, $row_sp->Common_Name);
										array_push($specialSpeciesSciNameArray, $row_sp->Species);
										//array_push($specialSpeciesShortDescriptionArray, $row_sp->Short_Description);
									}//while
								
								?>
								 
								<?php 
									$sizeof_arr = sizeof($specialSpeciesIDArray);
									for ($i=0; $i<$sizeof_arr; $i++)
									{
										//create alternating column layout with left/right floats
										if ($i % 2)
										{
											$float = 'right';
										} 
										else
										{
											$float = 'left';
										}
										//$specialSpeciesShortDescriptionArray_1[$i]=str_replace(array("ì","î","'","'","Ë"),array("\"","\"","'","'","e"),$specialSpeciesShortDescriptionArray[$i]);
										
										echo '<a href="plantresources_speciesinfo.php?speciesid=' . $specialSpeciesIDArray[$i] .
										'"><div class="mostwantedplants" style="width:120px; height:180px; margin:0 0 10px 0; border: 1px solid grey; float:' . $float .'">';
																			
										echo '<img src="images/'. $specialSpeciesIDArray[$i] . '.jpg" alt="' . $specialSpeciesCommonNameArray[$i] . '" height="120px" width="120px" border="0" style="border-radius:8px"/>';
										echo '<div style="padding:3px 0 0 3px;line-height:1.3">';
										echo $specialSpeciesCommonNameArray[$i] . '<br />';
										echo '<em style="font-size:0.75em;">' .$specialSpeciesSciNameArray[$i] . '</em>';
										echo '</div></div></a>';						
									} //for
									?>
							</div><!--end toptenholder-->
						</div><!--end rightspecialsection-->
					</div><!-- end rightcolumnspecialsection -->
					  
				<div id="LeftColumnSpecialSection">
					<div id="LeftSpecialSection">
							<!--<div style="float:right; width:284px;">-->
							
							<h1>Choose A Plant</h1>
							<p style="font-family: Verdana, Geneva, sans-serif;  width: 380px; height: 145px;">"How do I choose a plant to monitor?" is probably one of the most frequently asked questions at Project BudBurst. You can search for species on the Project BudBurst 10 Most Wanted plants, the Project BudBurst Master Plant List, browse species by state and more. Take a minute or two and explore the resources on this page and decide which plant is right for you. </p>
							<div style="width:410px; height:205px; padding: 15px 10px 10px 10px; background-color:#FCDAB0; border-radius:10px;">
								<div class="ui-widget" style="font-family:Arial;height:45px">
									Search for your plant by common or scientific name <br />
									<img src="images/search_16x16.png" alt="search button" width="18" height="18" align="absbottom" border="0" id="searchButton" name="searchButton" style="float:left"/>
									<input type="text" id="searchbox" name="searchbox" style="text-align:left; width:263px;float:left" tabindex="2"/>
									<div id="nomatchesbox" style="display:none;padding-left:5px" >
										No matches found
									</div>
								</div>	
									
								<div style="height:132px;">
									<img src="images/0.jpg" width="100px" height="100px" alt="Plant image" style="float:right; border: 1px solid grey; margin: 13px 0 0 0;color:black;" id="plantIMG" />
									<div class="ui-widget" style="margin-top:1em; font-family:Arial;width:300px;float:left">
										Common Name: <input style="width: 180px;color:#000000;" readonly="readonly" id="commonName" />
									</div>
									<div class="ui-widget" style="margin-top:1em; font-family:Arial;width:300px;float:left;">
										Scientific Name: <input style="width: 180px;color:black;" readonly="readonly" id="scientificName" />
									</div>
									<div class="ui-widget" style="margin-top:1em; font-family:Arial;width:300px;float:left">
										Plant Group: <input style="width: 200px;color:black;" readonly="readonly" id="plantGroup" />
									</div>
								</div>
								<div style="margin: 0 auto;width:270px">
									<input id="goButton"  type="button" value="That's The One!  Show Me More About It..." style="display:none;font-family:Arial;" onclick="location.href='plantresources_speciesinfo.php?speciesid=' + newspeciesid;"/>
								</div>
							</div>
						<br />
							<div id="buttonholder" style="margin: 0 auto 0 auto;font-size:.9em;height:30px;width:410px;">
								<input id="top10SpeciesButton"  type="button" onclick="location.href='mostwanted.php'" value="Top 10 Species" style="float:left;width:117px;margin: 0 5px;padding: 5px 0" class="buttons" tabindex="3"/>
								<input id="browseByStateButton"  type="button" onclick="location.href='plantresources_list_bystate.php'" value="Browse By State" style="float:left;width:126px;margin: 0 3px;padding: 5px 0" class="buttons" tabindex="4"/>
								<input id="browseAllSpeciesButton"  type="button" class="buttons" onclick="location.href='display_all_plants_list.php'" value="Browse All Species" style="float:left;width:142px;margin: 0 3px;padding: 5px 0" tabindex="5"/>
							</div><!--buttonholder-->

							<div style="margin-left:12px; width:410px;"><!-- 462 was good -->
							<br />
							<div id="LineSeparator"></div>
							<br />
							<div style="width:400px;"><h3 style="margin: 0">Select a Plant Group...</h3>
										<ul class="plantgrouplinks">
											<li>
												<a href='plantresources_list.php?PlantGroupID=1' tabindex="6">
													<img src="images/plantGroups/1.png" height="32" width="32" alt="Wildflowers and Herbs" />
													<p>Wildflowers and Herbs</p>
												</a>
											</li>
											<li>
												<a href="plantresources_list.php?PlantGroupID=3" tabindex="7">
													<img src="images/plantGroups/3.png" height="32" width="32" alt="Deciduous Trees and Shrubs" />
													<p>Deciduous Trees and Shrubs</p>
												</a>
											</li>
											<li>
												<a href="plantresources_list.php?PlantGroupID=4" tabindex="8">
													<img src="images/plantGroups/4.png" height="32" width="32" alt="Evergreen Trees and Shrubs" />
													<p>Evergreen Trees and Shrubs</p>
												</a>
											</li>
											<li>
												<a href="plantresources_list.php?PlantGroupID=2" tabindex="9">
													<img src="images/plantGroups/2.png" height="32" width="32" alt="Grasses" />
													<p>Grasses</p>
												</a>
											</li>
											<li>
												<a href="plantresources_list.php?PlantGroupID=5" tabindex="10">
													<img src="images/plantGroups/5.png" height="32" width="32" alt="Conifers" />
													<p>Conifers</p>
												</a>
											</li>
										</ul>
								</div>
								<div style="clear:both;" />
							</div>
							<div id="LineSeparator"></div>
							<div id="questions">
								<h3 style="margin: 10px 0 10px 0">Questions?</h3>
								<div id="content" style="width:415px;">
									<div id="accordion" style="margin:0 auto 0 auto; width:415px; height:500px; font-family: Arial,Helvetica,sans-serif;">
										<h3 style="font-weight:bold;">Help! I couldn't find my plant on your list.<br>
										  How do I to enter "other" plants?</h3>
										<div>
											<p>
											Want to monitor a plant that isn't on the Project BudBurst Master Plant List? No problem! Although we prefer that people make observations of the plants from our list, we recognize that not everyone has access to plants from our Master List. Therefore, we support observations of any plant species that is of interest to you.</p>

											<p>
											You can use our Project BudBurst Generic field journals (found on the Regular Observations page) or our Single Report forms to record observations about species not on the Project BudBurst Master Plant List. When you're ready to report your observations on the website, follow the usual steps for reporting Regular Observations or Single Reports and choose "Other" from the bottom of the species dropdown lists.</p>
										</div>
										<h3 style="font-weight:bold;">What are native, non-native, and invasive plants?</h3>
										<div>
											<p>
											All plants respond in some way to changing environments and for that reason, Project BudBurst is interested in collecting data on all kinds of plants, including native, non-native, and invasive species. You can report observations for all of these types of plants through Project BudBurst.</p>

											<p>Wondering what all of these terms mean? We've included definitions below:</p>

											<p>Native:  A commonly accepted definition for native plant is any plant species that was present in the area prior to European colonization. Examples: Southern magnolia, Red maple, and California poppy.</p>

											<p>Non-native plant: A plant that was introduced after European colonization. A common example of a non-native plant is the Common lilac. Non-native plants are not, by default, invasive plants. Sometimes non-native plants are called exotics. Examples: Common lilac, Alfalfa, and Apple trees.</p>

											<p>Invasive plant: A plant that was introduced after European colonization and is adversely affecting the new area either ecologically, economically, or as it relates to human health. Examples: Kudzu, Cheatgrass, and Purple loosestrife</p>
										</div>
										<h3 style="font-weight:bold;">What are cultivars?</h3>
										<div>
											<p>
											A cultivar (cultivated variety) is a plant selected for specific characteristics and maintained through propagation.  Cultivars can be developed through plant breeding programs or can be selections of a wild variety. Red maple trees provide a great example of cultivars. The "native" red maple tree, Acer rubra, has been grown and selected so it now includes many types of cultivars, such as 'Autumn Blaze', 'Red Sunset', 'Burgundy Bell' and more. Each of these cultivars have different characteristics and may behave a little differently in their phenology.  We are interested in these differences. Do you have a cultivar of a Project BudBurst species that you'd like to monitor? Great! If you know the name of the cultivar, we encourage you to enter it in the "Additional Comments" box when you go to report an observation of that species. For example, if you have are monitoring a Red maple tree and you know the cultivar is 'Autumn Blaze', type 'Autumn Blaze' into the Additional Comments box. If you know you have a Red maple but aren't sure which cultivar it is, just select Red maple from the dropdown box for your observation.
											</p>
										</div>
										<h3 style="font-weight:bold;">What plant is this?</h3>
										<div>
											<p>
											Need help identifying a plant? Send a photo to <a href="mailto:budburstinfo@neoninc.org?Subject=Plant ID">budburstinfo@neoninc.org</a> and one of our botanists will help you figure it out!
											</p>
										</div>
									</div><!--end accordion div-->
								</div><!--end content div-->
							</div><!--end questions div-->
					</div><!--LeftSpecialSection-->
				</div>
			</div><!--end leftcolumnspecialsection-->
		</div><!-- end special section wrapper-->
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