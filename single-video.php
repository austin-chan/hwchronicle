<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

<header class="dark-header tint">
	<a href="<?php echo home_url(); ?>/video/">
		<img src="<?php bloginfo('template_directory'); ?>/images/cool/videos.png" id="announce" class="videos single"/>
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

<div id="SingleBottom" class="video inner">
	<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 
		$wp_query->in_the_loop = true;	
	?>
		<div class="entry-content">
		
		<?php the_content(); ?>
					
		</div>	
		<div class="related-videos tint pop">
			<h4>Related Videos</h4>
			<?php get_related_videos(); ?>
		</div>
		<div class="related-articles tint pop">
			<h4>Related Articles</h4>
			<div>
				<?php get_related_posts(2); ?>
			</div>
		</div>
		<div class="clear"></div>
		<div class="video-bottom tint pop inner">
			<div class="left-part">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
			</div>
			<div class="right-part">
				<div class="meta">
					<p class="uppercase bold">Video By: <?php yo_author(); ?></p>
				</div>
				<div class="red date sans-serif2 bold font12">Posted <?php the_date('F j, Y'); ?></div>		
			</div>		
			<div class="clear"></div>
		</div>	

			<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>
</div>


	<?php endwhile; endif; ?>

<?php include 'inc/darkbackground.php'; ?>
<?php get_footer(); ?>