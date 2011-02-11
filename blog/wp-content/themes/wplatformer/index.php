<?php 
get_header();
?>

<body>
  <div id="page">
      	<?php 
		get_sidebar();
		?>
	<div id="arrows">
     	<ul>
			<li id="left"><a href="javascript://" title="go left">go left</a></li>
			<li id="right"><a href="javascript://" title="go right">go right</a></li>
		</ul>	
     </div>
     <div id="bottomwrap">
     <div id="bottombar"></div>
     <div id="sidebartwo">
		<div class="menu">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Bottom Sidebar One') ) : else : ?>
					
		<?php endif; /* END FOR WIDGETS CALL */ ?>
		</div>
     </div> 
     <div id="sidebarthree">
		<div class="menu">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Bottom Sidebar Two') ) : else : ?>
					
		<?php endif; /* END FOR WIDGETS CALL */ ?>
		</div>     
     </div>
     <div id="sidebarfour">
		<div class="menu">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Bottom Sidebar Three') ) : else : ?>
					
		<?php endif; /* END FOR WIDGETS CALL */ ?>
		</div>      
     </div>
     <div id="sidebarfive">
     	<div class="menu">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Bottom Sidebar Four') ) : else : ?>
					
		<?php endif; /* END FOR WIDGETS CALL */ ?>
		</div>    
     </div>
     </div>
	<hr/>
    <div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php
						global $wpdb;
						$attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1");
						?>
		<div class="par" id="post-<?php the_ID(); ?>">
 				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<span class="emph"><?php the_date(); ?></span><br /><br />
				<?php 
				if ($attachment_id) {
				echo wp_get_attachment_image($attachment_id, 'thumbnail', true);
				}
				?>
				<?php the_excerpt(__('(more...)')); ?>
							<p class="postmetadata"><?php the_category(', ') ?> <strong>|</strong>  <?php the_tags(); ?> <strong>|</strong> <?php edit_post_link('Edit','','<strong> |</strong>'); ?>  <?php comments_popup_link('Comments', 'Comments (1)', 'Comments (%)'); ?></p>
		<p class="secbot"><a href="#mainmenu" title="go left to menu">return to menu</a></p>
		</div>
		<?php endwhile; else: ?>
		<div class="par">
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		</div>
		<?php endif; ?>
		<?php 
		get_footer();
		?>
    </div>
	</div>
  </body>
</html>
