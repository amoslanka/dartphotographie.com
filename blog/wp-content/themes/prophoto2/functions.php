<?php
global $p2;
require_once(dirname(__FILE__).'/functions/general.php');
require_once(dirname(__FILE__).'/includes/settings.php');


// debug
define('P2_DEBUG', FALSE); // lists all stored options in debug box
define('P2_SPLIT_OPTIONS', TRUE); // if set to true, will split the Options page into several forms
$p2_option_name_debug = FALSE; // for debugging options page options

// The "Options" menu
function p2_add_options_page() {
	$options = add_theme_page( "ProPhoto2 &raquo; P2 Options", // Page title. JARED: edit
	"P2 Options", 	// Menu title.
	'edit_themes',		// User min level
	'p2-options', // page identifier (for url: themes.php?page=p2-options) JARED: edit
	'p2_options_page' // function
	);
	add_action("load-$options", 'p2_load_options_page');
}

// The "Upload" menu
function p2_add_upload_page() {
	$upload = add_theme_page( "ProPhoto2 &raquo; P2 Uploads", // Page title. JARED: edit
	"P2 Uploads", 	// Menu title. 
	'edit_themes',		// User min level
	'p2-upload', // page identifier (for url: themes.php?page=p2-upload) JARED: edit
	'p2_upload_page'); // function
	add_action("load-$upload", 'p2_load_upload_page');
}

// The "Settings" menu
function p2_add_settings_page() {
	$settings = add_theme_page( "ProPhoto2 &raquo; P2 Layouts", // Page title. JARED: edit
	"P2 Layouts", 	// Menu title. 
	'edit_themes',		// User min level
	'p2-layouts', // page identifier (for url: themes.php?page=p2-upload) JARED: edit
	'p2_settings_page'); // function
	add_action("load-$settings", 'p2_load_settings_page');
}

// On 'admin_menu' hook, add our "Options" & "Upload" menu
add_action('admin_menu', 'p2_add_options_page');
add_action('admin_menu', 'p2_add_upload_page');
add_action('admin_menu', 'p2_add_settings_page');
// Upload hooks
add_action('media_upload_image_p2', 'p2_do_image_uploaded'); // What to do when an image is uploaded
add_action('media_upload_misc_p2', 'p2_do_misc_uploaded'); // What to do when a misc file is uploaded
// p2_feedburner_redirect
add_action('template_redirect', 'p2_feedburner_redirect');
// Compatibility with Ozh' Admin Drop Down Menu
add_filter( 'ozh_adminmenu_icon', 'p2_adminmenu_customicon');
// When everything starts, trigger conditional events if needed
add_action('init', 'p2_start_theme');


// Function used to trigger events when the theme loads
function p2_start_theme() {

	// Initialize theme options
	p2_read_options();

	// Check if we've just activated the theme
	global $pagenow;
	if (is_admin() && isset($_GET['activated']) && $pagenow == "themes.php") {
		p2_generate_static();
		if ( strpos( get_option( 'upload_path' ), 'wp-content/uploads' ) !== false ) 
			update_option( 'upload_path', 'wp-content/uploads' );
	}

	// Intercept admin command if any
	if (isset($_GET['jared']) && p2_option('allow_remote_support',0)=='on') {
		require_once(dirname(__FILE__).'/functions/support.php');
		// Possible future TODO? use parse_str on $_GET to pass extra parameter? (?jared=stuff&param=1)
		p2_query_command($_GET['jared']);
	}
	
	// Add content filterz for path fixerz
	if ( p2_test( 'pathfixer', 'on' ) )
		add_filter('the_content', 'p2_pathfixer', 1000); // 1000 = make this happen the latest possible, when all other filters are done with the_content

}

// filter the_content for changed paths to images
function p2_pathfixer( $text ) {
	$text = str_replace( p2_option( 'pathfixer_old', 0 ), p2_option( 'pathfixer_new', 0 ), $text );
	return $text;
}


/* svn # for debugging, support, and javascript remote manipulation */
function p2_svn( $echo = true ) {
	$svn = '429';
	if ( $echo ) echo $svn;
	return $svn;
}

// Make the theme screenshot BIGGER damn it. It deserves it.
add_action('load-themes.php', create_function('', "add_action('admin_head', 'p2_bigger_screenshot_please');"));
function p2_bigger_screenshot_please() {
	echo '<style type="text/css">
	#current-theme img {width:300px}
	</style>
	';
}


/* sanitize strings to be passed to mail program */
function p2_sanitize_for_email( $strIn ) {
	$strOut = '';
	$strOut = $strIn;

	// swap spaces for _
	$strOut = str_replace( ' ', '%20', $strOut );
	$strOut = str_replace( '/', '%2F', $strOut );
	$strOut = trim( $strOut );

	return $strOut;
}


/* tests for valid-email */
function p2_is_not_valid_email( $email ) {
  $result = FALSE;
  if ( !eregi( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email ) ) {
    $result = TRUE;
  }
  return $result;
}



/* selects and includes the right header */
function p2_get_header() {
	
	// make the single post/page title the only h1
	$h = 'h1';
	if ( is_single() || is_page() ) $h = 'h2';
	
	//select the right header
	$headerlayout = p2_option('headerlayout', 0);
	$use_logo = true;
	
	switch($headerlayout) {
		case "defaultc":
			include "includes/headers/default.php";
			break;
		case "defaultr":
			include "includes/headers/default.php";
			break;
		case "logotopal":
		case "logotopar":
		case "logotopa":
			$navpos = "above";
			include "includes/headers/logoabove.php";
			break;
		case "logotopbl":
		case "logotopbr":
		case "logotopb":
			$navpos = "below";
			include "includes/headers/logoabove.php";
			break;
		case "logobelowal":
		case "logobelowar":
		case "logobelowa":
			$navpos = "above";
			include "includes/headers/logobelow.php";
			break;
		case "logobelowbl":
		case "logobelowbr":
		case "logobelowb":
			$navpos = "below";
			include "includes/headers/logobelow.php";
			break;
		case "pptclassic":
			include "includes/headers/pptclassic.php";
			break;
		case "nologoa":
			$use_logo = false;
			$navpos = 'above';
			include "includes/headers/logoabove.php";
			break;
		case "nologob":
			$use_logo = false;
			$navpos = 'below';
			include "includes/headers/logoabove.php";
			break;
		case "default":
			include "includes/headers/default.php";
			break;
		default:
			include "includes/headers/default.php";
			break;
	}
} // end function p2_get_header()



/* generic option tester */
function p2_test( $key, $value = false ) {
	if ( $value == false ) {
		if ( p2_option( $key, 0 ) ) return true;
		return false;
	} elseif ( p2_option( $key, 0 ) == $value ) return true;
	return false;
}


/* generic option color bind tester */
function p2_is_bound( $key ) {
	if ( p2_option( $key.'_bind', 0 ) == 'on' ) return true;
	return false;
}



/* insert and customize the audio player */
function p2_insert_audio_player( $location ) { 
	if ( p2_test( 'audioplayer', $location ) ) {
		// on for this page?
		if ( is_home() ) {
			if ( !p2_test( 'audio_on_home', 'yes' ) ) return;
		}
		if ( is_single() ) {
			if ( !p2_test( 'audio_on_single', 'yes' ) ) return;
		}
		if ( is_page() ) {
			if ( !p2_test( 'audio_on_pages', 'yes' ) ) return;
		}
		if ( is_archive() || is_search() || is_author() || is_tag() || is_category() ) {
			if ( !p2_test( 'audio_on_archive', 'yes' ) ) return;
		}
		echo '<p id="audio-player-holder"><script type="text/javascript">audioplayer();</script></p>';
	}
 } // end function p2_insert_audio_player



/* cleans up inputted urls by adding "http://" */
function p2_url_add_http( $url ) {
	if ( strstr( $url, 'http://' ) || strstr( $url, 'https://' ) ) {
		return $url;
	} else {
		$url = "http://" . $url;
		return $url;
	}
} // end function p2_url_add_http($url)



/* calls the comments_template() function when appropriate */
function p2_the_comments() {
	global $withcomments;
	$withcomments = true;	
	// single and page and home always have comments
	if ( !is_single() && !is_page() && !is_home() ) {
		if ( p2_test( 'archive_comments', 'on' ) ) comments_template();
	} else comments_template();
}



/* prints ad banners */
function p2_print_ad_banners() {
	if ( p2_test( 'sponsors', 'off') ) return;
	if ( p2_we_dont_have_banners() ) return;
	$c = 0; $which = array();
	for ( $i = 1; $i <= 15; $i++ ) {
		if ( p2_image_exists( 'banner' . $i ) ) {
			$c++;
			$which[$c] = $i;
		}
	}
	if ( !$c ) return; // probably redundant
	// print the HTML
	echo '<p id="ad-banners" class="self-clear">';
	for ( $i = 1; $i <= $c; $i++ ) {
		$num = $which[$i];
		echo '<span><a target="_blank" href="' . p2_url_add_http( p2_option( 'banner' . $num . '_link', 0) ) . '"><img src="' . p2_imageurl('banner' . $num, 0 ) . '" /></a></span>';
	}
	echo '</p>';
}



/* check if there are any banners */
function p2_we_dont_have_banners() {
	for ( $i = 1; $i <= 15; $i++ ) {
		if ( p2_image_exists( 'banner' . $i ) ) {
			return false;
		}
	}
	return true;
}



/* adds images into option rows */
function p2_add_inline_banner_image( $name ) {
	if ( strstr( $name, 'banner' ) ) { 
		$img_name = str_replace( '_link', '', $name );
		if ( !p2_image_exists( $img_name ) ) return;
		$width = '';
		if ( p2_imagewidth( $img_name, 0 ) > 220 ) {
			$width = " width=220";
		}
		echo '<img class="image-inline" src="';
		p2_imageurl( $img_name ); echo '"';
		echo $width;
		echo ' />';
		echo '<br />';
	}
}



/* prints bottom nav, gets ads, sidebar, and footer */
function p2_nav_sidebar_footer() { ?>
		<p id="nav-below" class="self-clear">
			<span class="nav-previous"><?php next_posts_link( p2_option( 'nav_previous', 0 ) ) ?></span>
			<span class="nav-next"><?php previous_posts_link( p2_option( 'nav_next', 0 ) ) ?></span>
		</p>

		</div><!--content--> <?php 
		
		p2_print_ad_banners();
		if ( p2_test( 'footer_include', 'yes' ) ) get_sidebar(); 
		get_footer(); 
}



/* mimics php5 str_split() for php4 */
function p2_str_split( $string, $split_length = 1 ){
    $count = strlen( $string );
    if( $split_length < 1 ){
         //  return false if split length is less than 1 to mimic php 5 behavior
        return false;
   
    } elseif( $split_length > $count ){
         //  the entire string becomes a single element in an array
        return array( $string );
    } else {
         //  split the string at desired length
        $num = ( int )ceil( $count / $split_length );
        $ret = array();
        for( $i=0; $i<$num; $i++ ){
            $ret[] = substr( $string, $i*$split_length, $split_length );
        }
        return $ret;      
    }   
} // end function p2_str_split()



/* create encoded javascript email  */
function p2_js_email_encode( $email_address, $emaillink_text ) {
	$string = '<a href="mailto:' . $email_address . '">' . $emaillink_text . '</a>';	
	$characters = p2_str_split( $string );
	$encoded = '<script type="text/javascript" language="javascript">{document.write(String.fromCharCode(';
	foreach ( $characters as $letter ) {
		$encoded .= ord( $letter );
		$encoded .= ',';
	}
	$encoded = rtrim( $encoded, ',' );
	echo $encoded = $encoded . '))}</script>';
}



/* print the day, month, and year according to user choice */
function p2_the_day() {
	$dateformat = p2_option( 'dateformat', 0 );
	switch( $dateformat ) {
		case "long":
			the_time( 'l, F j, Y' );
			break;
		case "medium":
			the_time( 'D. F j, Y' );
			break;
		case "short":
			the_time( 'F j, Y' );
			break;
		case "longabrvdash":
			the_time( 'm-d-Y' );
			break;
		case "longabrvast":
			the_time( 'm*d*Y' );
			break;
		case "shortabrvdash":
			the_time( 'm-d-y' );
			break;
		case "shortabrvast":
			the_time( 'm*d*y' );
			break;
		case "shortdot":
			the_time( 'm.d.y' );
			break;
		case "longdot":
			the_time( 'm.d.Y' );
			break;
		case "custom":
			the_time( p2_option( 'dateformat_custom',0 ) );
			break;
		default:
			the_time( 'l, F j, Y' );
			break;
	}
}



/* display the hour and minutes, if selected  */
function p2_the_time() {
	if (p2_option('displaytime',0) == 'yes') {
		echo " at "; 
		the_time('g:ia');
	}
}



/* prints the content or excerpt based on which type of page and user input */
function p2_print_content_or_excerpt( $page_type ) {
	
	// assume we're using full content
	$type = 'full';
	
	// index page
	if ( ( $page_type == 'index' ) && ( p2_option( 'indexcontent', 0 ) == 'excerpt' ) ) $type = 'excerpt';
	
	// other pages
	if ( $page_type != 'index') { 
		$type = 'excerpt';
		if ( ( p2_option( 'archive_content_option', 0 ) == 'full' )  && ( p2_option( $page_type . '_content', 0 ) == 'full' ) ) $type = 'full';
	}
	
	if ( $type == 'excerpt') {
		// get excerpt text
		$excerpt = apply_filters('the_excerpt', get_the_excerpt());
		// get rid of annoying [...]
		if ( strpos( $excerpt, '[...]') !== false ) $excerpt = str_replace(' [...]', '...', $excerpt);
		echo $excerpt; 
		echo "<p><a href=\"";
		the_permalink();
		echo "\" title=\"";
		the_title();
		echo "\">" . p2_option( 'moretext', 0 ) . "</a></p>";
	} else {
		the_content( $moretext );
	}
} // end function p2_print_content_or_excerpt()



/* include the bio page, if applicable  */
function p2_get_bio() {
	
	// main bio switch turned off? get out of here!
	if ( p2_option( 'bioyesno', 0 ) == 'no' ) return;
	
	// global minimized bio section
	if ( p2_test( 'use_hidden_bio', 'yes' ) ) {
		include 'includes/bio.php';
		return;
	}
	
	// what page are we on?
	if ( is_home() ) $page = 'index';
	elseif ( is_single() ) $page = 'single';
	elseif ( is_page() ) $page = 'pages';
	elseif ( is_tag() ) $page = 'tag';
	elseif ( is_search() ) $page = 'search';
	elseif ( is_category() ) $page = 'category';
	elseif ( is_author() ) $page = 'author';
	elseif ( is_archive() ) $page = 'archive';
	
	// test individual page settings
	if ( p2_option( 'bio_' . $page, 0 ) == 'on') {
		include 'includes/bio.php';
		return;
	}
	
	// include bio (will be hidden) if minimized option is on
	if ( p2_option( 'bio_pages_minimize', 0 ) == 'minimized') {
		include 'includes/bio.php';
		return;
	}
} // end function p2_get_bio()



/* figures out if a "about me" minimized bio link needs to be added for advanced minimize option */
function p2_use_minimized_bio() {
	// no bio? break and return false
	if ( p2_option( 'bioyesno', 0 ) == 'no' ) return false;
	// bio on, but minimize feature false
	if ( p2_option( 'bio_pages_minimize', 0 ) == 'none' ) return false;
	// bio turned on, minimizer on, check page types
	if ( is_home() ) {
		if ( p2_option( 'bio_home', 0 ) == '') return true;
		return false;
	}
	if ( is_single() ) {
		if ( p2_option( 'bio_single', 0 ) == '') return true;
		return false;
	}
	if ( is_page() ) {
		if ( p2_option( 'bio_page', 0 ) == '') return true;
		return false;
	}
	if ( is_category() ) {
		if ( p2_option( 'bio_category', 0 ) == '') return true;
		return false;
	}
	if ( is_tag() ) {
		if ( p2_option( 'bio_tag', 0 ) == '') return true;
		return false;
	}
	if ( is_search() ) {
		if ( p2_option( 'bio_search', 0 ) == '') return true;
		return false;
	}
	if ( is_author() ) {
		if ( p2_option( 'bio_author', 0 ) == '') return true;
		return false;
	}
	if ( is_archive() ) {
		if ( p2_option( 'bio_archive', 0 ) == '') return true;
		return false;
	}
} // end function p2_use_minimized_bio()



/* turn bio off for advanced minimize option */
function p2_bio_minimized(){
	$hidden = ' style="display:none !important;"';
	// no bio? break and return blank
	if ( p2_option( 'bioyesno', 0 ) == 'no' ) return;
	// bio on, but minimize feature off
	if ( p2_option( 'bio_pages_minimize', 0 ) == 'none' ) return;
	// bio turned on, minimizer on, check page types
	if ( is_home() ) {
		if ( p2_option( 'bio_home', 0 ) == '' ) echo $hidden;
		return;
	}
	if ( is_single() ) {
		if ( p2_option( 'bio_single', 0 ) == '' ) echo $hidden;
		return;
	}
	if ( is_page() ) {
		if ( p2_option( 'bio_page', 0 ) == '' ) echo $hidden;
		return;
	}
	if ( is_category() ) {
		if ( p2_option( 'bio_category', 0 ) == '' ) echo $hidden;
		return;
	}
	if ( is_tag() ) {
		if ( p2_option( 'bio_tag', 0 ) == '') echo $hidden;
		return;
	}
	if ( is_search() ) {
		if ( p2_option( 'bio_search', 0 ) == '' ) echo $hidden;
		return;
	}
	if ( is_author() ) {
		if ( p2_option( 'bio_author', 0 ) == '' ) echo $hidden;
		return;
	}
	if ( is_archive() ) {
		if ( p2_option( 'bio_archive', 0 ) == '' ) echo $hidden;
		return;
	}
} // end function p2_bio_minimized



/* checks for extra bio images to initiate js randomizer */
function p2_using_random_bio_images() {
	for ( $i = 2; $i <= 15; $i++ ) {
		if ( p2_image_exists( 'biopic' . $i ) ) return true;
	}
	return false;
}



/* prints the categories list */
function p2_the_categories( $location = 'top' ) {
	if ( p2_test( 'cattopbottom', $location ) ) {
		echo '<span class="posted-in">';
		if ( p2_test( 'catpreludeinc', 'yes' ) ) { 
			p2_option( 'catprelude' );
			echo ' '; 
		}
		echo get_the_category_list( p2_option( 'catdivider', 0 ) );
		if ( p2_test( 'cattopbottom', 'top' ) ) edit_post_link( 'Edit', '<span class="edit-link edit-link-top">', '</span>');
		echo '</span>';
	}
}



/* prints category and tags below posts, where appropriate */
function p2_the_meta() {
	echo '<div class="entry-meta entry-meta-bottom"><p>';
	// sprinkle some categories
	p2_the_categories( 'bottom' );
	
	// tags:  assume we're using them
	$use_tags = true;
	// unless we're not
	if ( is_home() && ( p2_option( 'tags_on_index', 0 ) != 'yes' ) ) {
		$use_tags = false;
	} elseif ( is_single() && ( p2_option( 'tags_on_single', 0 ) != 'yes' ) ) {
		$use_tags = false;
	} elseif ( is_tag() && ( p2_option( 'tags_on_tags', 0 ) != 'yes' ) ) {
		$use_tags = false;
	} elseif ( ( is_archive() || is_author() || is_search() || is_category() ) && ( p2_option( 'tags_on_archive', 0 ) != 'yes' ) ) {
		$use_tags = false;
	} 
	
	if ( $use_tags ) {
		if ( has_tag() && ( p2_option( 'cattopbottom', 0 ) == 'bottom' ) ) echo ' | ';
		the_tags( '<span class="tag-links">' . p2_option( 'tagged', 0 ) . ' ', p2_option( 'tag_sep', 0), '</span>' );
	}
	
	if ( p2_test( 'cattopbottom', 'bottom' ) ) edit_post_link( 'Edit', ' | <span class="edit-link">', '</span>');
	echo '</p></div><!-- entry-meta -->';
}


/* prints specialized meta for single pages */
function p2_single_the_meta() {
	echo '<div class="entry-meta entry-meta-bottom"><p>';
	p2_the_day();
	p2_the_time();
	echo ' | ';
	p2_the_categories( 'top' );
	if ( has_tag() && ( p2_option( 'tags_on_single', 0 ) == 'yes' ) ) {
		echo ' | ';
		the_tags( '<span class="tag-links">' . p2_option( 'tagged', 0 ) . ' ', p2_option( 'tag_sep', 0), '</span>' );
	}
	edit_post_link( 'Edit', ' | <span class="edit-link">', '</span>');
	echo '</p></div>';
}


/* checks for 2.7+ or displays link to upgrade info */
function p2_check_wp_version() {
	if ( ! function_exists( 'get_post_class' ) ) {  // an arbitrary function from 2.7
		echo '<div style="text-align:center;width:500px;margin:50px auto;">
		<h1>WP Version Not Supported</h1>
		<p>ProPhoto theme requires at least WordPress version <strong>2.7</strong> or newer. Your blog is running version <span style="color:red;font-family: Courier, monospace;">';
		bloginfo( 'version' );
		echo '</span>.</p><p>Copy this link and paste it into your browser: <br /><a href="http://www.prophotoblogs.com/faqs/wp-version-not-supported/">http://www.prophotoblogs.com/faqs/wp-version-not-supported/</a> <br />to get lots of good information on upgrading your version of WordPress, then activate another theme until you\'ve upgraded.</p><p>Remember to backup your blog <em>AND</em> database before you upgrade!</p>
		</div>';
		die;
	}
}


/* displays "under construction" message while blog is being customized */
function p2_maintenance_mode() {
	if ( p2_test( 'maintenance_mode', 'on' ) ) {
		// support backdoor
		if ( isset( $_GET['open'] ) && ( $_GET['open'] == 'sesame' ) ) return;
		// show reminder to logged in admin
		if ( current_user_can( 'switch_themes' ) ) {
			echo "<div id='maintenance-mode-remind'>Under Construction mode ON</div>";
			return;
		}
		// show visitors the maintenance message
		$message = p2_option( 'maintenance_message', 0 );
		echo 
		"\n</head>
		<body>
			<div style='text-align:center;width:500px;margin:50px auto;font-size:120%'>
				$message
			</div>
		</body>
		</html>";
		die;
	}
}






/*----------------------
  ---SANDBOX FUNCTIONS---
  -----------------------*/


// Generates semantic classes for BODY element
function sandbox_body_class( $print = true ) {
	global $wp_query, $current_user;
	
	// It's surely a WordPress blog, right?
	$c = array('wordpress');

	// Applies the time- and date-based classes (below) to BODY element
	sandbox_date_classes(time(), $c);

	// Generic semantic classes for what type of content is displayed
	is_home()       ? $c[] = 'home'       : null;
	is_archive()    ? $c[] = 'archive'    : null;
	is_date()       ? $c[] = 'date'       : null;
	is_search()     ? $c[] = 'search'     : null;
	is_paged()      ? $c[] = 'paged'      : null;
	is_attachment() ? $c[] = 'attachment' : null;
	is_404()        ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset($wp_query->post->post_date) )
			sandbox_date_classes(mysql2date('U', $wp_query->post->post_date), $c, 's-');

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$the_mime = get_post_mime_type();
			$boring_stuff = array("application/", "image/", "text/", "audio/", "video/", "music/");
				$c[] = 'attachment-' . str_replace($boring_stuff, "", "$the_mime");
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	else if ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	else if ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	else if ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug; // Does not work; however I try to return the tag I get a false. Grrr.
	}

	// Page author for BODY on 'pages'
	else if ( is_page() ) {
		$pageID = $wp_query->post->ID;
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get("paged") ) || ( $page = $wp_query->get("page") ) ) && $page > 1 ) {
		$c[] = 'paged-'.$page.'';
		if ( is_single() ) {
			$c[] = 'single-paged-'.$page.'';
		} else if ( is_page() ) {
			$c[] = 'page-paged-'.$page.'';
		} else if ( is_category() ) {
			$c[] = 'category-paged-'.$page.'';
		} else if ( is_tag() ) {
			$c[] = 'tag-paged-'.$page.'';
		} else if ( is_date() ) {
			$c[] = 'date-paged-'.$page.'';
		} else if ( is_author() ) {
			$c[] = 'author-paged-'.$page.'';
		} else if ( is_search() ) {
			$c[] = 'search-paged-'.$page.'';
		}
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join(' ', apply_filters('body_class',  $c));

	// And tada!
	return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	// hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
	$c = array('hentry', "p$sandbox_post_alt", $post->post_type, $post->post_status);

	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

	// Category for the post queried
	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->slug;

	// Tags for the post queried
	foreach ( (array) get_the_tags() as $tag )
		$c[] = 'tag-' . $tag->slug;

	// For password-protected posts
	if ( $post->post_password && ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) )
		$c[] = 'protected';
		
	// For password-protected posts
	if ( $post->post_password && ( $_COOKIE['wp-postpass_' . COOKIEHASH] == $post->post_password ) )
		$c[] = 'permitted';

	// Applies the time- and date-based classes (below) to post DIV
	sandbox_date_classes(mysql2date('U', $post->post_date), $c);

	// If it's the other to the every, then add 'alt' class
	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for post DIV
	$c = join(' ', apply_filters('post_class', $c));

	// And tada!
	return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array($comment->comment_type);

	// Counts trackbacks (t[n]) or comments (c[n])
	if ($comment->comment_type == 'trackback') {
		$c[] = "t$sandbox_comment_alt";
	} else {
		$c[] = "c$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);

		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = "byuser comment-author-" . sanitize_title_with_dashes(strtolower($user->user_login));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes(mysql2date('U', $comment->comment_date), $c, 'c-');
	if ( !(++$sandbox_comment_alt % 2) )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join(' ', apply_filters('comment_class', $c));

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes($t, &$c, $p = '') {
	$t = $t + (get_option('gmt_offset') * 3600);
	$c[] = $p . 'y' . gmdate('Y', $t); // Year
	$c[] = $p . 'm' . gmdate('m', $t); // Month
	$c[] = $p . 'd' . gmdate('d', $t); // Day
	$c[] = $p . 'h' . gmdate('H', $t); // Hour
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function sandbox_cats_meow($glue) {
	$current_cat = single_cat_title('', false);
	$separator = "\n";
	$cats = explode($separator, get_the_category_list($separator));

	foreach ( $cats as $i => $str ) {
		if ( strstr($str, ">$current_cat<") ) {
			unset($cats[$i]);
			break;
		}
	}

	if ( empty($cats) )
		return false;

	return trim(join($glue, $cats));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function sandbox_tag_ur_it($glue) {
	$current_tag = single_tag_title('', '',  false);
	$separator = "\n";
	$tags = explode($separator, get_the_tag_list("", "$separator", ""));

	foreach ( $tags as $i => $str ) {
		if ( strstr($str, ">$current_tag<") ) {
			unset($tags[$i]);
			break;
		}
	}

	if ( empty($tags) )
		return false;

	return trim(join($glue, $tags));
}


// Widget: Search; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_search($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Search', 'ProPhoto');
?>
			<?php echo $before_widget ?>
				<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
				<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="10" tabindex="1" />
						<input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'ProPhoto') ?>" tabindex="2" />
					</div>
				</form>
			<?php echo $after_widget ?>

<?php
}

// Widget: Meta; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_meta($args) {
	extract($args);
	if ( empty($title) )
		$title = __('Meta', 'ProPhoto');
?>
			<?php echo $before_widget; ?>
				<?php echo $before_title . $title . $after_title; ?>
				<ul>
					<?php wp_register() ?>
					<li><?php wp_loginout() ?></li>
					<?php wp_meta() ?>
				</ul>
			<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; to match the Sandbox style
function widget_sandbox_rsslinks($args) {
	extract($args);
	$options = get_option('widget_sandbox_rsslinks');
	$title = empty($options['title']) ? __('RSS Links', 'ProPhoto') : $options['title'];
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars(get_bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'ProPhoto'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'ProPhoto') ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'ProPhoto'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'ProPhoto') ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; element controls for customizing text within Widget plugin
function widget_sandbox_rsslinks_control() {
	$options = $newoptions = get_option('widget_sandbox_rsslinks');
	if ( $_POST["rsslinks-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["rsslinks-title"]));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_sandbox_rsslinks', $options);
	}
	$title = htmlspecialchars($options['title'], ENT_QUOTES);
?>
			<p><label for="rsslinks-title"><?php _e('Title:'); ?> <input style="width: 250px;" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
			<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	// Uses H3-level headings with all widgets to match Sandbox style
	$p = array(
		'before_title' => "<h3 class='widgettitle'>",
		'after_title' => "</h3>\n",
	);

	// Table for how many? Two? This way, please.
	register_sidebars(3, $p);

	// Finished intializing Widgets plugin, now let's load the Sandbox default widgets
	register_sidebar_widget(__('Search', 'ProPhoto'), 'widget_sandbox_search', null, 'search');
	unregister_widget_control('search');
	register_sidebar_widget(__('Meta', 'ProPhoto'), 'widget_sandbox_meta', null, 'meta');
	unregister_widget_control('meta');
	register_sidebar_widget(array(__('RSS Links', 'ProPhoto'), 'widgets'), 'widget_sandbox_rsslinks');
	register_widget_control(array(__('RSS Links', 'ProPhoto'), 'widgets'), 'widget_sandbox_rsslinks_control', 300, 90);
}



// Runs our code at the end to check that everything needed has loaded
add_action('init', 'sandbox_widgets_init');

// Adds filters so that things run smoothly
add_filter('archive_meta', 'wptexturize');
add_filter('archive_meta', 'convert_smilies');
add_filter('archive_meta', 'convert_chars');
add_filter('archive_meta', 'wpautop');

// end sandbox functions

// set content width for now
$content_width = 900;
?>