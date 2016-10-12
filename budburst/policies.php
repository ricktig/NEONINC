<?php 
/*------------------------------------------------
# Author: Kirsten K. Meymaris (UCAR)
# Modified by Rich Zigrino
# Modified by Greg Newman (NewmanDesigns.org)
# Last modified 1/9/11
# Copyright 2008-2010 All Rights Reserved	
# University Corporation for Atmosperhic Research, 	
# Chicago Botanic Gardens, & University of Montana	
--------------------------------------------------*/

require 'cgi-bin/db_connect.php';
require_once 'cgi-bin/pb_lib.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
HeaderStart("Project BudBurst Policies"); // The first and only parameter is the page title
//
// place script tags and or style tags here if needed
//
HeaderEnd();
?>

<body id="about">

<div id="wrapper">

 <div id="contentwrapper">
  
	<?php
		WriteTopLogin($dbh);
	?>
    
    <!-- Top Navigation -->

	<?php	
		WriteTopNavigation();
	?>

<div id="MainContent">
      
      <h1>Policies</h1>
      
      <img style="float:right; padding-left:12px;" src="images/Flower_1_Policies.png" />
      
      <h2>Privacy</h2>
      
      <p>You can visit the Project BudBurst Website without identifying who you are, or revealing personally identifiable information. If you do provide personal information by registering as a member of Project BudBurst we will not sell, trade, or give away your personal information<a href="http://www.ucar.edu/legal/privacy_policy.shtml" target="_blank" class="maincontent"></a>.</p>
      
  <h2>Cookies</h2> 
  Parts of the Project BudBurst Web site may use cookies to improve your interaction with the site or service (e.g.maintaining login information throughout the user experience on the Website).  The Project BudBurst Web site may also use cookies for Web traffic analysis purposes (e.g. determining unique visits to a site).</p>
	  	
      <h2>Children&rsquo;s Guidelines</h2>
        
        Students are advised to consult with their parents before giving any personal information online.
  	    
      <p>Subscription to the <a href="http://visitor.r20.constantcontact.com/manage/optin/ea?v=001c5Zc9ukCtXZWbXgxoxbbzBKCzT_zyMzw8_2aKX7VksGjQz4pM6Y1fugs80-2zVckjlp6FS-37FN-BBL4lZJpKQZFygaRJGgT" target="_blank" class="maincontent">Project BudBurst mailing list</a> will be kept private and is available only to the Project BudBurst Team. You must be over the age of 13 to subscribe to our mailing list. The Project BudBurst mailing list is used only for announcements and updates from the Project BudBurst Team. Messages will be kept to a minimum.</p>
        
      <h2>Terms of Use</h2>
 		
        <p>By using this Site and/or downloading materials from this Site, you, the  user, agree to the terms and conditions set forth in this document (the  &quot;Terms of Use&quot;). If you do not agree to be bound by these Terms of  Use, please promptly exit all Sites.&nbsp; Project BudBurst reserves the right  to modify the Terms of Use in its discretion at any time. Such modifications  will be effective when posted.</p>
  	  <p align="left"> <strong>Site Content.</strong>&nbsp;Throughout this Site you can access images, information, documents,  software, data, models and services (collectively, the &quot;Materials&quot;)  from throughout Project BudBurst. Some of these Materials are governed by their  own specific terms of use and copyrights. In the absence of specific terms of  use, these Terms of Use shall apply. The burden of determining that use of any  Materials on or linked to a Site is permissible, rests with you, the user.</p>
  	  <p align="left"><strong>Use.</strong> The user is granted the right to use this Site for non-commercial,  non-profit&nbsp;research, or educational purposes only, without any fee or  cost. In the event you breach the Terms of Use or terms of use for&nbsp;  specific Materials, or infringe any copyrights, Project BudBurst may suspend or  immediately terminate your access to this Site and the Materials and pursue any  and all legal and equitable remedies available to it, although Project BudBurst  is under no legal obligation to do so.</p>
  	  <p align="left"> <strong>Prohibited Uses.</strong> The  following categories of use are inappropriate and prohibited: <br />
      Use  that is unlawful, harassing or threatening, libelous, defamatory, obscene,  pornographic, or that would violate any law or the rights of others, including  without limitation, copyright laws. </p>
 		  	  <p> 		  	    Use  that impedes, interferes with, impairs, damages or otherwise causes harm to the  activities of others, this Site, the Materials or other Project BudBurst  systems, including but not limited to, spamming, attempts to defeat system  security, unauthorized access or use, distribution of computer viruses, and  modification or removal of data. </p>
 		  	  <p> 		  	    Use  that is inconsistent with Project BudBurst's non-profit status and mission.  Commercial use of this Site or the Materials for non-Project BudBurst purposes  is generally prohibited. Requests for exception to this should be directed to <a href="mailto:budburstweb@neoninc.org">budburstweb@neoninc.org</a>. Use  for the purpose of lobbying that connotes Project BudBurst involvement, except  for authorized lobbying through or in consultation with Project BudBurst. </p>
 		  	  <p> 		  	    Use  that may expose Project BudBurst to criminal or civil liability. </p>
 		  	  <p>The name Project BudBurst  may not be used in any advertising or publicity to endorse or promote any  products or commercial entity unless specific written permission is obtained  from Project BudBurst.</p>
  	  <p align="left"><strong>Copyright.</strong> You  bear the burden of determining the proper usage of any Materials or content on  this Site or any other site.&nbsp; Any copyright notice contained in this  Notice or in any other part of this Site shall remain intact and unaltered and  shall be included with any use or copy of all or any such part of this Site.  The user must include an appropriate citation crediting the source of all or  any portion of this Site.&nbsp; Any complaints about copyright use or infringement  should be processed as stated under the Copyright infringement procedures.</p>
 		  	  <p> 		  	    The  rights granted to you constitute a license and not a transfer of title. Except  as specifically permitted herein or unless agreed to in writing by Project  BudBurst, Project BudBurst does not grant any express or implied right or  license to you under any patents, copyrights, trademarks, or other intellectual  property rights with respect to this Site or the Materials. </p>
 		  	  <p>Unless otherwise agreed to  in writing by Project BudBurst, Project BudBurst is not obligated to provide,  and will not provide, support, consulting, training, or assistance of any kind  whatsoever with regard to the use of the content, operation and/or performance of this Site.</p>
  	  <p align="left"><strong>Links.</strong> This Site contains links to other Web sites that do not belong to  Project BudBurst (&quot;third-party sites&quot;).&nbsp; Any third-party site is  outside the domain of and is not under the control of Project BudBurst. Project  BudBurst is providing the link only as a convenience. Project BudBurst is not  responsible for the content or use of any third-party site or any linked site  contained within the third-party site, or any changes or updates thereto. No  sponsorship, approval or endorsement of any product, service or information  provided by the third-party site, the content of the site, or the site itself  is intended or implied by Project BudBurst. </p>
  	  <p align="left"><strong>Disclaimer/Limitation of Liability.</strong> THE CONTENT ON THIS SITE, INCLUDING THE MATERIALS, IS PROVIDED BY  PROJECT BUDBURST &quot;AS IS.&quot; PROJECT BUDBURST EXPRESSLY DISCLAIMS THE  APPLICABILITY OF THE UNIFORM COMPUTER INFORMATION TRANSACTIONS ACT (UCITA), AND  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED  WARRANTIES OF NONINFRINGEMENT, MERCHANTABILITY AND FITNESS FOR A PARTICULAR  PURPOSE. IN NO EVENT SHALL PROJECT BUDBURST BE LIABLE FOR ANY DAMAGES OF ANY  NATURE SUFFERED BY YOU, ANY USER, OR ANY THIRD PARTY RESULTING IN WHOLE OR IN  PART FROM PROJECT BUDBURST&rsquo;S EXERCISE OF ITS RIGHTS UNDER THESE TERMS OF USE.  IN NO EVENT SHALL PROJECT BUDBURST BE LIABLE FOR ANY SPECIAL, INDIRECT,  PUNITIVE OR CONSEQUENTIAL DAMAGES OR ANY LOSS OR DAMAGES WHATSOEVER, INCLUDING,  BUT NOT LIMITED TO, CLAIMS ASSOCIATED WITH THE LOSS OF DATA OR PROFITS, THAT  ARISE OUT OF OR IN CONNECTION WITH THE ACCESS, USE, CONTENT, PERFORMANCE OF OR  RELIANCE ON THIS SITE, ANY LINKED SITE, ANY LINKS CONTAINED IN ANY LINKED SITE,  OR THE MATERIALS. SOME STATES OR JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF  IMPLIED WARRANTIES OR LIMITATIONS ON HOW LONG AN IMPLIED WARRANTY MAY LAST. TO  THE EXTENT PERMISSIBLE, ANY IMPLIED WARRANTIES ARE LIMITED TO NINETY (90) DAYS.</p>
  	  <p align="left"><strong>Indemnification.&nbsp;</strong>You agree to indemnify and hold Project BudBurst harmless from any  claims, losses or damages, including legal fees, resulting from your violation  of these Terms or your use of the Site, and to fully cooperate in Project  BudBurst&rsquo;s defense against any such claims.</p>
  	  <p align="left"><strong>Laws.</strong> By  visiting the Project BudBurst Site, the user agrees that the laws of the State  of Colorado and the United States of America, without regard to principles of  conflict of laws, will govern these Terms of Use and any dispute that might  arise between the user and Project BudBurst. </p>
	  <p>By visiting and using this Site and the Materials, the User agrees to abide by all laws of the United  States of America, including any applicable export control laws regarding the  use of any or all parts of this Site and the Materials.
 		  	  
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