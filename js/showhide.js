/*--------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Last modified 4/13/09	
#		   
# Copyright 2008-2009 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
---------------------------------------------------*/

function toggle(speciesID) {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(speciesID == "999") {
    		ele.style.display = "none";
		text.innerHTML = "show";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "hide";
	}
} 



function toggle2(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "show";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "hide";
	}
} 


function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
}


