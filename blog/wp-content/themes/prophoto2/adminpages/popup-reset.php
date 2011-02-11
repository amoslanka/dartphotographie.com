<?php
/*
This is the reset image to default form. Nothing really to edit here.
*/

if ($_POST['action'] == 'reset') {
	check_admin_referer('reset-image');
	global $p2;
	unset($p2['options']['images'][attribute_escape($_POST['image'])]);
	p2_store_options();
	p2_reset_image_done();
} else {
	p2_reset_image_form();
}

function p2_reset_image_form() {
	global $p2;
	
	$image = attribute_escape($_GET['p2_image']);
	$reset_title = "Delete this image?";
	$reset_button = 'delete';
	if ( $p2['defaultimages'][$image] != 'nodefaultimage.gif') {
		$reset_title = 'Reset this image to default?';
		$reset_button = "reset";
	}
	if ( $p2['miscfiles'][$image] ){
		$reset_title = 'Delete this file?';
		$reset_button = "delete";
	}
	echo <<<FORM
	<h3>{$reset_title}</h3>
	<form method="post">
	<input type="hidden" name="image" value="$image" />
	<input type="hidden" name="action" value="reset" />
	<input type="submit" value="{$reset_button}"/>
FORM;
	wp_nonce_field('reset-image');
	//echo "</form>\n"; // DO NOT close the form. It's closed somewhere else.
}

function p2_reset_image_done() {
	global $p2;
	$shortname = $_POST['image'];
	
	$reset_msg = 'Image reverted to default.';
	if ( $p2['defaultimages'][$shortname] == 'nodefaultimage.gif' ) $reset_msg = 'Image deleted.';
	if ( $p2['miscfiles'][$shortname] ) $reset_msg = 'File deleted.';
	
	echo '<p>'.$reset_msg.'</p>';
	
	// Not in a frame? send back to main page
	if ($_POST['iframed'] == 'false')
		die(' <a href="'.get_option('siteurl').'/wp-admin/themes.php?page=p2-upload">Return</a></p>');
	
	// In a frame: update background page and add close link

	
	$width = p2_imagewidth($shortname, false);
	$height = p2_imageheight($shortname, false);
	$size = p2_imagefilesize($shortname, false);
	$imgurl = p2_imageurl(attribute_escape($_POST['image']), false);
	if ($width == 0 && $height == 0) {
		// it's not an image: refresh the page when closing the popup
		$shortname = 'logo';
	}
	echo "<script type='text/javascript'>
	p2_sendtopage('$imgurl', '$shortname', '$width', '$height', '$size');
	</script>
	";
		die('<a onclick="return top.tb_remove();" href="#">Close</a></body></html>');
}

?>