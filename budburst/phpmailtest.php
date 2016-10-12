<?php
	//assign current datestamp
	$errordatestamp = date('Y-m-d');
	
	/* FIRST, SEND THE ERROR EMAIL
		  // recipient
		  //$to = 'budburstweb@neoninc.org';*/
		  $to = 'rrose@neoninc.org';
		  
		  // subject
		  $subject = 'Database insert error';
		  // message
		  $message = '<html>
		  <head>
			<h2>Database Insert Error</h2>
		  </head>
		  <body>
		  	  <p>An error has occurred:</p>
			  <blockquote>
				Error in table: ' . $errortablename .'
				<br />Requested by: '. $_SESSION['username'] .'
				<br />Submitted at: '. $errordatestamp .'</p>
			  </blockquote>
			  
		  </body>
		  </html>';
		  
		  // To send HTML mail, the Content-type header must be set
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  // Additional headers
		  $headers .= 'To: BudBurst Helpdesk <'. $to .'>' . "\r\n";
		  $headers .= 'From: NEON <noreply@neoninc.org>' . "\r\n";
		  //$headers .= 'Bcc: dward@neoninc.org' . "\r\n";
		  
		  //debug
		  //print $headers;
		  //print $message;
		  
		  // Mail it
		  mail($to, $subject, $message, $headers);
?>
