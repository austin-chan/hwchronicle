<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<header id="snubbed-header" class="pop inner">
	<p id="small-header-lastupdated2" class="gray uppercase">
		Last updated: 
		<span class="red">
			<?php last_updated(); ?>
		</span>
	</p>
	<div id="SingleTop" class="archives">
		<div class="start">
			<a href="<?php echo home_url(); ?>/news/"><img src="<?php bloginfo('template_directory'); ?>/images/cool/archives.png" id="announce"/></a>
		</div>
		<div class="archive-info">
			<h5 class="font16 bold">The Chronicle Online Archives 2006-2012</h5>
			<p class="sans-serif1 font11">The current site at hwchronicle.com was launched in September 2012.  Articles form the old website dating to 2006 are stored in the Archives section of the website.</p>
		</div>
	</div>
</header>
<div id="SingleBottom" class="inner archives">
	<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 
		$wp_query->in_the_loop = true;	
	?>
		

		<article class="pop" id="single-article">
		<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<?php if(has_post_thumbnail()){
				echo "<div id='feat-image'>";
				echo yo_post_thumbnail("single-article");
				echo "<p>";
				the_post_thumbnail_caption();
				echo "</p>";
				echo "</div>";
			}
			
			?>
			
			<div class="meta left">
				<p class="gray mini date"><?php the_checked_date(); ?></p>
			</div>
			<div class="buttons right">
				<?php facebook_code_3(); ?>				
				<?php twitter_code_1(); ?>
			</div>
			<div class="clear"></div>
			<div class="entry-content">
				
				<?php the_content(); ?>
							
			</div>
			
			<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>
		
		</div>
		</article>
		<div id="related-stories" class="pop">
			<h4 class="title1">Related Stories</h4>
			<?php get_related_posts(); ?>
		</div>
		<div class="clearleft"></div>
		<div id="comments" class="pop">
			<h4 class="title1">Comments</h4>
			<?php facebook_code_2(); ?>
		</div>

	<?php endwhile; endif; ?>
</div>


<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>