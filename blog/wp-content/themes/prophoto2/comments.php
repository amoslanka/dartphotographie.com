<?php  



// only show comments if there is no password on post, or if password is entered correctly
if  ( ( ( empty( $post->post_password ) ) || ( $_COOKIE['wp-postpass_' . COOKIEHASH] == $post->post_password ) ) && ('open' == $post->comment_status)  && ( 'open' == get_option( 'default_comment_status' ) ) ) {
	
	// get numbers of pings and comments 
	$ping_count = $comment_count = 0;
	foreach ( $comments as $comment )
		get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;

	// pull in correct author data
	global $authordata;

/*-----------------	
 the comment header 
 ------------------*/  

?>

<div id="entry-comments-<?php the_ID(); ?>" class="entry-comments<?php 
	
	// add a class when the comments are open
	$class = '';
	$active = ' comments-count-active';
	// single page and there are comments = active
	if ( is_single() && ( ( $comment_count + $ping_count ) > 0 ) ) $class = $active;
	// home page and option is open = active, and there are comments
	if ( ( is_home() ) && ( p2_option( 'commentsopenclosed', 0 ) == 'open' ) && ( ( $comment_count + $ping_count ) > 0 ) ) $class = $active;
	// if its an archive-ish page and comments are included...
	if ( ( ( is_archive() ) || ( is_tag() )  || ( is_search() ) || ( is_author() ) || ( is_category() ) ) && ( p2_option( 'archive_comments_showhide', 0 ) == 'show' ) ) {
		// ... show only if there are comments
		if ( ( $comment_count + $ping_count ) > 0 ) $class = $active;
	}
	// whew, spit out the class, empty or not
	echo $class; 
	
	 ?>">
	
	<div class="comments-header self-clear">
		
		<?php // for boxy layout, we add an extra inner div
		if ( p2_option( 'commentslayout', 0 ) == 'boxy') echo "<div class=\"comments-header-inner\">\n\t\t<div class=\"comments-header-inner-inner\">\n"; ?>
			
		<p class="postedby"><?php p2_option( 'translate_by' ); echo ' <a class="url fn n" href="'. get_author_posts_url( $authordata->ID, $authordata->user_nicename ) .'" title="View all posts by ' . $authordata->display_name . '">' . get_the_author() . '</a>'; ?></p>
		
		<div class="comments-count" id="comments-count-<?php the_ID(); ?>" <?php 
		
		

		
		
		
		// change the cursor pointer and color of link based on layout and presence of comments
		if ( ( $comment_count + $ping_count ) > 0  ) echo ' style="cursor:pointer;"';
		
		 ?>><div>
				
				<p<?php
				// add a class for minima when no comments
				if ( p2_test( 'commentslayout', 'minima' ) &&  ( $comment_count + $ping_count ) == 0  ) echo ' class="no-comments"';
							
				?>><?php 
				
		// handle comments show/hide links area
		// for minimalist layout, add show/hide text changed with jquery
		if ( ( p2_option( 'commentslayout', 0 ) == 'minima' ) && ( ( $comment_count + $ping_count ) > 0 ) ) {
			echo '<span class="show-text">' . p2_option( 'comments_minima_show_text', 0 ) . ' </span>';
			echo '<span class="hide-text">' . p2_option( 'comments_minima_hide_text', 0 ) . ' </span>';
		}
		
		// insert number of comments
		comments_number( p2_translate('no', false ),'1','%' ); 
		echo " ";
		if ( ( $comment_count + $ping_count ) != 1 ) {
			p2_translate('comments');
		} else {
			p2_translate('comment');
		}?></p>
		
		</div>
		
		</div><!-- .comments-count -->
		
		<p class="post-interact">
			
			<?php // "add a comment" link
			// don't show it if we're on a single or page
			if ( ( !is_single() ) && ( !is_page() ) ) { ?><span class="addacomment post-interact-span"><a href="<?php the_permalink(); ?>#addcomment"><?php p2_option( 'comments_addacomment_text' ); ?></a></span><?php } ?>
			
			<?php if ( p2_test( 'comments_linktothispost', 'yes' ) ) { ?><span class="linktothispost post-interact-span"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title(); ?>"><?php p2_option( 'comments_linktothispost_text' ); ?></a></span><?php } ?>
			
			<?php if ( p2_test( 'comments_emailafriend', 'yes' ) ) { ?><span class="emailafriend post-interact-span"><a href="mailto:?subject=<?php echo p2_sanitize_for_email( p2_option( 'comments_emailafriend_subject', 0 ) ); ?>&amp;body=<?php echo p2_sanitize_for_email( p2_option( 'emailfriendbody', 0 ) )?>%20<?php echo p2_sanitize_for_email( apply_filters('the_permalink', get_permalink() ) ); ?>"><?php p2_option( 'comments_emailafriend_text' ); ?></a></span><?php } ?>
			
		</p> <!-- .post-interact -->
		
		<?php // close the extra div for the boxy layout
		if ( p2_option( 'commentslayout', 0 ) == 'boxy' ) { echo "</div>\n\t\t</div>\n" ;} ?>
		
	</div>  <!-- .comments-header -->
	
<?php

/*---------------	
 the comment body 
 ----------------*/

?>	
	<div id="comments-body-<?php the_ID(); ?>" class="comments-body"<?php 
	
	
	/* figure out if the comments should be shown by default or not
	   add "display:none" if hidden */
	
	$show = ''; $hide = ' style="display:none;"';
	// show em on the single pages
	if ( is_single() ) :
		$showhide = $show;
	// on home pages or pages with comments enabled
	elseif ( is_home() || is_page() ) :
		// boxy layout? always shown then
		if ( p2_option( 'commentslayout', 0 ) == 'boxy' ) : $showhide = $show;
		// not boxy? but option set to open, show em
		elseif ( p2_option( 'commentsopenclosed', 0 ) == 'open' ) : $showhide = $show;
		// not boxy, and not set to be open, hide 'em
		else : $showhide = $hide;
		endif;
	// on archive, search, or tag pages...
	elseif ( ( is_archive() ) || ( is_search() ) || ( is_tag() ) ) :
		// boxy layout? show em
		if ( p2_option( 'commentslayout', 0 ) == 'boxy' ) : $showhide = $show;
		// not boxy, but option set to open, show em
		elseif ( p2_option( 'archive_comments_showhide', 0 )  == 'show' ) : $showhide = $show;
		// not boxy, and not set to open, hide em,
		else: $showhide = $hide;
		endif;
	
	// what is this? a fallback?	
	else: $showhide = $hide;
	endif;
	
	// oh yeah, if no comments, hide it
	if ( ( $comment_count + $ping_count ) == 0 )  $showhide = $hide;
	
	// echo it out, dog
	echo $showhide; ?>>
	
		<?php if ( $comment_count || $ping_count ) : // do we have comments or chinese ducks?  ?>
		<?php $sandbox_comment_alt = 0 ?>
			
			<div class="comments-body-inner">
			
				<?php if ( $comment_count ) :  /* normal comments below */ ?>
				<?php 
				// sort newest comment on top, if specified
				if ( p2_test( 'reverse_comments' ) ) $comments = array_reverse( $comments );
				foreach ( $comments as $comment ) : ?>
				<?php if ( get_comment_type() == "comment" ) : ?>		
	
				<p id="comment-<?php comment_ID(); ?>" class="<?php sandbox_comment_class(); ?>">
				<?php 
				
				// set up the comment time stamp in a variable
				$commenttimestamp = '<span class="comment-time">' . get_comment_date() . ' - ' . get_comment_time() . '</span>'; 
				
				// timestamp on the right?  right this way...
				if ( p2_option( 'commenttime', 0 ) == 'right' ) echo $commenttimestamp; ?>		
				
				<span class="comment-author"><?php p2_comment_author_link(); ?></span> - <?php 
				
					
				// print the comments (without adding pee, and subtracting any stored pee)
				echo str_replace(array('<p>', '</p>', '<P>', '</P>'), '', get_comment_text() ); 
				
				
				// unapproved comment, awaiting moderation
				if ( $comment->comment_approved == '0' ) {
					echo '<span class="unapproved"> &nbsp;';
					p2_option( 'comments_moderation_text' );
					echo '</span>';
				}
				
				// timestamp left-aligned
				if ( p2_option( 'commenttime', 0 ) == 'left' ) echo $commenttimestamp; ?></p>
	
				<?php endif; // if ( get_comment_type() == "comment" ) ?>
				<?php endforeach; // ( $comments as $comment ) ?>
				<?php endif; // if ( $comment_count ) ?>
				
				<?php if ( $ping_count ) : /* pingbacks below */ ?>
				<?php 
				// sort newest comment on top, if specified
				if ( p2_test( 'reverse_comments' ) ) $comments = array_reverse( $comments );
				foreach ( $comments as $comment ) : ?>
				<?php if ( get_comment_type() != "comment" ) : ?>
					
				<p id="comment-<?php comment_ID(); ?>" class="comment <?php sandbox_comment_class(); ?>">
				<?php 

				// set up the comment time stamp in a variable
				$commenttimestamp = '<span class="comment-time">' . get_comment_date() . ' - ' . get_comment_time() . '</span>'; 

				// timestamp on the right?  right this way...
				if ( p2_option( 'commenttime', 0 ) == 'right' ) echo $commenttimestamp; ?>		

				<span class="comment-author"><?php p2_comment_author_link(); ?> - </span><?php 

				// print the comments (without adding pee, and subtracting any stored pee)
				echo str_replace(array('<p>', '</p>', '<P>', '</P>'), '', get_comment_text() );
				
				
				// unapproved comment, awaiting moderation
				if ( $comment->comment_approved == '0' ) {
					echo '<span class="unapproved"> &nbsp;';
					p2_option( 'comments_moderation_text' );
					echo '</span>';
				}

				// timestamp left-aligned
				if ( p2_option( 'commenttime', 0 ) == 'left' ) echo $commenttimestamp; ?></p>
				
				<?php endif; // if ( get_comment_type() != "comment" ) ?>
				<?php endforeach; // ( $comments as $comment ) ?>
				<?php endif; // if ( $ping_count ) ?>
				
			</div> <!-- .comments-body-inner -->

		<?php endif; // if ( $comment_count || $ping_count )  ?>

	</div><!-- .comments-body -->

</div><!-- .entry-comments -->

<?php $sandbox_comment_alt = 0 ?>

<?php 

/*---------------	
 the comment form 
 ----------------*/

// if appropriate, display the add comment form 
if ( ( is_single() ) || ( is_page() ) ) {  ?>

<div class="formcontainer" id="addcomment">	
	
	<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

	<?php if ( $user_ID ) : // someone is logged in, no need to put in name and stuff ?>
		
		<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'P2'),
			get_option('siteurl') . '/wp-admin/profile.php',
			wp_specialchars($user_identity, true),
			wp_logout_url( get_permalink() ) ) ?></p>

		<?php else : // not logged in ?>

		<p id="comment-notes"><?php p2_translate( 'commentform_message' ) ?> <?php if ($req) { p2_translate('comments_required'); ?> <span class="required">*</span><?php } ?></p>

		<div class="form-label"><p><label for="author"><?php p2_translate('comments_name') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></p></div>
		
		<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="40" maxlength="60" tabindex="3" /></div>

		<div class="form-label"><p><label for="email"><?php p2_translate('comments_email') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></p></div>
		
		<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="40" maxlength="60" tabindex="4" /></div>

		<div class="form-label"><p><label for="url"><?php p2_translate('comments_website') ?></label></p></div>
		
		<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="40" maxlength="60" tabindex="5" /></div>

		<?php endif; // if ( $user_ID ) ?>

		<div class="form-label"><p><label for="comment"><?php p2_translate('comments_comment') ?></label></p></div>
		
		<div class="form-textarea"><textarea id="comment" name="comment" cols="65" rows="12" tabindex="6"></textarea></div>

		<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php p2_translate('comments_button') ?>" tabindex="7" accesskey="P" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>

		<?php do_action('comment_form', $post->ID); ?>

	</form><!-- #commentform -->
	
</div><!-- .formcontainer -->

<?php } // if ( ( is_single() ) || ( is_page() ) ) 
} // end if  ( ( empty($post->post_password) ) ... 
?>