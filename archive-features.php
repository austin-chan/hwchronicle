<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<?php $curmonth = curmonth(); $curyear = curyear(); ?>

<header id="snubbed-header" class="pop inner ArchiveTop features">
	<p id="small-header-lastupdated" class="uppercase">
		<?php just_tell_me($curmonth); ?> ISSUE
	</p>
	<img src="<?php bloginfo('template_directory'); ?>/images/cool/features.png" id="announce"/>
	<div id="ticker">
		<?php get_recent_tags('features'); ?>
	</div>
</header>

<!-- --------------------Check for importance posts------------------------ -->

<?php
	$poet = array();
?>
<div id="ArchiveBottom" class="inner features">
	<div class="firstbig pop">
		<div id="archive-showcase" class="showcase">
			<?php
				$query = new WP_Query(array( 'post_type' => 'features', 'features_importance' => 'section_slider', 'posts_per_page' => 4 ) );
				while($query->have_posts()) { $query->the_post();
					$wp_query->in_the_loop = true;
					$poet[] = get_the_ID();
			?>
			<div class="showcase-slide">
				<div class="showcase-content">
					<div class="showcase-content-wrapper">
						<?php
						package_thumbnail('section-slider');
						?>	
					</div>
					<div class="showcase-caption">
						<h2><?php the_full_title(); ?></h2>
						<div class="meta">
							<p class="mini gray uppercase">By <?php yo_author(); ?></p>
						</div>
						<div class="caption-excerpt sans-serif1 font10"><?php the_excerpt(); ?></div>
					</div>
				</div>
				<div class="showcase-thumbnail">
					<div class="bold font18">
						<?php the_title(); ?>
					</div>
					<div class="gray mini uppercase author">
						By <?php yo_author(); ?>
					</div>
					<div class="sans-serif1 font10">
						<?php the_excerpt(); ?>
					</div>
					<div class="showcase-thumbnail-cover"></div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="features-panel pop first">
		<?php picture_feature($curmonth); ?>
	</div>
	<div class="features-panel pop">
		<?php picture_feature($curmonth); ?>
	</div>
	<div class="panel">
		<div id="sectionvideo" class="pop">
			<h4 class="nytimes"><a href="<?php echo site_url(); ?>/video/">[ video ]</a></h4>
			<div class="colored clear">
				<div class="eins"></div>
				<div class="zwei"></div>
				<div class="drei"></div>
				<div class="vier"></div>
			</div>
			<?php section_video('features'); ?>
		</div>
		<div class="printedition pop">
			<h4 class="nytimes">Print Edition</h4>
			<?php 
				the_issue_link($curmonth);
				the_issue_image($curmonth, "thumbnail"); 
			?>
			<div class="text">
				View the 
				<div class="red">
					<?php echo first_word( get_formal_issue_month($curmonth) ); ?> Issue
				</div>
				Features Section in Archives
			</div>
			</a>
		</div>
	</div>
	<div class="ae pop">
		<h4 class="usatoday uppercase features">A&E</h4>
		<div class="annoyingbar"></div>
		<?php features_ae($curmonth); ?>
	</div>
	<div class="clear"></div>
	<div class="second pop">
		<h4 class="usatoday uppercase features">More Features</h4>
		<div class="annoyingbar"></div>
		<div class="one">
		<?php
			$query = new WP_Query(array( 'post_type' => 'features', 'issue_month' => $curmonth, 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<article>
				<div class="image1">
					<?php
					if(has_post_thumbnail()){
						the_full_title_1();
						the_post_thumbnail("thumbnail");
						echo "</a>";
					}	
					?>	
				</div>
				<div class="font24 bold">
					<?php the_full_title(); ?>
				</div>
				<div class="mini gray uppercase">
					By <?php yo_author(); ?>
				</div>
				<div class="sans-serif1 font12 justify">
					<?php the_excerpt(); ?>
				</div>
			</article>
		<?php
			}
		?>
		</div>
		<div class="two">
		<?php
			$query = new WP_Query(array( 'post_type' => 'features', 'issue_month' => $curmonth, 'posts_per_page' => 3, 'post__not_in' => $poet ) );
			while($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<article>
				<div class="font22 bold">
					<?php the_full_title(); ?>
				</div>
				<div class="mini gray uppercase">
					By <?php yo_author(); ?>
				</div>
				<div class="sans-serif1 font11 justify">
					<?php the_excerpt(); ?>
				</div>
			</article>
		<?php
			}
		?>
		</div>
	</div>


<?php
	$query = new WP_Query(array( 'post_type' => 'features', 'issue_month' => $curmonth, 'posts_per_page' => -1, 'post__not_in' => $poet ) );
	$post_count = $query->post_count;
	$end = false;
	
	for($count = 0; $count < $post_count / 4; $count++){
?>

	<div class="third pop">
		<div class="one">
			<div class="batch-one">
<?php
		if(!$end && $query->have_posts()){ $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
?>
				<article>
					<div class="font20 bold">
						<?php the_full_title(); ?>
					</div>
					<div class="uppercase mini gray">
						By <?php yo_author(); ?>
					</div>
					<div class="sans-serif1 font10">
						<?php the_excerpt(); ?>
					</div>
				</article>
<?php
		}else{
			$end = true;
		}		
		if(!$end && $query->have_posts()){ $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
?>
				<article>
					<div class="font20 bold">
						<?php the_full_title(); ?>
					</div>
					<div class="uppercase mini gray">
						By <?php yo_author(); ?>
					</div>
					<div class="sans-serif1 font10">
						<?php the_excerpt(); ?>
					</div>
				</article>
<?php
		}else{
			$end = true;
		}		
?>
			</div>
		</div>
		<div class="two">
			<div class="batch-two">
<?php
		if(!$end && $query->have_posts()){ $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
?>
				<article>
					<div class="font20 bold">
						<?php the_full_title(); ?>
					</div>
					<div class="uppercase mini gray">
						By <?php yo_author(); ?>
					</div>
					<div class="sans-serif1 font10">
						<?php the_excerpt(); ?>
					</div>
				</article>
<?php
		}else{
			$end = true;
		}		
		if(!$end && $query->have_posts()){ $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
?>
				<article>
					<div class="font20 bold">
						<?php the_full_title(); ?>
					</div>
					<div class="uppercase mini gray">
						By <?php yo_author(); ?>
					</div>
					<div class="sans-serif1 font10">
						<?php the_excerpt(); ?>
					</div>
				</article>
<?php
		}else{
			$end = true;
		}	
?>
			</div>
		</div>
	</div>
<?php
	}
?>
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive-features.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>