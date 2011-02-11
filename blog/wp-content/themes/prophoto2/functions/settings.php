<?php
/*
Library of functions used in the settings management
*/

// Add stuff into the upload page's <head>
function p2_settings_head() {
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/common.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/settings.css" rel="stylesheet" type="text/css" />'."\n";
	//echo '<link href="'.get_bloginfo('siteurl').'/wp-includes/js/thickbox/thickbox.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<meta http-equiv="Pragma" content="no-cache" />'."\n";
}

// Save setting array into a flat file
function p2_settings_save($setname = '') {
	global $p2;
	
	$setname = p2_settings_setname_sanitize($setname);
	if (!$setname)
		return "No name given to set";	
	
	$custom_upload = p2_upload_dir();
	$file = $custom_upload['path'].'/'.'settings_'.$setname.'.php';
	
	ob_start();
	echo '<'.'?php $p2["options"] = ';
	var_export($p2['options']);
	echo '; ?>';
	$out = ob_get_contents();
	ob_end_clean();
		
	return p2_writefile($file, $out);
}

// Delete a settings file
function p2_settings_delete($file = '') {
	return @unlink($file);
}

// Load a settings set
function p2_settings_activate($file = '') {
	//$custom_upload = p2_upload_dir();
	//$file = $custom_upload['path'].'/'.'settings_'.$setname.'.php';

	if (!file_exists($file) or !is_readable($file))
		return "Cannot read file, or file is missing (file is: $file)";
		
	global $p2;
	
	//ob_start();
	require($file);
	//$out = ob_get_clean(); // the output buffer to make sure nothing will accidentally echo
	
	p2_store_options();
	
	return true;
}


// Process setting forms
function p2_settings_processform( $self_check_error = '' ) {
	//echo "<pre>";var_dump($_POST);echo "</pre>";

	if ( $self_check_error ) return;
	
	check_admin_referer( 'p2-settings' );

	$msg = $result = '';
	$class = 'updated fade';
	
	switch($_POST['p2_settings']) {
	case 'manage':
		$result = p2_settings_save($_POST['p2_settings_name']);
		$msg = ($result === true) ? 'Settings saved.' : 'Error: '.$result;		
		break;

	case 'delete':
		$result = p2_settings_delete($_POST['p2_settings_name']);
		$msg = ($result === true) ? 'Settings deleted.' : 'Error: '.$result;		
		break;
		
	case 'activate':
		$result = p2_settings_activate($_POST['p2_settings_name']);
		$msg = ($result === true) ? 'Settings loaded.' : 'Error: '.$result;		
		break;
	}
	
	if ( $msg == 'Error: not fopen') {
		$class = 'error';
		$msg = 'ProPhoto could not write settings file.  See <a href="http://www.prophotoblogs.com/faqs/p2-not-writeable/">this page</a> for info on how to fix this.';
	}
	if ( strpos( $msg, 'Error:' ) !== false ) $class = 'error';
	
	p2_message( $msg, true, $class );	
	
}

// Make set name simple
function p2_settings_setname_sanitize($setname = '') {
	// Very destructive set of function to allow only a limited set of characters
	$setname = str_replace(' ','_',$setname);
	$setname = preg_replace('/[^a-zA-Z0-9_-]/','',$setname);
	$setname = trim($setname);
	$setname = addslashes($setname);
	return $setname;	
}

// Get list of saved settings
function p2_settings_list() {

	$custom_upload = p2_upload_dir();

	$list = array_merge(glob($custom_upload['path'].'/'.'settings_*.php'), glob(TEMPLATEPATH .'/images/settings_*.php'));

	if (!$list)
		return "<li>No saved set yet!</li>";
	
	$return = '';
	
	ob_start();
	wp_nonce_field('p2-settings');
	$nonce = ob_get_contents();
	ob_end_clean();
	
	
	foreach ($list as $set) {
		$setname = preg_replace('/^settings_/', '',  basename($set));
		$setname = preg_replace('/.php/', '', $setname);
		
		$miniform_activate = "
			<span class='p2_settings_activate'>
				<form action='' method='post'>
				$nonce
				<input type='hidden' name='p2_settings_name' value='$set'/>
				<input type='hidden' name='p2_settings' value='activate'/>
				<input type='submit' onclick=\"javascript:return(confirm('If you have made design changes that you have not saved to a layout, you will lose those changes. Are you sure you want to activate this layout?'))\" value='Activate'/>
				</form>
			</span>";
			
		$miniform_delete = "";
		// if the setting file is shipped with the theme (ie in the p2/images directory) then don't add a delete button
		if (trailingslashit(str_replace('\\', '/', dirname($set))) != trailingslashit(str_replace('\\', '/', TEMPLATEPATH . '/images/')))
		$miniform_delete = "
			<span class='p2_settings_delete'>
				<form action='' method='post'>
				$nonce
				<input type='hidden' name='p2_settings_name' value='$set'/>
				<input type='hidden' name='p2_settings' value='delete'/>
				<input type='submit' onclick=\"javascript:return(confirm('Delete?'))\" value='Delete'/>
				</form>
			</span>";
		
		$return .= "<li><span class='p2_setname'>$setname</span>
		<span class='p2_settings_miniforms'>
			$miniform_activate
			$miniform_delete
		</span>
		</li>\n";
	
	}
	
	return $return;

}





?>