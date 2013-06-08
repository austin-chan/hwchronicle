<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

<header class="dark-header tint">
	<a href="<?php echo home_url(); ?>/photo/">
		<img src="<?php bloginfo('template_directory'); ?>/images/cool/photos.png" id="announce" class="photos single"/>
	</a>
<!--
	<div class="info sans-serif1 font12">
		The Chronicle provides timely coverage of Harvard-Westlake student events including athletics and performing arts as well as profiles of individuals in the school community throughout the year.
	</div>
-->
	<div class="colored clear">
		<div class="one"></div>
		<div class="two"></div>
		<div class="three"></div>
		<div class="four"></div>
	</div>
</header>

<?php 
	if (have_posts()) : while (have_posts()) : the_post(); 
	$wp_query->in_the_loop = true;	
?>
<div id="SingleTop" <?php post_class("photo inner tint pop"); ?>>
	<div class="left-side left">
		<div class="font28 title sans-serif2 bold">
			<?php the_title(); ?>
		</div>
		<div class="excerpt sans-serif2 font14">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<div class="right-side right">
		<div class="photosby uppercase font12 sans-serif2 bold">
			Photos by: <?php yo_break_author(); ?>
		</div>
		<div class="numberphotos bold font14 uppercase sans-serif2">
			<?php
				$Images = & get_children ( 'post_type=attachment&orderby=rand&post_mime_type=image&post_parent=' . get_the_ID() );
				
				echo count($Images);
				
			?> Photos
		</div>
		<div class="posted bold font15 sans-serif2">
			Posted <?php the_date('F j, Y'); ?>
		</div>
	</div>

</div>
<div id="SingleBottom" class="photo tint pop inner">

		

		<div id="<?php the_ID(); ?>" >
			

			<div class="clear"></div>
			
			<div class="entry-content">
				
				<?php the_content(); ?>
							
			</div>
			
			<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>
		
		</div>
		</article>

	<?php endwhile; endif; ?>


</div>


<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive-photos.js"></script>

<?php include 'inc/darkbackground.php'; ?>
<?php get_footer(); ?>