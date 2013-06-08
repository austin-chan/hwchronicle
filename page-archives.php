<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<?php $curmonth = curmonth(); $curyear = curyear(); ?>

<header id="snubbed-header" class="pop ArchiveTop archives">
	<img src="<?php bloginfo('template_directory'); ?>/images/cool/archives.png" id="announce"/>
	<div id="fauxbottomborder"></div>

</header>

<!-- --------------------Check for importance posts------------------------ -->

<?php
	$current_year = get_option("current_issue_year");
	$current_month = get_option("current_issue_month");
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
	<div class="firstbig pop">
		<?php get_placard($curmonth); ?>
	</div>
	<div class="clear"></div>
	<div class="this-years-issues pop">
		<h4 class="usatoday uppercase">Print Editions <?= get_option("current_issue_year") ?></h4>
		<div class="annoyingbar"></div>
		
		
		
		
				<div class="issue-area">
			
<?php

$args = array(
	'post_type' => 'issue',
	'numberposts' => -1,
	'tax_query' => array(
		array(
			'taxonomy' => 'issues',
			'field' => 'slug',
			'terms' => $current_year // Where term_id of Term 1 is "1".
		)
	)
);
$issue_query = new WP_Query( $args );

$count = 0;
while($issue_query->have_posts()) { $issue_query->the_post();
	if($count % 4 == 0 && $count != 0){
?>
		<div class="clear"></div>
<?php
	$count++;
	the_issue_box();

}
?>
	
		</div>
	</div>
	<div class="issues-by-year pop">
		<h4 class="usatoday uppercase">View print issues by year</h4>
			<div class="annoyingbar"></div>
			<div class="issue-area">
		
		<?php 
		
		$years = get_terms( 'issues', array('exclude' => $current_year) );
		$years = array_reverse($years);
		$count = 0;
		foreach($years as $year){ // Gets a list of all the years that aren't the current year
			if($count % 4 == 0 && $count != 0){
?>
				<div class="clear"></div>
<?php
			}
			$count++;
			$year->slug;
			$args = array( 
				'post_type' => 'issue',
				'posts_per_page' => 10,
				'tax_query' => array(
					array(
						'taxonomy' => 'issues',
						'field' => 'slug',
						'terms' => $year // Where term_id of Term 1 is "1".
					),
					array(
						'taxonomy' => 'is_other_publication',
						'field' => 'slug',
						'terms' => 'yes',
						'operator' => 'NOT IN'
					)
				)
			);
			
			$year_link = '<a href="'.get_term_link($year->slug, 'issues').'">'.$year->name.'</a>';
			$year_link_1 = '<a href="'.get_term_link($year->slug, 'issues').'">';

			$issue_query = new WP_Query( $args ); // Gets a single post from each of the years
			$issue_query->the_post();
			$is_old = is_object_in_term( get_the_id(), 'is_old_issue', 'yes' );

			if( $is_old ){


		?>
			<?php echo $year_link_1; ?>
				<div class="issue-box">
					<div class="issue-month sans-serif2 bold"><?php echo $year->name; ?></div>
				<?php
					if($year->name == "2008-2009"){
						echo '<img src="'.get_template_directory_uri().'/images/2008.png" />';
					}elseif($year->name == "2009-2010"){
						echo '<img src="'.get_template_directory_uri().'/images/2009.png" />';
					}elseif($year->name == "2010-2011"){
						echo '<img src="'.get_template_directory_uri().'/images/2010.png" />';
					}elseif($year->name == "2011-2012"){
						echo '<img src="'.get_template_directory_uri().'/images/2011.png" />';
					}
				?>
				</div>
			</a>
		<?php
			}else{
		?>
			<?php echo $year_link_1; ?>
				<div class="issue-box">
					<div class="issue-month sans-serif2 bold"><?php echo $year->name; ?></div>
				<?php
					if(has_post_thumbnail(get_the_id())){
						the_post_thumbnail('medium');
					}else{
				?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/issue.png" />
				<?php
				}
				?>
				</div>
			</a>
<?php	
			}
			wp_reset_query();
		}
		
		?>
		
		</div>
	</div>
	<div class="about-archives pop">
		<h4 class="usatoday uppercase">About Archives</h4>
		<div class="annoyingbar"></div>
		<div class="leftpart sans-serif1">
			The Chronicle launched its current website in September 2012.  Online articles starting in September 2006 are available through the search function below as a well as on the old Chronicle website.  Digitized copies of our print edition are available from 2008 on the bottom left.  Send requests for articles before 2006 to chronicle@hw.com
		</div>
		<div class='rightpart'>
			<h3 class="left">Search Archives &raquo;</h3>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			<h3><a href="../about/#contact">Contact the Chronicle</a></h3>
			<h3><a href="http://students.hw.com/chronicle/News.aspx">Visit Old Site</a></h3>
		</div>
	</div>
</div>


<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>