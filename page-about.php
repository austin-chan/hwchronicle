<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

<div id="about-overlay">
</div>
<img src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif" id="loading" />

<header id="snubbed-header" class="pop inner about">





	<div id="SingleTop" >
		<div class="start">
			<a class="loader about" href="#about"><img src="<?php bloginfo('template_directory'); ?>/images/cool/about.png" class="about announce"/></a>
		</div>
		<div class="start">
			<a class="loader staff" href="#staff"><img src="<?php bloginfo('template_directory'); ?>/images/cool/staff.png" class="about announce"/></a>
		</div>
		<div class="start">
			<a class="loader contact" href="#contact"><img src="<?php bloginfo('template_directory'); ?>/images/cool/contact.png" class="about announce"/></a>
		</div>
		<div class="start last">
			<a class="loader website" href="#website"><img src="<?php bloginfo('template_directory'); ?>/images/cool/website.png" class="about announce"/></a>
		</div>
</header>

<div id="sandbox" class="inner">

</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/about.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>