<?php
/*
Library of functions used in the uploadage
*/

// Shortcircuit the default upload dir
add_filter('upload_dir', 'p2_upload_dir'); 
// Add styles to the iframed upload form
add_action('admin_head_p2_upload_form', 'p2_upload_form_head'); 
// Add styles to the iframed reset form
add_action('admin_head_p2_reset_form', 'p2_reset_form_head'); 
// Add styles to the iframed upload form
add_action('admin_head_p2_upload_misc_form', 'p2_upload_form_head'); 
// Add styles to the iframed reset form
add_action('admin_head_p2_reset_misc_form', 'p2_reset_form_head'); 



/* Add stuff into the upload page's <head> */
function p2_upload_head() {
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/common.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/upload.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('wpurl').'/wp-includes/js/thickbox/thickbox.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<meta http-equiv="Pragma" content="no-cache" />'."\n";
	// upload.js added by wp_enqueue_script in admin_menu hook
}



/* The upload form. Triggered by wp_iframe('p2_upload_form') in upload-form.php */
function p2_upload_form() {
	// see add_action('media_upload_image_p2') in functions.php
	media_upload_type_form('image_p2');
}



/* The misc upload form. Triggered by wp_iframe('p2_upload_form') in upload-form.php */
function p2_upload_misc_form() {
	media_upload_type_form('misc_p2');
}



/* Add stuff into the upload form's <head> */
function p2_upload_form_head($msg = '', $misc = '') {
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/popup-upload.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/adminpages/js/popup-upload.js"></script>'."\n";

	if (is_bool($misc)) {
		$is_misc = ($misc === true) ? 'true' : 'false' ;
		echo '<script type="text/javascript">var is_misc = '.$is_misc.';</script>';
	}

	if ($msg) 
		echo $msg;
}



/* The reset form. Triggered by wp_iframe('p2_reset_form') in reset-form.php */
function p2_reset_form() {
	include(dirname(dirname(__FILE__)).'/adminpages/popup-reset.php');
}



/* The reset form. Triggered by wp_iframe('p2_reset_form') in reset-form.php */
function p2_reset_misc_form() {
	include(dirname(dirname(__FILE__)).'/adminpages/popup-reset.php');
}



/* Add stuff into the upload form's <head> */
function p2_reset_form_head() {
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/common.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/popup-reset.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').'/adminpages/js/popup-reset.js"></script>'."\n";
}



/*What to do when an image has been uploaded. 
Triggered by add_action('media_upload_image_p2') 
(the do_action is in wp-admin/media-upload.php)
$misc: true for any file, false for image only (default) */
function p2_image_uploaded($misc = false) {
	global $p2;
	
	$msg = '';

	/** debug **
	ob_start();
	echo "<pre>";
	print_r($_POST);
	print_r($_FILES);
	print_r($_REQUEST);
	echo $_SERVER['REQUEST_URI'];
	echo "</pre>";
	$msg .= htmlentities(ob_get_clean());
	/***********/

	if ( isset($_POST['html-upload']) && !empty($_FILES) ) {
		// Upload File button was clicked. Check upload:
		switch($_FILES['async-upload']['error']) {
		case 1:
		case 2:
			die($p2['msg']['file_too_big'].' '.sprintf($p2['msg']['try_again'], $_POST['formurl']));
			break;
		case 3:
			die($p2['msg']['file_partial_upload'].' '.sprintf($p2['msg']['try_again'], $_POST['formurl']));
			break;
		case 4:
			die($p2['msg']['no_file_uploaded'].' '.sprintf($p2['msg']['try_again'], $_POST['formurl']));
			break;
		case 6:
			die($p2['msg']['no_temp_folder']);
			break;
		case 7:
			die($p2['msg']['upload_write_error']);
			break;
		}
		// Check file size
		if (!$misc && $_FILES['async-upload']['size'] > 2084000) {
			die($p2['msg']['file_too_big'].' '.sprintf($p2['msg']['try_again'], $_POST['formurl']));
		}

		// So far, so good, we have a file.
		$upload = p2_media_handle_upload('async-upload', $misc);
		
		// handle errors in a helpful way
		if ( $upload['error'] ) {
			$error_msg = $upload['error'] . ' ' . sprintf($p2['msg']['try_again'], $_POST['formurl'] );
			if ( strpos( $upload['error'], 'Is its parent directory writable by the server?' ) !== false ) {
				$msg = p2_self_check( false, false );
				$error_msg = 'ProPhoto can not upload the file. ' . $msg;
			}
			if ( strpos( $upload['error'], 'ploaded file could not be moved to' ) !== false )
				 $error_msg = 'ProPhoto can\'t upload the file because your "p2" folder (inside "wp-content" > "uploads" is not writeable by the server.  See <a href="http://www.prophotoblogs.com/faqs/p2-not-writeable/">this page</a> for more info on how to fix the problem.';
			die( $error_msg );
		}
		
		// Save image name in DB & randomize flash XML to prevent cacheing problems
		$p2['options']['images'][$_POST['shortname']] = basename($upload['file']);
		$p2['options']['settings']['randomizer'] = "?" . rand( 10000, 99999 );
		p2_store_options();
		
		// Success
		$msg .= '<p>'.$p2['msg']['file_upload_ok'];
		
		// Not in a frame? send back to main page
		if ($_POST['iframed'] == 'false') {
			$msg.=(' <a href="'.get_option('siteurl').'/wp-admin/themes.php?page=p2-upload">Return</a></p>');
		
		} else {
			// In a frame: update background page and add close link
			$shortname = $_POST['shortname'];
			$width = p2_imagewidth($shortname, false);
			$height = p2_imageheight($shortname, false);
			$size = number_format($_FILES['async-upload']['size']/1024);
			$url = $upload['url'];
			$msg .= "<script type='text/javascript'>
			p2_sendtopage('$url', '$shortname', '$width', '$height', '$size');
			</script>
			";
			$msg.=(' <a onclick="return top.tb_remove();" href="#">Close</a></p>');
		}

		@header('Content-Type: text/html'); // Forcing content-type because text/xml makes IE7 go moo
		wp_iframe('p2_upload_form_head', $msg, $misc);
	}
} // end function p2_image_uploaded



/* Upload the file and return file infos
   File infos is an array like:
	array (
	  'file' => 'E:\\home\\ozh\\planetozh.com\\blog/wp-content/uploads/p2/image.jpg',
	  'url' => 'http://192.168.0.1/planetozh.com/blog/wp-content/uploads/p2/image.jpg',
	  'type' => 'image/jpeg',
	)
	or array(
		'error' => 'no file uploaded'
	)
*/
function p2_media_handle_upload($file_id, $misc = false) {
	$overrides = array(
		'test_form' => false,
		'unique_filename_callback' => 'p2_rename_uploaded_image',
	);
	if (!$misc) { // for images, test what is sent. For misc stuff, we don't care
		$overrides['test'] = true; 
		$overrides['mimes'] = array('jpg|jpeg|jpe' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png');
	}
	add_filter('user_has_cap', create_function('$in', '$in["unfiltered_upload"] = false; return $in;')); // disable capability of "unfiltered_upload" to make sure we'll comply to mime types specified here
	$file = wp_handle_upload($_FILES[$file_id], $overrides);
	return $file;
}


/* Rename the uploaded image to match the given 'shortname'. Called by callback in p2_media_handle_upload() */
function p2_rename_uploaded_image($dir, $name) {
	global $p2;
	$shortname = $_POST['shortname'];
	$original = $_FILES['async-upload']['name'];
	if (!$shortname || !$original) {
		var_dump($original);
		die(sprintf($p2['msg']['generic_error'], $_POST['formurl']));
	}
	
	$path_info = pathinfo($original);
    $ext = $path_info['extension'];

	//return $shortname.'.'.$ext;
	return $shortname.'_'.time().'.'.$ext;
}



/* Make some data for p2_upload_box(). 
Everything in array $data will be returned for "extraction" in p2_upload_box() */
function p2_upload_box_data($shortname, $default, $prettyname, $comment, $is_misc=false) {
	global $p2;
	
	$misc = ( $is_misc ) ? 'true' : 'false'; // true for misc file, false for image only
	
	$data['upload_form_url'] = get_bloginfo('template_directory') . "/adminpages/popup.php?do=upload&amp;p2_image=$shortname&amp;misc=$misc&amp;TB_iframe=true&amp;height=110&amp;width=410"; // JARED: the width & height param define the popup size
	$data['reset_form_url'] = get_bloginfo('template_directory') . "/adminpages/popup.php?do=reset&amp;p2_image=$shortname&amp;misc=$misc&amp;TB_iframe=true&amp;height=110&amp;width=410"; // JARED: the width & height param define the popup size
	
	$data['imgurl'] = p2_imageurl($shortname, false);
	$data['imgpath'] = p2_imagepath($shortname, false);
	if (file_exists($data['imgpath']) && $p2['options']['images'][$shortname]) {
		$display_reset = '';
	} else {
		$display_reset = 'display:none;';
	}
	/*
	$custom_upload = p2_upload_dir();
	$imgpath = $custom_upload['path'].'/'.$p2['options']['images'][$shortname]; // this would be our custom image
	// does it exist ?
	if (file_exists($imgpath) && $p2['options']['images'][$shortname]) {
		//$data['reset_link'] = "<a href='{$data['reset_form_url']}' class='thickbox p2_reset_button'>{$p2['msg']['reset_link']}</a>";
		$display_reset = '';
	} else {
		// Nope. Default image then.
		$imgpath = TEMPLATEPATH . "/images/$default";
		//$data['reset_link'] = '';
		$display_reset = 'display:none;';
	}
	*/
	$reset_link_text = 'Reset Image';
	if ( $p2['defaultimages'][$shortname] == 'nodefaultimage.gif') $reset_link_text = "Delete Image";
	if ( $is_misc ) $reset_link_text = 'Delete File';
	
	$data['reset_link'] = "<a href='{$data['reset_form_url']}' style='$display_reset' id='p2_reset_button_$shortname' class='button-primary thickbox p2_reset_button'>{$reset_link_text}</a>";
	
	$data['name'] = basename($data['imgpath']);
	if (!is_file($data['imgpath']) ) {
		$data['error'] = '<p>'.$p2['msg']['image_not_found'].'</p>';
		$data['name'] = '';
	}

	// Image dimensions
	$file_infos = p2_image_infos($data['imgpath']);
	if ($file_infos) {
		$data['width'] = $file_infos[0];
		$data['height'] = $file_infos[1];
	} else {
		$data['width'] = 'unknown';
		$data['height'] = 'unknown';
	}
	
	// File size
	$data['size'] = @filesize($data['imgpath'])/1024;
	if ($data['size'] && $data['size'] < 1) $data['size'] = 1;
	$data['size'] = number_format($data['size']);
	if ( substr( $data['imgpath'], -1 ) == '/' ) $data['size'] = 0;

	// Images recommended dimensions :
	if ($p2['recommendations'][$shortname]) { // either specified
		$data['reco_width'] = $p2['recommendations'][$shortname]['width'];
		$data['reco_height'] = $p2['recommendations'][$shortname]['height'];
	} else if (strstr($shortname, 'flashheader')) { // or dependent from logo because it's a flashheader image
		$data['reco_width'] = p2_flashheader_recommendation('width');
		$data['reco_height'] = p2_flashheader_recommendation('height');
	} else {
		$data['reco_width'] = '';
		$data['reco_height'] = '';
	}

	if (p2_debug()) {
		$data['debug_link'] = "<li>Debug: this image URL with function call:<br/><code>p2_imageurl('$shortname');</code></li>";
	}
	
	return $data;
} // end function p2_upload_box_data




/* Function to print an image and its upload box */
function p2_upload_box($shortname, $prettyname = '', $comment = '', $groupkey = '', $is_misc=false) {
	global $p2;
	$prettyname = ($prettyname) ? $prettyname : $shortname;
	$default = $p2['defaultimages'][$shortname];
	extract (p2_upload_box_data($shortname, $default, $prettyname, $comment, $is_misc));
	
	$upload_button_label = ( $is_misc ) ? 'Upload New File' : 'Upload New Image';

?>

<div class="upload-row<?php if ($groupkey != '') echo ' advanced-image hidden-image-' . $groupkey . '" style="display:none;'?>">
	<div class="upload-row-top self-clear">
		<a id="<?php echo $shortname; ?>-cfe" title="help" class="click-for-explain"></a>
		<div class="upload-row-label">
			<p><?php echo $prettyname; ?></p>
		</div>
		<div class='p2_image_comment'><?php if ( $comment) echo '<p>'. $comment .'</p>'; ?>
			<div id="explain-<?php echo $shortname; ?>" class="extra-explain" style="display:none;"></div>
		</div>
	</div>
	
	<div class="upload-row-main self-clear">
		<div class="image-holder">

		<?php // Case 1: it's an image **********
			if (!$is_misc) {?>
			<?php
				// Width attribute will be set to be 400 or nothing
				$maxwidth = ($width > 475) ? ' width="475"' : '' ;
				if ($maxwidth)
					$message = "Not shown <a href=\"$imgurl\">fullsize</a>"; // This message is duplicated in upload.js
			?>
			<img title="<?php echo $shortname; ?>" id="p2_image_<?php echo $shortname; ?>" class="p2_upload_image" src="<?php echo $imgurl.'?'.$size; ?>"<?php echo $maxwidth; ?> />
			<p class="p2_widthmsg"><?php echo $message; ?></p>
		<?php } // Case 2 : it's a misc file *********
			else { ?>
			<?php
				$extension = end(explode('.',basename($name)));
				$fileicon = p2_fileicon($extension); 
				if ($name ) {?>
			<div class="p2_upload_misc p2_upload_misc_<?php echo $fileicon; ?>">
				<p><?php if ( 'favicon icon' == $fileicon ) { echo "<img src='" . p2_imageurl( $shortname, false ) . "'>"; } else { echo "<a href='$imgurl'>$name</a>"; } ?></p>
			</div>
				<?php } ?>
		<?php } ?>
		</div>

		<div class="image-info">

			<?php // Case 1: it's an image **********
			if (!$is_misc) { ?>
				<?php
				// Do we have to recommend dimensions ?
				if (p2_get_recommendations($shortname)) {
					if (p2_image_follows_reco($shortname)) {
						// perfect match, yeepee
						$displaygood = '';
						$displaybad = 'none';
					} else {
						// omg suxorz fail wrong no
						$displaygood = 'none';
						$displaybad = '';
					}
					 if ( !p2_image_exists( $shortname ) ) $displaybad = 'none';
					
					$recommended = "<span class='p2_fh_dimensions_ok' style='display:$displaygood'>This image is sized correctly</span><span class='p2_fh_dimensions_notok' style='display:$displaybad'>";
				 	$recommended .= "This image is not the recommended dimensions.  Please resize and re-upload."; 
					$recommended .= "</span>";
				
				?>
				<ul class="p2_image_infos p2_image_infos_recommend" id="p2_recommendation_<?php echo $shortname; ?>">
					<li style="line-height:1.1em;">
						<?php if (strstr($shortname, 'flashheader')) { ?> Based on your header layout choice<?php if ( p2_test ( 'headerlayout', 'default' ) || p2_test ( 'headerlayout', 'defaultc' ) || p2_test ( 'headerlayout', 'defaultr' ) ) { ?> and current logo dimensions<?php } ?>, t<?php } else { echo 'T'; }?>his image should be <strong>exactly</strong> <?php
						if ($reco_width && !$reco_height) echo 'this width';
						if ($reco_height && !$reco_width) echo 'this height';
						if ($reco_width && $reco_height) echo 'these dimensions';						
					?>:</li>
					<?php if ($reco_width) { ?>
					<li><strong>Width:</strong> <span class='p2_recommended_width'><?php echo $reco_width; ?></span> pixels</li>
					<?php } ?>
					<?php if ($reco_height) { ?>
					<li><strong>Height:</strong> <span class='p2_recommended_height'><?php echo $reco_height; ?></span> pixels</li>
					<?php } ?>
					<li class="p2_recommended p2_recommended_actual:<?php echo $width.':'.$height; ?>"><?php echo $recommended; ?></li>
				</ul> 
				<?php } // End of "Do we have to recommend dimensions" ?>
				<?php 
				
				
				/*---------------
				---IMAGE STATS---
				----------------*/
				
				$display_style = '';
				if ( !p2_image_exists( $shortname ) ) $display_style = ' style="display:none;"';
				
				
				 ?>
				<ul class='p2_image_infos' id='p2_imginfos_<?php echo $shortname; ?>'<?php echo $display_style; ?>> 
					<li><strong>Current Image Stats:</strong><br />
					<li><strong>Width:</strong> <span class='p2_imginfos_width'><?php echo $width; ?></span> pixels</li>
					<li><strong>Height:</strong> <span class='p2_imginfos_height'><?php echo $height; ?></span> pixels</li>
					<li><strong>Size:</strong> <span class='p2_imginfos_size'><?php echo $size; ?></span> kb</li>
					<li class='p2_imginfos_url'><a href='<?php echo $imgurl; ?>'>View image in browser</a></li>
				</ul>
				<?php // } else {
					
					if ( $p2['defaultimages'][$shortname] == 'nodefaultimage.gif') {
					
					$display = ' style="display:none;"';
					if ( !p2_image_exists( $shortname ) ) $display = ''; ?>
					<ul class="p2_image_infos" id="p2_noimg_<?php echo $shortname; ?>"<?php echo $display; ?>>
					<li>This is not a required image. You may upload one if you choose.</li>
					</ul>
				<?php } ?>
			
			<?php 
			
			
			/*---------------
			----FILE STATS---
			----------------*/
			
			// Case 2: it's a misc file **********
			} else { ?>
				<?php if ( $size ) { // there is a file?>
				<ul class='p2_image_infos' id='p2_imginfos_<?php echo $shortname; ?>'<?php echo $display_style; ?>> 
					<li><strong>Current File Stats:</strong><br />
					<li><strong>File type</strong>: <?php echo $fileicon; ?></li>
					<li><strong>Size:</strong> <span class='p2_imginfos_size'><?php echo $size; ?></span> kb</li>
				</ul>
				<?php } else { // no file uploaded yet ?>
				<ul class="p2_image_infos">
					<li>Nothing uploaded yet.</li>
				</ul><?php } ?>

			<?php } ?>
			<div class="self-clear">
				<a href='<?php echo $upload_form_url; ?>' class='button-primary thickbox p2_upload_button'><?php echo $upload_button_label; ?></a> 			
				<?php echo $reset_link; ?>
			</div>			
		</div>
	</div>
</div>
<?php
} // end function p2_upload_box



/* creates a title header for upload sections */
function p2_upload_header($title, $comment = "") {

echo <<<HTML

	<div class="upload-row-header">
		<p><span class="header-title">$title</span> <span class="header-comment">$comment</span></p>
	</div>

HTML;
	
}



/* an explanation section in the midst of upload boxes */
function p2_image_explanation( $note ) { ?>
<div class="upload-row image-explanation">
	<p><?php echo $note; ?></p>
</div>
<?php	
}



/* creates clickable "show/hide" title for advanced image options */
function p2_advanced_image_title ( $name, $title, $groupkey, $advanced_text = 'advanced', $speed = '400' ) {
	global $p2;
	if ( !$title ) $title = $name;
	extract( p2_upload_box_data( $name, $title, $params, $comment ) );

echo <<<HTML

<div id="aut-$groupkey" class="upload-row hidden-title self-clear">
	<div class="upload-row-label">&nbsp;</div>
	<div class="upload-row-main"><a onclick="javascript:jQuery('#hidden-image-$groupkey').slideToggle($speed); jQuery('#aut-$groupkey').toggleClass('shown');" style="float:right; margin-right:20px; cursor:pointer;">Click to <span class="aut-view">view</span><span class="aut-hide">hide</span> $advanced_text $title image upload options <span class="aut-view">&darr;</span><span class="aut-hide">&uarr;</span></a></div>
</div>
<div id="hidden-image-$groupkey" class="hidden-image-group" style="display:none;">

HTML;
	
}



/* closes out advanced image sections */
function p2_end_advanced_image() {
echo '</div>';
}



/* creates a white row to use as a visual divider */
function p2_upload_spacer () {

echo <<<HTML

<div class="spacer"></div>

HTML;
	
}


/* give extra explanation about masthead height and width, context-sensitive */
function p2_masthead_height_explain( $slideshow = TRUE ) {
	if ( $slideshow ) {
		$wording = "masthead slideshow images";
		
	} else {
		$wording = "masthead header image";
	}
	switch( p2_option( 'headerlayout', 0 ) ) {
		case 'default':
		case 'defaultc':
		case 'devaultr' :
		$explain = " Because of the header layout you've chosen, the height of your " . $wording . " must be the height of the logo you have uploaded.";
		break;
		default:
		$explain = " Because of the header layout you've chosen, your " . $wording . " can be any height";
		if ( $slideshow ) $explain = $explain . ", as long as they are the same";
		$explain = $explain . ".";
	}
	return $explain;
}

?>