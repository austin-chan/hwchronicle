<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

<div id="ChronSearch" class="inner">
	
	<div id="SearchTop" class="pop">
		<img src="<?php echo get_template_directory_uri(); ?>/images/cool/search.png" class="search"/>
		<div class="search-info">
			<h5 class="font12 normal sans-serif1">Searching the Chronicle Online database 2006-<?php echo date("Y"); ?> for articles, videos, and photos.</h5>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</div>
	</div>
	<div id="SearchResults" class="pop">


	<?php /* Search Count */ 
	$allsearch = &new WP_Query("s=$s&showposts=-1"); 
	$key = wp_specialchars($s, 1); 
	$count = $allsearch->post_count; _e(''); 

	wp_reset_query(); 
	?>
	<h2 class="results-header sans-serif2 font18">Showing <?php echo $count; ?> results for <?php echo "'".$key."'"; ?>
	
	</h2>
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); $wp_query->in_the_loop = false;
?>

			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<?php
						if(has_post_thumbnail()){
							echo '<div class="result-thumbnail">';
							the_full_title_1();
							echo the_post_thumbnail("thumbnail");
							echo '</a>';
							echo '</div>';
						}	
					?>
				<div class="result-text <?php if(has_post_thumbnail()) echo "has-thumbnail"; ?>">
					<h2><?php the_full_title(); ?></h2>
	
					<div class="meta">
						<div class="author mini uppercase gray sans-serif1 left">
						<?php
						if(get_post_type() != 'post') {
						?>
							By <?php yo_author();  ?>
						<?php
						}
						?>
						</div>
						<div class="date mini red sans-serif1 right">
							<?php the_checked_date(); ?>
						</div>
						<div class="clear"></div>
					</div>
	
					<div class="entry">
	
						<?php the_excerpt(); ?>
	
					</div>
				</div>
				<div class="clear"></div>
			</article>
			<hr class="nonflair" />

		<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/_/inc/nav.php' ); ?>

	<?php else : ?>

		<h2>No posts found.</h2>

	<?php endif; ?>
	</div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/search.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>
