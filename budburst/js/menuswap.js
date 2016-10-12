/*--------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Last modified 4/13/09	
#		   
# Copyright 2008-2009 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
---------------------------------------------------*/

var imgpath = "images/";

function showImage(imgID) {
   if (imgID == "" || imgID>999){
  
  	imgID = "other"; //default image
	
  }
  
document.images["mainImg"].src = imgpath+imgID+".jpg";
  
  /*  var elmt = document.sample_form.imgMenu;
  for (var i = 0; i < elmt.options.length; i++) {
    if (elmt.options[i].value == imgID) {
      elmt.selectedIndex = i;
      break;
    }
  }*/
  
  
}