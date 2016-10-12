/*--------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Last modified 4/13/09	
#		   
# Copyright 2008-2009 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
---------------------------------------------------*/

function validate_plant() {
with ( document.form1 ) {      
	if ( plant_com.options[plant_com.selectedIndex].value != "") return "";
   	else return "- plant selection is required\n";
   }
}

function validate_state() {
	with ( document.form1 ) {      
		if ( state.options[state.selectedIndex].value != "") return "";
			else return "- state is required\n";
	   }
}

//check elevation is within US - not a required field though
function validate_elevation(){
	with ( document.form1 ) { 
		var errmess=''; 
		if (isNaN(elevation.value)) {errmess = '- elevation must be a number\n';}
		else if ( elevation.value<0 || elevation.value>15000 )	{
			errmess = '- elevation must be a number between 0 and 15000 feet\n';}
		return errmess;
	}//with
}


//check lat is within US
//already checked for non-empty and decimal
function validate_lat() {
	//$lat = floatval($lat);

	with ( document.form1 ) { 
		var errmess='';     
		if ( state.options[state.selectedIndex].value == "AK"){
				if(lat.value <51|| 72<lat.value ) {
					errmess +='- latitude entered is not within selected state, Alaska\n';
				}
		}/*else if ( state.options[state.selectedIndex].value == "HI"){
				if (lat.value  > 23 || lat.value < 18 ) {
              	 errmess += '- latitude entered is not within selected state, Hawaii\n';
           		 }
		}*/else if (lat.value<24 || 50<lat.value ) {
			errmess += '- latitude entered is not within the US\n';
		}
		return errmess;
	} //with*/
}


//check lon is within US
//already checked for non-empty and decimal
function validate_lon(){
	
	//$long = floatval($long);
	with ( document.form1 ) { 
		var errmess='';
		
		//make negative since US only
		if (lon.value>0){lon.value = -1*lon.value;}
		
		if ( state.options[state.selectedIndex].value == "AK") {
				if( lon.value<-178 || -129<lon.value) {
					errmess += '- longitude entered is not within selected state, Alaska\n';
				}
		}else if ( state.options[state.selectedIndex].value == "HI") {
			if ( lon.value<-161 || -154 <lon.value) {
					errmess += '- longitude entered is not within selected state, Hawaii\n';
			}
		} else if( lon.value<-125 || -66<lon.value) {
			errmess += '- longitude entered is not within the US\n';
		}
		return errmess;
	} //with
}
			
function validate_age13(){
	with ( document.form1 ) {  
		if (age13.checked) return ""; 
		else return "- you must be over the age of 13 to register\n";
	}
}

function validate_site() {
with ( document.form1 ) {      
	if ( stationid.options[stationid.selectedIndex].value != "") return "";
   	else return "- myBudBurst Site is required\n";
   }
}

function validate_plant() {
with ( document.form1 ) {      
	if ( speciesid.options[speciesid.selectedIndex].value != "") return "";
   	else return "- myBudBurst Plant is required\n";
   }
}


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


function MM_validateForm_General() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm_Site.arguments;
	  
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }

	}
	
	if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

//used in register 
function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  
	errors += validate_age13();//extra validation
	errors += validate_state();
	//should check zip is number although not required
		
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }

	}
	  
	if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

//used in register site
function MM_validateForm_Site() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm_Site.arguments;
	
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }

	}
	
	 //extra validation
	  errors += validate_state();
	  errors += validate_lat();
	  errors += validate_lon();
	  errors += validate_elevation();
	  
	if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

//used in register site
function MM_validateForm_Plant() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm_Site.arguments;
	
	  //extra validation
	  errors += validate_plant();
	  errors += validate_site();
	  
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }

	}
	

	  
	if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}

