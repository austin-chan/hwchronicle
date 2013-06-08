<?php get_header(); ?>
<header id="snubbed-header" class="pop inner">
<?php include("inc/snubbed-nav.php"); ?>
	<div id="SingleTop" >
		<div class="start">
			<a href="<?php echo home_url(); ?>/news/"><img src="<?php bloginfo('template_directory'); ?>/images/cool/news.png" id="announce"/></a>
		</div>
		<p class="left uppercase one">Latest News Headlines</p>
		<div class="screams left">
			<div class="left scream">
				<a href="#">Largest summer program ever offers arts, athletics</a>
			</div>
			<div class="left scream">
				<a href="#">Pool arrives from Italy, construction projects on</a>
			</div>
			<div class="left scream lastone">
				<a href="#">Largest summer program ever offers arts, athletics</a>
			</div>
		</div>
	</div>
	
</header>

<div id="SingleBottom" class="inner">
	<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 
		$wp_query->in_the_loop = true;	
	?>
		

		<article class="pop" id="single-article">
		<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<?php if(has_post_thumbnail()){
				echo "<div id='feat-image'>";
				the_post_thumbnail("bigger_image");
				echo "<p>";
				the_post_thumbnail_caption();
				echo "</p>";
				echo "</div>";
			}else{
				echo "<div id='feat-image'><img src='".get_template_directory_uri()."/images/7.jpg' /></div>";
			}
			
			?>
			
			<div class="meta">
				<p class="uppercase">By <?php the_author(); ?></p>
				<p class="gray mini date"><?php the_checked_date(); ?></p>
			</div>
			
			<div class="entry-content">
				
				<?php the_content(); ?>
				
				<?php the_tags( 'Tags: ', ', ', ''); ?>
			
			</div>
			
			<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>
		
		</div>
		</article>
		<div id="related-stories" class="pop">
			<h4 class="title1">Related Stories</h4>
		</div>
		<div id="multimedia" class="pop">
			<h4>Multimedia</h4>
		</div>
		<div class="clearleft"></div>
		<div id="comments" class="pop">
			<h4 class="title1">Comments</h4>
		</div>

	<?php endwhile; endif; ?>
</div>

<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>