<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src="<?php bloginfo('template_url'); ?>/thw.js" type="text/javascript"></script>

<?php if(!(is_single() || is_page())) { ?>
<style type="text/css">body { overflow-y:hidden; } </style>
<?php } else { ?>
<style type="text/css">#arrows { display:none; } </style>
<?php } ?>

<?php wp_head(); ?>
</head>
<body>
<div id="page">
 	<div id="container">
 		<h1 id="title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('title'); ?><sub>/</sub></a></h1>
 		<div id="posts">