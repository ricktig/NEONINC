/*--------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Last modified 4/13/09	
#		   
# Copyright 2008-2009 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
---------------------------------------------------*/

function plant_onchange(speciesID) {
	var ele = document.getElementById("div_hide");
	var text = document.getElementById("displayText");

	if (speciesID == 999)
	{
		document.getElementById("div_hide").style.visibility='visible';
		//ele.style.display = "none";
	}
	else {
		document.getElementById("div_hide").style.visibility='hidden';
		//ele.style.display = "block";
	}
		
} // Java Document


function movevalue()
{
	s = document.getElementById("speciesid");
	document.getElementById("speciesid_selected").value =
	s.options[s.options.selectedIndex].value;
}

function reload(form){
var val=form.cat.options[form.cat.options.selectedIndex].value;
self.location='report_ohs_new.php?cat=' + val ;
}

function show_more(div) {
	var ele = document.getElementById('div');
	
	 if(ele.style.display == 'block')
        document.getElementById('div').style.visibility='visible';
       else
         document.getElementById('div').style.visibility='hidden';

} // Java Document