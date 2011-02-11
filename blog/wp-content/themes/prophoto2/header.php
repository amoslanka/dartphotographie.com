<?php p2_check_wp_version(); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head>
<title><?php p2_get_title_tag();?></title><!-- p2_svn#:<?php p2_svn() ?> --><?php p2_maintenance_mode(); ?> 
<meta http-equiv="content-type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="description" content="<?php p2_meta_description(); $meta = false; ?>" />
<?php p2_get_meta_keywords(); ?>
<?php p2_meta_robots(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php p2_static( 'css' ); p2_option('randomizer'); ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php p2_rss() ?>" title="<?php echo wp_specialchars(get_bloginfo( 'name' ), 1) ?> <?php _e( 'Posts RSS feed', 'P2' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />	
<?php wp_enqueue_script('jquery');
wp_head(); 
if (p2_option( 'lazyloader', 0) == 'on' ) { ?><script src="<?php bloginfo( 'template_url' ); ?>/js/lazyload.js" type="text/javascript" charset="utf-8"></script>
<?php } ?>
<?php if (p2_option( 'audioplayer', 0) != 'off' ) { ?><script src="<?php bloginfo( 'template_url' ); ?>/js/audioplayer.js" type="text/javascript" charset="utf-8"></script>
<?php } ?>
<?php if ( p2_using_flash() ) { ?><script src="<?php bloginfo( 'template_url' ); ?>/js/swfobject<?php p2_swfobject_version(); ?>.js" type="text/javascript" charset="utf-8"></script>
<?php } ?>
<script src="<?php p2_static( 'js' ); ?>" type="text/javascript" charset="utf-8"></script>
<?php if ( p2_imageurl( 'favicon', 0 ) != '#' ) { ?><link rel="shortcut icon" href="<?php p2_imageurl( 'favicon' ); p2_option('randomizer'); ?>" type="image/x-icon" /><?php } ?> 
<?php if ( p2_image_exists('iphone_webclip_icon' ) ) { ?><link rel="apple-touch-icon" href="<?php p2_imageurl('iphone_webclip_icon'); p2_option('randomizer'); ?>" /><?php } ?> 
</head>

<body class="<?php sandbox_body_class(); ?>"<?php p2_option( 'no_right_click' );  ?>>

<div id="outerwrapper">

<div id="wrapper">
<?php if ( p2_test( 'prophoto_classic_bar', 'on' ) ) echo '<div id="top-colored-bar"></div>'; ?>
	
<div id="header">
	
<?php p2_get_header(); ?>

</div><!-- #header -->

<?php if (p2_option('contactform_yesno',0) == 'yes') { ?>
<div id="p2-contact-success" class="p2-contact-message">
	<p><?php p2_option( 'contact_success_msg' ); ?></p>
</div><!-- formsuccess -->
<div id="p2-contact-error" class="p2-contact-message">
	<p><?php p2_option( 'contact_error_msg' ); ?></p>
</div><!-- formerror -->
<div id="contact-form" class="self-clear" style="display:none">
<?php if ( p2_test( 'contactform_ajax', 'off' ) ) include( 'includes/contact.php'); ?>
</div><!-- #contact-form-->
<?php } ?>

<?php p2_get_bio(); ?>
<?php p2_insert_audio_player( 'top' ); ?>