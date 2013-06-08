<?php 
/*
	session_start();
	if( !isset($_SESSION['blah']) || empty($_SESSION['blah'] ) ){
		$_SESSION['blah'] = '1';
		header("Location: ".site_url()."/launch/");
	}
*/

	$poet = array();
	$current_month = get_option("current_issue_month");
?>

<?php get_header(); ?>
<?php include ("inc/big-nav.php"); ?>
<?php $curmonth = curmonth(); $curyear = curyear(); ?>
</div>
<div id="ChronTop" class=" inner">
<div class="card">
<div class="frontface">
	<div id="ChronTopLeft">
		<?php
			$query = new WP_Query(array( 'front' => 'top1', 'posts_per_page' => '1') );
			while($query->have_posts()) : $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
		<article id="top1" class="expandable">
			<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	
				<div class="details">
					<p class="left mini gray uppercase">BY <?php yo_break_author(); ?></p>
					<p class="right mini red"><?php the_checked_date(); ?></p>
					<div class="clear"></div>
				</div>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</article>
		<?php
			endwhile;
			wp_reset_postdata();
		?>
		<hr>
		<?php
			$query = new WP_Query(array( 'front' => 'top2' ) );
			while($query->have_posts()) : $query->the_post();
			$wp_query->in_the_loop = true;
			if(!in_array(get_the_ID(), $poet)){
				$poet[] = get_the_ID();
		?>
		<article id="top2" class="expandable">
			<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	
				<div class="details">
					<p class="left mini gray uppercase">BY <?php yo_break_author(); ?></p>
					<p class="right mini red"><?php the_checked_date(); ?></p>
					<div class="clear"></div>
				</div>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</article>
		<?php
				break;
			}
			endwhile;
			wp_reset_postdata();
		?>
		<hr>
		<?php
			$query = new WP_Query(array( 'front' => 'top' ) );
			$count = 0;
			while($query->have_posts()) : $query->the_post();
				$wp_query->in_the_loop = true;
				if(!in_array(get_the_ID(), $poet)){
					$poet[] = get_the_ID();
		?>
		<article class="top3">
			<div id="<?php the_ID(); ?>" <?php post_class(); ?>> 
				<div class="details2">
					<p class="left mini gray uppercase"><?php echo get_post_type($post); ?></p>
					<p class="right mini red"><?php the_checked_date(); ?></p>
					<div class="clear"></div>
				</div>
				<h5><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
			</div>
		</article>
		<?php
					$count++;
					if($count >= 3)
						break;
				}
			endwhile;
			wp_reset_postdata();
		?>
	</div>
	<?php
		$query = new WP_Query(array( 'front' => 'center', 'posts_per_page' => '1') );
		while($query->have_posts()) : $query->the_post();
		$wp_query->in_the_loop = true;
		$poet[] = get_the_ID();
		if(!(get_post_type($post->ID) == "video")){
		
	?>
	<div id="ChronTopCenter">
			<?php
				if(has_post_thumbnail()){
?>
					<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>" class="image-link">

<?php
					the_post_thumbnail("section-slider");
?>
					</a>
<?php
				}
			?>
		<div class="details">
		<div <?php post_class(); ?>>
			<h2>
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</h2>
			<p class="gray author mini uppercase">
				By <?php yo_author(); ?>
			</p>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		</div>
		</div>		
	</div>
	<?php
		}else{
	?>
	<script>
		window.centerIsVideo = true;
	</script>
	<div id="ChronTopCenter">
		<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>">
			<div id="video">
			<?php
				echo apply_filters('the_content', get_the_content());
			?>
			</div>
		</a>
		<div class="details">
		<div <?php post_class(); ?>>
			<h2>
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</h2>
			<p class="gray mini uppercase">
				By <?php yo_author(); ?>
			</p>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		</div>
		</div>		
	</div>
	<?php
		}
		endwhile;
		wp_reset_postdata();
	?>
	<div id="ChronTopRight">
	<div class="fb-like-box" data-href="http://www.facebook.com/thehwchronicle" data-width="240" data-height="290" data-show-faces="true" data-stream="false" data-header="false"></div>
		<div class="fb-like-box-filler"></div>
<!--
		<h4 class="uppercase">Subscribe To Weekly Newsletters</h4>
		<input type="text" placeholder="Submit email here" />
-->
		<div class="twitter-button">
			<?php twitter_code_3(); ?>
		</div>
		<div class="launch-box">
			<img src="<?php echo get_template_directory_uri(); ?>/images/launch.png" />
			<div class="text">
				<a href="<?php echo site_url(); ?>/launch" ?>
				watch our welcome video
				</a>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="backface">
	<?php get_placard( get_option('current_issue_month') ); ?>

</div>
</div>
</div>

<div id="ChronBottom" class="inner">
	<div id="ChronBottomInDepth" class="pop">
		<div id="showcase" class="showcase">
	<?php
		$query = new WP_Query(array( 'front' => 'featured_issue_article', 'issue_month' => $curmonth, 'posts_per_page' => '4') );
		while($query->have_posts()) : $query->the_post();
		$poet[] = get_the_ID();
		if(!(get_post_type($post->ID) == "video")){
		
	?>
			<div class="showcase-slide">
				<div class="showcase-content">
					<div <?php post_class('showcase-content-wrapper'); ?>>
						<h4 class="title3 uppercase">
							<?php echo get_post_type(get_the_ID()); ?> | <span class="red"><?php just_tell_me($curmonth); ?> Issue</span>
						</h4>
						<p class="title">
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
		}
		endwhile;
		wp_reset_postdata();
	?>
		</div>
	</div>
	<div id="ChronBottomMultimedia" class="pop tint">
		<h4><span class="first">Multimedia</span><span class="second"><a href="<?php echo site_url(); ?>/video/">[ video ]</a> + <a href="<?php echo site_url(); ?>/photo/">[ photo ]</a></span></h4>
		<div class="colored clear">
			<div class="one"></div>
			<div class="two"></div>
			<div class="three"></div>
			<div class="four"></div>
		</div>
	<?php
		$query = new WP_Query(array( 'post_type' => array('photo','video'), 'posts_per_page' => '6') );
		while($query->have_posts()) : $query->the_post();
		$poet[] = get_the_ID();
		if((get_post_type($post->ID) == "photo")){
	?>
		<article>
			<?php the_full_title_1() ?>
			<?php the_post_thumbnail('thumbnail'); ?>
			</a>
			<div class="clear"></div>
			<p class="left gray mini uppercase">Photo</p>
			<p class="right red mini"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<p class="title3 sans-serif2"><?php the_full_title(); ?></p>
		</article>	
	<?php
		}else{
	?>
		<article>
			<?php the_full_title_1() ?>
			<img id="overlay" src="<?php echo get_template_directory_uri(); ?>/images/playbutton.png" height="102" width="152">
			<img src="<?php if(has_post_thumbnail()){$src = wp_get_attachment_image_src(get_post_thumbnail_id());echo $src[0];}else{video_thumbnail();} ?>" height="102"/>
			</a>
			<div class="clear"></div>
			<p class="left gray mini uppercase">Video</p>
			<p class="right red mini"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<p class="title3 sans-serif2"><?php the_full_title(); ?></p>
		</article>	
	<?php	
		}
		endwhile;
	?>
	</div>
	<div id="ChronBottomNews" class="pop">
		<h4 class="usatoday news"><a href="<?php echo site_url(); ?>/news/" class="section-link">News</a></h4>
		<div class="annoyingbar"></div>
		<article <?php post_class('first-article'); ?>>
			<!-- LOOP ===== Get first news post with a thumbnail yo. -->
		<?php
			$query = new WP_Query(array( 'post_type' => 'news', 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}
			?>
			<p class="title1">
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</p>
			<p class="uppercase mini gray left">By <?php yo_author(); ?></p>
			<p class="red mini right"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<div class="description content-summary">
				<?php the_excerpt(); ?>
			</div>
		</article>
		<?php
			}
			$query = new WP_Query(array( 'post_type' => 'news', 'posts_per_page' => 2, 'post__not_in' => $poet ) );
			
			while($query->have_posts()) : $query->the_post();
			$poet[] = get_the_ID();
		?>
		<hr/>
		<article <?php post_class(); ?>>
			<div class="title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
			<p class="uppercase mini gray left">By <?php yo_author(); ?></p>
			<p class="red mini right"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<div class="small-excerpt"><?php the_excerpt(); ?></div>
		</article>
		<?php
			endwhile;
		?>
	</div>
	<div id="ChronBottomSports" class="pop">
		<h4 class="usatoday sports"><a href="<?php echo site_url(); ?>/sports/" class="section-link">Sports</a></h4>
		<div class="annoyingbar"></div>
		<article <?php post_class('first-article'); ?>>
		<?php
			$query = new WP_Query(array( 'post_type' => 'sports', 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}
			?>
			<p class="title1">
				<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</p>
			<p class="uppercase mini gray left">By <?php yo_author(); ?></p>
			<p class="red mini right"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<div class="description content-summary">
				<?php the_excerpt(); ?>
			</div>
		</article>
		<?php
			}
			$query = new WP_Query(array( 'post_type' => 'sports', 'posts_per_page' => 2, 'post__not_in' => $poet ) );
			
			while($query->have_posts()) : $query->the_post();
			$poet[] = get_the_ID();
		?>
		<hr/>
		<article <?php post_class(); ?>>
			<div class="title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
			<p class="uppercase mini gray left">By <?php yo_author(); ?></p>
			<p class="red mini right"><?php the_checked_date(); ?></p>
			<div class="clear"></div>
			<div class="small-excerpt"><?php the_excerpt(); ?></div>
		</article>
		<?php
			endwhile;
		?>
	</div>
	

	<div id="ChronBottomOpinion" class="pop">
		<h4  class="usatoday opinion"><a href="<?php echo site_url(); ?>/opinion/" class="section-link">Opinion</a></h4>
		<div class="annoyingbar moveable"><?php the_issue_link($current_month); echo first_word(get_formal_issue_month($current_month)); ?> Issue</a></div>
		<div class="annoyingbar-filler"></div>
		<article <?php post_class("one"); ?>>
	<?php
		$query = new WP_Query(array( 'post_type' => 'opinion', 'posts_per_page' => 1, 'issue_month' => $curmonth, 'opinion_type' => 'editorial' ) );
		if($query->have_posts()) { $query->the_post();
		$wp_query->in_the_loop = true;
	?>
			<?php
				if(has_post_thumbnail()){
					the_full_title_1();
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					the_full_title_2();
				}else{
					echo "<br/>";
				}
			?>
			<div class="text">
				<p class="left uppercase gray mini">Editorial</p>
				<p class="right uppercase red mini"><?php just_tell_me($curmonth); ?> issue</p>
				<div class="clear"></div>
				<p class="title1"><?php the_full_title(); ?></p>
				<div class="one-summary justify font10 sans-serif1"><?php the_excerpt(); ?></div>
				<div class="clear"></div>
			</div>
		<?php
			}
		?>

		</article>
		<div class="two">
			<div class="slide">
		<?php
			$query = new WP_Query(array( 'post_type' => 'opinion', 'posts_per_page' => 3, 'issue_month' => $curmonth, 'opinion_type' => 'column', 'orderby' => 'rand' ) );
			while($query->have_posts()) { $query->the_post();
			$wp_query->in_the_loop = true;
		?>
				<article <?php post_class(); ?>>
					<?php the_full_title_1(); $i = new CoAuthorsIterator(); $i->iterate(); userphoto_the_author_photo(); the_full_title_2(); ?>
					<p class="title3"><?php the_full_title(); ?></p>
					<p class="mini gray uppercase">By <?php yo_author(); ?></p>
					<div class="sans-serif1 font10"><?php the_excerpt(); ?></div>
				</article>
	<?php } ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="ChronBottomFeatures" class="pop">
		<h4 class="usatoday features"><a href="<?php echo site_url(); ?>/features/" class="section-link">Features</a></h4>
		<div class="annoyingbar moveable"><?php the_issue_link($current_month); echo first_word(get_formal_issue_month($current_month)); ?> Issue</a></div>
		<div class="annoyingbar-filler"></div>

		<div class="left-side">
	<?php
		$query = new WP_Query(array( 'post_type' => 'features', 'posts_per_page' => 2, 'post__not_in' => $poet, 'features_importance' => 'section_slider' ) );
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		$wp_query->in_the_loop = true;
	?>
		<article <?php post_class("one"); ?>>
			<div class="image1">
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}			
			?>
			</div>
			<div class="left free">
				<div class="bold font22 line-height"><?php the_full_title(); ?></div>
				<p class="mini gray uppercase author">By <?php yo_author(); ?></p>
				<div class="sans-serif1 font10 justify"><?php the_excerpt(); ?></div>
			</div>
		</article>
		<?php
		}
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		?>
		<article <?php post_class("two"); ?>>
			<div class="left free">
				<div class="bold font16 line-height"><?php the_full_title(); ?></div>
				<p class="mini gray uppercase author">By <?php yo_author(); ?></p>
			</div>
		</article>
	<?php 
		}
	?>
	</div>
	<div class="right-side">
	<?php
		$query = new WP_Query(array( 'post_type' => 'features', 'posts_per_page' => 2, 'issue_month' => $curmonth, 'post__not_in' => $poet, 'features_importance' => 'section_slider' ) );
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		$wp_query->in_the_loop = true;
	?>
			<article <?php post_class("three"); ?>>
				<div class="image2">
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}
			?>
				</div>
				<div class="left free">
					<div class="bold line-height font18"><?php the_full_title(); ?></div>
					<p class="mini gray uppercase author">By <?php yo_author(); ?></p>
				</div>
			</article>
	<?php 
		}
		if($query->have_posts()) { $query->the_post(); 
	?>
			<article <?php post_class("four"); ?>>
				<div class="bold font16"><?php the_full_title(); ?></div>
				<p class="uppercase mini gray">By <?php yo_author(); ?></p>
				<div class="sans-serif1 font10 justify"><?php the_excerpt(); ?></div>
			</article>
	<?php
		}
	?>
		</div>
	</div>
	<div id="ChronBottomExtra" class="pop">
		<h4>
			Hwchronicle.com
		</h4>
		<div class="watch">
			<div class="watch-intro">
				<a href="<?php echo site_url(); ?>/launch/">
				<img src="<?php echo get_template_directory_uri(); ?>/images/click.png" height="100" width="150" />
				</a>
			</div>
			<div class="one uppercase sans-serif2 font10 bold">
				Watch Intro Video
			</div>
		</div>
		<hr />
		<div class="important">
			<div class="first uppercase sans-serif2 font11 bold">
				<a href="http://www.hwchronicle.com/opinion/your-paper-as-always/">LETTER FROM THE EDITORS-IN-CHIEF</a>
			</div>
			<div class="second uppercase sans-serif2 font11 bold">
				<a href="<?php echo site_url(); ?>/about/#contact">CONTACT US</a>
			</div>
			<div class="third uppercase sans-serif2 font11 bold">
				<a href="<?php echo site_url(); ?>/about/#website">ABOUT THE WEBSITE</a>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div id="ChronBottomAE" class="pop">
		<h4>
			A&E
		</h4>
	<?php
		$query = new WP_Query(array( 'post_type' => 'ae', 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		$wp_query->in_the_loop = true;
	?>
		<div <?php post_class('one'); ?>>
			<div class="image1">
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}
			?>
			</div>
			<article>
				<div class="bold font16"><?php the_full_title(); ?></div>
				<div class="mini gray author uppercase">by <?php yo_author(); ?></div>
				<div class="sans-serif1 font10"><?php the_excerpt(); ?></div>
			</article>
			<div class="clear"></div>
		</div>
	<?php
		}
	?>
		<hr />
		<div class="two">
	<?php 
		$query = new WP_Query(array( 'post_type' => 'ae', 'posts_per_page' => 2, 'post__not_in' => $poet ) );
		while($query->have_posts()) { $query->the_post();
	?>
			<article>
				<div class="font12 bold"><?php the_full_title(); ?></div>
			</article>
	<?php
		}
	?>
		</div>
	</div>
	<div id="ChronBottomMoreNews" class="pop">
		<h4>
			More News
		</h4>
		<?php
		
		$query = new WP_Query(array( 'post_type' => 'news', 'posts_per_page' => 5, 'post__not_in' => $poet ) );
		while($query->have_posts()) { $query->the_post();
		?>
		<article>
			<div class="first left font13 bold line-height">
				<?php the_full_title(); ?>
			</div>
			<div class="second right red mini">
				<?php the_checked_date(); ?>
			</div>
			<div class="clear"></div>
		</article>
		<?php 
		}
		?>
	</div>
	<div id="ChronBottomMoreSports" class="pop">
		<h4>
			More Sports
		</h4>
	<?php
		$query = new WP_Query(array( 'post_type' => 'sports', 'posts_per_page' => 5, 'post__not_in' => $poet ) );
		while($query->have_posts()) { $query->the_post();
	?>
		<article>
			<div class="first left bold font12 line-height">
				<?php the_full_title(); ?>
			</div>
			<div class="second right red mini">
				<?php the_checked_date(); ?>
			</div>
			<div class="clear"></div>
		</article>
		<?php
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/home.js"></script>

<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>
