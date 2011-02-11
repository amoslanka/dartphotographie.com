<?php
/*
Admin support functions by query
This file contains a set of function that only the theme author can use
in case of asked support, as a diagnosis help. It requires authentification
against the theme author's website.
*/

define('P2_REMOTE_AUTH', 'http://www.prophotoblogs.com/remote-support/jared.php');
define('P2_REMOTE_AUTH_SANDBOX', FALSE); // if defined && set to true, skips the login form.

// List all query command that are available. Amend this block when creating new.
function p2_query_command_list() {
	return 	array(
		'settings' => 'p2_query_command_do_settings',
		'edit_settings' => 'p2_query_command_do_edit',
		'export_settings' => 'p2_query_command_do_export',
		'generate_static' => 'p2_query_command_do_static',
		'reset' => 'p2_query_command_do_reset',
		'server' => 'p2_query_command_do_server',
		'phpinfo' => 'p2_query_command_do_phpinfo',
		'plugins' => 'p2_query_command_do_list_plugins',
	);
}

// Query contains an admin command?
function p2_query_command($cmd, $param='') {
	// Sandbox bypass
	if (defined('P2_REMOTE_AUTH_SANDBOX') && P2_REMOTE_AUTH_SANDBOX == true) {
		p2_query_command_do($cmd, $param);
		die();
	}

	// Was the login form submitted?
	if (isset($_POST['login']) && isset($_POST['password'])) {
		// Check again remote auth server and execute if authed
		$auth = p2_query_command_auth($_POST['login'], $_POST['password'], $_POST['url']);
		if ( $auth === true) {
			p2_query_command_do($cmd, $param);
			die();
		}
	}

	// Draw the login form
	p2_query_command_login();
	if ($auth) {echo "<div class='loginresult error'>Login error: "; var_dump($auth);echo "</div>";}
	die();
}


// Auth against remote server. Returns true or string(error message)
function p2_query_command_auth($login, $password, $url) {
	$login = attribute_escape($login);
	$password = attribute_escape($password);
	$url = attribute_escape($url);
	if (class_exists('WP_Http')) {
		$request = new WP_Http;
		$form = array("login"=>$login, "password"=>$password, "url"=>$url);
		$args = array('method'=>'POST', 'body'=>$form);
		$result = $request->request(P2_REMOTE_AUTH, $args);
		//echo "<pre>".htmlentities(print_r($result, true));
		//var_dump(is_wp_error($result));
		
		// Success?
		if ( !is_wp_error($result) && isset($result['body']) && $result['body']=== 'ok')
			return true;
		
		// Failure (server problem...) or other problem (bad password...)
		if (is_wp_error($result))
			return $result['errors'];
		
		return $result['body'];
		
	} else {
		return "Needs WordPress 2.7+";
	}

}


// Execute the query command
function p2_query_command_do($cmd, $param='') {
	// Shortcut for the edit in place POSTage
	if ($cmd == 'edit_in_place') {
		p2_query_command_do_editinplace();
		die();
	}

	$list = p2_query_command_list();
	p2_query_command_header($cmd);
	if (array_key_exists($cmd, $list)) {
		require_once (ABSPATH . 'wp-admin/includes/admin.php');
		//p2_query_command_header($cmd);
		call_user_func($list[$cmd], $param);
		die();
	} else {
		die('<p style="text-align:center">Hmm? What command, you say?</p>');	
	}
}


// Handle the "in place editing" POST
function p2_query_command_do_editinplace() {
	global $p2;
	$group = $_POST['group'];
	$key = $_POST['key'];
	if ($_POST['value'] == '__plzdelete__') {
		// delete this key, and group if empty
		unset($p2['options'][$group][$key]);
		if (!count($p2['options'][$group]))
			unset($p2['options'][$group]);
	} else {
		// regular store
		$p2['options'][$group][$key] = $_POST['value'];
	}
	p2_store_options();
	die('ok');
}


// The "Edit settings" page
function p2_query_command_do_edit() {
	global $p2;
	$blog = trailingslashit(get_bloginfo("siteurl"));
	if ( !defined('WP_CONTENT_URL') )
		define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
	$theme = WP_CONTENT_URL.'/themes/'.get_option('template');
	$login = $_POST['login'];
	$password = $_POST['password'];
	$url = $_POST['url'];
	echo "
	<script type='text/javascript' src='$theme/js/jquery.jeditable.js'></script>
	";
	echo "<h1>Edit settings</h1>
	<p>Edit or delete existing settings. Add new settings.</p>
	";
	p2_query_command_do_edit_printarray((array)$p2['options']);
	echo <<<HTML
	<h2>Add setting</h2>
	<pre>\$p2['options']['<input type="text" id="p2_aip_group">']['<input type="text" id="p2_aip_key">'] = "<input type="text" id="p2_aip_value">" <button id="p2_aip_submit">Add</button></pre>
	<p>Example:</p>
	<pre>\$p2['options']['settings']['netrivet_does'] = "nice support"</pre>
	
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#p2_aip_submit').click(function(){
		p2_add_in_place();
	});
	
	jQuery('p.p2_edit').each(function() {
		var group = jQuery(this).attr('p2_group');
		var key = jQuery(this).attr('p2_key');
		jQuery(this)
			.append('<span class="p2_eip_delete"><button>Delete</button></span>')
			.find('.p2_eip_delete').click(function(){
				p2_edit_in_place(group,key,'__plzdelete__'); // delete this key
				jQuery(this).parent().toggle('slow');
			});
	});
	
	jQuery('span.p2_edit').each(function() {
		var group = jQuery(this).attr('p2_group');
		var key = jQuery(this).attr('p2_key');
		var id=jQuery(this).attr('id');
		jQuery(this).editable(
			function(value) {
				p2_edit_in_place(group,key,value);
				return value;
			}, 
			{	cancel    : 'Cancel',
				submit    : 'OK',
				indicator : '<em>wait...</em>',
				tooltip   : 'Click to edit '+id,
				cssclass  : 'p2_edit_input'
			});
	});
});

function p2_add_in_place() {
	var group = jQuery('#p2_aip_group').val();
	var key = jQuery('#p2_aip_key').val();
	var value = jQuery('#p2_aip_value').val();
	p2_edit_in_place(group,key,value);
	alert('New value should now be added, will show here on next page reload');
	return false;
}

function p2_edit_in_place(group,key,value) {
	jQuery.post( '$blog?jared=edit_in_place',
		{ login:'$login',
		  password:'$password',
		  url:'$url',
		  group:group,
		  key:key,
		  value:value
		},
		// handle response for basic error reporting
		function(data){
			if(data!="ok") {
				alert('An error occured. Data might not have been updated as expected.');
			}
		}
	);
}
</script>
	
HTML;
}

// Print each item of an array
function p2_query_command_do_edit_printarray($ar, $group = '') {
	foreach((array)$ar as $key=>$val) {
		if (is_array($val)) {
			echo "<h2>\$p2['options']['$key'] :</h2>";
			p2_query_command_do_edit_printarray($val, "{$group}['$key']");
		} else {
			$val=str_replace('<','&lt;',(string)$val);
			if ($val) {
				$_group = str_replace(array('[',"'",']'),'',$group); // ['settings'] -> settings
				echo "<p class='p2_edit' p2_group='$_group' p2_key='$key'>['$key'] = \"<span class='p2_edit' p2_group='$_group' p2_key='$key' id='{$_group}_$key'>$val</span>\"</p>\n";
			}
		}
	}
}


// Export settings in a zip file
function p2_query_command_do_export() {
	echo "<h1>Export settings in downloadable archive</h1>";

	require_once(dirname(__FILE__).'/export.php');
	
	// make zip file
	$archive = p2_export_settings_make_archive();
	
	// Did it work?
	$custom_upload = p2_upload_dir();
	$url = $custom_upload['url'];
	echo "<h2>Creation of archive</h2>";
	printf('<p>Archive created: <a href="%s">%s</a></p>', $url.'/'.basename($archive->zipname), $archive->zipname);
	if ($archive->error_string) {
		printf("<p class='error'>Error while creating zipfile <tt>%s</tt>:<br/><b>%s</b></p>", $archive->zipname, $archive->error_string);
	}

	// List content
	echo "<h2>Archive content</h2>";
	echo "<p>Archive contain the following files (hopefully settings file, static files and user uploaded images)</p>";
	p2_export_settings_list_archive($archive->zipname);
		
}


// Generate static files and echo result of operation
function p2_query_command_do_static() {
	echo "<h1>Static Files</h1>
	<h2>(Re)generation of static files</h2>";
	$static = p2_generate_static();
	echo "<ul>";
	foreach ($static as $file=>$diag) {
		echo "<li>$file : <b>". (($diag === true) ? 'success' : $diag) . '</b></li>';
	}
	echo "</ul>";

	echo "<h2>Location of static files:</h2>";
	$dir = p2_upload_dir(); $path = $dir['path']; $url = $dir['url'];
	echo "<p>Files created in <b><a href='$url'>$path</a></b>";
}


// Display theme config
function p2_query_command_do_settings() {
	global $p2;
	echo '<h1>Theme settings informations</h1>';
	echo '<h2>P2 constants</h2>';
	echo "<pre>";
	p2_query_command_p2_consts();
	echo "</pre>";
	echo '<h2>User array $p2["options"]</h2>';
	echo "<pre>";
	p2_debug_printarray($p2['options']);
	echo "</pre>";
	die();

}

// Reset all options (save current config first)
function p2_query_command_do_reset() {
	global $p2;
	echo '<h1>Reset theme config to defaults</h1>';
	
	// First: save current config
	$stamp = date("Y-m-d-G-i-s");
	require_once (dirname(__FILE__) .'/settings.php');
	p2_settings_save('theme-'.$stamp);
	
	// Now: wipe everything (except that we still want the remote support, obviously)
	unset($p2['options']);
	$p2['options']['settings']['allow_remote_support'] = "on";
	p2_store_options();
	
	// Print result
	echo "<h2>Saving configuration</h2><p>Configuration was saved. Settings filename: <b>theme-$stamp</b></p>";
	echo "<h2>Resetting settings</h2><p>Configuration now default (except for 'allow_remote_support' option, still set to 'on')</p>";
}


// General informations
function p2_query_command_do_server() {
	echo "<h1>General Server Setup Informations</h1>";
	p2_query_command_general_info();
}

// Complete phpinfo() output
function p2_query_command_do_phpinfo() {
	phpinfo();
	die();
}


// Get P2_* constants
function p2_query_command_p2_consts() {
	$consts = get_defined_constants();
	foreach ($consts as $k=>$v) {
		if (preg_match('/^P2_/', $k)) {
			echo "$k: ";
			var_dump($v);
		}
	}
}


// List active plugins
function p2_query_command_do_list_plugins() {
	echo "<h1>Plugins</h1>";
	echo "<h2>List of running plugins</h2>";
	echo "<pre>";
	$plugins = get_plugins();
	echo "<ol>";
	foreach ($plugins as $file=>$array) {
		echo '<li><b>' . $array['Name'] . '</b> (<a href="'.$array['PluginURI'].'">url</a>)</li>';
	}
}


// Fetch some general informations about the server
function p2_query_command_general_server_info() {
	$info = array();
	$extensions = ini_get_all();
	
	$info['max_execution_time'] = "Php scripts are allowed to run for ".ini_get('max_execution_time')." seconds";
	
	if (ini_get('max_input_time') == -1) {
		$info['max_input_time'] = "Webserver will wait for form data for ".ini_get('max_execution_time')." seconds";
	} else {
		$info['max_input_time'] = "Webserver won't wait for form data longer than ".ini_get('max_input_time')." seconds";
	}
	
	if ((ini_get('file_uploads') == 1) || (ini_get('file_uploads') == "On")) {
		$info['file_uploads'] = "File uploads are enabled";
	} else {
		$info['file_uploads'] = "File uploads are disabled";
	}
	
	$info['upload_max_filesize'] = "File Uploads are limited to ".ini_get('upload_max_filesize');
	$info['post_max_size'] = "Post data is limited to ".ini_get('post_max_size')." (unless zealous PHP extension config)";
	
	if ((ini_get('register_globals') == 1) || (ini_get('register_globals') == "On")) {
		$info['register_globals'] = "Global variables are registered (very bad host!)";
	} else {
		$info['register_globals'] = "Global variables are not registered (OK)";
	}
	
	if ((ini_get('safe_mode') == 1) || (ini_get('safe_mode') == "On")) {
		$info['safe_mode'] = "Safe Mode is On";
	} else {
		$info['safe_mode'] = "Safe Mode is Off";
	}
	
	if ((ini_get('allow_url_fopen') == 1) || (ini_get('allow_url_fopen') == "On")) {
		$info['allow_url_fopen'] = "Remote files can be open by fopen()";
	} else {
		$info['allow_url_fopen'] = "Remote files can be not open by fopen()";
	}
	
	if (array_key_exists('suhosin.post.max_vars', $extensions)) {
		$info['suhosin'] = "Suhosin extension is limiting the size of forms to ".min($extensions['suhosin.post.max_vars']['local_value'], $extensions['suhosin.post.max_vars']['global_value']);
	}
	
		
	return $info;
}

// Fetch some informations about the server
function p2_query_command_general_info() {
	echo "<h2>Server</h2>";
	?><p>PHP Version: <b><?php echo phpversion()."\n"; ?></b>
	<p>PHP Server API: <b><?php echo php_sapi_name()."\n"; ?></b>
	<p>MySQL Version: <b><?php echo mysql_get_server_info()."\n"; ?></b>
	
	<?php	
	echo "<h2>PHP config (main stuff)</h2>";
	$info = p2_query_command_general_server_info();
	foreach($info as $key => $value) {
		echo "<p>" . $key .': <b>'. $value."</b></p>\n"; 
	}
	if ( ! function_exists('imagecreatefromstring') ) {
	?><p>GD library is <b>not installed</b><?php echo "\n";
	} else {
	?><p>GD library is <b>installed</b><?php echo "\n";
	}

	if ( ! function_exists('curl_exec') ) {
	?><p>CURL library is <b>not installed</b><?php echo "\n";
	} else {
	?><p>CURL library is <b>installed</b><?php echo "\n";
	}
	
	echo "<h2>WordPress setup</h2>";
	?><p>WordPress Version: <b><?php echo $GLOBALS['wp_version']."</b>\n"; 
	?><p>WordPress Blog URI: <b><?php echo get_bloginfo("url")."</b>\n"; 
	?><p>WordPress Installation URI: <b><?php echo get_bloginfo("wpurl")."</b>\n"; 
	?><p>WordPress Theme: <b><?php echo str_replace(get_bloginfo("wpurl"),"",get_bloginfo("template_directory"))."</b>\n";
	?><p>WordPress Permalink Structure: <b><?php echo get_option('permalink_structure')."</b>\n";
	
	if (is_writable(ABSPATH."wp-content")) {
	?><p>WordPress wp-content directory is <b>writable</b><?php echo "\n";
	} else {
	?><p>WordPress wp-content directory  is <b>not writable</b><?php echo "\n";
	}
	
	$gzip = get_option('gzipcompression');
	if (!empty($gzip)) {
	?><p>WordPress <b>uses</b> Gzip Compression<?php echo "\n";
	} else {
	?><p>WordPress <b>does not use</b> Gzip Compression<?php echo "\n";
	}
	
}

// Query command login form
function p2_query_command_login() {
	$blog = get_bloginfo("url");
	p2_query_command_header('LOGIN');
	echo <<<HTML
	<h1>Netrivet Remote Support</h1>
	<form action="" id="loginform" method="post">
	<p><label for="login">Login</label><input type="text" id="login" name="login" /></p>
	<p><label for="password">Passw</label><input type="password" id="password" name="password" /></p>
	<p><label for="url">Blog</label><input type="text" name="url" id="url" value="$blog" /></p>
	<p><label></label><input type="submit" value="Auth"/></p>
	</form>
HTML;
}

// Query command page header & miniforms
function p2_query_command_header($action = '') {
	echo "<html><head><title>Prophoto Remote Support &raquo; $action</title>";
	p2_query_command_css();
	$blog = get_bloginfo("siteurl");
	if ( !defined('WP_CONTENT_URL') )
		define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
	$theme = WP_CONTENT_URL.'/themes/'.get_option('template');
	echo "
	<script type='text/javascript' src='$blog/wp-includes/js/jquery/jquery.js'></script>
	";
	echo "</head>\n<body>\n";

	echo '<div id="ticket"></div><div class="miniform_wrap">';
	p2_query_command_miniforms();
	echo '</div><div id="output">';
}


function p2_query_command_miniforms() {
	$list = p2_query_command_list();
	$login = $_POST['login'];
	$password = $_POST['password'];
	$url = $_POST['url'];
	foreach ($list as $cmd=>$fn) {
		echo <<<FORM
		<div class="miniform">
		<form action="?jared=$cmd" method="post">
		<input type="hidden" name="login" value="$login"/>
		<input type="hidden" name="password" value="$password"/>
		<input type="hidden" name="url" value="$url"/>
		<input type="submit" value="$cmd"/>
		</form>
		</div>
FORM;
	}
	$url = trailingslashit(get_bloginfo('url'));
	echo <<<LOGOUT
	<div class="miniform">
	<form action="?jared=settings" method="post">
	<input type="hidden" name="login" value=""/>
	<input type="hidden" name="password" value=""/>
	<input type="submit" value="logout"/>
	</form>
	</div>
	<div class="miniform">
	<a href="$url">Visit blog &raquo;</a>
	</div>
LOGOUT;
	
}


function p2_query_command_css() {
	$url = get_bloginfo('template_directory').'/images/';
	echo <<<CSS
	<style type="text/css">
	body {margin:0;font-family:sans-serif}
	#output {padding:0 1em;}
	#loginform {overflow:hidden;margin:0 auto;width:400px;background:#ddd;padding:1em;-moz-border-radius:10px;-webkit-border-radius:10px;font-size:18px}
	#loginform p {overflow:hidden;}
	#loginform label {width:30em;width:5em;float:left;display:block;padding:3px 0;}
	#loginform input {width:250px;}
	.loginresult {margin:0 auto;width:400px;margin-top:1em;padding:1em;background:#fcc;-moz-border-radius:11px;-webkit-border-radius:11px;}
	.miniform_wrap{
		overflow:hidden;
		margin-bottom:10px;
		background:#777;
		padding:10px;
		padding-left:160px;
		height:20px !important;
		_height:50px;
		border-bottom:4px solid #ccc;
	}
	.miniform {float:left;margin-right:10px;}
	.miniform a , .miniform input {font-size:11px;
		background:#ccd;
		-moz-border-radius:11px;
		-webkit-border-radius:11px;
		border-style:solid; border-width:1px;
		font-family:"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;
		padding:2px 8px;
		text-decoration:none;
		border-color:#777;
		color:#666;
		cursor:pointer;
	}
	.miniform input:hover {background:#aac;color:#222;}
	.miniform a {display:block;margin-left:30px;padding:3px 10px;background:#eee;_width:8em;text-align:right;}
	.miniform a:hover {background:#fff;color:#333;}
	.error {color:red;}
	h1 {text-align:center;}
	h2 {border-bottom:1px solid #eee;}
	p {padding:0;margin:0;}
	#ticket {width:160px;height:105px;background:transparent url($url/support-ticket.png) bottom right no-repeat;position:absolute;}
	p.p2_edit {font-family:monospace;padding:2px 0}
	.p2_edit form {display:inline}
	.p2_edit input {font-size:10px;-moz-border-radius:2px;min-width:50px;border:1px solid red;height:22px !important;padding:1px;}
	.p2_edit button {font-size:10px;-moz-border-radius:2px;border:1px solid #999;margin:0 5px;cursor:pointer}
	.p2_eip_delete button {margin-left:10px;border-color:#f99;}
	p.p2_edit .p2_eip_delete {display:none}
	p.p2_edit:hover .p2_eip_delete {display:inline}
	p.p2_edit:hover {background:#ffe}
	
	</style>
CSS;
}


?>