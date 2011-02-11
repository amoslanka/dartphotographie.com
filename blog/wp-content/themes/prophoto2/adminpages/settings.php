<?php
/*
The "Manage Settings" admin page
*/

// Load library of our custom functions regarding uploading
require_once(dirname(dirname(__FILE__)).'/functions/settings.php');

// Main function: prints the admin page
function p2_settings_page() {
	global $p2, $explain;
	p2_debug_report();
	
	echo '<div class="wrap p2-settings" svn="' . p2_svn( false ) . '">
	<h2>P2 Layouts: save &amp; manage custom layouts</h2>';
	
	$self_check_error = p2_self_check();
	
	if ( isset( $_POST['p2_settings'] ) ) p2_settings_processform( $self_check_error );
	
	echo '<div class="settings-chunk" id="save-settings">
	<h3>Save current layout</h3>
	<p>Once you are happy with your settings (<em>ie</em> theme <a href="admin.php?page=p2-options">options</a> and <a href="admin.php?page=p2-upload">uploads</a>)
	you can store them. This way, it\'s easier for you to try other settings without losing what you\'ve done, or even store multiple layouts to change your site\'s look and feel every so often.</p>
	';
	
	// tell people they can't use IE6 to admin this theme
	echo $explain['major']['noie6'];
	
	echo <<<HTML
	<form action="" method="post" id="p2_settings_form">
	<input type="hidden" name="p2_settings" value="manage"/>
	<p><strong>Name for the current layout:</strong><br /><input type="text" id="p2_settings_name" size="35" name="p2_settings_name" value="" /></p>
	<p>Give it a meaningful and memorable name. Example: <tt>dark_red_biglogo</tt></p>
	<p class="submit self-clear"><input class="button-primary" type="submit" id="p2_settings_submit" value="Save Current Layout"/></p>
HTML;
	wp_nonce_field('p2-settings');
	echo "</form></div>";
	
	echo '<div class="settings-chunk" id="managed-saved-settings">
	<h3 id="manage-saved">Manage saved settings</h3>
	<p>Here is the list of sets you currently have:</p>
	<ul id="settings-list">';
	echo p2_settings_list(); // this function is in functions/settings.php
	echo "</ul></div>";
	echo "</div>"; // wrap
}


?>