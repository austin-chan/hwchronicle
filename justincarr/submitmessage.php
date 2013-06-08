<?php

include('connect.php');

if(empty($_POST)){
	die('error');
}


$name = mysql_real_escape_string( $_POST['name'] );
$email = mysql_real_escape_string( $_POST['email'] );
$message = mysql_real_escape_string( $_POST['message'] );
$anon = 0;
$image = mysql_real_escape_string( $_POST['image'] );

mysql_set_charset('utf8'); 


if(empty($name) || empty($email) || empty($message)){
	die('error');
}

mysql_query("INSERT INTO justincarr (name, email, message, anon) VALUES ('$name', '$email', '$message', '$anon') ");
$id = mysql_insert_id();

if(!empty($image)){
	mysql_query("INSERT INTO justincarrimages (messageid, image) VALUES ('$id', '$image')");	
}

$body = "Thank you for sharing a memory of Justin Carr '14 to the \"Remembering Justin Carr\" page on the Harvard-Westlake Chronicle website.

You can read your submission at http://hwchronicle.com/rememberingjustincarr.

If you did not submit a post, please immediately contact Austin Chan '13 or the Chronicle through our form at hwchronicle.com/about/#contact to remove the post.";

$subject = "Your post to Remembering Justin Carr";
$headers   = array();
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-type: text/plain; charset=iso-8859-1";
$headers[] = "From: Chronicle <chronicle@hw.com>";
$headers[] = "Bcc: David Lim Editor in Chief <dslim23@gmail.com>";
$headers[] = "Subject: {$subject}";
$headers[] = "X-Mailer: PHP/".phpversion();

mail($email, $subject, $body, implode("\r\n", $headers));




die("dfd");

?>