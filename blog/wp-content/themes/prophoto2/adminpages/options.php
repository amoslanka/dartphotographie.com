<?php
/*
The General Options admin page
*/

$p2_form_weight = 0; // keep track of the form "weight" (number of fields)

// Load library of our custom functions regarding uploading
require_once(dirname(dirname(__FILE__)).'/functions/options.php');


// Checks if we can have all options at once, or if we need to split the form in blocks. Returns boolean.
function p2_options_do_all_tabs() {
	// Setting overwrite:
	if (defined('P2_SPLIT_OPTIONS') && P2_SPLIT_OPTIONS == true)
		return false;

	// Are we running this crappy Suhosin extension & is it capping the POST ?
	$extensions = ini_get_all();
	$post_limit = 800; // The maximum number of fields we'll need to submit at once
	if (array_key_exists('suhosin.post.max_vars', $extensions) &&
		(
			($extensions['suhosin.post.max_vars']['local_value'] < $post_limit)
			||
			($extensions['suhosin.post.max_vars']['global_value'] < $post_limit)
		)) {
		// Suhosin running with too limited settings: will display one block at a time
		return false;
	} else {
		// Should be fine, display everything as usual!
		return true;
	}

}


// Draw the option page itself
function p2_options_page() {
	global $p2, $explain, $content_width, $p2_form_weight;	
	$write_result = p2_process_options(); // handle any POST information
	p2_debug_report(); // the debug box if we're in debug mode
	$counter = 1; // helps the multiple-input function keep track of itself
	
	$blocks = array(
		// 'shortname' => 'Long Pretty Name',
		'background' => 'Background',
		'header' => 'Header',
		'fonts' => 'Fonts',
		'menu' => 'Menu',
		'contact' => 'Contact',
		'bio' => 'Bio',
		'posts' => 'Posts',
		'pages' => 'Pages',
		'comments' => 'Comments',
		'footerz' => 'Footer',
		'advanced' => 'Advanced',
	);
	
	$do_all_tabs = p2_options_do_all_tabs();
	

	echo '
	<div class="wrap" svn="' . p2_svn( false ) . '">';

	// tell people they can't use IE6 to admin this theme
	echo $explain['major']['noie6'];
	
	// quick links and form header
	echo '
	<h2>P2 Options: manage custom settings</h2>';
	
	p2_self_check( $write_result );
	
	echo '<ul id="quicklinks" style="padding-left:0;" class="self-clear">';
	foreach ( $blocks as $key=>$val ) {
		$anchor = $key;
		$text = $val;
		echo "<li><a class=\"tab-link\" id=\"$anchor-link\" href=\"themes.php?page=p2-options&p2_tab=$anchor\">$text</a></li>\n";
	}
	echo '<!--<li><a href="#save-reset">Save/Reset</a></li>-->
	</ul>
	<script type="text/javascript">
	// What to do when a tab is clicked ?
	function p2_hijack_tab_url(step) {
	';
	if ($do_all_tabs) {
	echo '
		if (step == 1) {
			return "update_display";
		} else {
			return false;
		}
	';
	} else {
	echo '
		if (step == 1) {
			if (p2_form_changed) return confirm("You have unsaved changes on this page. Do you want to go to another page and lose those changes?");
		} else {
			return true;
		}
	';
	}
	echo '
	}
	</script>';
	if (p2_debug() && !$do_all_tabs) echo "<em style='color:#f99'>Debug: Options in 'split mode'</em>";
	echo '<form method="post" action="">
	';
	wp_nonce_field('p2-options');
	$p2_form_weight+=2;
	
	// This hidden field will keep track of the tab that was displayed prior to submit
	$helper = ( isset( $_POST['location'] ) ) ? $_POST['location'] : '' ;
	echo '<input id="location-post" type="hidden" value="'.$helper.'" name="location" />';
	if (!$do_all_tabs) {
	// This javascript watch if anything has changed in the form, to trigger a warning on tab change
	echo <<<HTML
	<script type="text/javascript">
	var p2_form_changed = false;
	jQuery(document).ready(function() {
		jQuery(['input', 'select', 'textarea']).each(function() {
			jQuery(this.toString()).change(function() {
				p2_form_changed = true;
			});
		});
	});
	</script>
	<!-- <div id="p2_limited_options">Due to some limitations on your server config (namely, <a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.post.max_vars">this</a>) you are not able to view all options at once. Please make sure you SAVE before going to another tab!</div> -->
HTML;
	}
	$p2_form_weight++;
	echo "<span class='funky-helper' style='display:none;'>";
	echo $helper; echo"</span>";
	
	if ($do_all_tabs) {
		// Print everything, all the 23392 input fields, yeah baby
		foreach ($blocks as $key=>$val) {
			p2_options_page_block($key);
		}
	} else {
		// Restrict to one block only, sorry
		$p2_tab = (isset($_GET['p2_tab'])) ? $_GET['p2_tab'] : 'background';
		p2_options_page_block($p2_tab);
	}
	
	p2_options_page_footer();
	
}

// Display each "block" of options
function p2_options_page_block($block='') {
	global $p2, $explain, $content_width, $p2_form_weight;	

	$weight_before = $p2_form_weight;
	switch($block) {
	
	case('background'):
		/* ------------------------- */
		/* BACKGROUND CUSTOMIZATIONS */
		/* ------------------------- */
		p2_option_header('General Background Options', 'background');
		// blog bg color
		$bg_msg = ''; if ( p2_image_exists('blog_bg') ) $bg_msg = ', behind background image';
		p2_multiple_option_box('bg_color', 'color', 'Blog background colors', 'background color of your blog, seen at the outside edges of your browser' . $bg_msg,'first');
		p2_multiple_option_box('body_bg_color', 'color', 'Body background color', 'background color of the main section of your blog, where most of the text and pictures are','last');
		// blog border
		p2_multiple_option_box('blog_border', 'radio|border|use the default solid border|dropshadow|use a subtle dropshadow','Blog border style', 'choose the appearance of the sides of your blog, either solid borders (default), or a subtle dropshadow effect','first');
		p2_multiple_option_box('blog_border_color', 'color', '', 'color for solid border', 'last');
		
		// background advanced options
		p2_advanced_option_title('Blog Border & Background', 'blogborder', '500');
		p2_multiple_option_box('blog_border_width', 'text|2', 'More blog border options', 'width in pixels of blog border (not more than 16 pixels)', 'first' );
		p2_multiple_option_box('blog_border_topbottom', 'radio|no|left and right only|yes|all four sides ', '', 'show blog border just on left and right, or all four sides');
		p2_multiple_option_box('blog_top_margin', 'text|3', '', 'margin (in pixels) for top of blog (this is the distance between the top of the main area of the blog and the browser viewing area)');
		p2_multiple_option_box('blog_btm_margin', 'text|3', '', 'margin (in pixels) for bottom of blog (this is the distance between the bottom of the main area of the blog and the bottom of the browser viewing area)', 'last');
		$continue = p2_image_option('blog_bg', 'blog background', 'Blog background image position');
		if ( $continue ) {
			p2_multiple_option_box('bg_img_position', 'select|repeat|tile background image|no-repeat|do not tile bg image|repeat-x|tile bg image only horizontally|repeat-y|tile bg image only vertically|repeat fixed|tile in fixed position|repeat-x fixed|tile horizontally only in fixed position', 'Background image position','customize the way your background image appears', 'last');
		}
		p2_multiple_option_box('prophoto_classic_bar', 'radio|on|add colored bar|off|do not add colored bar', 'ProPhoto classic colored bar', 'add a solid colored bar on the top of the blog like the original ProPhoto theme design', 'first');
		p2_multiple_option_box('prophoto_classic_bar_height', 'text|3', '', 'height (in pixels) of ProPhoto Classic colored bar');
		p2_multiple_option_box('prophoto_classic_bar_color', 'color', '', 'color of ProPhoto Classic colored bar', 'last');
		p2_end_advanced_option('Blog Border', 'blogborder', 1);
		p2_option_spacer($weight_before);
	break;
	
	case('header'):
		/* --------------------- */
		/* HEADER CUSTOMIZATIONS */
		/* --------------------- */
		p2_option_header('Header Area Options', 'header');
		// header layout
		p2_header_options();
		// flash header
		p2_option_box('flashonoff', 'radio|on|Use masthead slideshow|off|Do not use masthead slideshow', 'Masthead Slideshow', 'if slideshow is turned off, the first uploaded header image will be shown as a static masthead image in your header', 'first');
		p2_advanced_option_title('Header Area', 'header', '400');
		// header bg color
		p2_option_box('header_bg_color', 'color', 'Header background color', 'background color behind logo (only seen in certain header layouts with logos less than width of blog)' );
		// masthead borders
		p2_multiple_option_box('masthead_border_top', 'radio|on|add custom line|off|do not add custom line','Custom line above masthead', 'add/remove a custom line above the masthead area', 'first');
		p2_multiple_option_box('masthead_border_top_color', 'color', '', 'color of custom line');
		p2_multiple_option_box('masthead_border_top_width', 'text|3', '', 'width (in pixels) of custom line');
		p2_multiple_option_box('masthead_border_top_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of custom line', 'last');
		p2_multiple_option_box('masthead_border_bottom', 'radio|on|add custom line|off|do not add custom line','Custom line below masthead', 'add/remove a custom line below the masthead area', 'first');
		p2_multiple_option_box('masthead_border_bottom_color', 'color', '', 'color of custom line');
		p2_multiple_option_box('masthead_border_bottom_width', 'text|3', '', 'width (in pixels) of custom line');
		p2_multiple_option_box('masthead_border_bottom_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of custom line', 'last');
		// flash header advanced
		p2_multiple_option_box('flash_speed', 'text|2', 'Masthead slideshow options', 'time (in seconds) each slideshow image is shown', 'first');
		p2_multiple_option_box('flash_fadetime', 'text|2', '', 'time of transition fade between slideshow images -- 1 is slowest, 50 is fastest');
		p2_multiple_option_box('flash_order', 'radio|random|play images in random order|sequential|play images in sequential order', '', '');
		p2_multiple_option_box('flash_loop', 'radio|yes|loop images|no|stop on last image');
		p2_multiple_option_box('flashheader_bg_color', 'color|optional', '', '<span class="color-optional">override background color of slideshow masthead area</span>', 'last');

		p2_end_advanced_option('Header', 'header', 1);
		p2_option_spacer($weight_before);
	break;

	case('fonts'):
		/* ------------------------- */
		/* FONT/LINK  CUSTOMIZATIONS */
		/* ------------------------- */
		p2_option_header('Overall Font & Link Font Options', 'fonts');
		p2_font_options('Overall font appearance', 'gen', 'paragraphs');
		// generic link styling
		p2_gen_link_options();
		p2_font_options('Overall headline appearance', 'header');	
		p2_option_spacer($weight_before);
	break;
	
	case('menu'):		
		/* ----------------------- */
		/* NAVIGATION MENU OPTIONS */
		/* ----------------------- */
		p2_option_header('Navigation Menu Options', 'menu');
		p2_multiple_option_box('nav_bg_color', 'color', 'Menu & dropdown appearance', 'background color of navigation menu', 'first');
		p2_multiple_option_box('nav_dropdown_bg_color', 'color|optional', 'Menu dropdown appearance', '<span class="color-optional">override inherited background color of dropdown area of menus</span>');
		// menu link options and preview
		
		p2_multiple_option_box("nav_top_fontsize", "text|3", 'Menu & dropdown appearance', 'link font size (in pixels) for top-level menu title links');
		p2_multiple_option_box('nav_dropdown_link_textsize', 'text|3', '', 'size (in pixels) for link text in drop down menus');
		p2_multiple_option_box("nav_link_font_family", 'select||select...|Arial, Helvetica, sans-serif|Arial|Times, Georgia, serif|Times|Verdana, Tahoma, sans-serif|Verdana|"Century Gothic", Helvetica, Arial, sans-serif|Century Gothic|Helvetica, Arial, sans-serif|Helvetica|Georgia, Times, serif|Georgia|"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif|Lucida Grande|Palatino, Georgia, serif|Palatino|Garamond, Palatino, Georgia, serif|Garamond|Tahoma, Verdana, Helvetica, sans-serif|Tahoma|Courier, monospace|Courier|"Trebuchet MS", Tahoma, Helvetica, sans-serif|Trebuchet MS|"Comic Sans MS", Arial, sans-serif|Comic Sans MS|Bookman, Palatino, Georgia, serif|Bookman', '', 'select your link font');
		p2_multiple_option_box("nav_link_font_color", 'color', '',  'link font color');
		p2_multiple_option_box("nav_dropdown_bg_hover_color", 'color', '', 'color of background of dropdown menu links when being hovered over');
		p2_multiple_option_box("nav_link_visited_font_color", 'color|optional', '', '<span class="color-optional">set unique font color after link has been visited</span>', '', true);
		p2_multiple_option_box("nav_link_hover_font_color", 'color', '', 'link font color when being hovered over', '', true);
		p2_multiple_option_box("nav_link_font_style", 'select||select...|normal|normal|italic|italic', '', 'link font style', '', true);
		p2_multiple_option_box('nav_link_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '','normal appearance of link', '', true);
		p2_multiple_option_box('nav_link_hover_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '', 'appearance of link when being hovered over', '', true);
		p2_multiple_option_box('nav_link_text_transform', 'select||select...|none|Normal|uppercase|UPPERCASE|lowercase|lowercase', '', 'link text effect', 'last', true);
		echo "<a class='font-link-more-options'></a>";
		//p2_link_options('Menu link appearance', 'nav', 'nav_dropdown_bg_hover_color*color*&nbsp;*color of background of dropdown menu links when being hovered over');
		// portfolio link
		p2_multiple_option_box('navportfolioonoff', 'radio|on|display portfolio link|off|do not display portfolio link', 'Menu portfolio link', 'the link to your portfolio website in your navigation menu', 'first');
		p2_multiple_option_box('navportfoliotitle', 'text|25', '', 'Link text for your portfolio website link');
		p2_multiple_option_box('navportfoliourl', 'text|25', '', 'web address for your portfolio link');
		p2_multiple_option_box('portfoliotarget', 'radio|_self|same window|_blank|new window', '', 'link, when clicked, opens in same browser window or new window/tab', 'last');
		
		// nav hidden options
		p2_advanced_option_title('Navigation Menu', 'navmenu', '200');	
		// nav menu additional items
		p2_advanced_option_title('Menu Items', 'navmenuitems', '800', '', '', '', '');
		// home link
		p2_multiple_option_box('nav_home_link', 'radio|on|add home link|off|do not add home link', 'Home Link', 'Show a "Home" link in the left-hand side of the navigation menu. When clicked, always takes user to home page of blog', 'first');
		p2_multiple_option_box('nav_home_link_text', 'text|25', '', 'text of "home" link', 'last');
		// archives
		p2_multiple_option_box('navarchivesonoff', 'radio|on|show Archives|off|do not show Archives', 'Archives dropdown', 'display monthly archive links in a dropdown menu', 'first');
		p2_multiple_option_box('navarchivestitle', 'text|25', '', 'Text for header of Archives drop-down menu');
		p2_multiple_option_box('nav_archives_threshold', 'text|2', '', 'after this many months displayed in dropdown menu, switch to months nested within years', 'last');
		// categories
		p2_multiple_option_box('navcategoriesonoff', 'radio|on|show categories|off|do not show categories', 'Categories dropdown', 'display category links in a dropdown menu', 'first');
		p2_multiple_option_box('navcategoriestitle', 'text|25', '', 'Text for header of categories drop-down menu', 'last');
		// blogroll
		p2_option_box('navblogrollonoff', 'radio|on|show blogroll|off|do not show blogroll', 'Blogroll dropdown', 'display menu of links (blogroll) in a dropdown menu');
		// contact form link
		p2_multiple_option_box('contactform_link_text', 'text', 'Contact form link text', 'Text for "Contact" form link', 'first');
		p2_multiple_option_box('contactform_loading_text', 'text', '', 'Text displayed briefly while contact form is loading', 'last');
		// pages
		p2_multiple_option_box('navpagesonoff', 'radio|on|show pages|off|do not show pages', 'Pages dropdown', 'display links to "Pages" in a dropdown menu', 'first');
		p2_multiple_option_box('navpagestitle', 'text|25', ' ', 'Text for header of pages drop-down menu', 'last');
		// recent posts
		p2_multiple_option_box('navrecentpostsonoff', 'radio|on|show recent posts|off|do not show recent posts', 'Recent Posts dropdown', 'display links to recent posts in a dropdown menu', 'first');
		p2_multiple_option_box('navrecentpoststitle', 'text|25', ' ', 'Text for header of recent posts drop-down menu');
		p2_multiple_option_box('navrecentpostslimit', 'text|3', ' ', 'number of recent posts shown in drop down menu', 'last');
		// email me link
		p2_multiple_option_box('nav_emaillink_onoff', 'radio|on|include "email me" link|off|do not include "email me" link', 'Email link', 'Include a link to your email address. This is an alternative to the built-in contact form, and is protected against spam.', 'first');
		p2_multiple_option_box('nav_emaillink_text', 'text|25', '', 'text of email link');
		p2_multiple_option_box('nav_emaillink_address', 'text|32', '', 'email address', 'last');
		// rss
		p2_multiple_option_box('nav_rss', 'radio|on|include link|off|do not include link', 'RSS link', 'link to your RSS feed in the nav menu', 'first');
		p2_multiple_option_box('nav_rss_options', 'checkbox|nav_rss_use_icon|yes|include RSS icon|nav_rss_use_linktext|yes|include link text', '', 'use icon or text link or both?');
		p2_multiple_option_box('nav_rsslink_text', 'text|15', '', 'text for RSS link', 'last');
		// subscribe by email
		p2_multiple_option_box('subscribebyemail_nav', 'radio|on|include subscribe by email form|off|do not include subscribe by email form', 'Subscribe by email', 'include option for users to subscribe to blog updates by email -- requires a free <a href="http://www.feedburner.com">Feedburner</a> feed + configuration <a style="cursor:pointer;" onclick="javascript:jQuery(\'#subscribebyemail_nav-cfa\').click();" tip="help">[?]</a>', 'first');
		p2_multiple_option_box('subscribebyemail_nav_leftright', 'radio|left|align left|right|align right', '', 'alignment of subscribe by email form in nav bar');
		p2_multiple_option_box('feedburner_id', 'text|12', '', 'Feedburner ID [<a style="cursor:pointer" onclick="javascript: jQuery(\'#menu-feedburner-id-explain\').slideToggle();">?</a>]</p><p id="menu-feedburner-id-explain" style="display:none">This is the unique word/s appended to your feedburner feed address. Example, your feedburner feed is something like: <span style="white-space:nowrap;font-size:80%;font-style:normal">http://feeds2.feedburner.com/SmithPhotoBlog</span><br />- in that case "SmithPhotoBog" is your Feedburner ID.');
		p2_multiple_option_box('subscribebyemail_lang', 'select|en_US|English|es_ES|Español|fr_FR|Français|da_DK|Dansk|de_DE|Deutsch|pt_PT|Portguese|ru_RU|русский язык|ja_JP|Japanese', '', 'Language that appears in the feedburner subscribe window');
		p2_multiple_option_box('subscribebyemail_nav_textinput_value', 'text', '', 'text shown in input box before user types');
		p2_multiple_option_box('subscribebyemail_nav_submit', 'text', '', 'text shown on submit button', 'last');	
		// search
		p2_multiple_option_box('navsearchonoff', 'radio|on|show search box|off|do not show search box', 'Search options', 'display the search box in the main navigation menu', 'first');
		p2_multiple_option_box('navsearchleftright', 'radio|right|search box aligned right|left|search box aligned normally', '', 'alignment of search box in navigation menu');
		p2_multiple_option_box('nav_search_btn_text', 'text|15', '', 'text on search submit button');
		p2_multiple_option_box('nav_search_dropdown', 'radio|off|show search form in nav bar|on|show search form in dropdown box', '', 'search form appearance - in nav menu, or in a box that drops down when a text "search" link is hovered over');
		p2_multiple_option_box('nav_search_dropdown_linktext', 'text', '', 'text of search dropdown link (only used if search shown in dropdown box)', 'last');	
		// custom links
		p2_multiple_option_box('navoption1title', 'text|25', 'Optional custom link #1', 'Link text for  custom link #1', 'first');
		p2_multiple_option_box('navoption1url', 'text|25', ' ', 'web address for link #1');
		p2_multiple_option_box('navoption1target', 'radio|_self|same window|_blank|new window', '', 'link, when clicked, opens in same browser window or new window/tab', 'last');
		p2_multiple_option_box('navoption2title', 'text|25', 'Optional custom link #2', 'Link text for custom link #2', 'first');
		p2_multiple_option_box('navoption2url', 'text|25', ' ', 'web address for link #2');
		p2_multiple_option_box('navoption2target', 'radio|_self|same window|_blank|new window', '', 'link, when clicked, opens in same browser window or new window/tab', 'last');
		
		
		p2_multiple_option_box('navoption3title', 'text|25', 'Optional custom link #3', 'Link text for  custom link #3', 'first');
		p2_multiple_option_box('navoption3url', 'text|25', ' ', 'web address for link #3');
		p2_multiple_option_box('navoption3target', 'radio|_self|same window|_blank|new window', '', 'link, when clicked, opens in same browser window or new window/tab', 'last');
		p2_multiple_option_box('navoption4title', 'text|25', 'Optional custom link #4', 'Link text for custom link #4', 'first');
		p2_multiple_option_box('navoption4url', 'text|25', ' ', 'web address for link #4');
		p2_multiple_option_box('navoption4target', 'radio|_self|same window|_blank|new window', '', 'link, when clicked, opens in same browser window or new window/tab', 'last');
		
		
		// twitter
		p2_multiple_option_box('twitter_onoff', 'radio|off|do not include twitter updates|on|include twitter updates', 'Twitter dropdown menu','embed <a href="http://www.twitter.com">Twitter</a> tweets in dropdown menu', 'first');
		p2_multiple_option_box('twitter_title', 'text|17', '','title of Twitter dropdown menu');
		p2_multiple_option_box('twitter_id', 'text|11', '','Your Twitter name. [<a style="cursor:pointer" onclick="javascript: jQuery(\'#twitter-name-explain2\').slideToggle();">?</a>]</p><p id="twitter-name-explain2" style="display:none">This is your twitter username, and is also the end of your twitter address. So if your twitter address is <span style="white-space:nowrap;font-family:courier, monospace;">http://twitter.com/susiephoto</span><br />then "susiephoto" is your twitter name');
		p2_multiple_option_box('twitter_count', 'text|2', '','show how many tweets?', 'last');
		p2_end_advanced_option('Menu Items', 'navmenuitems');	
		// nav menu additional items
		p2_advanced_option_title('Menu Appearance', 'navmenuappear', '800', '', '', '', '');
		// dropdown options
		p2_option_box('nav_dropdown_opacity', 'text|3', 'Dropdown menu transparency', 'transparency of dropdown menus. leave at 100 for no transparency, or set between 1 and 99 for semi-transparent menus. between 90 and 99 is usually best');
		// nav styling
		p2_option_box('nav_align', 'radio|left|align navigation menu to the left|right|align navigation menu to the right', 'Menu alignment', '');
		p2_multiple_option_box('nav_center_padding','text|3','Menu link custom spacing','Add optional spacing (in pixels) to the left of your menu', 'first');
		p2_multiple_option_box('nav_link_padding_right', 'text|3', 'Spacing between nav links', 'override default spacing between menu links by entering pixel amount', 'last');
		// nav top and bottom border
		p2_multiple_option_box('nav_border_top', 'radio|on|add custom line|off|do not add custom line','Custom line above menu', 'add/remove a custom line above the menu', 'first');
		p2_multiple_option_box('nav_border_top_color', 'color', '', 'color of custom line');
		p2_multiple_option_box('nav_border_top_width', 'text|3', '', 'width (in pixels) of custom line');
		p2_multiple_option_box('nav_border_top_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of custom line', 'last');
		p2_multiple_option_box('nav_border_bottom', 'radio|on|add custom line|off|do not add custom line','Custom line below menu', 'add/remove a custom line below the menu', 'first');
		p2_multiple_option_box('nav_border_bottom_color', 'color', '', 'color of custom line');
		p2_multiple_option_box('nav_border_bottom_width', 'text|3', '', 'width (in pixels) of custom line');
		p2_multiple_option_box('nav_border_bottom_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of custom line', 'last');
		// end menu appearance advanced 
		p2_end_advanced_option('Menu Appearance', 'navmenuappear');
		// end all nav advanced
		p2_end_advanced_option('Navigation Menu', 'navmenu');
		p2_option_spacer($weight_before);
	break;
		
	case('contact'):		
		/* ----------------------- */
		/* ---CONTACT  OPTIONS---- */
		/* ----------------------- */
		p2_option_header('Contact Form Options', 'contact');
		// include/don't include contact form
		p2_option_box('contactform_yesno', 'radio|yes|Include the built-in contact form|no|Do not include the built-in contact form', 'Include contact form?');
		p2_conditional_option_group('contactform-options', 'contactform_yesno', 'no');
		// header and text
		p2_multiple_option_box('contact_header', 'text|23', 'Contact area text', 'headline for contact form', 'first', '', true);
		p2_multiple_option_box('contact_text', 'textarea|10|74', '', 'text for body of contact form area', 'last', '', true);
		p2_advanced_option_title('Contact Form', 'contactform', '900');
		// link text
		p2_option_box('contactform_link_text_advise', 'blank', 'Contact form link text', 'The link text for the contact form navigation menu link is set in the "P2 Options" => "Menu" section.');
		// custom fields
		p2_multiple_option_box('contact_customfield_label', 'text|29', 'Custom field #1', 'label for a custom form field', 'first');
		p2_multiple_option_box('contact_customfield_required', 'radio|yes|yes, required|no|no, not required', '', 'is this a required field for the user to fill out?', 'last');
		p2_advanced_option_title('Custom Contact Form Fields', 'customfields', '400');
		p2_multiple_option_box('contact_customfield2_label', 'text|29', 'Custom field #2', 'label for your custom field', 'first');
		p2_multiple_option_box('contact_customfield2_required', 'radio|yes|yes, required|no|no, not required', '', 'is this a required field for the user to fill out?', 'last');
		p2_multiple_option_box('contact_customfield3_label', 'text|29', 'Custom field #3', 'label for your custom field', 'first');
		p2_multiple_option_box('contact_customfield3_required', 'radio|yes|yes, required|no|no, not required', '', 'is this a required field for the user to fill out?', 'last');
		p2_multiple_option_box('contact_customfield4_label', 'text|29', 'Custom field #4', 'label for your custom field', 'first');
		p2_multiple_option_box('contact_customfield4_required', 'radio|yes|yes, required|no|no, not required', '', 'is this a required field for the user to fill out?', 'last');
		p2_end_advanced_option('Custom Contact Form Fields', 'customfields', 1);
		// form error and success messages
		p2_multiple_option_box('contact_success_msg', 'text|33', 'Contact form submitted success message', 'text displayed when contact form successfully submitted', 'first');
		p2_multiple_option_box('contact_success_bg_color', 'color', '', 'color of background of success message area');
		p2_multiple_option_box('contact_success_text_color', 'color', '', 'color of text of success message', 'last');
		p2_multiple_option_box('contact_error_msg', 'text|33', 'Contact form submitted error message', 'text displayed when contact form error', 'first');
		p2_multiple_option_box('contact_error_bg_color', 'color', '', 'color of background of error message area');
		p2_multiple_option_box('contact_error_text_color', 'color', '', 'color of text of error message', 'last');
		// text and background colors
		p2_multiple_option_box('contact_header_color', 'color|optional', 'Text and background colors', '<span class="color-optional">override inherited color of contact form headers</span>', 'first');
		p2_multiple_option_box('contact_text_color', 'color|optional', '', '<span class="color-optional">override inherited color of contact form text</span>');
		p2_multiple_option_box('contact_bg_color', 'color|optional', '', '<span class="color-optional">Override inherited background color of contact form area</span>', 'last');
		// form labels and headers	
		p2_multiple_option_box('contactform_yourinformation_text', 'text|25', 'Contact form text', 'headline text for top part of contact form', 'first');
		p2_multiple_option_box('contactform_yourmessage_text', 'text|25', '', 'headline text for bottom part of contact form');
		p2_multiple_option_box('contactform_name_text', 'text|25', '', 'Label for "Name" input field');
		p2_multiple_option_box('contactform_email_text', 'text|25', '', 'Label for "Email" input field');
		p2_multiple_option_box('contactform_message_text', 'text|25', '', 'Label for the "Message" input field');
		p2_multiple_option_box('contactform_required_text', 'text|25', '', 'text shown when field is required');
		p2_multiple_option_box('contactform_submit_text', 'text|25', '', 'text on "submit" button');
		p2_multiple_option_box('anti_spam_explanation', 'text|25', '', 'text shown to explain anti-spam challenge', 'last');
		// anti spam questions	
		p2_option_box('contactform_antispam_enable', 'radio|on|enabled|off|disabled', 'Anti-spam challenges', 'Enable/disable the contact form anti-spam challenges.  If you are having any issues with spam coming from your contact form (as opposed to blog comment spam) then be sure to leave this enabled');
		p2_multiple_option_box('anti_spam_question_1', 'text|32', 'Anti-spam questions', 'random challenge #1 - asked to prove form submitted by human and not spam bot', 'first');
		p2_multiple_option_box('anti_spam_answer_1', 'text|18', '', 'answer to anti-spam challenge #1 <br /><em>not case-sensitive, if multiple answers are correct, separate with an asterisk like &quot;4*four&quot;</em>');
		p2_multiple_option_box('anti_spam_question_2', 'text|32', 'Anti-spam challenge #2', 'random challenge #2 - asked to prove form submitted by human and not spam bot');
		p2_multiple_option_box('anti_spam_answer_2', 'text|18', '', 'answer to anti-spam challenge #2 <br /><em>not case-sensitive, if multiple answers are correct, separate with an asterisk like &quot;4*four&quot;</em>');
		p2_multiple_option_box('anti_spam_question_3', 'text|32', 'Anti-spam challenge #3', 'random challenge #3 - asked to prove form submitted by human and not spam bot');
		p2_multiple_option_box('anti_spam_answer_3', 'text|18', '', 'answer to anti-spam challenge #3 <br /><em>not case-sensitive, if multiple answers are correct, separate with an asterisk like &quot;4*four&quot;</em>', 'last');
		// contact email to
		p2_option_box('contactform_emailto', 'text|30', 'Contact form email address', 'email address that contact form submissions are mailed to -- if not specified, will go to WordPress admin user email address');
		// disable ajax
		p2_option_box('contactform_ajax', 'radio|off|Simple mode on|on|Simple mode off', 'Contact form simple mode', 'Turn on "Simple mode" if your contact form is not loading correctly even after trying all of the fixes <a href="http://www.prophotoblogs.com/faqs/contact-form/">here</a>.');
		p2_end_advanced_option('Contact Form', 'contactform');
		echo '</div>';	// end of conditional_option_group
		p2_option_spacer($weight_before);
	break;
	
	case('bio'):		
		/* ----------------------- */
		/* ---BIO AREA OPTIONS---- */
		/* ----------------------- */
		p2_option_header('Bio Area Options', 'bio');
		// include / don't include bio area
		p2_option_box('bioyesno', 'radio|yes|Include bio area|no|Do not include bio area', 'Include bio area?');
		p2_conditional_option_group('bio-options', 'bioyesno', 'no');
		// bio 1 or 2 columns
		p2_option_box('bio2column', 'radio|off|Bio text all in one big column|on|Use two columns to display bio text', '1 or 2 Columns?', '');
		// bio text
		p2_biotext_option_box();
		p2_biotext_option_box(2);
		// hidden options begin
		p2_advanced_option_title('Bio Area', 'bioarea', '900');
		// bio twitter flash badge
		p2_multiple_option_box('bio_twitter', 'radio|off|off|display|display only|interact|interactive', 'Bio Twitter badge', 'Include a Twitter status badge in your bio area. Must have free <a href="http://twitter.com">Twitter</a> account. See what they look like <a href="http://twitter.com/widgets/which_flash">here</a>.', 'first');
		p2_multiple_option_box('twitter_num_id', 'text', '', 'Twitter numerical ID# (<a href="http://help.twitter.com/forums/23786/entries/15360" target="_blank">how to find</a>)');
		p2_multiple_option_box('twitter_name', 'text', '', 'Your Twitter name. [<a style="cursor:pointer" onclick="javascript: jQuery(\'#twitter-name-explain\').slideToggle();">?</a>]</p><p id="twitter-name-explain" style="display:none">This is your twitter username, and is also the end of your twitter address. So if your twitter address is <span style="white-space:nowrap;font-family:courier, monospace;">http://twitter.com/susiephoto</span><br />then "susiephoto" is your twitter name');
		p2_multiple_option_box('twitter_linktext', 'text|28', '', 'link text below badge');
		p2_multiple_option_box('bio_twitter_color', 'color', '', 'color of Twitter badge');
		p2_multiple_option_box('bio_twitter_style', 'radio|smooth|Smooth|velvetica|Velvetica|revo|Revo', '', 'style of interactive Twitter badge', 'last');
		// bio picture
		p2_multiple_option_box('biopiconoff', 'radio|on|Show bio picture|off|Do not show bio picture', 'Bio picture', '', 'first');
		p2_multiple_option_box('biopicleftright', 'radio|left|on left side of bio area|right|on right side of bio area', 'Alignment of bio picture', 'choose left or right alignment for your bio picture', 'last');
		// bio picture border options
		p2_advanced_option_title('Bio Picture','biopic-border', '300');
		p2_multiple_option_box('biopic_border_width', 'text|3', 'Border around bio picture', 'width (in pixels) of the border around your bio picture (set to 0 for no border)', 'first');
		p2_multiple_option_box('biopic_border_color', 'color', '', 'color of border around bio picture', 'last');
		p2_end_advanced_option('Bio Picture','biopic-border', 1);
		// bio text and header text appearance
		p2_font_options('Bio area headline text appearance', 'bio_header', 'headlines', true);
		p2_font_options('Bio area text appearance', 'bio_para', 'paragraphs', true);
		// hidden (minimized) bio
		p2_multiple_option_box('use_hidden_bio', 'radio|no|shown normally|yes|minimized', 'Bio area display type', 'Bio area shown normally, or "minimized" to an "About Me" link in the navigation menu', 'first');
		p2_multiple_option_box('hidden_bio_link_text', 'text|20', '', 'text of nav link to show/hide bio section', 'last');
		// bio on which pages?
		p2_multiple_option_box('bio_pages_options', 'checkbox|bio_home|on|Home|bio_single|on|Single post|bio_pages|on|Pages|bio_archive|on|Archive|bio_category|on|Category|bio_tag|on|Tag archive|bio_search|on|Search results|bio_author|on|Author archives', 'Bio on page types', 'choose which types of pages you want the bio to appear on', 'first');
		p2_multiple_option_box('bio_pages_minimize', 'radio|none|no bio section on unchecked|minimized|bio section minimized on unchecked', '', 'on unchecked pages, choose to either not show bio at all, or have bio "minimized" to a "about me" link in nav menu');
		p2_multiple_option_box('bio_pages_minimize_text', 'text|25', '', 'text for minimized "About Me" link for non-checked pages','last');
		// bio background
		p2_multiple_option_box('bio_bg', 'radio|default|default gradient &amp; "page-turn" images|gradient|just default gradient (no "page-turn")|color|custom background color|none|no background','Bio background appearance', '', 'first');
		p2_multiple_option_box('bio_bg_color', 'color', '','custom background color for bio area', 'last');
		// border/separator image below -- advanced background option
		p2_advanced_option_title('Bio Background', 'bio-background', '400');
		p2_multiple_option_box('bio_border', 'radio|border|use a border line below bio area|noborder|do not use a border line|image|custom image as a bottom border', 'Border below bio', 'to use a"custom image", you must upload one in the "P2 Uploads" page, and it will be centered below your bio', 'first');
		p2_multiple_option_box('bio_border_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of bottom border line');
		p2_multiple_option_box('bio_border_thickness', 'text|3', '', 'thickness (in pixels) of border');
		p2_multiple_option_box('bio_border_color', 'color', '', 'color of border', 'last');
		// signature image
		$continue = p2_image_option('bio_signature', 'signature image', 'Bio area "signature" image');
		if ( $continue ) {
			p2_multiple_option_box('bio_sig_float', 'radio|left|signature left aligned|right|signature right aligned', 'Signature Image', 'general alignment of optional bio signature image');
			p2_multiple_option_box('bio_sig_top_margin', 'text|3', '', 'extra spacing (in pixels) above signature image (between text and image)');
			p2_multiple_option_box('bio_sig_left_margin', 'text|3', '', 'extra spacing (in pixels) left of signature image');
			p2_multiple_option_box('bio_sig_right_margin', 'text|3', '', 'extra spacing (in pixels) right of signature image', 'last');
		}
		p2_end_advanced_option('Bio Background', 'bio-background', 1);
		echo '</div>';	// end of conditional_option_group
		p2_end_advanced_option('Bio Area', 'bioarea');
		p2_option_spacer($weight_before);
	break;
	
	case('posts'):		
		/* ----------------------- */
		/* ---POST AREA OPTIONS--- */
		/* ----------------------- */
		p2_option_header('Post Area Options', 'posts');
		// post date and time
		p2_multiple_option_box('dateformat', 'select|long|Monday, February 23, 2009|medium|Mon. February 23, 2009|short|February 23, 2009|longabrvdash|02-23-2009|shortabrvdash|02-23-09|longabrvast|02*23*2009|shortabrvast|02*23*09|longdot|02.23.2009|shortdot|02.23.09|custom|custom...', 'Post date/time display options', 'Choose your date display format for your posts', 'first');
		p2_multiple_option_box('displaytime', 'radio|yes|yes|no|no', '', 'also display time of day posted?');
		p2_multiple_option_box('dateformat_custom', 'text|14', '', 'enter custom <a href="http://codex.wordpress.org/Formatting_Date_and_Time">PHP-syntax date format</a> here', 'last');
		// content or excerpts
		p2_multiple_option_box('indexcontent', 'radio|full|display full posts|excerpt|display only excerpts of posts', 'Main page post display', 'Show full posts or only excerpts on main page', 'first');
		p2_multiple_option_box('moretext', 'text|15', '', 'Text used as link to full post if excerpts chosen', 'last');
		// more options
		p2_advanced_option_title('Post Area Options', 'post_options', '250');	
		// post header appearance
		p2_advanced_option_title('Post Header', 'postheader', '800', '', '', '', '');
		// post titles
		p2_link_options('Post title (link) appearance', 'post_title', 'post_title_margin_below*text|3**margin (in pixels) below post titles', false, true);
		// header alignment and margin below
		p2_multiple_option_box('post_header_align', 'radio|left|left aligned|center|centered|right|right aligned', 'Post header alignment & spacing below', 'this controls the text alignment of the post and page headers, where it says the title of the post/page and the date', 'first');
		p2_multiple_option_box('post_header_margin_below', 'text|3', '', 'spacing below post header (between post header and beginning of post conent)', 'last');
		// post header line below
		p2_multiple_option_box('post_header_border', 'radio|off|no line|on|add a line', 'Line below post header', 'use a line below the post header to separate it from the post body content', 'first');
		p2_multiple_option_box('post_header_border_width', 'text|3', 'Line below post header options', 'width of line below post header');
		p2_multiple_option_box('post_header_border_color', 'color', '', 'color of line below post header');
		p2_multiple_option_box('post_header_border_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of line below post header');
		p2_multiple_option_box('post_header_border_padding', 'text|3', '', 'spacing (in pixels) between post header and line');
		p2_multiple_option_box('post_header_border_margin', 'text|3', '', 'spacing (in pixels) between line and beginning of post', 'last');
		// end post header appearance
		p2_end_advanced_option('Post Header', 'postheader');
		// post content
		p2_advanced_option_title('Post Content', 'postcontent', '450', '', '', '', '');
		// post text
		p2_font_options('Post text appearance', 'post_text', 'paragraphs', true);
		// pictures
		p2_multiple_option_box('post_pic_border_width', 'text|2', 'Post picture appearance', 'width of border around posted pictures (0 for no border)', 'first');
		p2_multiple_option_box('post_pic_border_color', 'color', '', 'color of border around posted pictures');
		p2_multiple_option_box('post_pic_margin_top', 'text|2', '', 'margin (in pixels) above posted pictures');
		p2_multiple_option_box('post_pic_margin_bottom', 'text|2', '', 'margin (in pixels) below posted pictures', 'last');
		//p2_multiple_option_box('post_pic_margin_right', 'text|2', '', 'margin (in pixels) to the right of posted pictures (only necessary if you like to post pictures side by side with a small gap)', 'last');
		// end post content
		p2_end_advanced_option('Post Content', 'postcontent');
		// post meta
		p2_advanced_option_title('Post Meta', 'postmeta', '800', '', '', '', '');
		// category options
		p2_multiple_option_box('cattopbottom', 'radio|top|at top of post under post title|bottom|at bottom of post near comments', 'Post category links options', 'placement of category links', 'first');
		p2_multiple_option_box('cat_header_placement', 'radio|same|on same line with post date/time|newline|on a new line below post date/time', 'Post category links options', 'category links on same line or new', 'last');
		// .entry-meta-top styles - post date and top categories
		p2_font_options('Post meta text - top:<br /> post date & time<span class="cat1"><br />category list</span>', 'emt', false, true);
		// .entry-meta-bottom styles - Category and tag styles below post
		p2_font_options('Post meta text- bottom:<br />tag list<span class="cat2"><br />category list</span>', 'emb', false, true);
		// .entry-meta links
		p2_link_mini_options('Post meta link appearance:<br />category and tag links', 'em');
		// category links list display options	
		p2_multiple_option_box('catdivider', 'text|5', 'Category links list display options', 'When multiple categories, what should divide the category links? Default is ", "', 'first');
		$catpreludeinc_input = "radio|yes|include <em>\"<span class='cat-links'>" . p2_option('catprelude',0) . "</span></em>\" before category links|no|don't include <em>\"<span class='cat-links'>" . p2_option('catprelude',0) . "</span></em>\" before links";
		p2_multiple_option_box('catpreludeinc', $catpreludeinc_input, '', 'Text before category list');
		p2_multiple_option_box('catprelude', 'text', '', 'text to be included before category list','last');
		// tags
		p2_multiple_option_box('tagged', 'text|20', 'Tag options', 'text shown before list of tags', 'first');
		p2_multiple_option_box('tag_sep', 'text|4', '', 'text used to separate multiple tags');
		p2_multiple_option_box('tags_where_shown', 'checkbox|tags_on_index|yes|home page|tags_on_single|yes|single post (permalink pages)|tags_on_archive|yes|archive, category, author, and search|tags_on_tags|yes|tag archives', '', 'display tags below posts on which types of pages?', 'last');
		p2_post_sep_css();
		//post divider
		p2_multiple_option_box('post_divider_onoff', 'radio|line|use a line to separate posts|none|no line or image separating posts|image|upload a custom image to separate posts', 'Post separator', 'which type of separator?', 'first');
		p2_multiple_option_box('padding_below_post', 'text|3', '', '<span class="for1">First e</span<span class="for3">First e</span><span class="for2">E</span>xtra space (in pixels) below the post.<span class="for1">  This is the space between the bottom of the post and the </span><span class="for3">  This is the space between the bottom of the post and the </span><span class="for1">line.</span><span class="for3">image.</span>');
		p2_multiple_option_box('margin_below_post', 'text|3', '', '<span class="for1">Second e</span<span class="for3">Second e</span><span class="for1">xtra space (in pixels) below the post.</span><span class="for3">xtra space (in pixels) below the post.</span><span class="for1">  This is the space below the </span><span class="for3">  This is the space below the </span><span class="for1">line.</span><span class="for3">image.</span>');
		p2_multiple_option_box('post_sep_border_width', 'text|3', 'Line below post header options', 'width of line below post header');
		p2_multiple_option_box('post_sep_border_color', 'color', '', 'color of line below post header');
		p2_multiple_option_box('post_sep_border_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of line below post header', 'last');
		// end post meta
		p2_end_advanced_option('Post Meta', 'postmeta');
		p2_end_advanced_option('post-options', 'Post Area Options', 1);
		p2_option_spacer($weight_before);
	break;
	
	case('comments'):		
		/* ----------------------- */
		/* ----COMMENTS OPTIONS--- */
		/* ----------------------- */
		p2_option_header('Comments', 'comments');
		// comment layout
		p2_multiple_option_box('commentslayout', 'radio|tabbed|Tabbed layout|boxy|Boxy layout|minima|Minimalist layout', 'Comments Layout & Display', 'overall comment layout appearance', 'first');
		
		// show/hide by default
		p2_multiple_option_box('commentsopenclosed', 'radio|closed|Comments are hidden by default|open|Comments are open by default', 'Comments Open/Closed', 'comments area open or hidden by default', 'last');
		// font and link options
		p2_link_options('Comments header area font and link appearance', 'comments_header', '', TRUE, TRUE, '', TRUE);
		
		
		
		
		//p2_link_options('Comment font and link appearance', 'comments', '', TRUE, TRUE, '', TRUE);
		p2_multiple_option_box("comments_link_font_size", "text|3", 'Comment font and link appearance', 'link font size (in pixels)', 'first');
		p2_multiple_option_box('comments_comment_bg', 'color', 'Comments background color', 'default background color of individual comment area');
		p2_multiple_option_box('commenttime', 'radio|right|time of comment aligned right|left|time of comment aligned left|off|comment time not shown', 'Comment Timestamp Display', 'if/where to show the timestamp of the comment');
		p2_multiple_option_box('commenttimecolor', 'color', '', 'pick the color of the comment timestamp if included');
		p2_multiple_option_box('comments_nonlink_font_color', 'color|optional', '', '<span class="color-optional">override inherited font color for comment text</span>');
		p2_multiple_option_box("comments_link_font_color", 'color|optional', '', '<span class="color-optional">override inherited font color for commenter name/link</span>');
		p2_multiple_option_box("comments_link_font_style", 'select||select...|normal|normal|italic|italic', '', 'comment area font style', '', true);
		p2_multiple_option_box('comments_link_text_transform', 'select||select...|none|Normal|uppercase|UPPERCASE|lowercase|lowercase', '', 'comment area text effect', '', true);
		p2_multiple_option_box('comments_link_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '','appearance of comment name if link', '', true);
		p2_multiple_option_box('comments_link_hover_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '', 'appearance of comment name (if link) when being hovered over', '', true);
		p2_multiple_option_box("comments_link_font_family", 'select||select...|Arial, Helvetica, sans-serif|Arial|Times, Georgia, serif|Times|Verdana, Tahoma, sans-serif|Verdana|"Century Gothic", Helvetica, Arial, sans-serif|Century Gothic|Helvetica, Arial, sans-serif|Helvetica|Georgia, Times, serif|Georgia|"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif|Lucida Grande|Palatino, Georgia, serif|Palatino|Garamond, Palatino, Georgia, serif|Garamond|Tahoma, Verdana, Helvetica, sans-serif|Tahoma|Courier, monospace|Courier|"Trebuchet MS", Tahoma, Helvetica, sans-serif|Trebuchet MS|"Comic Sans MS", Arial, sans-serif|Comic Sans MS|Bookman, Palatino, Georgia, serif|Bookman', '', 'override the inherited font', 'last', true);
		echo "<a class='font-link-more-options'></a>";
		// hidden options below >>>
		p2_advanced_option_title('Comments', 'comments-advanced', '700');
		// boxy comments line color 
		p2_option_box('boxy_comments_line_color', 'color', 'Boxy comments line color', 'color of the thin line around the boxy comments area');
		// reverse comments
		p2_option_box('reverse_comments', 'radio||oldest comments on top|true|newest comments on top','Sort comments', 'sort your comments, most recent comment on the bottom of the list, or on top');
		// post interact options
		p2_multiple_option_box('comments_addacomment_text', 'text|29', 'Comment interaction links', 'text used for the "add a comment" links', 'first');
		p2_multiple_option_box(' ', 'blank', ' ', ' ');
		p2_multiple_option_box('comments_linktothispost', 'radio|yes|include|no|do not include', '', 'include or remove "link to this post" permalink option');
		p2_multiple_option_box('comments_linktothispost_text', 'text|29', '', 'text used for the "link to this post" permalink link');
		p2_multiple_option_box('comments_emailafriend', 'radio|yes|include|no|do not include', '', 'include or remove "email a friend" permalink option');
		p2_multiple_option_box('comments_emailafriend_text', 'text|29', '', 'text used for the "email a friend" links');
		p2_multiple_option_box('emailfriendbody', 'text|19', 'Email a Friend body text', 'Text used in the body of the email sent when someone clicks on the Email a Friend link');
		p2_multiple_option_box('comments_emailafriend_subject', 'text|29', '', 'Text used in subject line of email sent when someone clicks on the "Email a Friend" link', 'last');
		p2_multiple_option_box('comments_minima_show_text', 'text|15', 'Show/hide text in comment header area', '"show" text', 'first');
		p2_multiple_option_box('comments_minima_hide_text', 'text|15', '', '"hide" text', 'last');
		// comment bottom border line
		p2_multiple_option_box('comments_comment_border_onoff', 'radio|on|add a line|off|no line', 'Optional line separating individual comments', 'add and customize a line to separate each individual comment', 'first');
		p2_multiple_option_box('comments_comment_border_thickness', 'text|3', 'Optional line separating individual comments', 'thickness (in pixels) of line');
		p2_multiple_option_box('comments_comment_border_style', 'select||select...|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of line below comments');
		p2_multiple_option_box('comments_comment_border_color', 'color', '', 'color of line below comments', 'last');
		// awaiting moderation
		p2_multiple_option_box('comments_moderation_text', 'text|35', 'Comment awaiting moderation text/style', 'Text shown to comment submitter when comment moderation is turned on', 'first');
		p2_multiple_option_box('comments_moderation_style', 'select||select...|normal|normal|italic|italic', '', 'style of message text');
		p2_multiple_option_box('comments_moderation_color', 'color|optional', '', '<span class="color-optional">override default color of message text</span>');
		p2_multiple_option_box('comments_moderation_alt_color', 'color|optional', '', '<span class="color-optional">override default color of message text on every other comment</span>', 'last');
		// target=blank for comment author links
		p2_option_box('comment_author_link_blank', 'radio||open in same window|blank|open in new window', 'Comment author link window', 'links to comment author websites open in same window or in a new window');
		// alt and by author styling
		p2_advanced_option_title('Alternate & Author Styling', 'commentsaltauthorstyle', '', '', '', '', '');
		// alt comment styling
		p2_multiple_option_box('comments_comment_alt_bg', 'color|optional', 'Alternate comment styling', '<span class="color-optional">override the inherited background color of every other comment</span>', 'first');
		p2_multiple_option_box('comments_comment_alt_text_color', 'color|optional', '', '<span class="color-optional">override the inherited comment text color on every other comment</span>');
		p2_multiple_option_box('comments_comment_alt_link_color', 'color|optional', '', '<span class="color-optional">override the inherited link color (for commenters names who leave a website address) on every other comment</span>');
		p2_multiple_option_box('comments_timestamp_alt_color', 'color|optional', '', '<span class="color-optional">override the inherited text color of the comment timestamp on every other comment</span>', 'last');
		// by author styling
		p2_multiple_option_box('comments_comment_byauthor_bg', 'color|optional', 'Alternate styling for comments by post author', '<span class="color-optional">override the background color for your own comments</span>', 'first');
		p2_multiple_option_box('comments_comment_byauthor_text_color', 'color|optional', '', '<span class="color-optional">override the comment text color for your own comments</span>');
		p2_multiple_option_box('comments_comment_byauthor_link_color', 'color|optional', '', '<span class="color-optional">override link color on your own comments</span>');
		p2_multiple_option_box('comments_timestamp_byauthor_color', 'color|optional', '', '<span class="color-optional">override the text color of the comment timestamp of your own comments</span>', 'last');
		p2_end_advanced_option('', '');
		p2_end_advanced_option('Comments', 'comments-advanced', 0);
		p2_option_spacer($weight_before);
	break;
		
	case('pages'):
		/* ----------------------- */
		/* ----TEMPLATE OPTIONS--- */
		/* ----------------------- */
		p2_option_header('Other Pages: Archive, Category, Search, Tag, and Author Pages', 'pages');
		// header styling
		p2_font_options('Other pages: header styling', 'archive_h2', 'headers');
		p2_advanced_option_title('Other Pages', 'other_pages_options', '600');
		// single and page h1 titles
		p2_font_options('Single (permalink) and "Page" pages post title appearance', 'single_h1', 'post titles', true);
		// excerpts or full content on template pages
		p2_multiple_option_box('archive_content_option', 'radio|excerpt|excerpts (recommended)|full|full posts', 'Other pages: content', 'show excerpts of posts on other page or show full posts - excerpts are recommended for search engine optimization (SEO)', 'first');
		p2_multiple_option_box('other_pages_content', 'checkbox|archive_content|full|Archive pages|category_content|full|Category pages|search_content|full|Search results pages|tag_content|full|Tag archive pages|author_content|full|Author archive pages', '', 'check which types of pages you want to show full posts on', 'last');
		// comments on template pages
		p2_multiple_option_box('archive_comments', 'radio|on|include comments|off|no comments (recommended)', 'Other pages: comments', 'include comments on other pages', 'first');
		p2_multiple_option_box('archive_comments_showhide', 'radio|show|comments visible by default|hide|comments not visible by default', '', 'comments on other pages visible or hidden by default', 'last');
		// archive post divider
		p2_multiple_option_box('archive_post_divider', 'radio|same|same as on home pages|line|use a custom line', 'Other pages: post separator', 'use the same visual separator between posts on home page, or override with a custom line', 'first');
		p2_multiple_option_box('archive_padding_below_post', 'text|3', '', 'First extra space (in pixels) below post.  This is the space between the bottom of the post and the line');
		p2_multiple_option_box('archive_margin_below_post', 'text|3', '', 'Second extra space (in pixels) below post.  This is the space below the line.');
		p2_multiple_option_box('archive_post_sep_border_width', 'text|3', '', 'width of line below posts');
		p2_multiple_option_box('archive_post_sep_border_color', 'color', '', 'color of line below posts');
		p2_multiple_option_box('archive_post_sep_border_style', 'select|solid|solid line|dashed|dashed line|dotted|dotted line', '', 'style of line below posts', 'last');
		p2_end_advanced_option('Other Pages', 'other_pages_options', 1);	
		p2_option_spacer($weight_before);
	break;
		
	case('footerz'):
		/* ----------------------- */
		/* ----FOOTER OPTIONS----- */
		/* ----------------------- */
		p2_option_header('Footer Options', 'footerz');
		// include footer?
		p2_option_box('footer_include', 'radio|yes|Include footer area|no|Do not include footer area', 'Include footer area?');
		p2_conditional_option_group('footer-options', 'footer_include', 'no');
		// footer options
		p2_multiple_option_box('footer_bg_color', 'color', 'Footer options','Footer background color', 'first');
		p2_multiple_option_box('footer_widget_margin_below', 'text|3', '', 'spacing (in pixels) below footer content chunks', 'last');
		// header font
		p2_font_options('Footer headings text appearance', 'footer_headings', 'headings');
		// link and text
		p2_link_options('Footer links and text appearance', 'footer', '', true, true);
		// subscribe by email form
		p2_multiple_option_box('footer_subscribebyemail', 'radio|on|include|off|do not include', 'Footer "Subscribe by Email" form', 'Include a form to have your visitors sign up to receive updates to your blog via email. Requires that a free <a href="http://www.feedburner.com">Feedburner</a> account.', 'first');
		p2_multiple_option_box('footer_subscribebyemail_placement', 'radio|left|top of left column of footer|middle|top of middle column of footer|right|top of right column of footer', '', 'in which column of the footer would you like the form to appear?');
		p2_multiple_option_box('feedburner_footer_id', 'text|12', '', 'Feedburner ID [<a style="cursor:pointer" onclick="javascript: jQuery(\'#footer-feedburner-id-explain\').slideToggle();">?</a>]</p><p id="footer-feedburner-id-explain" style="display:none">This is the unique word/s appended to your feedburner feed address. Example, your feedburner feed is something like: <span style="white-space:nowrap;font-size:80%;font-style:normal">http://feeds2.feedburner.com/SmithPhotoBlog</span><br />- in that case "SmithPhotoBog" is your Feedburner ID.');
		p2_multiple_option_box('footer_subscribebyemail_lang', 'select|en_US|English|es_ES|Español|fr_FR|Français|da_DK|Dansk|de_DE|Deutsch|pt_PT|Portguese|ru_RU|русский язык|ja_JP|Japanese', '', 'Language that appears in the feedburner subscribe window');
		p2_multiple_option_box('footer_subscribebyemail_header', 'text|30', '', 'text for header of subscribe form');
		p2_multiple_option_box('footer_subscribebyemail_submit', 'text|30', '', 'text for submit button in form');
		p2_multiple_option_box('footer_subscribebyemail_note', 'textarea|3|25', '', 'an optional note to explain in more detail what the user is signing up for', 'last');
		echo '</div>';	// end of conditional_option_group
		p2_option_box('custom_copyright', 'text|50', 'Custom copyright text', 'Write your own custom footer copyright text -- shown at the very bottom of your blog. If blank, will read: <em>&copy; ' . date('Y') .  " " . get_bloginfo('name') . '</em>');
		p2_option_spacer($weight_before);
	break;
		
	case('advanced'):		
		/* ----------------------- */
		/* ----ADVANCED OPTIONS--- */
		/* ----------------------- */
		p2_option_header('Advanced Options', 'advanced');
		// maintainance mode
		p2_multiple_option_box('maintenance_mode', 'radio|on|under construction mode on|off|under construction mode off', 'Under construction mode', 'Display an "under construction" message to all blog visitors except you. Used to prevent viewing of your blog while customizations are being worked on.', 'first');
		p2_multiple_option_box('maintenance_message', 'textarea|3|32', '', 'message displayed to visitors when in "under construction" mode', 'last');
		// feedburner
		p2_option_box('feedburner', 'text|35', 'Feedburner URL', 'Enter your <a href="http://www.feedburner.com">Feedburner</a> URL here if you have burned your blog\'s feed to feedburner and want to use that instead of the built-in feed address.');
		// google analytics 
		p2_option_box('google_analytics_code', 'textarea|4|65', 'Google Analytics', 'Paste in your Google Analytics tracking code (new version - ga.gs) here. Will not count your own visits to your blog.');
		// statcounter 
		p2_option_box('statcounter_code', 'textarea|4|65', 'Statcounter Analytics', 'Paste in your Statcounter setup code here. Will not count your own visits to your blog.');
		// lazyloader
		p2_option_box('lazyloader', 'radio|on|on|off|off', 'Lazyloader', '<a href="http://www.appelsiini.net/projects/lazyload">Lazyloader</a> image loading delay. Makes your blog load much quicker by only loading images the user can see or will see soon as they scroll down your page.');
		// SEO
		p2_multiple_option_box('metadesc', 'textarea|2|32', 'Search Engine Optimization (SEO) options', 'Write a custom "meta description" - this will often be what appears in search engine results pages beneath the link to your blog. If blank, the theme will use the "Tagline" for your blog from "Settings" => "General"', 'first');
		p2_multiple_option_box('metakeywords', 'textarea|2|32', '', 'Enter a list of keywords and keyword phrases, separated by commas, for the meta keywords tag.');
		p2_multiple_option_box( 'noindexoptions', 'checkbox|noindex_archive|true|monthly archives|noindex_category|true|categories|noindex_search|true|search results|noindex_tag|true|tag archives|noindex_author|true|author archives', '', 'block search engines from indexing certain types of pages - helps reduce duplicate content which can improve rankings', 'last');
		
		// nav previous/next
		p2_multiple_option_box('nav_previous', 'text|18', 'Older/Newer posts navigation links', 'text for "Older posts" links on paginated pages', 'first');
		p2_multiple_option_box('nav_previous_align', 'radio|left|left-aligned|right|right-aligned', '', 'alignment of "Older posts" link');
		p2_multiple_option_box('nav_next', 'text|18', '', 'text for "Newer posts" links on paginated pages');
		p2_multiple_option_box('nav_next_align', 'radio|left|left-aligned|right|right-aligned', '', 'alignment of "Newer posts" links', 'last');
		p2_link_options('Font and link options for "Newer/Older posts" links text', 'nav_below', '', 0, true);
		// audio player basic
		p2_multiple_option_box('audioplayer', 'radio|off|off|bottom|bottom of page|top|top of page', 'Audio MP3 Player', 'activate and place the built-in audio MP3 player to provide music for your blog', 'first');
		p2_multiple_option_box('audiooptions', 'checkbox|audioplayer_autostart|yes|music should autostart|audioplayer_loop|yes|music should loop when finished');
		p2_multiple_option_box('audio_where', 'checkbox|audio_on_home|yes|Home page|audio_on_single|yes|Single post pages|audio_on_pages|yes|Pages|audio_on_archive|yes|Archive, category, tag, search, & author', '', 'choose which types of pages you want the audio player to appear on');
		p2_multiple_option_box('audio_hidden', 'radio|on|hide audio player|off|show audio player (recommended)', '', 'Hide audio player.  If hidden, user will not be able to stop music.', 'last');
		// audio player advanced options
		p2_advanced_option_title('Audio Player', 'audioplayero', '600', '', 'audioplayer', 'off');
		p2_multiple_option_box('audioplayer_override_file1', 'text|30', 'URLs mp3 files', 'URL path (web address) to mp3 file 1. Use if you can\'t upload the mp3 because it\'s too big.', 'first');
		p2_multiple_option_box('audioplayer_override_file2', 'text|30', '', 'URL path (web address) to mp3 file 2. Use if you can\'t upload the mp3 because it\'s too big.');
		p2_multiple_option_box('audioplayer_override_file3', 'text|30', '', 'URL path (web address) to mp3 file 3. Use if you can\'t upload the mp3 because it\'s too big.');
		p2_multiple_option_box('audioplayer_override_file4', 'text|30', '', 'URL path (web address) to mp3 file 4. Use if you can\'t upload the mp3 because it\'s too big.', 'last');
		p2_multiple_option_box('audioplayer_center_bg', 'color', 'Audio player custom colors', 'color of center of player when playing', 'first');
		p2_multiple_option_box('audioplayer_text', 'color', '', 'color of text in audio player');
		p2_multiple_option_box('audioplayer_left_bg', 'color', '', 'color of background of left side of player');
		p2_multiple_option_box('audioplayer_left_icon', 'color', '', 'color of speaker icon in left side of player');
		p2_multiple_option_box('audioplayer_right_bg', 'color', '', 'color of background of right side of player');
		p2_multiple_option_box('audioplayer_right_icon', 'color', '', 'color of play/pause icon in right side of player');
		p2_multiple_option_box('audioplayer_right_bg_hover', 'color', '', 'color of background of right side of player when hovered over');
		p2_multiple_option_box('audioplayer_right_icon_hover', 'color', '', 'color of play/pause icon in right side of player when hovered over');
		p2_multiple_option_box('audioplayer_slider', 'color', '', 'color of slider');
		p2_multiple_option_box('audioplayer_loader', 'color', '', 'color of loader bar');
		p2_multiple_option_box('audioplayer_track', 'color', '', 'color of track bar');
		p2_multiple_option_box('audioplayer_track_border', 'color', '', 'color of border of track bar');
		// add explanatory image...
		echo '<tr><td colspan=2><img src="'; bloginfo('template_url'); echo '/images/audioplayer.gif" style="margin:0 0 15px 30px;" /></tr></td></table></div></div>';
		p2_end_advanced_option('Audio Player', 'audioplayero', 1);
		// banner ads
		p2_multiple_option_box('sponsors', 'radio|on|on|off|off', 'Sponsor banner link options', 'add sponsor banner links or ads in the bottom of your blog', 'first');
		p2_multiple_option_box('sponsors_side_margins', 'text|3', '', 'spacing (in pixels) on left and right side of entire sponsor banner area', '');
		p2_multiple_option_box('sponsors_img_margin_right', 'text|3', '', 'spacing (in pixels) between sponsor banners (side to side)', '');
		p2_multiple_option_box('sponsors_img_margin_below', 'text|3', '', 'spacing (in pixels) below sponsor banners');
		p2_multiple_option_box('sponsors_border_color', 'color', '', 'color of border around sponsor banners');
		p2_multiple_option_box('blanky243', 'blank', '', '', '');
		p2_banner_ads();
		// override CSS
		p2_multiple_option_box('override_css_switch', 'radio|on|add css rules|off|do not add css rules', 'Override Styles', 'Add additional, custom CSS rules after all other CSS has loaded. Users with CSS knowledge only.', 'first', false, true);
		p2_multiple_option_box('override_css', 'textarea|18|77', '', 'custom CSS rules', 'last', false, true);
		// custom javascript
		p2_multiple_option_box('custom_js_switch', 'radio|on|add custom javascript|off|do not add custom javascript', 'Custom javascript', 'Add additional, custom javascript. Users with javascript knowledge only.', 'first', false, true);
		p2_multiple_option_box('custom_js', 'textarea|9|77', '', 'additional custom js', '', false, true);
		p2_multiple_option_box('custom_js_ready', 'textarea|9|77', '', 'Ready function jQuery code - code added here gets added inside a jQuery(document).ready(function(){}); function. NOTE: you cannot use the "$" alias, you must use "jQuery"', 'last', false, true);
		// disable right-click
		p2_multiple_option_box('no_right_click', 'radio||off| ondragstart="return false" onselectstart="return false"|on', 'Deter image theft', 'Turning this on makes it impossible to left-click or right click on images in your post, which makes it harder (but not impossible) to steal your images.', 'first');
		p2_multiple_option_box('no_left_click', 'radio|off|off|on|on', '', 'Disable left-clicking of any images that link to source files.  Turning this off causes only right-clicking to be disabled, but may make some 3rd party WordPress plugins work better.', 'last');
		
		// blog width
		p2_option_box('blog_width', 'select|994|994|950|950|900|900|850|850|800|800|760|760', 'Overall blog width', 'Overall width (in pixels) of blog, measured from outermost edge of border or dropshadow.  Use this to make your blog a different overall width, if desired. Changing this will affect the width of your masthead image/s and the size images you should upload. With your current settings, you can upload images with a max-width of <span class="upload-width" innermargin="'.p2_option('inner_margin',0).'" difference="'. p2_upload_width('diff') .'">'.p2_upload_width().'</span>px.');
		// inner spacing
		p2_option_box('inner_margin', 'radio|30|default inner spacing|zero|remove inner spacing', 'Blog inner spacing', 'Optionally remove the inner spacing from the left and right side of your blog.  This is most likely desired in a very minimalist layout with no border and a blog background color that matches the blog body.  In this case, removing the inner spacing causes all the text &amp; images to line up with the masthead image/s.');
		// translation
		p2_option_box('translate_switch', 'radio|on|translate|off|do not translate', 'Translation', 'translate some default English text used by the theme into another language');
		p2_conditional_option_group('translation-options', 'translate_switch', 'off');
		// translate: comments header area
		p2_multiple_option_box('translate_by', 'text|22', 'Translation: comments header', 'text shown before post author name link - default is "by", i.e. "<strong>by</strong> <span style="text-decoration:underline;">Admin</span>"', 'first');
		p2_multiple_option_box('translate_no', 'text|22', '', 'text shown before "comments" when there are no comments, as in "no" comments');
		p2_multiple_option_box('translate_comments', 'text|22', '', 'text shown in comment header area when there is zero or more than one comments');
		p2_multiple_option_box('translate_comment', 'text|22', '', 'text shown in comment header area when there is only 1 comment', 'last');
		// translate: comment form
		p2_multiple_option_box('translate_commentform_message', 'textarea|2|29', 'Translation: comment form', 'text shown at top of comment form', 'first');
		p2_multiple_option_box('translate_comments_required', 'text|32', '', 'text shown indicating how required fields are marked');
		p2_multiple_option_box('translate_comments_name', 'text|26', '', 'text shown above Name input area of comment form');
		p2_multiple_option_box('translate_comments_email', 'text|26', '', 'text shown above Email input area of comment form');
		p2_multiple_option_box('translate_comments_website', 'text|26', '', 'text shown above Website input area of comment form');
		p2_multiple_option_box('translate_comments_comment', 'text|26', '', 'text shown above Comment input area of comment form');
		p2_multiple_option_box('translate_comments_button', 'text|26', '', 'text shown on "post comment" submit button of comment form', 'last');
		// translate: archive pages 
		p2_multiple_option_box('translate_archives_monthly', 'text|33', 'Translation: archive pages', 'text shown in header of monthly archive pages', 'first');
		p2_multiple_option_box('translate_archives_yearly', 'text|33', 'Translation: archive pages', 'text shown in header of yearly archive pages');
		p2_multiple_option_box('translate_blog_archives', 'text|33', 'Translation: archive pages', 'text shown on certain other archive pages');
		p2_multiple_option_box('translate_tag_archives', 'text|33', 'Translation: archive pages', 'text shown as header on tag archive pages');
		p2_multiple_option_box('translate_category_archives', 'text|33', 'Translation: archive pages', 'text shown as header on category archive pages');
		p2_multiple_option_box('translate_author_archives', 'text|33', 'Translation: archive pages', 'text shown as header on author archive pages', 'last');
		// translate: search page
		p2_multiple_option_box('translate_search_results', 'text|33', 'Translation: search page', 'text used in header of search page when results are found', 'first');
		p2_multiple_option_box('translate_search_notfound_header', 'text|33', '', 'text used in header of search page when results are not found');
		p2_multiple_option_box('translate_search_notfound_text', 'textarea|2|29', '', 'text used in body of search page when results are not found');
		p2_multiple_option_box('translate_search_notfound_button', 'text|33', '', 'text used in on search page in button of new search form when results are not found', 'last');
		// translate: 404 page
		p2_multiple_option_box('translate_404_header', 'text|22', 'Translation: 404 page', 'header for "404 Not Found" template page -- shown when broken link in blog clicked or incorrect URL typed', 'first');
		p2_multiple_option_box('translate_404_text', 'textarea|2|29', '', 'text for "404 Not Found" template page -- shown when broken link in blog clicked or incorrect URL typed', 'last');
		echo '</div>';	// end of conditional_option_group
		// show hidden areas
		p2_option_box('show_hidden', 'radio|hide|show/hide advanced areas on click|show|always show hidden, advanced areas', 'Hidden options', 'show "P2 Options" hidden areas by default?');
		// pathfixer
		p2_multiple_option_box('pathfixer', 'radio|on|on|off|off', 'Blog path fixer', 'If you have changed the address of your blog and your images no longer load, turn on to fix your image paths.', 'first');
		p2_multiple_option_box(' ', 'blank', ' ', ' ');
		p2_multiple_option_box('pathfixer_old', 'text|35', '', 'Address of blog <strong>before</strong> address change');
		p2_multiple_option_box('pathfixer_new', 'text|35', '', 'Address of blog <strong>after</strong> address change', 'last');
		// remote support
		p2_option_box('allow_remote_support', 'radio|on|on|off|off', 'Support Mode', 'Allow NetRivet.com support professional to gather information from your theme settings and server configuration when working on a support ticket with you.');
		p2_option_spacer($weight_before);
	break;
	
	default:
		echo "<p><b>Oopsie? Don't know about block \"$block\"!!</b></p>";

	}	
	
}

// Close option form
function p2_options_page_footer() {
	global $p2, $explain, $content_width, $p2_form_weight;	

	// end of the form and wrapping div
	echo '<a name="save-reset" class="save-reset"></a>
	<p class="submit self-clear"><input type="submit" value="Save Changes" name="Submit" class="button-primary"/>
	<input type="hidden" value="update" name="p2-options"/>
	</p>';
	$p2_form_weight+=2;
	
	if (p2_debug())
		echo "<b style='color:#f33'>Number of fields in this form: $p2_form_weight</b>";
	
	echo '</form>
	</div>
	';


}

?>