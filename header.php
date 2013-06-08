<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]> <![endif]-->
<!--[if IE 8 ]> <![endif]-->
<!--[if IE 9 ]> <![endif]-->
<html class="no-js" <?php language_attributes(); ?>>
<!-- the "no-js" class is for Modernizr. -->

<!--
  _   _             _____ _                     _      _      
 | | | |           / ____| |                   (_)    | |     
 | |_| |__   ___  | |    | |__  _ __ ___  _ __  _  ___| | ___ 
 | __| '_ \ / _ \ | |    | '_ \| '__/ _ \| '_ \| |/ __| |/ _ \
 | |_| | | |  __/ | |____| | | | | | (_) | | | | | (__| |  __/
  \__|_| |_|\___|  \_____|_| |_|_|  \___/|_| |_|_|\___|_|\___|
                                                              
                                                                  
                                                                  
Coded by Austin Chan '13.  

[update] Wow this is the dirtiest code I've ever seen. Worst programming practice ever.  I'm ashamed of myself haha.

Almost completely from scratch, used a completely blank Reset wordpress theme.
Brushed up my PHP for the confusing post setup, wrote A LOT of CSS, and a hint of JavaScript.
This site took FOREVER to code.  But I'm glad it's up :)

Designed by David Lim and Austin Chan.
We hope you like our site design, we spent A LOT of time on the design too, with about 5 other site design mockups.
 
After two and a half months and tens of thousands of lines of code, I'm so exhausted.

Contact me at auscwork@gmail.com for any questions or anything at all.

-->


<head profile="http://gmpg.org/xfn/11">

	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<?php if (is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (is_home()) {
		         bloginfo('name'); /* echo ' - '; bloginfo('description'); */ }
		      else {
		          bloginfo('name'); }
		      if (function_exists('is_tag') && is_tag()) {
		         echo '&quot; - '; single_tag_title("Tag Archive for &quot;"); }
		      elseif (is_archive()) {
		         echo ' - '; wp_title('');}
		      elseif (is_search()) {
		         echo ' - Search for &quot;'.wp_specialchars($s).'&quot;'; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         echo ' - '; wp_title(''); }
		      elseif (is_404()) {
		         echo ' - Not Found'; }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<meta name="title" content="<?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>">
	<?php if(is_single()){ global $post;?>
	<meta name="description" content="<?php the_excerpt(); ?>">
	<?php }elseif(is_archive()){ ?>
	<meta name="description" content="<?php wp_title(''); ?>">
	<?php }else{ ?>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<?php } ?>
	
	<meta name="google-site-verification" content="">
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
	
	<meta name="Copyright" content="Copyright Harvard-Westlake Chronicle 2012. All Rights Reserved.">

	<!-- Dublin Core Metadata : http://dublincore.org/ -->
	<meta name="DC.title" content="Harvard-Westlake Chronicle">
	<meta name="DC.subject" content="The Online version of the monthly student newspaper of Harvard-Westlake.">
	<meta name="DC.creator" content="By Austin Chan.">
	
	<?php if(is_single()){ global $post;?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
<?php
		$attach = wp_get_attachment_image_src(get_post_thumbnail_id(), 'section-slider');
?>
	<meta property="og:image" content="<?php echo ($attach ? $attach[0] : get_template_directory_uri().'/images/404-logo.jpg'); ?>" />
	<meta property="og:site_name" content="HW Chronicle" />
	<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>"/>
	<meta property="fb:app_id" content="249052195198188" />
	<?php }else{ ?>
	<meta property="og:title" content="The Harvard-Westlake Chronicle" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/404-logo.jpg" />
	<meta property="og:site_name" content="HW Chronicle" />
	<meta property="og:description" content="The award-winning student newspaper of Harvard-Westlake"/>
	<meta property="fb:app_id" content="249052195198188" />
	<?php } ?>
	
	
	<!--  Mobile Viewport meta tag
	j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag 
	device-width : Occupy full width of the screen in its current orientation
	initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
	maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width -->
	<!-- Uncomment to use; use thoughtfully!
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	-->
	
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/_/img/favicon.png">
	<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK
		 - see wikipedia for info on browser support: http://mky.be/favicon/ -->
		 
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon.png">
	<!-- The is the icon for iOS's Web Clip.
		 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4's retina display (IMHO, just go ahead and use the biggest one)
		 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
		 - Transparency is not recommended (iOS will put a black BG behind the icon) -->
	
	<!-- CSS: screen, mobile & print are all in the same file -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<!--[if IE]>
	<style>
	
	html{height:100%;}
	</style>
	
	<![endif]-->

	<script src="<?php bloginfo('template_directory'); ?>/_/js/modernizr-1.7.min.js"></script>
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	
	
<!-- 	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/lightview/lightview.css"/> -->
<link href='http://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.fancybox.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/iconfont/css/font-awesome.min.css"/>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.livequery.js"></script>	
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.flippy.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.fancybox.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.transit.min.js"></script>
<!-- 	<script src="<?php echo get_template_directory_uri(); ?>/slider/js/lightview/lightview.js"></script> -->
	<!--[if lt IE 9]>
	  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/slider/js/excanvas/excanvas.js"></script>
	<![endif]-->
<!-- 	<script src="<?php echo get_template_directory_uri(); ?>/slider/js/spinners/spinners.js"></script> -->
</head>
<body <?php body_class(); ?>>
<?php facebook_code_1(); ?>

<div id="background" class="noselect"></div>
<script>var template_directory = '<?php echo get_template_directory_uri(); ?>';</script>
<!-- Confetti shamefully stolen from http://metervara.net/ - he's a genius check him out -->

