<?php
// Load config file
if (file_exists(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php')) {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php'); // WP 2.6+
} else {
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-config.php'); // WP 2.5
}
?>
	<div>
		<h2><?php p2_option( 'contact_header' ); ?></h2>
		<?php echo wpautop( p2_option( 'contact_text',0 ) ); ?>
	</div>
	<form id="contactform" action='<?php bloginfo( 'template_directory' ) ?>/includes/contactform.php' method='post'>
		<?php if ( p2_option( 'contactform_yourinformation_text', 0 ) ); { ?><h2><?php p2_option( 'contactform_yourinformation_text' )?></h2><?php } ?>
		<?php // this "firstname" field is an invisible field to foil spambots
		      // if they fill it out, we know they are spammers, or someone handicapped :) ?>
		<p class="firstname">
			<label for="firstname">First name (required)</label>
		</p>
		<input id="firstname" size="35" name="firstname" type="text" class="firstname" />	
		<p>
			<label for="lastname"><?php p2_option( 'contactform_name_text' )?> <span class="required"><?php p2_option( 'contactform_required_text' ); ?></span></label>
		</p>
		<input id="lastname" size="35" name="lastname" type="text" />
		<p>
			<label for="email"><?php p2_option( 'contactform_email_text' )?> <span class="required"><?php p2_option( 'contactform_required_text' ); ?></span></label>
		</p>
		<input id="email" size="35" name="email" type="text" />
		<?php // if custom field specified, add it into the form
		if ( p2_option( 'contact_customfield_label', 0 ) ) { ?><p><label for="custom-field"><?php p2_option( 'contact_customfield_label' ); if ( ( p2_option( 'contact_customfield_required', 0 ) ) == 'yes' ) { ?> <span class="required"><?php p2_option( 'contactform_required_text' )?></span><?php } ?></label></p>
		<input id="custom-field" size="35" name="custom-field" type="text"  />
		<?php } // end custom field area ?>
		<?php // if custom field 2 specified, add it into the form
		if ( p2_option( 'contact_customfield2_label', 0 ) ) { ?><p><label for="custom-field2"><?php p2_option( 'contact_customfield2_label' ); if ( ( p2_option( 'contact_customfield2_required', 0 ) ) == 'yes' ) { ?> <span class="required"><?php p2_option( 'contactform_required_text' )?></span><?php } ?></label></p>
		<input id="custom-field2" size="35" name="custom-field2" type="text"  />
		<?php } // end custom field area ?>
		<?php // if custom field 3 specified, add it into the form
		if ( p2_option( 'contact_customfield3_label', 0 ) ) { ?><p><label for="custom-field3"><?php p2_option( 'contact_customfield3_label' ); if ( ( p2_option( 'contact_customfield3_required', 0 ) ) == 'yes' ) { ?> <span class="required"><?php p2_option( 'contactform_required_text' )?></span><?php } ?></label></p>
		<input id="custom-field3" size="35" name="custom-field3" type="text"  />
		<?php } // end custom field area ?>
		<?php // if custom field 4 specified, add it into the form
		if ( p2_option( 'contact_customfield4_label', 0 ) ) { ?><p><label for="custom-field4"><?php p2_option( 'contact_customfield4_label' ); if ( ( p2_option( 'contact_customfield4_required', 0 ) ) == 'yes' ) { ?> <span class="required"><?php p2_option( 'contactform_required_text' )?></span><?php } ?></label></p>
		<input id="custom-field4" size="35" name="custom-field4" type="text"  />
		<?php } // end custom field area ?>
		<?php if ( p2_test( 'contactform_antispam_enable', 'on' ) ) { $tmp = rand( 1,3 ); // pick one of the three anti-spam Q/A pairs ?>
		<p><label for="anti-spam"><?php p2_option('anti_spam_question_' . $tmp); ?> <span class="required"><?php p2_option( 'anti_spam_explanation' ); ?></span></label></p>
		 <input id="anti-spam" size="35" name="anti-spam" type="text"  /><?php } ?> 
		<?php if ( p2_option('contactform_yourmessage_text', 0 ) ) { ?><h2><?php p2_option('contactform_yourmessage_text')?></h2><?php } ?>
		<p>
			<label for="message"><?php p2_option('contactform_message_text')?> <span class="required"><?php p2_option('contactform_required_text'); ?></span></label><br />
			<textarea id="message" name="message" rows="10" style="width:95%"></textarea>
		</p>
		<input type="hidden" id="referpage" name="referpage" value="<?php echo bloginfo('url'); ?>" />
		<input type="hidden" name="spam_question" value="<?php echo $tmp; ?>" />
		<input type='submit' name='submit' value='<?php p2_option('contactform_submit_text'); ?>' />
		<?php wp_nonce_field('p2-contactform'); ?>
	</form>
