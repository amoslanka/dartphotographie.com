<?php
/*
Server side processing of the contact form
*/

/* Access only on POST */
if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	@header('HTTP/1.1 405 Method Not Allowed');
	echo '<h1>Method Not Allowed</h1><p>The requested method is not allowed</p>';
	die();
}


// Load config file
if (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php')) {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php'); // WP 2.6+
} else {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-config.php'); // WP 2.5
}

// Check origin
check_admin_referer('p2-contactform');

// set the variables
$name    = attribute_escape($_POST['lastname']);
$email   = attribute_escape($_POST['email']);
$phone   = attribute_escape($_POST['phone']);
$message = attribute_escape($_POST['message']);
$_POST['referpage'] = preg_replace('/#.*$/', '', $_POST['referpage']);


// referpage includes error hash unless it passes all the test
$referpage = attribute_escape($_POST['referpage']) . '#error';


// did the spambot fill out the invisible field?  ha ha!  caught you!
if (!empty($_POST['firstname'])) {
	@header('HTTP/1.1 403 Forbidden');
	//@header( "Location: $referpage" );
	echo '<h1>Forbidden</h1><p>If you feel you get this message and should not, please try again.</p>';
	die();
}


// do some validation, first the spam question
if ( p2_test( 'contactform_antispam_enable', 'on' ) ) {
	if (empty($_POST['anti-spam'])) {
		@header( "Location: $referpage" );
	  	exit ;	
	}
	$user_input = attribute_escape( strtolower( trim( $_POST['anti-spam'] ) ));
	if ( !$user_input ) {
		@header( "Location: $referpage" );
	  	exit ;
	}
	// we have some input check it against acceptible answers
	$answers = p2_option( 'anti_spam_answer_' . intval($_POST['spam_question']), 0 );
	$answers = explode('*', strtolower( $answers ) );
	$spam = true;
	foreach ( $answers as $answer ) {
		if ( $user_input == $answer ) $spam = false;
	}
	if ( $spam ) {
		@header( "Location: $referpage" );
	  	exit ;
	}
}

// check for required fields
if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
   @header( "Location: $referpage" );
   exit ;
}

// is it an email address?
if ( p2_is_not_valid_email( $email ) ) {
   @header( "Location: $referpage" );
   exit ;	
}

// if custom fields are present and required, validate
if ( ( p2_option( 'contact_customfield_label', 0 ) ) && ( ( p2_option( 'contact_customfield_required', 0 ) == 'yes' ) ) && ( empty( $_POST['custom-field'] ) ) ) {
   @header( "Location: $referpage" );
   exit ;	
}
if ( ( p2_option( 'contact_customfield2_label', 0 ) ) && ( ( p2_option( 'contact_customfield2_required', 0 ) == 'yes' ) ) && ( empty( $_POST['custom-field2'] ) ) ) {
   @header( "Location: $referpage" );
   exit ;	
}
if ( ( p2_option( 'contact_customfield3_label', 0 ) ) && ( ( p2_option( 'contact_customfield3_required', 0 ) == 'yes' ) ) && ( empty( $_POST['custom-field3'] ) ) ) {
   @header( "Location: $referpage" );
   exit ;	
}
if ( ( p2_option( 'contact_customfield4_label', 0 ) ) && ( ( p2_option( 'contact_customfield4_required', 0 ) == 'yes' ) ) && ( empty( $_POST['custom-field4'] ) ) ) {
   @header( "Location: $referpage" );
   exit ;	
}


// successful submission, change the hash
$referpage = $_POST['referpage'] . '#success';


if ( get_magic_quotes_gpc() ) {
	$message = stripslashes( $message );
}

// use custom email address, or snag the admin's email address
if ( p2_option( 'contactform_emailto', 0 ) ) {
	$mailto = p2_option( 'contactform_emailto', 0 );
} else {
	$user_info = get_userdata( 1 );
	$mailto = $user_info->user_email;
}

// make the subject
$subject = get_bloginfo( 'name', 'display' ) . " - blog contact form submission";

// pull in the field labels
$name_label 	= p2_option( 'contactform_name_text', 0 );
$email_label 	= p2_option( 'contactform_email_text', 0 );
$phone_label 	= p2_option( 'contactform_phone_text', 0 );
$message_label 	= p2_option( 'contactform_message_text', 0 );
$custom_label 	= p2_option( 'contact_customfield_label', 0 );
//custom fields
$custom_input	= $_POST['custom-field'];
$custom_label2 	= p2_option( 'contact_customfield2_label', 0 );
$custom_input2	= $_POST['custom-field2'];
$custom_label3 	= p2_option( 'contact_customfield3_label', 0 );
$custom_input3	= $_POST['custom-field3'];
$custom_label4 	= p2_option( 'contact_customfield4_label', 0 );
$custom_input4	= $_POST['custom-field4'];

// create the email body
$email_text =

	$name_label . ": " .
	$name
	."\n\n " . $email_label . ": " .
	$email;
	
// custom fields	
if ( $custom_label ) $email_text .=  
	"\n\n " . $custom_label . ": " .
	$custom_input;
	
if ( $custom_label2 ) $email_text .=  
	"\n\n " . $custom_label2 . ": " .
	$custom_input2;
		
if ( $custom_label3 ) $email_text .=  
	"\n\n " . $custom_label3 . ": " .
	$custom_input3;
			
if ( $custom_label4 ) $email_text .=  
	"\n\n " . $custom_label4 . ": " .
	$custom_input4;
	
$email_text .=

	"\n\n " . $message_label . ": \n\n " .
	$message;
	
// ship it
wp_mail($mailto, $subject, $email_text, "From: \"$name\" <$email>\nReply-To: \"$name\" <$email>\nX-Mailer: chfeedback.php 2.02" );
@header( "Location: $referpage" );
exit ;


?>