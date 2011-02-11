<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Dart Photographie &rsaquo; Edit Post &#8212; WordPress</title>
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
<link rel='stylesheet' href='../wp-includes/js/thickbox/thickbox-962.css' type='text/css' media='all' />
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
		time: "1281648331"
	}
/* ]]> */
</script>
<script type='text/javascript' src='js/common.js?ver=20081210'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery.color.js?ver=2.0-4561'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/suggest.js?ver=1.1b'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/ui.core.js?ver=1.5.2'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/ui.tabs.js?ver=1.5.2'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	wpAjax = {
		noPerm: "You do not have permission to do that.",
		broken: "An unidentified error has occurred."
	}
	try{convertEntities(wpAjax);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='../wp-includes/js/wp-ajax-response.js?ver=20081210'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	wpListL10n = {
		url: "http://dartphotographie.com/blog/wp-admin/admin-ajax.php"
	}
/* ]]> */
</script>
<script type='text/javascript' src='../wp-includes/js/wp-lists.js?ver=20081210'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/ui.sortable.js?ver=1.5.2c'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	postboxL10n = {
		requestFile: "http://dartphotographie.com/blog/wp-admin/admin-ajax.php"
	}
/* ]]> */
</script>
<script type='text/javascript' src='js/postbox.js?ver=20081210'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	slugL10n = {
		requestFile: "http://dartphotographie.com/blog/wp-admin/admin-ajax.php",
		save: "Save",
		cancel: "Cancel"
	}
	try{convertEntities(slugL10n);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='js/slug.js?ver=20081210'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	postL10n = {
		tagsUsed: "Tags used on this post:",
		add: "Add",
		addTag: "Add new tag",
		separate: "Separate tags with commas",
		cancel: "Cancel",
		edit: "Edit",
		publishOn: "Publish on:",
		publishOnFuture: "Schedule for:",
		publishOnPast: "Published on:",
		showcomm: "Show more comments",
		endcomm: "No more comments found.",
		publish: "Publish",
		schedule: "Schedule",
		update: "Update Post",
		savePending: "Save as Pending",
		saveDraft: "Save Draft",
		private: "Private",
		public: "Public",
		publicSticky: "Public, Sticky",
		password: "Password Protected",
		privatelyPublished: "Privately Published",
		published: "Published"
	}
	try{convertEntities(postL10n);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='js/post.js?ver=20081210'></script>
<script type='text/javascript' src='js/editor.js?ver=20081129'></script>
<script type='text/javascript' src='../wp-includes/js/thickbox/thickbox.js?ver=3.1-20090123'></script>
<script type='text/javascript' src='js/media-upload.js?ver=20081210'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	wordCountL10n = {
		count: "Word count: %d"
	}
	try{convertEntities(wordCountL10n);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='js/word-count.js?ver=20081210'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/ui.resizable.js?ver=1.5.2'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	quicktagsL10n = {
		quickLinks: "(Quick Links)",
		wordLookup: "Enter a word to look up:",
		dictionaryLookup: "Dictionary lookup",
		lookup: "lookup",
		closeAllOpenTags: "Close all open tags",
		closeTags: "close tags",
		enterURL: "Enter the URL",
		enterImageURL: "Enter the URL of the image",
		enterImageDescription: "Enter a description of the image"
	}
	try{convertEntities(quicktagsL10n);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='../wp-includes/js/quicktags.js?ver=20081210'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	adminCommentsL10n = {
		hotkeys_highlight_first: "",
		hotkeys_highlight_last: ""
	}
/* ]]> */
</script>
<script type='text/javascript' src='js/edit-comments.js?ver=20081210'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery.schedule.js?ver=20'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	autosaveL10n = {
		autosaveInterval: "60",
		previewPageText: "Preview this Page",
		previewPostText: "Preview this Post",
		requestFile: "http://dartphotographie.com/blog/wp-admin/admin-ajax.php",
		savingText: "Saving Draft&#8230;"
	}
	try{convertEntities(autosaveL10n);}catch(e){};
/* ]]> */
</script>
<script type='text/javascript' src='../wp-includes/js/autosave.js?ver=20081210'></script>

<script type="text/javascript">
/* <![CDATA[ */
tinyMCEPreInit = {
	base : "http://dartphotographie.com/blog/wp-includes/js/tinymce",
	suffix : "",
	query : "ver=20081129",
	mceInit : {mode:"none", onpageload:"switchEditors.edInit", width:"100%", theme:"advanced", skin:"wp_theme", theme_advanced_buttons1:"bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,wp_more,|,spellchecker,fullscreen,wp_adv", theme_advanced_buttons2:"formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help", theme_advanced_buttons3:"", theme_advanced_buttons4:"", language:"en", spellchecker_languages:"+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv", theme_advanced_toolbar_location:"top", theme_advanced_toolbar_align:"left", theme_advanced_statusbar_location:"bottom", theme_advanced_resizing:"1", theme_advanced_resize_horizontal:"", dialog_type:"modal", relative_urls:"", remove_script_host:"", convert_urls:"", apply_source_formatting:"", remove_linebreaks:"1", paste_convert_middot_lists:"1", paste_remove_spans:"1", paste_remove_styles:"1", gecko_spellcheck:"1", entities:"38,amp,60,lt,62,gt", accessibility_focus:"1", tab_focus:":prev,:next", content_css:"http://dartphotographie.com/blog/wp-includes/js/tinymce/wordpress.css", save_callback:"switchEditors.saveCallback", wpeditimage_disable_captions:"", plugins:"safari,inlinepopups,autosave,spellchecker,paste,wordpress,media,fullscreen,wpeditimage,wpgallery"},

	go : function() {
		var t = this, sl = tinymce.ScriptLoader, ln = t.mceInit.language, th = t.mceInit.theme, pl = t.mceInit.plugins;

		sl.markDone(t.base + '/langs/' + ln + '.js');

		sl.markDone(t.base + '/themes/' + th + '/langs/' + ln + '.js');
		sl.markDone(t.base + '/themes/' + th + '/langs/' + ln + '_dlg.js');

		tinymce.each(pl.split(','), function(n) {
			if (n && n.charAt(0) != '-') {
				sl.markDone(t.base + '/plugins/' + n + '/langs/' + ln + '.js');
				sl.markDone(t.base + '/plugins/' + n + '/langs/' + ln + '_dlg.js');
			}
		});
	},

	load_ext : function(url,lang) {
		var sl = tinymce.ScriptLoader;

		sl.markDone(url + '/langs/' + lang + '.js');
		sl.markDone(url + '/langs/' + lang + '_dlg.js');
	}
};
/* ]]> */
</script>
<script type="text/javascript" src="../wp-includes/js/tinymce/tiny_mce.js?ver=20081129"></script>
<script type="text/javascript" src="../wp-includes/js/tinymce/langs/wp-langs-en.js?ver=20081129"></script>
<script type="text/javascript">


// Mark translations as done
tinyMCEPreInit.go();

// Init
tinyMCE.init(tinyMCEPreInit.mceInit);
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
	<li class="wp-has-submenu wp-has-current-submenu wp-menu-open wp-menu-open menu-top menu-top-first" id="menu-posts">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='edit.php' class="wp-has-submenu wp-has-current-submenu wp-menu-open wp-menu-open menu-top menu-top-first" tabindex="1">Posts</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Posts</div><ul><li class="wp-first-item current"><a href='edit.php' class="wp-first-item current" tabindex="1">Edit</a></li><li><a href='post-new.php' tabindex="1">Add New</a></li><li><a href='edit-tags.php' tabindex="1">Tags</a></li><li><a href='categories.php' tabindex="1">Categories</a></li></ul></div></li>
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
	<li class="wp-has-submenu menu-top" id="menu-users">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='users.php' class="wp-has-submenu menu-top" tabindex="1">Users</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Users</div><ul><li class="wp-first-item"><a href='users.php' class="wp-first-item" tabindex="1">Authors &amp; Users</a></li><li><a href='user-new.php' tabindex="1">Add New</a></li><li><a href='profile.php' tabindex="1">Your Profile</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top" id="menu-tools">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='tools.php' class="wp-has-submenu menu-top" tabindex="1">Tools</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Tools</div><ul><li class="wp-first-item"><a href='tools.php' class="wp-first-item" tabindex="1">Tools</a></li><li><a href='import.php' tabindex="1">Import</a></li><li><a href='export.php' tabindex="1">Export</a></li><li><a href='update-core.php' tabindex="1">Upgrade</a></li></ul></div></li>
	<li class="wp-has-submenu menu-top menu-top-last" id="menu-settings">
	<div class="wp-menu-image"><br /></div><div class="wp-menu-toggle"><br /></div><a href='options-general.php' class="wp-has-submenu menu-top menu-top-last" tabindex="1">Settings</a>
	<div class='wp-submenu'><div class='wp-submenu-head'>Settings</div><ul><li class="wp-first-item"><a href='options-general.php' class="wp-first-item" tabindex="1">General</a></li><li><a href='options-writing.php' tabindex="1">Writing</a></li><li><a href='options-reading.php' tabindex="1">Reading</a></li><li><a href='options-discussion.php' tabindex="1">Discussion</a></li><li><a href='options-media.php' tabindex="1">Media</a></li><li><a href='options-privacy.php' tabindex="1">Privacy</a></li><li><a href='options-permalink.php' tabindex="1">Permalinks</a></li><li><a href='options-misc.php' tabindex="1">Miscellaneous</a></li></ul></div></li>
	<li class="wp-menu-separator-last"><br /></li></ul>
<div id="wpbody-content">
<div id="screen-meta">
<div id="screen-options-wrap" class="hidden">
	<h5>Show on screen</h5>
	<form id="adv-settings" action="" method="get">
	<div class="metabox-prefs">
<label for="tagsdiv-hide"><input class="hide-postbox-tog" name="tagsdiv-hide" type="checkbox" id="tagsdiv-hide" value="tagsdiv" checked="checked" />Tags</label>
<label for="categorydiv-hide"><input class="hide-postbox-tog" name="categorydiv-hide" type="checkbox" id="categorydiv-hide" value="categorydiv" checked="checked" />Categories</label>
<label for="postexcerpt-hide"><input class="hide-postbox-tog" name="postexcerpt-hide" type="checkbox" id="postexcerpt-hide" value="postexcerpt" checked="checked" />Excerpt</label>
<label for="trackbacksdiv-hide"><input class="hide-postbox-tog" name="trackbacksdiv-hide" type="checkbox" id="trackbacksdiv-hide" value="trackbacksdiv" checked="checked" />Send Trackbacks</label>
<label for="postcustom-hide"><input class="hide-postbox-tog" name="postcustom-hide" type="checkbox" id="postcustom-hide" value="postcustom" checked="checked" />Custom Fields</label>
<label for="commentstatusdiv-hide"><input class="hide-postbox-tog" name="commentstatusdiv-hide" type="checkbox" id="commentstatusdiv-hide" value="commentstatusdiv" checked="checked" />Discussion</label>
<label for="slugdiv-hide"><input class="hide-postbox-tog" name="slugdiv-hide" type="checkbox" id="slugdiv-hide" value="slugdiv" />Post Slug</label>
<label for="authordiv-hide"><input class="hide-postbox-tog" name="authordiv-hide" type="checkbox" id="authordiv-hide" value="authordiv" checked="checked" />Post Author</label>
<label for="revisionsdiv-hide"><input class="hide-postbox-tog" name="revisionsdiv-hide" type="checkbox" id="revisionsdiv-hide" value="revisionsdiv" checked="checked" />Post Revisions</label>
<input type="hidden" id="hiddencolumnsnonce" name="hiddencolumnsnonce" value="a72f7d90ff" />	<br class="clear" />
	</div></form>
</div>

	<div id="contextual-help-wrap" class="hidden">
	<h5>Get help with "Edit Post"</h5><div class="metabox-prefs">
	<p>Most of the modules on this screen can be moved. If you hover your mouse over the title bar of a module you’ll notice the 4 arrow cursor appears to let you know it is movable. Click on it, hold down the mouse button and start dragging the module to a new location. As you drag the module, notice the dotted gray box that also moves. This box indicates where the module will be placed when you release the mouse button.</p>
	<p>The same modules can be expanded and collapsed by clicking once on their title bar and also completely hidden from the Screen Options tab.</p>
<p><a href="http://codex.wordpress.org/Writing_Posts" target="_blank">Writing Posts</a></p></div>
<h5>Other Help</h5><div class="metabox-prefs"><a href="http://codex.wordpress.org/" target="_blank">Documentation</a><br /><a href="http://wordpress.org/support/" target="_blank">Support Forums</a></div>
	</div>

<div id="screen-meta-links">
<div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
<a href="#contextual-help" id="contextual-help-link" class="show-settings">Help</a>
</div>
<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
<a href="#screen-options" id="show-settings-link" class="show-settings">Screen Options</a>
</div>
</div>
</div>
<div id='update-nag'>WordPress 3.0.1 is available! <a href="update-core.php">Please update now</a>.</div>

<div class="wrap">
	<div id="icon-edit" class="icon32"><br /></div>
<h2>Edit Post</h2>
<form name="post" action="post.php" method="post" id="post">
<input type="hidden" id="_wpnonce" name="_wpnonce" value="8a07077706" /><input type="hidden" name="_wp_http_referer" value="/blog/wp-admin/post.php?action=edit&amp;post=186" />
<input type="hidden" id="user-id" name="user_ID" value="2" />
<input type="hidden" id="hiddenaction" name="action" value="editpost" />
<input type="hidden" id="originalaction" name="originalaction" value="editpost" />
<input type="hidden" id="post_author" name="post_author" value="2" />
<input type="hidden" id="post_type" name="post_type" value="post" />
<input type="hidden" id="original_post_status" name="original_post_status" value="publish" />
<input name="referredby" type="hidden" id="referredby" value="http://dartphotographie.com/blog/category/lovers/" />
<input type="hidden" name="_wp_original_http_referer" value="http://dartphotographie.com/blog/category/lovers/" />
<input type='hidden' id='post_ID' name='post_ID' value='186' />
<div id="poststuff" class="metabox-holder">

<div id="side-info-column" class="inner-sidebar">


<div id='side-sortables' class='meta-box-sortables'>
<div id="submitdiv" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Publish</span></h3>
<div class="inside">
<div class="submitbox" id="submitpost">

<div id="minor-publishing">

<div style="display:none;">
<input type="submit" name="save" value="Save" />
</div>

<div id="minor-publishing-actions">
<div id="save-action">
</div>

<div id="preview-action">

<a class="preview button" href="../christina-and-justin/index.html" target="wp-preview" id="post-preview" tabindex="4">Preview</a>
<input type="hidden" name="wp-preview" id="wp-preview" value="" />
</div>

<div class="clear"></div>
</div>
<div id="misc-publishing-actions">

<div class="misc-pub-section"><label for="post_status">Status:</label>
<b><span id="post-status-display">
Published</span></b>
<a href="#post_status" class="edit-post-status hide-if-no-js" tabindex='4'>Edit</a>

<div id="post-status-select" class="hide-if-js">
<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="publish" />
<select name='post_status' id='post_status' tabindex='4'>
<option selected="selected" value='publish'>Published</option>
<option value='pending'>Pending Review</option>
<option value='draft'>Draft</option>
</select>
 <a href="#post_status" class="save-post-status hide-if-no-js button">OK</a>
 <a href="#post_status" class="cancel-post-status hide-if-no-js">Cancel</a>
</div>

</div>
<div class="misc-pub-section " id="visibility">
Visibility: <b><span id="post-visibility-display">Public</span></b>  <a href="#visibility" class="edit-visibility hide-if-no-js">Edit</a>

<div id="post-visibility-select" class="hide-if-js">
<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="" />
<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky"  />
<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="public" />


<input type="radio" name="visibility" id="visibility-radio-public" value="public"  checked="checked" /> <label for="visibility-radio-public" class="selectit">Public</label><br />
<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky"  tabindex="4" /> <label for="sticky" class="selectit">Stick this post to the front page</label><br /></span>
<input type="radio" name="visibility" id="visibility-radio-password" value="password"  /> <label for="visibility-radio-password" class="selectit">Password protected</label><br />
<span id="password-span"><label for="post_password">Password:</label> <input type="text" name="post_password" id="post_password" value="" /><br /></span>
<input type="radio" name="visibility" id="visibility-radio-private" value="private"  /> <label for="visibility-radio-private" class="selectit">Private</label><br />

<p>
 <a href="#visibility" class="save-post-visibility hide-if-no-js button">OK</a>
 <a href="#visibility" class="cancel-post-visibility hide-if-no-js">Cancel</a>
</p>
</div>

</div>

<div class="misc-pub-section curtime misc-pub-section-last">
	<span id="timestamp">
	Published on: <b>Oct 13, 2008 @ 0:55</b></span>
	<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" tabindex='4'>Edit</a>
	<div id="timestampdiv" class="hide-if-js"><select id="mm" name="mm" tabindex="4">
			<option value="01">Jan</option>
			<option value="02">Feb</option>
			<option value="03">Mar</option>
			<option value="04">Apr</option>
			<option value="05">May</option>
			<option value="06">Jun</option>
			<option value="07">Jul</option>
			<option value="08">Aug</option>
			<option value="09">Sep</option>
			<option value="10" selected="selected">Oct</option>
			<option value="11">Nov</option>
			<option value="12">Dec</option>
</select><input type="text" id="jj" name="jj" value="13" size="2" maxlength="2" tabindex="4" autocomplete="off" />, <input type="text" id="aa" name="aa" value="2008" size="4" maxlength="5" tabindex="4" autocomplete="off" /> @ <input type="text" id="hh" name="hh" value="00" size="2" maxlength="2" tabindex="4" autocomplete="off" /> : <input type="text" id="mn" name="mn" value="55" size="2" maxlength="2" tabindex="4" autocomplete="off" /><input type="hidden" id="ss" name="ss" value="00" />

<input type="hidden" id="hidden_mm" name="hidden_mm" value="10" />
<input type="hidden" id="cur_mm" name="cur_mm" value="08" />
<input type="hidden" id="hidden_jj" name="hidden_jj" value="13" />
<input type="hidden" id="cur_jj" name="cur_jj" value="12" />
<input type="hidden" id="hidden_aa" name="hidden_aa" value="2008" />
<input type="hidden" id="cur_aa" name="cur_aa" value="2010" />
<input type="hidden" id="hidden_hh" name="hidden_hh" value="00" />
<input type="hidden" id="cur_hh" name="cur_hh" value="17" />
<input type="hidden" id="hidden_mn" name="hidden_mn" value="55" />
<input type="hidden" id="cur_mn" name="cur_mn" value="25" />

<input type="hidden" id="ss" name="ss" value="00" size="2" maxlength="2" />

<p>
<a href="#edit_timestamp" class="save-timestamp hide-if-no-js button">OK</a>
<a href="#edit_timestamp" class="cancel-timestamp hide-if-no-js">Cancel</a>
</p>
</div>
</div>
</div>
<div class="clear"></div>
</div>

<div id="major-publishing-actions">
<div id="delete-action">
<a class="submitdelete deletion" href="post-41310.php" onclick="if ( confirm('You are about to delete this post \'Christina and Justin\'\n  \'Cancel\' to stop, \'OK\' to delete.') ) {return true;}return false;">Delete</a>
</div>

<div id="publishing-action">
	<input name="original_publish" type="hidden" id="original_publish" value="Update Post" />
	<input name="save" type="submit" class="button-primary" id="publish" tabindex="5" accesskey="p" value="Update Post" />
</div>
<div class="clear"></div>
</div>
</div>

</div>
</div>
<div id="tagsdiv" class="postbox if-js-closed" >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Tags</span></h3>
<div class="inside">
<p id="jaxtag"><label class="hidden" for="newtag">Tags</label><input type="text" name="tags_input" class="tags-input" id="tags-input" size="40" tabindex="3" value="" /></p>
<div id="tagchecklist"></div>
<p id="tagcloud-link" class="hide-if-no-js"><a href='#'>Choose from the most popular tags</a></p>
</div>
</div>
<div id="categorydiv" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Categories</span></h3>
<div class="inside">
<ul id="category-tabs">
	<li class="ui-tabs-selected"><a href="#categories-all" tabindex="3">All Categories</a></li>
	<li class="hide-if-no-js"><a href="#categories-pop" tabindex="3">Most Used</a></li>
</ul>

<div id="categories-pop" class="ui-tabs-panel" style="display: none;">
	<ul id="categorychecklist-pop" class="categorychecklist form-no-clear" >
		
		<li id="popular-category-14" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-14" type="checkbox" value="14" />
				music			</label>
		</li>

		
		<li id="popular-category-15" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-15" type="checkbox" value="15" />
				lovers			</label>
		</li>

		
		<li id="popular-category-16" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-16" type="checkbox" value="16" />
				friends			</label>
		</li>

		
		<li id="popular-category-1" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-1" type="checkbox" value="1" />
				Uncategorized			</label>
		</li>

		
		<li id="popular-category-10" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-10" type="checkbox" value="10" />
				family			</label>
		</li>

		
		<li id="popular-category-7" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-7" type="checkbox" value="7" />
				artists			</label>
		</li>

		
		<li id="popular-category-11" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-11" type="checkbox" value="11" />
				personal			</label>
		</li>

		
		<li id="popular-category-8" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-8" type="checkbox" value="8" />
				travel			</label>
		</li>

		
		<li id="popular-category-4" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-4" type="checkbox" value="4" />
				la vie			</label>
		</li>

		
		<li id="popular-category-9" class="popular-category">
			<label class="selectit">
			<input id="in-popular-category-9" type="checkbox" value="9" />
				wedding			</label>
		</li>

			</ul>
</div>

<div id="categories-all" class="ui-tabs-panel">
	<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
		
<li id='category-15' class="popular-category"><label class="selectit"><input value="15" type="checkbox" name="post_category[]" id="in-category-15" checked="checked"/> lovers</label></li>

<li id='category-7' class="popular-category"><label class="selectit"><input value="7" type="checkbox" name="post_category[]" id="in-category-7"/> artists</label></li>

<li id='category-18'><label class="selectit"><input value="18" type="checkbox" name="post_category[]" id="in-category-18"/> babies</label></li>

<li id='category-12'><label class="selectit"><input value="12" type="checkbox" name="post_category[]" id="in-category-12"/> clients</label></li>

<li id='category-10' class="popular-category"><label class="selectit"><input value="10" type="checkbox" name="post_category[]" id="in-category-10"/> family</label></li>

<li id='category-17'><label class="selectit"><input value="17" type="checkbox" name="post_category[]" id="in-category-17"/> fashion</label></li>

<li id='category-16' class="popular-category"><label class="selectit"><input value="16" type="checkbox" name="post_category[]" id="in-category-16"/> friends</label></li>

<li id='category-4' class="popular-category"><label class="selectit"><input value="4" type="checkbox" name="post_category[]" id="in-category-4"/> la vie</label></li>

<li id='category-3'><label class="selectit"><input value="3" type="checkbox" name="post_category[]" id="in-category-3"/> life</label></li>

<li id='category-14' class="popular-category"><label class="selectit"><input value="14" type="checkbox" name="post_category[]" id="in-category-14"/> music</label></li>

<li id='category-11' class="popular-category"><label class="selectit"><input value="11" type="checkbox" name="post_category[]" id="in-category-11"/> personal</label></li>

<li id='category-13'><label class="selectit"><input value="13" type="checkbox" name="post_category[]" id="in-category-13"/> poetry and prose</label></li>

<li id='category-8' class="popular-category"><label class="selectit"><input value="8" type="checkbox" name="post_category[]" id="in-category-8"/> travel</label></li>

<li id='category-1' class="popular-category"><label class="selectit"><input value="1" type="checkbox" name="post_category[]" id="in-category-1"/> Uncategorized</label></li>

<li id='category-9' class="popular-category"><label class="selectit"><input value="9" type="checkbox" name="post_category[]" id="in-category-9"/> wedding</label></li>
	</ul>
</div>

<div id="category-adder" class="wp-hidden-children">
	<h4><a id="category-add-toggle" href="#category-add" class="hide-if-no-js" tabindex="3">+ Add New Category</a></h4>
	<p id="category-add" class="wp-hidden-child">
		<label class="hidden" for="newcat">Add New Category</label><input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="New category name" tabindex="3" aria-required="true"/>
		<label class="hidden" for="newcat_parent">Parent category:</label><select name='newcat_parent' id='newcat_parent' class='postform'  tabindex="3">
	<option value='-1'>Parent category</option>
	<option class="level-0" value="7">artists</option>
	<option class="level-0" value="18">babies</option>
	<option class="level-0" value="12">clients</option>
	<option class="level-0" value="10">family</option>
	<option class="level-0" value="17">fashion</option>
	<option class="level-0" value="16">friends</option>
	<option class="level-0" value="4">la vie</option>
	<option class="level-0" value="3">life</option>
	<option class="level-0" value="15">lovers</option>
	<option class="level-0" value="14">music</option>
	<option class="level-0" value="11">personal</option>
	<option class="level-0" value="13">poetry and prose</option>
	<option class="level-0" value="8">travel</option>
	<option class="level-0" value="1">Uncategorized</option>
	<option class="level-0" value="9">wedding</option>
</select>
		<input type="button" id="category-add-sumbit" class="add:categorychecklist:category-add button" value="Add" tabindex="3" />
		<input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="e726b738ef" />		<span id="category-ajax-response"></span>
	</p>
</div>
</div>
</div>
</div></div>

<div id="post-body" class="has-sidebar">
<div id="post-body-content" class="has-sidebar-content">
<div id="titlediv">
<div id="titlewrap">
	<input type="text" name="post_title" size="30" tabindex="1" value="Christina and Justin" id="title" autocomplete="off" />
</div>
<div class="inside">
	<div id="edit-slug-box">
<strong>Permalink:</strong>
<span id="sample-permalink">http://dartphotographie.com/blog/<span id="editable-post-name" title="Click to edit this part of the permalink">christina-and-justin</span><span id="editable-post-name-full">christina-and-justin</span>/</span>
<span id="edit-slug-buttons"><a href="#post_name" class="edit-slug button" onclick="edit_permalink(186); return false;">Edit</a></span>
	</div>
</div>
</div>

<div id="postdivrich" class="postarea">

	<div id="editor-toolbar">
			<div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('content')" /></div>
					<a id="edButtonHTML" onclick="switchEditors.go('content', 'html');">HTML</a>
			<a id="edButtonPreview" class="active" onclick="switchEditors.go('content', 'tinymce');">Visual</a>
					<div id="media-buttons" class="hide-if-no-js">
			Upload/Insert 
	<a href="media-upload-17808.php" id="add_image" class="thickbox" title='Add an Image'><img src='images/media-button-image.gif' alt='Add an Image' /></a>
	<a href="media-upload-9154.php" id="add_video" class="thickbox" title='Add Video'><img src='images/media-button-video.gif' alt='Add Video' /></a>
	<a href="media-upload-60524.php" id="add_audio" class="thickbox" title='Add Audio'><img src='images/media-button-music.gif' alt='Add Audio' /></a>
	<a href="media-upload-63294.php" id="add_media" class="thickbox" title='Add Media'><img src='images/media-button-other.gif' alt='Add Media' /></a>
			</div>
			</div>
	
	<div id="quicktags">
		<script type="text/javascript">edToolbar()</script>
	</div>

	<div id='editorcontainer'><textarea rows='10' cols='40' name='content' tabindex='2' id='content'>&lt;p&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj5.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj5.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj7.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj7.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj16.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj16.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj15-1.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj15-1.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=jc.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/jc.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj4.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj4.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj20-2.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj20-2.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj2-1.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj2-1.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj18.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj18.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj9.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj9.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj11.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj11.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;br /&gt;&lt;a href="http://s276.photobucket.com/albums/kk4/dartphoto/?action=view&amp;#038;current=cj12.jpg" target="_blank"&gt;&lt;img src="http://i276.photobucket.com/albums/kk4/dartphoto/cj12.jpg" border="0" alt="Photobucket"&gt;&lt;/a&gt;&lt;/p&gt;
</textarea></div>
	<script type="text/javascript">
	// <![CDATA[
	edCanvas = document.getElementById('content');
		var dotabkey = true;
	// If tinyMCE is defined.
	if ( typeof tinyMCE != 'undefined' ) {
		// This code is meant to allow tabbing from Title to Post (TinyMCE).
		jQuery('#title')[jQuery.browser.opera ? 'keypress' : 'keydown'](function (e) {
			if (e.which == 9 && !e.shiftKey && !e.controlKey && !e.altKey) {
				if ( (jQuery("#post_ID").val() < 1) && (jQuery("#title").val().length > 0) ) { autosave(); }
				if ( tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden() && dotabkey ) {
					e.preventDefault();
					dotabkey = false;
					tinyMCE.activeEditor.focus();
					return false;
				}
			}
		});
	}
		// ]]>
	</script>
	
<div id="post-status-info">
	<span id="wp-word-count" class="alignleft"></span>
	<span class="alignright">
	<span id="autosave">&nbsp;</span>
<span id="last-edit">Last edited by lauradart on July 25, 2010 at 3:35 pm</span>	</span>
	<br class="clear" />
</div>


<input type="hidden" id="autosavenonce" name="autosavenonce" value="9bf703d4c4" /><input type="hidden" id="closedpostboxesnonce" name="closedpostboxesnonce" value="1ecfe431b0" /><input type="hidden" id="getpermalinknonce" name="getpermalinknonce" value="7728f98daa" /><input type="hidden" id="samplepermalinknonce" name="samplepermalinknonce" value="a40889579d" /><input type="hidden" id="meta-box-order-nonce" name="meta-box-order-nonce" value="f1bc654af4" /></div>

<div id='normal-sortables' class='meta-box-sortables'>
<div id="postexcerpt" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Excerpt</span></h3>
<div class="inside">
<label class="hidden" for="excerpt">Excerpt</label><textarea rows="1" cols="40" name="excerpt" tabindex="6" id="excerpt"></textarea>
<p>Excerpts are optional hand-crafted summaries of your content. You can <a href="http://codex.wordpress.org/Template_Tags/the_excerpt" target="_blank">use them in your template</a></p>
</div>
</div>
<div id="trackbacksdiv" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Send Trackbacks</span></h3>
<div class="inside">
<p><label for="trackback_url">Send trackbacks to:</label> <input type="text" name="trackback_url" id="trackback_url" tabindex="7" value="" /><br /> (Separate multiple URLs with spaces)</p>
<p>Trackbacks are a way to notify legacy blog systems that you&#8217;ve linked to them. If you link other WordPress blogs they&#8217;ll be notified automatically using <a href="http://codex.wordpress.org/Introduction_to_Blogging#Managing_Comments" target="_blank">pingbacks</a>, no other action necessary.</p>
</div>
</div>
<div id="postcustom" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Custom Fields</span></h3>
<div class="inside">
<div id="postcustomstuff">
<div id="ajax-response"></div>
<table id="list-table">
	<thead>
	<tr>
		<th class="left">Name</th>
		<th>Value</th>
	</tr>
	</thead>
	<tbody id='the-list' class='list:meta'>

	<tr id='meta-268' class='alternate'>
		<td class='left'><label class='hidden' for='meta[268][key]'>Key</label><input name='meta[268][key]' id='meta[268][key]' tabindex='6' type='text' size='20' value='blogger_author' />
		<div class='submit'><input name='deletemeta[268]' type='submit' class='delete:the-list:meta-268::_ajax_nonce=1a671baf3c deletemeta' tabindex='6' value='Delete' />
		<input name='updatemeta' type='submit' tabindex='6' value='Update' class='add:the-list:meta-268::_ajax_nonce=0a1d1bdc99 updatemeta' /></div><input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="63fb16e43d" /></td>
		<td><label class='hidden' for='meta[268][value]'>Value</label><textarea name='meta[268][value]' id='meta[268][value]' tabindex='6' rows='2' cols='30'>d'art photographiehttp://www.blogger.com/profile/02391660224391645129noreply@blogger.com</textarea></td>
	</tr>
	<tr id='meta-267' class=''>
		<td class='left'><label class='hidden' for='meta[267][key]'>Key</label><input name='meta[267][key]' id='meta[267][key]' tabindex='6' type='text' size='20' value='blogger_blog' />
		<div class='submit'><input name='deletemeta[267]' type='submit' class='delete:the-list:meta-267::_ajax_nonce=fde1e70d0e deletemeta' tabindex='6' value='Delete' />
		<input name='updatemeta' type='submit' tabindex='6' value='Update' class='add:the-list:meta-267::_ajax_nonce=0a1d1bdc99 updatemeta' /></div><input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="63fb16e43d" /></td>
		<td><label class='hidden' for='meta[267][value]'>Value</label><textarea name='meta[267][value]' id='meta[267][value]' tabindex='6' rows='2' cols='30'>dartphoto.blogspot.com</textarea></td>
	</tr>
	<tr id='meta-269' class='alternate'>
		<td class='left'><label class='hidden' for='meta[269][key]'>Key</label><input name='meta[269][key]' id='meta[269][key]' tabindex='6' type='text' size='20' value='blogger_permalink' />
		<div class='submit'><input name='deletemeta[269]' type='submit' class='delete:the-list:meta-269::_ajax_nonce=5e1e97af0a deletemeta' tabindex='6' value='Delete' />
		<input name='updatemeta' type='submit' tabindex='6' value='Update' class='add:the-list:meta-269::_ajax_nonce=0a1d1bdc99 updatemeta' /></div><input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="63fb16e43d" /></td>
		<td><label class='hidden' for='meta[269][value]'>Value</label><textarea name='meta[269][value]' id='meta[269][value]' tabindex='6' rows='2' cols='30'>/2008/10/christina-and-justin.html</textarea></td>
	</tr>
	<tr id='meta-644' class=' hidden'>
		<td class='left'><label class='hidden' for='meta[644][key]'>Key</label><input name='meta[644][key]' id='meta[644][key]' tabindex='6' type='text' size='20' value='_edit_last' />
		<div class='submit'><input name='deletemeta[644]' type='submit' class='delete:the-list:meta-644::_ajax_nonce=19f48d8730 deletemeta' tabindex='6' value='Delete' />
		<input name='updatemeta' type='submit' tabindex='6' value='Update' class='add:the-list:meta-644::_ajax_nonce=0a1d1bdc99 updatemeta' /></div><input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="63fb16e43d" /></td>
		<td><label class='hidden' for='meta[644][value]'>Value</label><textarea name='meta[644][value]' id='meta[644][value]' tabindex='6' rows='2' cols='30'>2</textarea></td>
	</tr>
	<tr id='meta-643' class='alternate hidden'>
		<td class='left'><label class='hidden' for='meta[643][key]'>Key</label><input name='meta[643][key]' id='meta[643][key]' tabindex='6' type='text' size='20' value='_edit_lock' />
		<div class='submit'><input name='deletemeta[643]' type='submit' class='delete:the-list:meta-643::_ajax_nonce=2a90798009 deletemeta' tabindex='6' value='Delete' />
		<input name='updatemeta' type='submit' tabindex='6' value='Update' class='add:the-list:meta-643::_ajax_nonce=0a1d1bdc99 updatemeta' /></div><input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="63fb16e43d" /></td>
		<td><label class='hidden' for='meta[643][value]'>Value</label><textarea name='meta[643][value]' id='meta[643][value]' tabindex='6' rows='2' cols='30'>1281648331</textarea></td>
	</tr>	</tbody>
</table>
<p><strong>Add new custom field:</strong></p>
<table id="newmeta">
<thead>
<tr>
<th class="left"><label for="metakeyselect">Name</label></th>
<th><label for="metavalue">Value</label></th>
</tr>
</thead>

<tbody>
<tr>
<td id="newmetaleft" class="left">
<select id="metakeyselect" name="metakeyselect" tabindex="7">
<option value="#NONE#">- Select -</option>

<option value='blogger_author'>blogger_author</option>
<option value='blogger_blog'>blogger_blog</option>
<option value='blogger_permalink'>blogger_permalink</option></select>
<input class="hide-if-js" type="text" id="metakeyinput" name="metakeyinput" tabindex="7" value="" />
<a href="#postcustomstuff" class="hide-if-no-js" onclick="jQuery('#metakeyinput, #metakeyselect, #enternew, #cancelnew').toggle();return false;">
<span id="enternew">Enter new</span>
<span id="cancelnew" class="hidden">Cancel</span></a>
</td>
<td><textarea id="metavalue" name="metavalue" rows="2" cols="25" tabindex="8"></textarea></td>
</tr>

<tr><td colspan="2" class="submit">
<input type="submit" id="addmetasub" name="addmeta" class="add:the-list:newmeta" tabindex="9" value="Add Custom Field" />
<input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="0a1d1bdc99" /></td></tr>
</tbody>
</table>
</div>
<p>Custom fields can be used to add extra metadata to a post that you can <a href="http://codex.wordpress.org/Using_Custom_Fields" target="_blank">use in your theme</a>.</p>
</div>
</div>
<div id="commentstatusdiv" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Discussion</span></h3>
<div class="inside">
<input name="advanced_view" type="hidden" value="1" />
<p class="meta-options">
	<label for="comment_status" class="selectit"> <input name="comment_status" type="checkbox" id="comment_status" value="open"  checked="checked" /> Allow comments on this post</label><br />
	<label for="ping_status" class="selectit"><input name="ping_status" type="checkbox" id="ping_status" value="open"  checked="checked" /> Allow <a href="http://codex.wordpress.org/Introduction_to_Blogging#Managing_Comments" target="_blank">trackbacks and pingbacks</a> on this post</label>
</p>
</div>
</div>
<div id="slugdiv" class="postbox " style="display:none;">
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Post Slug</span></h3>
<div class="inside">
<label class="hidden" for="post_name">Post Slug</label><input name="post_name" type="text" size="13" id="post_name" value="christina-and-justin" />
</div>
</div>
<div id="authordiv" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Post Author</span></h3>
<div class="inside">
<label class="hidden" for="post_author_override">Post Author</label><select name='post_author_override' id='post_author_override' class=''>
	<option value='3'>amoslanka</option>
	<option value='2' selected='selected'>lauradart</option>
</select></div>
</div>
<div id="revisionsdiv" class="postbox " >
<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>Post Revisions</span></h3>
<div class="inside">
<ul class='post-revisions'>
	<li><a href='revision-35715.php'>13 October, 2008 @ 0:55</a> by lauradart</li>
</ul></div>
</div>
</div><input type="hidden" id="wp-old-slug" name="wp-old-slug" value="christina-and-justin" /><div id='advanced-sortables' class='meta-box-sortables'>
</div>
</div>
</div>
<br class="clear" />
</div><!-- /poststuff -->
</form>
</div>

<form method="get" action="">
<table style="display:none;"><tbody id="com-reply"><tr id="replyrow"><td colspan="4">
	<div id="replyhead" style="display:none;">Reply to Comment</div>

	<div id="edithead" style="display:none;">
		<div class="inside">
		<label for="author">Name</label>
		<input type="text" name="newcomment_author" size="50" value="" tabindex="101" id="author" />
		</div>

		<div class="inside">
		<label for="author-email">E-mail</label>
		<input type="text" name="newcomment_author_email" size="50" value="" tabindex="102" id="author-email" />
		</div>

		<div class="inside">
		<label for="author-url">URL</label>
		<input type="text" id="author-url" name="newcomment_author_url" size="103" value="" tabindex="103" />
		</div>
		<div style="clear:both;"></div>
	</div>

	<div id="replycontainer"><textarea rows="8" cols="40" name="replycontent" tabindex="104" id="replycontent"></textarea></div>

	<p id="replysubmit" class="submit">
	<a href="#comments-form" class="cancel button-secondary alignleft" tabindex="106">Cancel</a>
	<a href="#comments-form" class="save button-primary alignright" tabindex="104">
	<span id="savebtn" style="display:none;">Update Comment</span>
	<span id="replybtn" style="display:none;">Submit Reply</span></a>
	<img class="waiting" style="display:none;" src="images/loading.gif" alt="" />
	<span class="error" style="display:none;"></span>
	<br class="clear" />
	</p>

	<input type="hidden" name="user_ID" id="user_ID" value="2" />
	<input type="hidden" name="action" id="action" value="" />
	<input type="hidden" name="comment_ID" id="comment_ID" value="" />
	<input type="hidden" name="comment_post_ID" id="comment_post_ID" value="" />
	<input type="hidden" name="status" id="status" value="" />
	<input type="hidden" name="position" id="position" value="1" />
	<input type="hidden" name="checkbox" id="checkbox" value="0" />
	<input type="hidden" name="mode" id="mode" value="single" />
	<input type="hidden" id="_ajax_nonce" name="_ajax_nonce" value="5cb220db7c" />	<input type="hidden" id="_wp_unfiltered_html_comment" name="_wp_unfiltered_html_comment" value="7eb80e9a60" /></td></tr></tbody></table>
</form>


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