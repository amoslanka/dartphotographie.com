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
	 <br />
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
		<!--<div class="par" id="post-<?php //the_ID(); ?>">-->
			<div class="entry">
 				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<span class="emph"><?php the_date(); ?></span>
				<?php the_content(__('(more...)')); ?>
			<!--</div>-->
				<p class="postmetadata">
					Category: <?php the_category(', ') ?> <br />
					<?php the_tags(); ?> <br />
					<?php edit_post_link('Edit','','<br />'); ?>  
				</p>
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
