<!-- Begin Navigation -->
<?php if ( p2_option( 'nav_align',0 ) == 'right' ) echo '<div id="topnav-outer" class="self-clear">'; ?>
<ul id="topnav" class="self-clear">
<?php 


// home link
if ( p2_option( 'nav_home_link', 0 ) == 'on' ) { ?>
<li><a href="<?php echo get_option('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php p2_option( 'nav_home_link_text' ); ?></a></li>
<?php } 


// portfolio link
if ( p2_option('navportfolioonoff', 0 ) == 'on' ) { ?>
<li><a href="<?php echo $url = ( p2_test( 'navportfoliourl' ) ) ? p2_url_add_http( p2_option( 'navportfoliourl', 0 ) ) : '#'; ?>" target="<?php p2_option('portfoliotarget'); ?>"><?php p2_option( 'navportfoliotitle' ); ?></a></li><?php } ?>
<?php 	


// normal hidden bio area "about me" link
if ( p2_test( 'bioyesno', 'yes' ) ) {
	$use_hidden_bio = false;
	$about_me_early = true;
	if ( p2_option('use_hidden_bio', 0 ) == 'yes' ) { 
		$link_text = p2_option( 'hidden_bio_link_text', 0 );
		$use_hidden_bio = true;
	} elseif ( p2_use_minimized_bio() ) {
		$link_text = p2_option( 'bio_pages_minimize_text', 0 );
		$use_hidden_bio = true;
		$about_me_early = false;
	}
	if ( ( $use_hidden_bio ) && ( $about_me_early ) ) {
	?>
<li><a id="hidden-bio"><?php echo $link_text; ?></a></li><?php } ?>
<?php
}


// pages
if ( p2_option( 'navpagesonoff',0 ) == 'on' ) { 
	$pagesparameters = 'orderby=name&title_li=<a>' . p2_sanitizer( 'navpagestitle', 0 ) . '</a>';
	wp_list_pages( $pagesparameters ); 
} 
	
	
// recent posts
if ( p2_option('navrecentpostsonoff', 0 ) == 'on' ) { 
	$limit = p2_option( 'navrecentpostslimit', 0 );
	$archparameters = 'type=postbypost&limit=' . $limit; ?>
<li><a><?php p2_option( 'navrecentpoststitle' ); ?></a>	
		<ul> 
		<?php wp_get_archives( $archparameters ); ?> 
		</ul>			
	</li><?php 
}  


// archives
if ( p2_option( 'navarchivesonoff', 0 ) == 'on' ) { ?>
<li><a><?php p2_option( 'navarchivestitle' ); ?></a>
	<?php p2_archive_drop_down('threshold='.p2_option('nav_archives_threshold',0)); ?> 
</li><?php } 

	
// categories
if (p2_option( 'navcategoriesonoff',0) == 'on' ) {
 	echo "\n";
	$catparameters = "orderby=name&title_li=<a>" . p2_sanitizer( 'navcategoriestitle', 0 ) . "</a>\n";
	wp_list_categories( $catparameters ); 
} 

	
// blogroll	
if ( p2_option( 'navblogrollonoff', 0 ) == 'on') { 
	echo "\n";
	wp_list_bookmarks( "title_before=<a>&title_after=</a>\t\t\t&category_before=<li class=\"%class\">&before=\t\t<li>" ); 
} 

		
// custom option 1
if ( p2_option( 'navoption1url', 0 ) ) { ?>
<li><a href="<?php echo $url = p2_url_add_http( p2_option( 'navoption1url', 0 ) ); ?>" target="<?php p2_option('navoption1target'); ?>"><?php p2_option( 'navoption1title' ); ?></a></li><?php 
}


// custom option 2
if ( p2_option( 'navoption2url', 0 ) ) { ?>
<li><a href="<?php echo $url = p2_url_add_http( p2_option( 'navoption2url', 0 ) ); ?>" target="<?php p2_option('navoption2target'); ?>"><?php p2_option( 'navoption2title' ); ?></a></li><?php 
} 



// custom option 3
if ( p2_option( 'navoption3url', 0 ) ) { ?>
<li><a href="<?php echo $url = p2_url_add_http( p2_option( 'navoption3url', 0 ) ); ?>" target="<?php p2_option('navoption3target'); ?>"><?php p2_option( 'navoption3title' ); ?></a></li><?php 
}


// custom option 4
if ( p2_option( 'navoption4url', 0 ) ) { ?>
<li><a href="<?php echo $url = p2_url_add_http( p2_option( 'navoption4url', 0 ) ); ?>" target="<?php p2_option('navoption4target'); ?>"><?php p2_option( 'navoption4title' ); ?></a></li><?php 
}


// twitter
if ( p2_option( 'twitter_onoff', 0 ) == 'on' ) {
?>
<li id="twitter-nav"><a><?php p2_option( 'twitter_title' ); ?></a>
	<div id="twitter_div">
	<ul id="twitter_update_list"></ul></div>
	<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
	<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php p2_option( 'twitter_id' ); ?>.json?callback=twitterCallback2&amp;count=<?php p2_option( 'twitter_count' ); ?>"></script>
</li>
<?php }


// email link
if ( p2_option( 'nav_emaillink_onoff', 0 ) == 'on' ) { ?>
<li><?php p2_js_email_encode( p2_option( 'nav_emaillink_address', 0 ), p2_option( 'nav_emaillink_text', 0 ) ); ?></li>
<?php 
} 


// contact
if ( p2_option( 'contactform_yesno', 0 ) == 'yes' ) { ?>
<li id="p2-contact-click" ><a id="p2-nav-contact"><?php p2_option('contactform_link_text'); ?></a></li>
<?php } 



// RSS icon 
if ( ( p2_option( 'nav_rss', 0 ) == 'on' ) && ( ( p2_option( 'nav_rss_use_icon', 0 ) == 'yes' ) || ( p2_option( 'nav_rss_use_linktext', 0 ) == 'yes' ) ) ) {
	if (p2_option( 'feedburner', 0 ) ) {
		$nav_rsslink_address = p2_option( 'feedburner', 0 );
	} else {
		$nav_rsslink_address = get_bloginfo('rss2_url', 'display');
	} ?>
<li id="nav-rss"><?php if ( p2_option( 'nav_rss_use_icon', 0 ) == 'yes' ) { ?><a href="<?php echo $nav_rsslink_address; ?>"><img src="<?php bloginfo( 'template_url' ); ?>/images/rss-icon.png" class="png" height="<?php p2_option( 'nav_top_fontsize' ); ?>" width="<?php p2_option( 'nav_top_fontsize' ); ?>" alt="" /></a><?php }; if ( p2_option( 'nav_rss_use_linktext', 0 ) == 'yes' ) { ?><a href="<?php echo $nav_rsslink_address; ?>" id="nav-rss-subscribe"><?php p2_option( 'nav_rsslink_text'); ?></a><?php } ?></li><?php }



// subscribe by email
if ( p2_option( 'subscribebyemail_nav', 0 ) == 'on' ) { ?>
<li id="subscribebyemail-nav">
	<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="_blank" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php p2_option( 'feedburner_id' ); ?>', 'blank');return false">
		<input type="text" size="12" name="email" value="<?php p2_option( 'subscribebyemail_nav_textinput_value' ) ?>" id="subscribebyemail-nav-input" /> 		
		<input type="hidden" value="<?php p2_option( 'feedburner_id' ); ?>" name="uri" />
		<input type="hidden" name="loc" value="<?php p2_option( 'subscribebyemail_lang' ); ?>" />
		<input type="submit" value="<?php p2_option( 'subscribebyemail_nav_submit' ); ?>" />
	</form>
</li>
<?php 
}


// search
if ( p2_option( 'navsearchonoff', 0 ) == 'on' ) { 
	$search_close = '';
	?>
<li id="search-top"><?php if ( p2_option( 'nav_search_dropdown', 0 ) == 'on' ) {
	$search_close = '</li></ul>';
	 ?><a><?php p2_option( 'nav_search_dropdown_linktext' ); ?></a>
	<ul>
	<li>
	<?php } ?>
	<form id="searchform-top" method="get" action="<?php bloginfo( 'home' ) ?>">
		<div>
			<input id="s-top" name="s" type="text" value="<?php echo wp_specialchars( stripslashes( $_GET['s'] ), true ) ?>" size="9" tabindex="1" />
			<input id="searchsubmit-top" name="searchsubmit-top" type="submit" value="<?php p2_option( 'nav_search_btn_text' ); ?>" />
		</div>	
	</form>
	<?php echo $search_close; ?>
</li>
<?php } 


// advanced 'minimized' about me link for unchecked pages
if ( p2_test( 'bioyesno', 'yes' ) ) {
	if ( ( $use_hidden_bio ) && ( !$about_me_early ) ) {
	?>
<li><a id="hidden-bio"><?php echo $link_text; ?></a></li><?php } 
}


 ?>
</ul><!-- #topnav --><?php if ( p2_option( 'nav_align', 0 ) == 'right' ) echo "\n</div><!-- #outer-topnav -->"; ?>
<!-- end Navigation -->