<?php
/*
Admin support functions by query
Functions needed for the export functions
*/

function p2_export_settings_make_archive() {
	global $p2;
	require_once (ABSPATH . 'wp-admin/includes/class-pclzip.php');
	require_once (dirname(__FILE__) .'/settings.php');

	$blog = sanitize_title_with_dashes(get_bloginfo());
	
	// save settings into uploads/p2/settings_$blog.php
	p2_settings_save($blog);
	
	// if export archive already exist, remove
	@unlink($path."/$blog.zip");
	
	// create new archive into upload dir
	$custom_upload = p2_upload_dir();
	$path = preg_replace('/^\S+:/', '', $custom_upload['path']); // remove leading "DRIVE:" on Win setups (needed for the PCLZIP_OPT_REMOVE_PATH option below)

	$archive = new PclZip($path."/$blog.zip");

	// add settings file
	$archive->create($path.'/settings_'.$blog.'.php', PCLZIP_OPT_REMOVE_PATH, $path);
	if ($archive == 0) {
		die("Error creating zip file <tt>$path/$blog.zip</tt>: ".$archive->errorInfo(true));
	}
	
	// add all images from $p2['options']['images'] if they exist in upload dir
	if ($p2['options']['images'])
	foreach ($p2['options']['images'] as $image) {
		$file = $path.'/'.$image;
		if (file_exists($file))
			$archive->add($file, PCLZIP_OPT_REMOVE_PATH, $path);
	}
	
	// add all static files
	foreach ($p2['staticfiles'] as $key=>$ar) {
		$archive->add($path.'/'.$ar['static'], PCLZIP_OPT_REMOVE_PATH, $path);
	}
		
	// return result
	return $archive;
}


function p2_export_settings_list_archive($file) {
	$zip = new PclZip($file);
	
	if (($list = $zip->listContent()) == 0) {
		die("Error : ".$zip->errorInfo(true));
	}
	
	echo "<ul>";
	foreach ($list as $array) {
		echo '<li>'.$array['filename']."</li>\n";
	}
	echo "</ul>";
}

?>