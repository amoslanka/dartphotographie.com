<?php
/*
Library of functions used in the "Manage Options" page
*/



/* Draws each upload form component */
function p2_option_box ($name, $params, $title = '', $comment = '', $groupkey = '') {
	global $p2, $p2_option_name_debug;
	if ( !$title ) $title = $name;
	extract( p2_option_box_data($name, $params, $title, $comment ) );  ?>
<div id="<?php echo $name; ?>-option-section" class="self-clear option-section"<?php p2_ux_display($name, false, 'section' ); ?>>
	<?php p2_click_for_explain( $name ); ?>
	<div class="option-section-label">
		<?php echo $title; ?>
		<?php if ( $p2_option_name_debug ) echo "<br /><h3 class='debug'><span>$name</span></h3>"; ?>
	</div>
	<div id="<?php echo $name; ?>-individual-option" class="individual-option not-multiple">
		<?php p2_extra_explain( $name )?>
		<?php p2_add_inline_banner_image( $name ); ?>
		<?php echo $input; ?>
		<?php echo "<p>$comment</p>"; ?>
	</div>
</div> <!-- .option-section  --><?php 	
}



/* creates clickable "show/hide" title for advanced options */
function p2_advanced_option_title ($title, $groupkey, $speed = '1000', $is_bottom = false, $db_test = '', $db_test_result = '', $more = 'more') {
	global $p2; 
	if ( p2_test('show_hidden', 'show') ) { ?>
<div id="<?php echo 'aot-' .$groupkey; ?>" class="self-clear option-section hidden-title">
<div class="individual-option" style="padding-top:9px"><a style="float:right; margin-right:8px;"><?php echo $more; ?> <?php echo $title; ?> options <span class="aot-view">&darr;</span></a></div>
</div>		
<?php } else {
	?>
<div id="<?php echo 'aot-' .$groupkey; ?>" class="self-clear option-section hidden-title"<?php if (($db_test) && (p2_option($db_test,0) == $db_test_result)) echo ' style="display:none;"'; ?>>
<div class="individual-option" style="padding-top:9px"><a onclick="javascript:jQuery('.hidden-option-<?php echo $groupkey; ?>').slideToggle(<?php echo $speed; ?>); jQuery('#aot-<?php echo $groupkey; ?>').toggleClass('shown');" style="float:right; margin-right:8px; cursor:pointer;">Click to <span class="aot-view">view</span><span class="aot-hide">hide</span> <?php echo $more; ?> <?php echo $title; ?> options <span class="aot-view">&darr;</span><span class="aot-hide">&uarr;</span></a></div>
</div><?php 
}
echo '<div class="hidden-option-'. $groupkey .' hidden-option">';	
}



/* closes out the div that gets animated for hidden options, adds an optional hide link */
function p2_end_advanced_option() {
	echo '</div>';
}



/* creates a white row to use as a visual divider and echo block weight (num of fiels) if applicable */
function p2_option_spacer ($weight_before=0) {
// this sux, i know
if (p2_debug() && $weight_before != 0) {
	global $p2_form_weight;
	$weight_after = $p2_form_weight;
	echo "<b style='color:#f99'>Number of fields in this block: ".($weight_after - $weight_before)."</b>";
}
echo '<div class="spacer"></div></div>';
}



/* creates a title header for option sections */
function p2_option_header($title, $id, $comment="") {
$display = ' style="display:none;"';
//if ($id == 'general') $display = '';
echo <<<HTML
<div id="tab-section-$id-link" class="tabbed-sections"$display>
<div class="self-clear header options-grouping-header" name="$id-link">
	<span class="option-section-label">$title</span>
	<span class="individual-option">$comment</span>
</div>

HTML;
	
}



/* adds "display:none" where appropriate after querying options */
function p2_ux_display( $index, $hide_font, $type = "individual" ) {
	if ( $hide_font ) {
		echo ' style="display:none;"';
		return;
	}
	global $options_ux;
	if ( !$options_ux['display'][$type][$index] ) return;
	$params = explode( '*', $options_ux['display'][$type][$index] );
	// if we have a third parameter, which reverses the function
	if ( $params[2] ) {
		if ( !p2_test( $params[0], $params[1] ) ) echo ' style="display:none;"';
		return;
	}
	// only two parameters, standard test
	if ( $params[1] ) {
		if ( p2_test( $params[0], $params[1] ) ) echo ' style="display:none;"';
	} else {
		// only one parameter, just check for existence
		if ( !p2_test( $params[0] ) ) echo ' style="display:none;"';
	}
}

/* adds special classes for font/link options, used by jquery font preview */
// TODO: make this suck less, so as not to incur the scorn of Ozh
function p2_font_option_addclass( $name, $hide_font ) {
	global $preview_options;	
	for ( $i = 0; $i <= 11; $i++ ) {
		if ( strpos( $name, $preview_options['name'][$i] ) !== false ) {
			echo $preview_options['class'][$i];
			$break = true;
		}
		if ( $break ) break;
	}
	if ( $hide_font ) echo " hidden-font-link-option";
}


/*adds class to multiple individual options for jquery and font preview */
function p2_ux_addclass( $name, $hide_font = false, $one_column = false ) {
	global $options_ux; $not_found = true;
	if ( ( strpos( $name, '_font_' ) !== false ) || ( strpos( $name, '_link_' ) !== false )  || ( strpos( $name, '_transform' ) !== false ) || ( strpos( $name, '_line_height' ) !== false ) || ( strpos( $name, 'gen_margin_below' ) !== false ) ) {
		p2_font_option_addclass( $name, $hide_font );
		return;
	}
	if ( $one_column ) echo " onecolumn";
	if ( !$options_ux['addclass'][$name] ) return;
	echo " a"; 
	echo $options_ux['addclass'][$name];
	echo "shg"; // stands for "show/hide group" :)
}



/* adds class to font and link group sections */
function p2_font_preview_add_section_class( $name ) {
	if ( strpos( $name, '_link_font_') !== false ) {
		echo " link-group";
		return true;
	}
	if ( strpos( $name, '_font_') !== false ) {
		echo " font-group";
		return true;
	}
	// other areas that get preview areas
	if ( strpos( 'nav_bg_color', $name) !== false ) {
		echo " link-group";
		return true;
	}
	return false;
}



/* adds in a contextually appropriate font preview test section, if appliciable */
function p2_font_preview( $name ) {
	global $preview_options;
	if ( $preview_options['preview'][$name] ) {
		$content = $preview_options['preview'][$name];
		echo "<div class='font-preview-wrapper'><div class='font-preview-spacer'><div class='font-preview' id='$name-font-preview'>$content</div></div></div>";
	}
}



/* add a "LIVE PREVIEW" button, if applicable */
function p2_live_preview_button( $name ) {
	global $preview_options;
	if ( $preview_options['preview'][$name] ) {
		echo "<br /><a class='live-preview-button' id='$name-lpb'></a>";
	}
}




/* A multiple-input section of certain peril */
function p2_multiple_option_box($name, $params, $title = '', $comment = '', $firstlast = '', $hide_font = false, $one_column = false) {
	global $p2, $counter, $p2_option_name_debug;
	if (!$title) $title = $name;

	// add crappy inline style TODO: make this not suck
	p2_suxorz( $name );
	
	// extract the normal stuff
	extract( p2_option_box_data( $name, $params, $title, $comment ) );
	
	if ($firstlast == 'first') { 
		// this is the first multiple option, so reset the counter
		$counter = 1;
		?>
<div id="<?php echo $name; ?>-option-section" class="self-clear option-section<?php $preview = p2_font_preview_add_section_class( $name ); ?>"<?php p2_ux_display($name, $hide_font, 'section' ); ?>>
	<?php p2_click_for_explain( $name ); ?>
	<div class="option-section-label">
		<?php echo $title; ?>
		<?php if ( $preview ) p2_live_preview_button( $name ); ?>
		<?php if ( $p2_option_name_debug ) echo "<br /><h3 class='debug'><span>$name</span></h3>"; ?>
	</div>
	<div class="multiple-option-table-wrapper">
		<?php p2_extra_explain( $name, true )?>
		<table class="multiple-option-table">	
			<?php if ( $preview ) p2_font_preview( $name ); ?>
<?php }
	// counter is odd?  that means we start a row
	if ($counter & 1) echo "<tr>\n";
 ?>	
				<td>
					<div id="<?php echo $name; ?>-individual-option" class="individual-option individual-option-multiple<?php p2_ux_addclass($name, $hide_font, $one_column);?>"<?php p2_ux_display( $name, $hide_font ); ?>><?php if ( $p2_option_name_debug ) echo "<br /><h3 class='debug'><span>$name</span></h3>"; ?>
						<?php p2_add_inline_banner_image( $name ); ?>											
						<div class="iehelper"><?php echo $input; ?></div>
						<?php echo "<p>$comment</p>"; ?>
					</div>
				</td>
<?php
	if ( ($counter & 0) || $one_column ) echo "</tr>\n";

	// done with the multiple option table/div, increment the counter
	$counter++;
	
	// close things up if we're done with the set
	if ($firstlast == 'last') echo "</table></div><!-- .individual-option -->\n</div><!-- .option-section -->\n";
	return $counter;	
} // end function p2_multiple_option_box();



/* prints all the options for styling fonts */
function p2_font_options($title, $key, $paragraph = '', $color_optional = false) {
	
	// conditional items
	$optional_comment = $optional = '';
	$span = '';
	$cspan = '';
	$font_comment = 'select your font';
	if ( $color_optional ) { 
		$optional = '|optional';
		$optional_comment = 'override inherited ';
		$font_comment = 'override the inherited font';
		$span = '<span class="color-optional">';
		$cspan = '</span>';
	}
	$last = 'last';
	if ( $paragraph ) $last = '';
	
	p2_multiple_option_box($key."_font_family", 'select||select...|Arial, Helvetica, sans-serif|Arial|Times, Georgia, serif|Times|Verdana, Tahoma, sans-serif|Verdana|"Century Gothic", Helvetica, Arial, sans-serif|Century Gothic|Helvetica, Arial, sans-serif|Helvetica|Georgia, Times, serif|Georgia|"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif|Lucida Grande|Palatino, Georgia, serif|Palatino|Garamond, Palatino, Georgia, serif|Garamond|Tahoma, Verdana, Helvetica, sans-serif|Tahoma|Courier, monospace|Courier|"Trebuchet MS", Tahoma, Helvetica, sans-serif|Trebuchet MS|"Comic Sans MS", Arial, sans-serif|Comic Sans MS|Bookman, Palatino, Georgia, serif|Bookman', $title, $font_comment, 'first');
	p2_multiple_option_box($key."_font_size", "text|3", '', $optional_comment . 'font size (in pixels)');
	p2_multiple_option_box($key."_font_color", 'color' . $optional, '', $span . $optional_comment . 'font color' . $cspan );
	p2_multiple_option_box($key."_font_weight", 'select||select...|400|normal|700|bold', '', $optional_comment . 'font weight (bold/normal)', '', true);
	p2_multiple_option_box($key."_font_style", 'select||select...|normal|normal|italic|italic', '', $optional_comment . 'font style', '', true);
	p2_multiple_option_box($key."_text_transform", 'select||select...|none|Normal|uppercase|UPPERCASE|lowercase|lowercase', '', $optional_comment . 'text effect', $last, true);
	if ( $paragraph ) {	
		if ( $paragraph == 'paragraphs') {
			p2_multiple_option_box($key.'_line_height', 'select||select...|1.0|single|1.25|1.25|1.5|1.5|1.75|1.75|2.0|double|2.25|2.25|2.5|2.5', '', $optional_comment . 'spacing between lines', '', true);
		}
		p2_multiple_option_box($key.'_margin_below', 'text|3', '', $optional_comment . 'margin (in pixels) below ' . $paragraph, 'last', true);
	}
	echo "<a class='font-link-more-options'></a>";
} // end function p2_font_options



/* prints all the options for styling a link */
function p2_link_options( $title, $key, $extra_option = '', $add_nonlink_font_color = false, $color_optional = false, $extras = '', $skip_visited = false ) {
	$optional_comment = $optional = '';
	$font_comment = 'select your link font';
	$span = '';
	$cspan = '';
	if ( $color_optional ) { 
		$span = '<span class="color-optional">';
		$cspan = '</span>';
		$optional = '|optional';
		$optional_comment = 'override inherited ';
		$font_comment = 'override the inherited link font';
	}
	// $extra allows for an extra, non-standard option to be passed to the function
	if ( $extra_option ) $params = explode( '*', $extra_option );
	p2_multiple_option_box($key."_link_font_size", "text|3", $title, $optional_comment . 'link font size (in pixels)', 'first', $extras);
	p2_multiple_option_box($key."_link_font_family", 'select||select...|Arial, Helvetica, sans-serif|Arial|Times, Georgia, serif|Times|Verdana, Tahoma, sans-serif|Verdana|"Century Gothic", Helvetica, Arial, sans-serif|Century Gothic|Helvetica, Arial, sans-serif|Helvetica|Georgia, Times, serif|Georgia|"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif|Lucida Grande|Palatino, Georgia, serif|Palatino|Garamond, Palatino, Georgia, serif|Garamond|Tahoma, Verdana, Helvetica, sans-serif|Tahoma|Courier, monospace|Courier|"Trebuchet MS", Tahoma, Helvetica, sans-serif|Trebuchet MS|"Comic Sans MS", Arial, sans-serif|Comic Sans MS|Bookman, Palatino, Georgia, serif|Bookman', '', $font_comment);
	if ( $add_nonlink_font_color ) p2_multiple_option_box($key.'_nonlink_font_color', 'color' . $optional, '', $span . $optional_comment . 'font color (non-link)' . $cspan );
	p2_multiple_option_box($key."_link_font_color", 'color' . $optional, '', $span . $optional_comment . 'link font color' . $cspan );
	if ( $extra_option ) p2_multiple_option_box($params[0],$params[1],$params[2], $optional_comment . $params[3],'', '');
	if ( !$skip_visited ) { 
		p2_multiple_option_box($key."_link_visited_font_color", 'color|optional', '', '<span class="color-optional">set unique font color after link has been visited</span>', '', true);
	 }
	p2_multiple_option_box($key."_link_hover_font_color", 'color' . $optional, '', $span . $optional_comment . 'link font color when being hovered over' . $cspan, '', true);
	p2_multiple_option_box($key."_link_font_style", 'select||select...|normal|normal|italic|italic', '', 'link font style', '', true);
	p2_multiple_option_box($key.'_link_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '','normal appearance of link', '', true);
	p2_multiple_option_box($key.'_link_hover_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '', $optional_comment . 'appearance of link when being hovered over', '', true);
	p2_multiple_option_box($key.'_link_text_transform', 'select||select...|none|Normal|uppercase|UPPERCASE|lowercase|lowercase', '', $optional_comment . 'link text effect', 'last', true);
	echo "<a class='font-link-more-options'></a>";
} // end function p2_link_options



/* prints a stripped down menu of link options */
function p2_link_mini_options( $title, $key, $color_optional = true) {
	$optional_comment = $optional = '';
	$font_comment = 'select your link font';
	$span = '';
	$cspan = '';
	if ( $color_optional ) { 
		$span = '<span class="color-optional">';
		$cspan = '</span>';
		$optional = '|optional';
		$optional_comment = 'override inherited ';
		$font_comment = 'override the inherited link font';
	}
	p2_multiple_option_box($key."_link_font_color", 'color' . $optional, $title, $span . $optional_comment . 'link font color' . $cspan, 'first' );
	p2_multiple_option_box($key."_link_visited_font_color", 'color' . $optional, '', $span . $optional_comment . 'link font color after being visited' . $cspan);
	p2_multiple_option_box($key."_link_hover_font_color", 'color' . $optional, '', $span . $optional_comment . 'link font color when being hovered over' . $cspan, '', true);
	p2_multiple_option_box($key.'_link_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '','normal appearance of link', '', true);
	p2_multiple_option_box($key.'_link_hover_decoration', 'select||select...|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '', $optional_comment . 'appearance of link when being hovered over', 'last', true);
	echo "<a class='font-link-more-options'></a>";
} // end function p2_link_options



/* creates the opening tag of a conditional group of options */
function p2_conditional_option_group($id, $option, $option_test) {
	echo '<div class="conditional-option-group" id="' . $id . '-cog"';
	if ( p2_test( $option, $option_test ) ) echo ' style="display:none;"';
	echo '>';
}



/* print the bio text options in all their jQuery and UX wizardry */
function p2_biotext_option_box($which = 1) {
	if ($which == 1) {
		$option = 'bioheader2';
		$class = 'a013shg';
		$one = '1';
		$two = '2';
		$msg = '';
		$hidden = 'b2';
		$id = '';
	} else {
		$option = 'bioheader4';
		$class = 'a014shg';
		$one = '3';
		$two = '4';
		$msg = ' -- second column';
		$hidden = 'b4';
		$id = 'bio-second-column';
	}	
	if ( p2_option( $option, 0 ) == '' ) {
		$reveal_hidden = '<br /><br />Want another header and text area beneath it in this column? &nbsp;<a onclick="javascript:jQuery(\'.' . $class . '\').slideToggle(200)" style="cursor:pointer;">click here &darr;</a>';
		$hide = '';
	} else {
		$reveal_hidden = '';
		$hide = 'hide';
	}
	

	$comment = 'the text of your bio area' . $msg . $reveal_hidden;
	p2_multiple_option_box('bioheader'.$one, 'text|40', 'Bio area text'.$msg, 'the headline in your bio area' . $msg, 'first', '', true);
	p2_multiple_option_box('biopara'.$one, 'textarea|9|74', 'Bio Paragraph 1', $comment, '', '', true);
	p2_multiple_option_box('bioheader'.$two, 'text|40', 'Bio area text', 'the second headline in your bio area' . $msg, '', '', true);
	p2_multiple_option_box('biopara'.$two, 'textarea|9|74', 'Bio Paragraph 1', 'the second text area of your bio area' . $msg, 'last', '', true);
} // end function p2_biotext_option_box



/* Color picker CSS in the head */
function p2_options_head() {
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/colorpicker/farbtastic.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/common.css?05" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('template_directory').'/adminpages/css/options.css?05" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="'.get_bloginfo('siteurl').'/wp-includes/js/thickbox/thickbox.css" rel="stylesheet" type="text/css" />'."\n";
	echo '<link href="' . p2_static( 'preview', 0 ) . p2_option('randomizer', 0 ) . '" rel="stylesheet" type="text/css" />'."\n";
}

/* Prepare data for p2_option_box() */
function p2_option_box_data ($name, $params, $title, $comment) {
	global $p2, $options_ux, $p2_form_weight;

	$params = explode('|', $params);
	
	// text|size
	// hidden
	// color|option
	// radio|id*which|value1|Text1|value2|Text2
	// select|value1|Text1|value2|Text2
	// dropdown|value1|Text1|value2|Text2
	// textarea|rows|cols
	// checkbox|option_var1|value1|Text1|option_var2|value2|Text2
	
	
	$value = p2_option($name, false); // Correct except for checkbox types, defined inline below
	
	$displayvalue = attribute_escape($value);

	$data = array();
	
	$type = array_shift($params);
	
	switch ($type) {
	case 'hidden':
	case 'text':
		$size=array_shift($params);
		$data['input'] = "<input type='$type' size='$size' id='p2-input-$name' name='p2_input_$name' value='$displayvalue' class='text-input' />";
		$p2_form_weight++;
		break;
	
	case 'color':
		$option=array_shift($params);
		if (!p2_validate_color($value)) $displayvalue = attribute_escape($p2['defaultsettings'][$name]);
		if (!$displayvalue) $displayvalue = '#000000';

		// Stuff to add if we have an optional color picker
		if ($option == 'optional') {
			$checked = ''; // checkbox state
			$jquery = 'false'; // checkbox state, 'true' or 'false'
			$display = 'none'; // display the binded color field, 'none' or 'block'
			$disabled = 'disabled="disabled"'; // state of the bound input field, '' or 'disabled="disabled"'
			if ('on' == p2_option("{$name}_bind", false)) {
				$checked='checked="checked"';
				$jquery = 'true';
				$display = 'block';
				$disabled = '';
			}
		
			$data['input'] .= "<input type='hidden' name='p2_input_{$name}_bind' value='' />";
			$p2_form_weight++;
			$data['input'] .= "<input type='checkbox' id='p2-input-{$name}-bind' name='p2_input_{$name}_bind' value='on' $checked class='optional-color-bind-checkbox' /><label for='p2-input-{$name}-bind'>$comment</label>";
			$p2_form_weight++;
			// Add a wrapping collapsible div around the color field
			$data['input'] .= "<div id='p2-input-{$name}-wrap' class='p2-colordiv-wrap' style='display:$display'>\n";
			$data['comment'] = ''; // reset the value of $comment in p2_option_box()
		} else {
			$data['input'] .= '<div>'; // this is so color pickers are same depth from parent divs no matter what for jquery
		}
		
		// The color picker itself
		$data['input'] .= "
		<input type='text' size='7' id='p2-input-$name' name='p2_input_$name' value='$displayvalue' $disabled class='color-picker' />
		<span class='p2_swatch' id='p2-swatch-$name' title='".$p2['msg']['pick_color']."'>&nbsp;</span>
		<div class='p2_picker_wrap' id='p2-picker-wrap-$name'>
			<div class='p2_picker' id='p2-picker-$name'></div>
		</div>
		";
		$p2_form_weight++;
		
		// Stuff for optional color picker, part 2
		if ($option == 'optional') {
			$data['input'] .= "</div>\n"; // end of the wrapping div
			// Add javascript behavior: force refresh + toggle div & input field
			$data['input'] .= "\n<script type='text/javascript'>
				jQuery('#p2-input-{$name}-bind').attr('checked',$jquery).click(function(){
					var display = (jQuery('#p2-input-{$name}-wrap').css('display') == 'block') ? 'none' : 'block';
					var disabled = (display == 'none') ? true : false;
					jQuery('#p2-input-$name').attr('disabled', disabled);
					jQuery('#p2-input-{$name}-wrap').slideToggle(100);
				});
				</script>\n";

		} else {
			$data['input'] .= "</div>";// this is so color pickers are same depth from parent divs no matter what for jquery
		}
		break;

	case 'textarea':
		$rows=array_shift($params);
		$cols=array_shift($params);
		$data['input'] =  "<textarea id='p2-input-$name' name='p2_input_$name' rows='$rows' cols='$cols' class='textarea-input'>$displayvalue</textarea>";
		$p2_form_weight++;
		break;
		
	case 'select':
	case 'dropdown':
		$data['input'] = "<select id='p2-input-$name' name='p2_input_$name' class='select-input'>";
		while ($params) {
			$v=array_shift($params);
			$t=array_shift($params);
			$selected='';
			if ($v == $value) $selected=' selected="selected"';
			$data['input'] .= "<option value='$v' $selected>$t</option>\n";
		}
		$data['input'] .= "</select>\n";
		$p2_form_weight++;
		break;
	
	case 'radio':
		// get custom javascript to attach to radio buttons
		$js = false;
		if ( $options_ux['js'][$name] ) {
			$js = true;
			$js_chunk = explode( '*', $options_ux['js'][$name] );
		}
		$radioloop = false; // Looping through radio params has not begun
		$counter = 0; // used as index for retrieving custom js
		while ($params) {
			$v=array_shift($params);
			$t=array_shift($params);
			$checked='';
			if ($v == $value) $checked='checked="checked"';
			if ($radioloop === false) {
				// Before the first radio button only, include the hidden field
				$data['input'] .= "<input type='hidden' name='p2_input_{$name}' value='' class='radio-input radio-input-hidden' />";
				$p2_form_weight++;
				$radioloop = true;
			}
			$data['input'] .= "<input type='radio' id=\"p2-input-{$name}-{$v}\" class='radio-input' name='p2_input_{$name}' value='$v' $checked";
			// add in custom javascript to control other option areas UX
			if ( $js ) {
				if ( $js_chunk[$counter] ) {
					$data['input'] .= " onclick=\"javascript:";
					$data['input'] .= $js_chunk[$counter];
					$data['input'] .= "\"";
				}
			}
			$data['input'] .= " /><label for='p2-input-{$name}-{$v}'>$t</label>";
			$p2_form_weight++;
			if (@$params) $data['input'] .= "<br />\n";
			$counter++;
		}
		break;

	case 'checkbox':
		while ($params) {
			$k=array_shift($params);
			$v=array_shift($params);
			$t=array_shift($params);
			$checked='';
			$jquery ='false';
			if ($v == p2_option($k, false)) {
				$checked='checked="checked"';
				$jquery = 'true';
			}
			$data['input'] .= "<input type='hidden' name='p2_input_$k' value='' class='checkbox-input checkbox-input-hidden' />";
			$p2_form_weight++;
			$data['input'] .= "<input type='checkbox' class='checkbox-input' id='p2-input-{$name}-{$k}' name='p2_input_$k' value='$v' $checked /><label for='p2-input-{$name}-{$k}'>$t</label>";
			$p2_form_weight++;
			// Add a javascript force refresh to avoid browser rendering inconsistencies between page reloads
			$data['input'] .= "<script type='text/javascript'>jQuery('#p2-input-{$name}-{$k}').attr('checked',$jquery);</script>";
			if (@$params) $data['input'] .= "<br />\n";
		}
		break;
	
	// leave one blank - for alignment purposes in multiple option areas	
	case 'blank':
		$data['input'] = "<span class='blank-comment' style='height:0;display:none;' class='blank-input-explain'>&nbsp;</span>";
		break;

	default:
		$data['input'] = "<span style='color:red;background:#ff8;padding:5px;border:1px solid #ccc;'>Oops, wrong input type: <b>$type</b></span>";

	}	
	return $data;	
} // end function p2_option_box_data



/* Handle POST data on the Options page */
function p2_process_options() {

	if (!isset($_POST['p2-options'])) return;
	
	global $p2;
	check_admin_referer('p2-options');

	// Debug :
	// echo "<pre>";echo attribute_escape(print_r($_POST,true));echo "</pre>";
	
	switch ($_POST['p2-options']) {
	case 'update':
		$update = false;
		$newoptions = array();

		foreach ($_POST as $key => $value) {
			// process each 'p2_input_something' entry
			if (strpos($key, 'p2_input_') !== false) {
				$key = str_replace('p2_input_', '', $key);
				$newoptions[$key] = $value;
				// randomize various filename to prevent cacheing issues
				$newoptions['randomizer'] = "?" . rand( 10000, 99999 );
				$update = true;
			}
		}		
		if ($update) {
			// if $p2 is not an array yet, make it one so we don't get an array_merger error
			if ( !is_array( $p2['options']['settings'] ) ) {
				$p2['options']['settings'] = array();
			}
			// overwrite new values only
			$p2['options']['settings'] = array_merge( $p2['options']['settings'], $newoptions);
			$write_result = p2_store_options();
		}
		break;
	case 'reset':
		unset($p2['options']);
		$write_result = p2_store_options();
	}
	return $write_result;
} // end function p2_process_options



/* Validate a color code */
function p2_validate_color($color) {
    $color = substr($color, 0, 7);
    return preg_match('/#[0-9a-fA-F]{6}/', $color);
}



/* show the banner ads options */
function p2_banner_ads() {
	$c = 0; $which = '';
	// find out how many banners (and which ones) exist
	for ( $i = 1; $i <= 15; $i++ ) {
		if ( p2_image_exists( 'banner' . $i ) ) {
			$c++;
			$which .= $i . '*';
		}
	}
	// no banners uploaded, show the message
	if ( $c == 0 ) { 
		echo $which;
		p2_multiple_option_box( 'no_sponsors', 'blank', 'Sponsor banners', '<span style="color:red;">[note:] To link your banners to websites, first go to the uploads page and upload at least one banner, then come back here</span>', 'last');
		return;
	// at least one banner uploaded	
	} elseif ( $c ) {
		$which_ones = explode( '*', $which );
		for ( $i = 1; $i <= $c; $i++ ) {
			// only one banner? single option box and return
			if ( $c == 1 ) {
				p2_multiple_option_box('banner' . $which_ones[0] . '_link', 'text|30', 'Sponsor banner links', 'Link for sponsor banner #' . $which_ones[0], 'last');
				return;
			}
			// more than one banner, set up and rip multiple options
			if ( $i == $c ) $firstlast = 'last';
			else $firstlast = '';
			$a = $i - 1;
			p2_multiple_option_box('banner' . $which_ones[$a] . '_link', 'text|30', 'Sponsor banner links', 'Link for sponsor banner #' . $which_ones[$a], $firstlast);
		}
	}		
} // end function p2_banner_ads



/* handles UI of option with an associated image */
function p2_image_option( $image, $prettyname, $title = '' ) {
	global $continue;
	if ( !$title ) $title = $prettyname;
	// we have an image. display it inline and continue
	if ( p2_image_exists( $image ) ) { 
		// shrink height, width, if necessary
		$h = p2_imageheight( $image, 0 );
		$w = p2_imagewidth( $image, 0 );
		$shrunk = false;
		if ( $w > 220 ) {
			$div = $w / 220;
			$w = 220; 
			$h = $h / $div;
			$shrunk = true;
		}
		if ( $h > 150 ) {
			$div = $h / 150;
			$h = 150; 
			$w = $w / $div;
			$shrunk = true;
		}
		// create the image html and rip the option
		$shrunk_msg = '';
		$img_html = '<img class="image-inline not-banner" src="' . p2_imageurl( $image, 0 ) . '"';
		if ( $shrunk ) { 
			$img_html .= " height=\"$h\" width=\"$w\"";
			$shrunk_msg = ' Not shown <a href="' . p2_imageurl( $image, 0 ) . '">fullsize</a>.';
		}
		$img_html .= ' /><br />Current ' . $prettyname . '. Change or remove in the <a href="admin.php?page=p2-upload">Uploads Page</a>.' . $shrunk_msg;
		p2_multiple_option_box( $image . '_display', 'blank', $title, $img_html, 'first' );
		return $continue = true;
	}
	// no image, show the no image message
	p2_option_box( $image . '_no_img_msg', 'blank', $title, 'There is currently no ' . $prettyname . ' image uploaded. Upload one in the "uploads" page and then return here to see and select options');
	return $continue = false;	
}



/* general link options */
function p2_gen_link_options() {
	// these are always shown
	p2_multiple_option_box("gen_link_font_color", 'color', 'Overall link font appearance', 'link font color', 'first');
	p2_multiple_option_box("gen_link_hover_font_color", 'color', '', 'link font color when being hovered over');
	// hidden ones
	p2_multiple_option_box("gen_link_visited_font_color", 'color|optional', '', '<span class="color-optional">set unique font color after link has been visited</span>', '', true);
	p2_multiple_option_box("gen_link_font_style", 'select||select...|normal|normal|italic|italic', '', 'font style', '', true);
	p2_multiple_option_box('gen_link_decoration', 'select|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '','normal appearance of link', '', true);
	p2_multiple_option_box('gen_link_hover_decoration', 'select|none|no decoration|underline|underlined|overline|overlined|line-through|line through', '','appearance of link when being hovered over', '', true);
	p2_multiple_option_box('gen_link_text_transform', 'select||select...|none|Normal|uppercase|UPPERCASE|lowercase|lowercase', '', 'text effect', 'last', true);
	echo "<a class='font-link-more-options'></a>";
}

/* prints special css for post separator area */
function p2_post_sep_css(){
	$test =  p2_option( 'post_divider_onoff', 0 );
	echo '<style type="text/css">';
	if ( $test == 'line' ) echo '.for1{display:inline;}';
	if ( $test == 'none' ) echo '.for2{display:inline;}';
	if ( $test == 'image' ) echo '.for3{display:inline;}';
	echo '</style>';
}


/* prints crappy invalid inline css for jquery to use */
function p2_suxorz( $shortname ) {
	if ( ( $shortname != 'emt_font_family' ) && ( $shortname != 'emb_font_family' ) ) return;
	if ( ( $shortname == 'emt_font_family' ) && ( p2_test( 'cattopbottom', 'bottom' ) ) ) {
		echo '<style type="text/css">.cat1 {display:none;}</style>';
	} else if ( ( $shortname == 'emb_font_family' ) && ( p2_test( 'cattopbottom', 'top' ) ) ){
		echo '<style type="text/css">.cat2 {display:none;}</style>';
	}
} // end function p2_suxorz()



/* adds extra hidden explanation (if there is one) & link to support page */
function p2_extra_explain( $name, $multi = false ) { 
	global $explain;
?>
	<div id="explain-<?php echo $name; ?>" class="extra-explain<?php if ( $multi ) echo ' extra-explain-multiple'; ?>">	
	</div>
<?php	
} // end function p2_extra_explain()



/* adds clickable "?" if there is an extra explanation */
function p2_click_for_explain( $name ) {
		echo " <a id=\"$name-cfa\" title=\"help\" class=\"click-for-explain\"></a>";
} // end function p2_click_for_explain( $name )



/* draws header options form, in all its glory */
function p2_header_options() { 
	$layout = p2_option('headerlayout',0);
	$position = array(
			'default', 0,
			'defaultc' => 1,
			'defaultr' => 2,
			'pptclassic' => 3,
			'logobelowa' => 4,
			'logobelowb' => 5,
			'logobelowal' => 6,
			'logobelowbl' => 7,
			'logobelowar' => 8,
			'logobelowbr' => 9,
			'logotopa' => 10,
			'logotopb' => 11,
			'logotopal' => 12,
			'logotopbl' => 13,
			'logotopar' => 14,
			'logotopbr' => 15,
			'nologoa' => 16,
			'nologob' => 17,
		);
	$options = array(
			'default',
			'defaultc',
			'defaultr',
			'logotopal',
			'logotopa',
			'logotopar',
			'logotopbl',
			'logotopb',
			'logotopbr',
			'logobelowal',
			'logobelowa',
			'logobelowar',
			'logobelowbl',
			'logobelowb',
			'logobelowbr',
			'nologoa',
			'nologob',
			'pptclassic',
		);
	?>
	<div id="headerlayout-option-section" class="self-clear option-section">
		 <a id="headerlayout-cfe" class="click-for-explain" tip="help"> </a>	<div class="option-section-label">
			Header Layout	</div>
		<div class="individual-option not-multiple">
			<?php p2_extra_explain('headerlayout') ?>
			<div style="display: none;" class="extra-explain" id="explain-headerlayout">
				<p style="margin-bottom: 13px;">This is the arrangement of the main portions of the blog header area: logo, masthead image(s), and navigation menu. The layout of the header area can directly affect the size of masthead image(s) that should be uploaded.  Click below to see pictures of the different options if you're having trouble visualizing the options.</p>		
				<p style="padding-top: 3px;">Still confused? <a href="http://www.prophotoblogs.com/support/header-layout/" target="_blank">Click here</a> for more help with this topic.</p>	
			</div>
			<input id="headerlayout-input" type="hidden" name="p2_input_headerlayout" value="<?php echo $layout ?>">
			<div id="headerlayout-viewer-wrapper">
				<p>Currently Selected Header Layout:</p>
				<div id="headerlayout-viewer" style="background-position:-<?php echo $left = $position[$layout] * 200; ?>px 0"></div>
			</div>
			<div id="header-thumbs" class="self-clear">
				<?php 
				for ( $i=0; $i<=17; $i++ ) {
					echo '<div id="';
					echo $options[$i];
					echo '" class="header-thumb-button self-clear';
					if ( $options[$i] == $layout ) echo ' active-thumb';
					echo'"><div style="cursor:pointer;background-position:-';
					echo $left = $position[$options[$i]] * 55;
					echo'px 0;"></div></div>';
				} 
				?>
			</div>			
		</div>
	</div>
<?php
} // end function p2_header_options()


/* calculate max recommended width for post image uploads */
function p2_upload_width( $type = 'upload' ) {
	if ( $type == 'diff' ) {
		 return p2_option( 'blog_width', 0 ) - p2_blogwidth();
	}
	$width = p2_blogwidth() - 62;
	if ( p2_test( 'inner_margin', 'zero' ) ) $width = $width + 62;
	return $width;
}

?>