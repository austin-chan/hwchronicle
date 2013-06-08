<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<header id="snubbed-header" class="pop ArchiveTop archives">
	<img src="<?php bloginfo('template_directory'); ?>/images/cool/archives.png" id="announce"/>
</header>

<!-- --------------------Check for importance posts------------------------ -->

<?php
	$poet = array();
	$query = new WP_Query(array( 'post_type' => 'news', 'news_importance' => 'top_news' ) );
	$count = 0;
	while($query->have_posts()) : $query->the_post();
		$poet[] = get_the_ID();
		$count++;
		if($count >= 3)
			break;
	endwhile;
	wp_reset_postdata();
	

?>
<div id="ArchiveBottom" class="inner archives">
	<div class="firstbig pop"></div>
	<div class="clear"></div>
	<div class="about-archives pop">
		<h4>About Archives</h4>
		<p class="sans-serif1 font11">The Chronicle launched its current website in September 2012.  Online articles starting in September 2006 are available through the search function below as a well as on the old Chronicle website.  Digitized copies of our print edition are available from 2008 on the bottom left.  Send requests for articles before 2006 to chronicle@hw.com</p>
		<h4>Search Archives</h4>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	<div class="this-years-issues pop">
		<h4>2012-13</h4>
	</div>
	<div class="issues-by-year pop">
		<h4 class="uppercase">View print issues by year</h4>
	</div>
</div>


<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>