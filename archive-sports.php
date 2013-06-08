<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<?php $curmonth = curmonth(); $curyear = curyear(); ?>

<header id="snubbed-header" class="pop inner ArchiveTop sports">
	<p id="small-header-lastupdated" class="gray uppercase">
		Last updated: 
		<span class="red">
			<?php last_updated(); ?>
		</span>
	</p>
	<img src="<?php bloginfo('template_directory'); ?>/images/cool/sports.png" id="announce" class="sports"/>
	<div id="ticker" class="lowercase">
		<?php get_recent_tags('sports'); ?>
	</div>

</header>

<!-- --------------------Check for importance posts------------------------ -->

<?php
	$poet = array();
	
	
		$query = new WP_Query(array( 'sports_importance' => 'featured_issue_article', 'issue_month' => $curmonth, 'posts_per_page' => '4') );
		while($query->have_posts()) : $query->the_post();
		$poet[] = get_the_ID();
		endwhile;
		wp_reset_postdata();
	
	
?>
<div id="ArchiveBottom" class="inner sports">
	<div class="firstbig pop">
		<div id="archive-showcase" class="showcase">
			<?php
				$query = new WP_Query(array( 'post_type' => 'sports', 'sports_importance' => 'section_slider', 'posts_per_page' => 4 ) );
				$count = 0;
				while($query->have_posts()) : $query->the_post();
					$wp_query->in_the_loop = true;

			?>
			<div class="showcase-slide">
				<div class="showcase-content">
					<div class="showcase-content-wrapper">
						<?php the_full_title_1(); ?>
						<?php
						
						if(has_post_thumbnail()){
							the_post_thumbnail("section-slider");
						}	
						?>
						</a>
					</div>
					<div <?php post_class("showcase-caption"); ?>>
						<h2><?php the_full_title(); ?></h2>
						<div class="meta">
							<p class="mini gray uppercase">By <?php yo_author(); ?></p>
						</div>
						<div class="caption-excerpt sans-serif1 font10"><?php the_excerpt(); ?></div>
					</div>
				</div>
				<div class="showcase-thumbnail">
					<?php
						if(has_post_thumbnail()){
							the_post_thumbnail("thumbnail");
						}
					?>
					<div class="first-tag uppercase sans-serif1 bold font12"><?php echo get_post_meta(get_the_ID(), 'special_label', true); ?></div>
					<div class="showcase-thumbnail-cover"></div>
				</div>

			</div>
			<?php

				endwhile;
				wp_reset_postdata();
			?>
		</div>
	</div>
	<div id="updates" class="pop">
			<h4 class="nytimes">Latest Sports Updates</h4>
			<?php
				$query = new WP_Query(array( 'post_type' => 'sports', 'posts_per_page' => 6, 'post__not_in' => $poet  ) );
				while($query->have_posts()) : $query->the_post();
					$poet[] = get_the_id();
					$wp_query->in_the_loop = true;
			?>
		<article>
			<div class="details">
				<p class="mini left gray uppercase"><?php echo first_tax_value(get_the_terms($post->ID, 'sports_type')); ?></p>
				<p class="mini right red"><?php the_checked_date(); ?></p>
				<div class="clear"></div>
			</div>
			<p class="content-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
		</article>
			<?php
				endwhile;
				wp_reset_postdata();
			?>
	</div>
	<div id="topnews" class="pop">
		<h4 class="usatoday uppercase sports">Top Sports</h4>
		<div class="annoyingbar"></div>
		<div class="blank-bar"></div>
		<?php
			$count = 0;
			$query = new WP_Query(array( 'post_type' => 'sports', 'sports_importance' => 'top_sports', 'posts_per_page' => '3' ) );
			while($query->have_posts()) : $query->the_post();
				$wp_query->in_the_loop = true;
		?>
		<article id="<?php the_ID(); ?>" <?php post_class(); ?>>
			<p class="title1"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
			<p class="left gray uppercase mini by">By <?php yo_author(); ?></p>
			<p class="right red mini by"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<div class="entry-summary sans-serif1 small-excerpt"><?php the_excerpt(); ?></div>
		</article>
		<?php
			if($count < 2){
				$count++;
				echo '<hr class="nonflair" />';
			}
			endwhile;
			wp_reset_postdata();
		?>
	</div>
	<div id="indepth" class="pop">
		<h4 class="title3 uppercase">Sports | <span class="red"><?php the_issue_link($curmonth); just_tell_me($curmonth); ?></a></span></h4>
		<div id="indepth-showcase" class="showcase">
	<?php
		$query = new WP_Query(array( 'sports_importance' => 'featured_issue_article', 'issue_month' => $curmonth, 'posts_per_page' => '4') );
		while($query->have_posts()) : $query->the_post();
		$wp_query->in_the_loop = false;
		$poet[] = get_the_ID();
		
	?>
			<div class="showcase-slide">
				<div class="showcase-content">
					<div <?php post_class('showcase-content-wrapper'); ?>>
						<p class="title bold font18">
							<?php the_full_title(); ?>
						</p>
						<p class="mini gray uppercase">
							By <?php yo_author(); ?>
						</p>
						<div class="content sans-serif1 ex">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</div>
			</div>
	<?php
		endwhile;
		wp_reset_postdata();
	?>
		</div>

	</div>
<!-- 	VIDEO -->
	<div id="sectionvideo" class="pop">
		<h4 class="nytimes"><a href="<?php echo site_url(); ?>/video/">[ video ]</a></h4>
		<div class="colored clear">
			<div class="eins"></div>
			<div class="zwei"></div>
			<div class="drei"></div>
			<div class="vier"></div>
		</div>
		<?php
			section_video('sports');		
		?>
	</div>
<!-- 	Q&A -->
	<div id="offbeat" class="pop">
		<h4 class="nytimes">Q&A</h4>
		<?php
			offbeat('sports', 'sports_type', 'qa');
		?>
	</div>
	<div class="sports-box first pop">
		<h4 class="usatoday uppercase sports">Football</h4>
		<div class="annoyingbar"></div>
		<div class="blank-bar"></div>
		<?php sports_box('football'); ?>
	</div>
	<div class="sports-box pop">
		<h4 class="usatoday uppercase sports">Field Hockey</h4>
		<div class="annoyingbar"></div>
		<div class="blank-bar"></div>
		<?php sports_box('field_hockey'); ?>
	</div>
	<div class="sports-box wide pop">
		<h4 class="usatoday uppercase sports">More Sports</h4>
		<div class="annoyingbar"></div>
		<div class="blank-bar"></div>
		<?php
			more_sports();
		?>
	</div>
	<div class="clear"></div>
	<div class="sports-box first pop">
		<h4 class="usatoday uppercase sports">Cross Country</h4>
		<div class="annoyingbar"></div>
		<div class="blank-bar"></div>
		<?php sports_box('cross_country'); ?>
	</div>
	<div class="sports-box">
		<div class="sports-box first short pop">
			<h4 class="usatoday uppercase sports">Girls Volleyball</h4>
			<div class="annoyingbar"></div>
			<div class="blank-bar"></div>
			<?php sports_box_short('girls_volleyball'); ?>	
		</div>
		<div class="sports-box short pop">
			<h4 class="usatoday uppercase sports">Girls Golf</h4>
			<div class="annoyingbar"></div>
			<div class="blank-bar"></div>
			<?php sports_box_short('girls_golf'); ?>	
		</div>
	</div>
	<div class="sports-box">
		<div class="sports-box first short pop">
			<h4 class="usatoday uppercase sports">Boys Water Polo</h4>
			<div class="annoyingbar"></div>
			<div class="blank-bar"></div>
			<?php sports_box_short('boys_water_polo'); ?>	
		</div>
		<div class="sports-box short pop">
			<h4 class="usatoday uppercase sports">Girls Tennis</h4>
			<div class="annoyingbar"></div>
			<div class="blank-bar"></div>
			<?php sports_box_short('girls_tennis'); ?>	
		</div>
	</div>
	<div class="sports-box contact pop">
		<h4>Sports Section</h4>
		<div class="first">
			<img class="logo" src="<?php echo get_template_directory_uri(); ?>/images/404-logo.jpg"  />
<!--
			<div class="text">
				<h5 class="sans-serif1">Sports Editors</h5>
				<div class="tres sans-serif1">
					<p>Michael Aronson '13</p>
					<p>Luke Holthouse '13</p>
				</div>
			</div>
			<div class="clear"></div>
			<div class="text2 sans-serif1">
				<h5 class="sans-serif1">Managing Editors</h5>
				<div class="tres sans-serif1">
					<p>Aaron Lyons '13</p>
					<p>Keane Muraoka-Robertson '13</p>
				</div>
				<a class="bold" href="">See all Sports Staff >></a>
			</div>
-->
			<div class="clear"></div>
			<div class="text3 sans-serif1">
				<p>
					Chronicle Sports aims to provide clear and consistent coverage of Harvard-Westlake athletic teams.
				</p>
			</div>
		</div>
		<hr class="nonflair" />
		<div class="second">
			<a class="bold font12 uppercase sans-serif2 link" href="">Contact Us</a>
		</div>
		<div class="second">
		<?php twitter_code_2(); ?>
		</div>
	</div>
	<div class="clear">
	
	</div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>