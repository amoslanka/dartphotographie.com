<?php
/*
This file is the iframed popup. NOT TO BE EDITED.
*/

function auth_redirect() {return true;} // We don't want to be redirected to a login form if unauthed. Security & permissions handled by current_user_can()

if (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php')) {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php'); // WP 2.6+
} else {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-config.php'); // WP 2.5
}
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-admin/admin.php');
require_once(dirname(dirname(__FILE__)).'/adminpages/upload.php');

wp_enqueue_script('jquery');
wp_enqueue_script('swfupload');
wp_enqueue_script('swfupload-degrade');
wp_enqueue_script('swfupload-queue');
wp_enqueue_script('swfupload-handlers');

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));

if (!current_user_can('upload_files'))
	wp_die(__('You do not have permission to upload files.'));

// Some options for the uploader:
add_filter('flash_uploader', create_function('','return false;')); // No flash uploader: it wont allow us to define our own upload dir :/
add_filter('media_upload_tabs', create_function('','return false;')); // No tabs

$action = attribute_escape($_GET['do']);
if (attribute_escape($_GET['misc']) == 'true')
	$action .= '_misc';

wp_iframe('p2_'.$action.'_form'); // This is what draws the page content

// A few additional fields
echo '<input type="hidden" name="shortname" value="'.$_GET['p2_image'].'" />';
echo '<input type="hidden" name="formurl" value="'.$_SERVER['REQUEST_URI'].'" />';
// Are we in a frame ? A 'standalone' (not iframed) page has an URL with TB_iframe=true in the GET
parse_str($_SERVER['REQUEST_URI']);
$iframe = ($TB_iframe) ? 'false' : 'true' ;
echo '<input type="hidden" name="iframed" value="'.$iframe.'" />';


?>