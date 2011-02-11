<?php
$GLOBALS['content_width'] = 315;

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Bottom Sidebar One',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Bottom Sidebar Two',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Bottom Sidebar Three',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Bottom Sidebar Four',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));			
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name' => 'Archive Sidebar One',
		'before_widget' => '', // Removes <li>
		'after_widget' => '', // Removes </li>
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));	

function thw_gallery_shortcode($attr) {
global $post;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	extract(shortcode_atts(array(
		'order'      => 'DESC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 9,
		'size'       => 'large',
	), $attr));

  $count = 1;
	$id = intval($id);
	$attachments = get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $size, true) . "\n";
		return $output;
	}

	$listtag = tag_escape($listtag);
	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

// Open gallery
	$output = apply_filters('gallery_style', "");

// Loop through each gallery item
	foreach ( $attachments as $id => $attachment ) {
	// Larger image URL
		$a_img = wp_get_attachment_url($id);
	// Attachment page ID
		$att_page = get_attachment_link($id);
	// Post content for Description
		$att_content = $attachment->post_content;
	// Returns array
	
		$img_thumb = wp_get_attachment_image_src($id,'thumbnail');
		$img = wp_get_attachment_image_src($id, $size);
		$img = $img[0];
	// If no caption is defined, set the title and alt attributes to title
		$title = $attachment->post_excerpt;
		if($title == '') $title = $attachment->post_title;

// Output each gallery item
if($count == 1)
$output .= "<div class='par' id='post-". $id ."'>";
if($count > 1)
$output .= "<div class='par' id='post-". $id ."'>";

// Set the link to the attachment URL
		$link = "#post-". $id;
		$output .= "\t<a href=\"#menu\" title=\"$title\" rel=\"$a_rel\">";
	// Output image
		$output .= "<img src=\"$img\" title=\"$title\" style=\"max-height:300px;max-width: 315px!important;\" alt=\"$att_content\" />";
	// Close link
		$output .= "</a>";
		$output .= "<div class='img_thumb'><a href=\"$link\" title=\"$title\" class=\"$a_class\" rel=\"$a_rel\"><img src=\"$img\" height='55' title=\"$title\" alt=\"$att_content\" /></a></div></div>";
$count++;
	// Close individual gallery item

	}
// Close gallery
	$output .= "";
	return $output;
}

/************************************************
Important stuff that runs this thing
************************************************/

// Remove original gallery shortcode
//	remove_shortcode(gallery);

// Add a new shortcode
	//add_shortcode('gallery', 'thw_gallery_shortcode');
	add_filter('post_gallery', 'thw_gallery_shortcode', $attr);
?>