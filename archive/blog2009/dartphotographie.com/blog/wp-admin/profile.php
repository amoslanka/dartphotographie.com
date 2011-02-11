<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Dart Photographie &rsaquo; Profile &#8212; WordPress</title>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function(func) {if (typeof jQuery != "undefined") jQuery(document).ready(func); else if (typeof wpOnload!='function'){wpOnload=func;} else {var oldonload=wpOnload; wpOnload=function(){oldonload();func();}}};

function convertEntities(o) {
	var c = function(s) {
		if (/&[^;]+;/.test(s)) {
			var e = document.createElement("div");
			e.innerHTML = s;
			return !e.firstChild ? s : e.firstChild.nodeValue;
		}
		return s;
	}

	if ( typeof o === 'string' )
		return c(o);
	else if ( typeof o === 'object' )
		for (var v in o) {
			if ( typeof o[v] === 'string' )
				o[v] = c(o[v]);
		}
	return o;
};
//]]>
</script>
<link rel='stylesheet' href='css/global-962.css' type='text/css' media='all' />
<link rel='stylesheet' href='wp-admin-962.css' type='text/css' media='all' />
<link rel='stylesheet' href='css/colors-fresh-962.css' type='text/css' media='all' />
<!--[if gte IE 6]>
<link rel='stylesheet' href='css/ie-962.css' type='text/css' media='all' />
<![endif]-->
<script type='text/javascript' src='../wp-includes/js/jquery/jquery.js?ver=1.2.6'></script>
<script type='text/javascript' src='../wp-includes/js/hoverIntent.js?ver=20081210'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	userSettings = {
		url: "/blog/",
		uid: "2",
		time: "1281648332"
	}
/* ]]> */
</script>
<script type='text/javascript' src='js/common.js?ver=20081210'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery.color.js?ver=2.0-4561'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	pwsL10n = {
		empty: "Strength indicator",
		short: "Very weak",
		bad: "Weak",
		good: "Medium",
		strong: "Strong"
	}
	try{convertEntities(pwsL10n);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='js/password-strength-meter.js?ver=20081210'></script>
<script type="text/javascript">
(function($){

	function check_pass_strength () {

		var pass = $('#pass1').val();
		var user = $('#user_login').val();

		$('#pass-strength-result').removeClass('short bad good strong');
		if ( ! pass ) {
			$('#pass-strength-result').html( pwsL10n.empty );
			return;
		}

		var strength = passwordStrength(pass, user);

		if ( 2 == strength )
			$('#pass-strength-result').addClass('bad').html( pwsL10n.bad );
		else if ( 3 == strength )
			$('#pass-strength-result').addClass('good').html( pwsL10n.good );
		else if ( 4 == strength )
			$('#pass-strength-result').addClass('strong').html( pwsL10n.strong );
		else
			// this catches 'Too short' and the off chance anything else comes along
			$('#pass-strength-result').addClass('short').html( pwsL10n.short );

	}

	function update_nickname () {

		var nickname = $('#nickname').val();
		var display_nickname = $('#display_nickname').val();

		if ( nickname == '' ) {
			$('#display_nickname').remove();
		}
		$('#display_nickname').val(nickname).html(nickname);

	}

	$(document).ready( function() {
		$('#nickname').blur(update_nickname);
		$('#pass1').val('').keyup( check_pass_strength );
		$('.color-palette').click(function(){$(this).siblings('input[name=admin_color]').attr('checked', 'checked')});
    });
})(jQuery);
</script>
</head>
<body class="wp-admin ">

<div id="wpwrap">
<div id="wpcontent">
<div id="wphead">

<img id="header-logo" src="../wp-includes/images/blank.gif" alt="" width="32" height="32" /> <h1 ><a href="../index.html" title="Visit site">Dart Photographie <span>&larr; Visit site</span></a></h1>

<div id="wphead-info">
<div id="user_info">
<p>Howdy, <a href="profile.php" title="Edit your profile">lauradart</a><span class="turbo-nag hidden"> | <a href="tools.php">Turbo</a></span> |
<a href="../wp-login-9883.php" title="Log Out">Log Out</a></p>
</div>

<div id="favorite-actions"><div id="favorite-first"><a href="post-new.php">New Post</a></div><div id="favorite-toggle"><br /></div><div id="favorite-inside"><div class='favorite-action'><a href='edit-17030.php'>Drafts</a></div>
<div class='favorite-action'><a href='page-new.php'>New Page</a></div>
<div class='favorite-action'><a href='media-new.php'>Upload</a></div>
<div class='favorite-action'><a href='edit-comments.php'>Comments</a></div>
</div></div>
</div>
</div>


<div id="wpbody">

<ul id="adminmenu">


	<li class="wp-first-item wp-has-submenu menu-top menu-top-first menu-top-last" id="menu-dashboard">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='index.php' class="wp-first-item wp-has-submenu menu-top menu-top-first menu-top-last" tabindex="1">Dashboard</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Dashboard</div><ul><li class="wp-first-item"><a href='index.php' class="wp-first-item" tabindex="1">Dashboard</a></li><li><a href='index-45891.php' tabindex="1">Akismet Stats</a></li></ul></div></li>
	<li class="wp-menu-separator"><br /></li>
	<li class="wp-has-submenu wp-menu-open menu-top menu-top-first" id="menu-posts">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='edit.php' class="wp-has-submenu wp-menu-open menu-top menu-top-first" tabindex="1">Posts</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Posts</div><ul><li class="wp-first-item"><a href='edit.php' class="wp-first-item" tabindex="1">Edit</a></li><li><a href='post-new.php' tabindex="1">Add New</a></li><li><a href='edit-tags.php' tabindex="1">Tags</a></li><li><a href='categories.php' tabindex="1">Categories</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top" id="menu-media">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='upload.php' class="wp-has-submenu menu-top" tabindex="1">Media</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Media</div><ul><li class="wp-first-item"><a href='upload.php' class="wp-first-item" tabindex="1">Library</a></li><li><a href='media-new.php' tabindex="1">Add New</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top" id="menu-links">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='link-manager.php' class="wp-has-submenu menu-top" tabindex="1">Links</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Links</div><ul><li class="wp-first-item"><a href='link-manager.php' class="wp-first-item" tabindex="1">Edit</a></li><li><a href='link-add.php' tabindex="1">Add New</a></li><li><a href='edit-link-categories.php' tabindex="1">Link Categories</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top" id="menu-pages">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='edit-pages.php' class="wp-has-submenu menu-top" tabindex="1">Pages</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Pages</div><ul><li class="wp-first-item"><a href='edit-pages.php' class="wp-first-item" tabindex="1">Edit</a></li><li><a href='page-new.php' tabindex="1">Add New</a></li></ul></div></li>
	<li class="menu-top menu-top-last" id="menu-comments">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='edit-comments.php' class="menu-top menu-top-last" tabindex="1">Comments <span id='awaiting-mod' class='count-0'><span class='pending-count'>0</span></span></a></li>
	<li class="wp-menu-separator"><br /></li>
	<li class="wp-has-submenu menu-top menu-top-first" id="menu-appearance">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='themes.php' class="wp-has-submenu menu-top menu-top-first" tabindex="1">Appearance</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Appearance</div><ul><li class="wp-first-item"><a href='themes.php' class="wp-first-item" tabindex="1">Themes</a></li><li><a href='widgets.php' tabindex="1">Widgets</a></li><li><a href='theme-editor.php' tabindex="1">Editor</a></li><li><a href='themes-45977.php' tabindex="1">P2 Options</a></li><li><a href='themes-62259.php' tabindex="1">P2 Uploads</a></li><li><a href='themes-23238.php' tabindex="1">P2 Layouts</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top" id="menu-plugins">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='plugins.php' class="wp-has-submenu menu-top" tabindex="1">Plugins <span class='update-plugins count-1'><span class='plugin-count'>1</span></span></a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Plugins <span class='update-plugins count-1'><span class='plugin-count'>1</span></span></div><ul><li class="wp-first-item"><a href='plugins.php' class="wp-first-item" tabindex="1">Installed</a></li><li><a href='plugin-install.php' tabindex="1">Add New</a></li><li><a href='plugin-editor.php' tabindex="1">Editor</a></li><li><a href='plugins-50170.php' tabindex="1">Akismet Configuration</a></li></ul></div></li>
	<li class="wp-has-submenu wp-has-current-submenu wp-menu-open menu-top" id="menu-users">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='users.php' class="wp-has-submenu wp-has-current-submenu wp-menu-open menu-top" tabindex="1">Users</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Users</div><ul><li class="wp-first-item"><a href='users.php' class="wp-first-item" tabindex="1">Authors &amp; Users</a></li><li><a href='user-new.php' tabindex="1">Add New</a></li><li class="current"><a href='profile.php' class="current" tabindex="1">Your Profile</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top" id="menu-tools">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='tools.php' class="wp-has-submenu menu-top" tabindex="1">Tools</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Tools</div><ul><li class="wp-first-item"><a href='tools.php' class="wp-first-item" tabindex="1">Tools</a></li><li><a href='import.php' tabindex="1">Import</a></li><li><a href='export.php' tabindex="1">Export</a></li><li><a href='update-core.php' tabindex="1">Upgrade</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top menu-top-last" id="menu-settings">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='options-general.php' class="wp-has-submenu menu-top menu-top-last" tabindex="1">Settings</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Settings</div><ul><li class="wp-first-item"><a href='options-general.php' class="wp-first-item" tabindex="1">General</a></li><li><a href='options-writing.php' tabindex="1">Writing</a></li><li><a href='options-reading.php' tabindex="1">Reading</a></li><li><a href='options-discussion.php' tabindex="1">Discussion</a></li><li><a href='options-media.php' tabindex="1">Media</a></li><li><a href='options-privacy.php' tabindex="1">Privacy</a></li><li><a href='options-permalink.php' tabindex="1">Permalinks</a></li><li><a href='options-misc.php' tabindex="1">Miscellaneous</a></li></ul></div></li>
	<li class="wp-menu-separator-last"><br /></li></ul>
<div id="wpbody-content">
<div id="screen-meta">
	<div id="contextual-help-wrap" class="hidden">
	<h5>Help</h5><div class="metabox-prefs"><a href="http://codex.wordpress.org/" target="_blank">Documentation</a><br /><a href="http://wordpress.org/support/" target="_blank">Support Forums</a></div>
	</div>

<div id="screen-meta-links">
<div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
<a href="#contextual-help" id="contextual-help-link" class="show-settings">Help</a>
</div>
</div>
</div>
<div id='update-nag'>WordPress 3.0.1 is available! <a href="update-core.php">Please update now</a>.</div>

<div class="wrap" id="profile-page">
	<div id="icon-users" class="icon32"><br /></div>
<h2>Profile</h2>

<form id="your-profile" action="" method="post">
<input type="hidden" id="_wpnonce" name="_wpnonce" value="e1f5bb2bbb" /><input type="hidden" name="_wp_http_referer" value="/blog/wp-admin/profile.php" /><p>
<input type="hidden" name="from" value="profile" />
<input type="hidden" name="checkuser_id" value="2" />
</p>

<h3>Personal Options</h3>

<table class="form-table">
	<tr>
		<th scope="row">Visual Editor</th>
		<td><label for="rich_editing"><input name="rich_editing" type="checkbox" id="rich_editing" value="false"  /> Disable the visual editor when writing</label></td>
	</tr>
<tr>
<th scope="row">Admin Color Scheme</th>
<td><fieldset><legend class="hidden">Admin Color Scheme</legend>
<div class="color-option"><input name="admin_color" id="admin_color_classic" type="radio" value="classic" class="tog"  />
	<table class="color-palette">
	<tr>
		<td style="background-color: #073447" title="classic">&nbsp;</td>
		<td style="background-color: #21759B" title="classic">&nbsp;</td>
		<td style="background-color: #EAF3FA" title="classic">&nbsp;</td>
		<td style="background-color: #BBD8E7" title="classic">&nbsp;</td>
		</tr>
	</table>

	<label for="admin_color_classic">Blue</label>
</div>
	<div class="color-option"><input name="admin_color" id="admin_color_fresh" type="radio" value="fresh" class="tog"  checked="checked" />
	<table class="color-palette">
	<tr>
		<td style="background-color: #464646" title="fresh">&nbsp;</td>
		<td style="background-color: #6D6D6D" title="fresh">&nbsp;</td>
		<td style="background-color: #F1F1F1" title="fresh">&nbsp;</td>
		<td style="background-color: #DFDFDF" title="fresh">&nbsp;</td>
		</tr>
	</table>

	<label for="admin_color_fresh">Gray</label>
</div>
	</fieldset></td>
</tr>
<tr>
<th scope="row">Keyboard Shortcuts</th>
<td><label for="comment_shortcuts"><input type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true"  /> Enable keyboard shortcuts for comment moderation. <a href="http://codex.wordpress.org/Keyboard_Shortcuts">More information</a></label></td>
</tr>
</table>

<h3>Name</h3>

<table class="form-table">
	<tr>
		<th><label for="user_login">Username</label></th>
		<td><input type="text" name="user_login" id="user_login" value="lauradart" disabled="disabled" class="regular-text" /> Your username cannot be changed.</td>
	</tr>


<tr>
	<th><label for="first_name">First name</label></th>
	<td><input type="text" name="first_name" id="first_name" value="Laura" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="last_name">Last name</label></th>
	<td><input type="text" name="last_name" id="last_name" value="Dart" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="nickname">Nickname</label></th>
	<td><input type="text" name="nickname" id="nickname" value="lauradart" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="display_name">Display name publicly&nbsp;as</label></th>
	<td>
		<select name="display_name" id="display_name">
					<option id="display_displayname" value="lauradart">lauradart</option>
					<option id="display_firstname" value="Laura">Laura</option>
					<option id="display_firstlast" value="Laura Dart">Laura Dart</option>
					<option id="display_lastfirst" value="Dart Laura">Dart Laura</option>
				</select>
	</td>
</tr>
</table>

<h3>Contact Info</h3>

<table class="form-table">
<tr>
	<th><label for="email">E-mail</label></th>
	<td><input type="text" name="email" id="email" value="dartphotographie@gmail.com" class="regular-text" /> Required.</td>
</tr>

<tr>
	<th><label for="url">Website</label></th>
	<td><input type="text" name="url" id="url" value="http://dartphotographie.com" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="aim">AIM</label></th>
	<td><input type="text" name="aim" id="aim" value="" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="yim">Yahoo IM</label></th>
	<td><input type="text" name="yim" id="yim" value="" class="regular-text" /></td>
</tr>

<tr>
	<th><label for="jabber">Jabber / Google Talk</label></th>
	<td><input type="text" name="jabber" id="jabber" value="" class="regular-text" /></td>
</tr>
</table>

<h3>About Yourself</h3>

<table class="form-table">
<tr>
	<th><label for="description">Biographical Info</label></th>
	<td><textarea name="description" id="description" rows="5" cols="30"></textarea><br />Share a little biographical information to fill out your profile. This may be shown publicly.</td>
</tr>

<tr>
	<th><label for="pass1">New Password</label></th>
	<td><input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /> If you would like to change the password type a new one. Otherwise leave this blank.<br />
		<input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" /> Type your new password again.<br />
			<div id="pass-strength-result">Strength indicator</div>
		<p>Hint: Your password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>
		</td>
</tr>
</table>



<p class="submit">
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="user_id" id="user_id" value="2" />
	<input type="submit" class="button-primary" value="Update Profile" name="submit" />
</p>
</form>
</div>

<div class="clear"></div></div><!-- wpbody-content -->
<div class="clear"></div></div><!-- wpbody -->
<div class="clear"></div></div><!-- wpcontent -->
</div><!-- wpwrap -->

<div id="footer">
<p id="footer-left" class="alignleft"><span id="footer-thankyou">Thank you for creating with <a href="http://wordpress.org/">WordPress</a>.</span> | <a href="http://codex.wordpress.org/">Documentation</a> | <a href="http://wordpress.org/support/forum/4">Feedback</a></p>
<p id="footer-upgrade" class="alignright"><strong><a href="update-core.php">Get Version 3.0.1</a></strong></p>
<div class="clear"></div>
</div>
<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>
</body>
</html>
<!-- Localized -->