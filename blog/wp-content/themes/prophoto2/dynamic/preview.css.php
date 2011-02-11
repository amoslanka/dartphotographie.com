<?php
if (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php')) {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php'); // WP 2.6+
} else {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-config.php'); // WP 2.5
}
@header('Content-type: text/css' );
?>
.font-preview  {
	background: <?php p2_option('body_bg_color'); ?>;
}
<?php font_css( 'gen', '.font-preview' ); ?>
.font-preview a {
	font-style:<?php p2_option('gen_link_font_style'); ?>;
}
.font-preview a.unvisited {
	color:<?php p2_option('gen_link_font_color'); ?>;
	text-decoration:<?php p2_option('gen_link_decoration'); ?>;
}
.font-preview a.visited {
	color:<?php p2_option('gen_link_visited_font_color'); ?>;
	text-decoration:<?php p2_option('gen_link_decoration'); ?>;
}
.font-preview a:hover {
	text-decoration:<?php p2_option('gen_link_hover_decoration'); ?>;
}
#header_font_family-font-preview {
	font-size: <?php p2_option('header_font_size'); ?>px; 
}
#nav_bg_color-font-preview {
	width: 235px;
	padding:0;
}

#nav_bg_color-font-preview a.visited, 
#nav_bg_color-font-preview a.unvisited {
	background: <?php p2_option( 'nav_bg_color' ); ?>;
	background: <?php p2_option( 'nav_dropdown_bg_color' ); ?>;
	font-size: 	<?php p2_option('nav_dropdown_link_textsize'); ?>px;
}
#nav_bg_color-font-preview a.title {
	background: <?php p2_option('nav_bg_color'); ?>;
	font-size: 	<?php p2_option('nav_top_fontsize'); ?>px;
}
#nav_bg_color-font-preview ul {
	padding-left:0;
	margin:0;
	padding:0;
}
#nav_bg_color-font-preview li {
	list-style:none;
	padding-left:0;
	margin-bottom:0;
}
#nav_bg_color-font-preview li a {
	display:block;
	padding:7px;
	margin:0;
}
#nav_bg_color-font-preview li a.visited {
	color: <?php p2_option('nav_link_font_color'); ?>; 
	color: <?php p2_option('nav_link_visited_font_color'); ?>; 
}
#bio_header_font_family-font-preview {
	<?php font_css('header'); ?> 
	<?php font_css('bio_header'); ?>
}
#bio_para_font_family-font-preview {
	<?php font_css('bio_para'); ?>
}
#post_title_link_font_size-font-preview a {
	<?php font_css('header'); ?> 
}
#archive_h2_font_family-font-preview {
	<?php font_css('header'); ?> 
	<?php font_css('archive_h2'); ?>
}
#single_h1_font_family-font-preview {
<?php font_css( 'header' ); ?>
	<?php font_css( 'post_title', '', true); ?>
	<?php font_css( 'single_h1' ); ?> 
}
#comments_header_link_font_size-font-preview {
	font-size:<?php p2_option('comments_header_link_font_size'); ?>px; 
	background:<?php
	if ( p2_test( 'commentslayout', 'tabbed' ) ) {
		echo "#F4F4F4;";
	} else {
		p2_option('body_bg_color');
	}	?>; 
}
#comments_link_font_size-font-preview {
	font-size:<?php p2_option('comments_link_font_size'); ?>px; 
	background:<?php p2_option('comments_comment_bg'); ?>;
	padding:10px !important;
}
#footer_headings_font_family-font-preview {
	font-size:<?php p2_option('footer_headings_font_size'); ?>px; 
	background:<?php p2_option('footer_bg_color'); ?>;
}
#footer_link_font_size-font-preview {
	background:<?php p2_option('footer_bg_color'); ?>; 
}
#post_title_link_font_size-font-preview a {
	font-size:<?php p2_option('post_title_link_font_size'); ?>px; 
}
#emt_font_family-font-preview {
	font-size:<?php p2_option('emt_font_size'); ?>px;
}
#emb_font_family-font-preview {
	font-size:<?php p2_option('emb_font_size'); ?>px;
}
#bio_header_font_family-font-preview, #bio_para_font_family-font-preview {
	<?php if (p2_test('bio_bg', 'color')) {
		echo "background:";
		p2_option('bio_bg_color');
		echo ";\n";
	}?>
}
span#comment-timestamp {
	<?php $val = p2_option( 'commenttime',0 ); 
	if ( $val == 'off' ) {
		echo "display:none;\n";
	} else {
		echo "float:$val;\n";
	}
	?> 
}
#gen_font_family-font-preview {
	line-height: <?php p2_option( 'gen_line_height' ) ?>em;
}
#post_text_font_family-font-preview p {
	line-height: <?php p2_option( 'gen_line_height' ) ?>em;
	<?php if ( p2_option( 'post_text_line_height', 0 ) ) { ?>line-height: <?php p2_option( 'post_text_line_height' ) ?>em;<?php } ?>
}
.hidden-option {
	<?php if ( p2_test('show_hidden', 'show') ) { ?>display:block;<?php } else { ?>display:none<?php } ?>
}
#emt_font_family-font-preview, #post_title_link_font_size-font-preview {
	text-align:<?php p2_option( 'post_header_align' ); ?>;
}