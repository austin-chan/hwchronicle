<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<header id="snubbed-header" class="pop inner ae">
	<div id="SingleTop" >
		<div class="start">
			<a href="<?php echo home_url(); ?>/features"><img src="<?php bloginfo('template_directory'); ?>/images/cool/ae.png" id="announce" class="ae"/></a>
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
				echo "<a class='fancybox' href='".wp_get_attachment_url( get_post_thumbnail_id($post->ID) )."'>";
				echo yo_post_thumbnail("single-article");
				echo "</a>";
				echo "<p class='credit'>";
				echo get_media_credit(get_post_thumbnail_id($post->ID));
				echo "</p>";
				echo "<p class='caption'>";
				the_post_thumbnail_caption();
				echo "</p>";
				echo "</div>";
			}
			
			?>
			
			<div class="meta">
				<p class="uppercase">By <?php yo_author(); ?></p>
				<p class="gray mini date"><?php the_checked_date(); ?></p>
			</div>
			
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
