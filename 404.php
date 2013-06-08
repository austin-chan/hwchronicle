<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

	<div id="fourOfour" class="inner pop">
		<div id="fourCenter">
			<a href="<?php echo site_url(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/404-logo.jpg" />
			</a>
			<div class="text">
				<h2>Page not found.</h2>
				<div class="bold sans-serif2 font20 error">Error 404<?php /* echo get_term_link('2012-13', 'issue'); */ ?></div>
				<div class=" sans-serif2 try font14">Try searching what you're looking for or return to the <a href="<?php echo site_url(); ?>">home page</a></div>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>

<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>