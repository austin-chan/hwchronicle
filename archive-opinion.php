<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<?php $curmonth = curmonth(); $curyear = curyear(); ?>

<header id="snubbed-header" class="pop inner ArchiveTop opinion">
	<p id="small-header-lastupdated" class="uppercase">
		<?php just_tell_me($curmonth); ?> ISSUE
	</p>
	<img src="<?php bloginfo('template_directory'); ?>/images/cool/opinion.png" id="announce"/>
	<div id="ticker">
		<?php get_recent_tags('opinion'); ?>
	</div>

</header>

<!-- --------------------Check for importance posts------------------------ -->

<?php
	$poet = array();
?>
<div id="ArchiveBottom" class="inner opinion">
	<div class="firstbig pop">
		<h4 class="usatoday uppercase opinion">Editorial</h4>
		<div class="annoyingbar"></div>
	<?php
		$query = new WP_Query(array( 'post_type' => 'opinion', 'issue_month' => $curmonth, 'posts_per_page' => 1, 'opinion_type' => "editorial" ) );
		if($query->have_posts()) { $query->the_post();
	?>
		<div id="drawing1">
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("section-slider", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}
			?>		</div>
		<div class="main-opinion">
			<p class="left mini uppercase sans-serif1 bold">EDITORIAL</p>
			<div class="clear"></div>
			<article>
				<p class="font30 main-title bold"><?php the_full_title(); ?></p>
				<div class="sans-serif1 font12"><?php the_excerpt(); ?></div>
			</article>
		</div>
	<?php
		}
	?>
	 </div> <!-- closes the first div box -->
		
		
		 <!-- The very first "if" tested to see if there were any Posts to -->
		 <!-- display.  This "else" part tells what do if there weren't any. -->
	<div class="poll pop">
		<h4 class="usatoday opinion">Poll</h4>
		<div class="annoyingbar moveable uppercase"><a href="javascript:void(0);">Last Updated: <?php echo last_updated(); ?></a></div>
		<div class="annoyingbar-filler"></div>
		<div id="showcase" class="showcase">
		        <!-- Each child div in #showcase represents a slide -->
		        <div class="showcase-slide">
		                <!-- Put the slide content in a div with the class .showcase-content -->
		                <div class="showcase-content">
		                        <div class="showcase-content-wrapper">
		                        
		                        
		                        	<?php
		                        		$num = 0;
										$query = new WP_Query(array( 'post_type' => 'opinion', 'posts_per_page' => 12, 'opinion_type' => "poll"));
										while($query->have_posts()) { $query->the_post();
										$num++;
										$poet[] = get_the_ID();
										$wp_query->in_the_loop = true;
									?>
									
									<?php
										if($num % 3 == 1 && $num != 1){
										?>
		                        </div>
		                </div>
		        </div>
		        <div class="showcase-slide">
		                <!-- Put the slide content in a div with the class .showcase-content -->
		                <div class="showcase-content">
		                        <div class="showcase-content-wrapper">
										<?php
										}
									?>
		                                <a class="poll-item <?php echo ($num%3 == 0) ? 'third' : ''; ?>" href="<?=wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>">
		                                	<?php the_post_thumbnail();?>
		                                	<div class="text">
		                                		<div class="title"><?php the_title(); ?></div>
		                                		<div class="responses red mini"><?php the_excerpt(); ?></div>
		                                		<div class="date gray mini uppercase"><?php the_checked_date(); ?></div>
		                                	</div>
		                                	<div class="clear"></div>
		                                </a>
		                                <?php
		                                }
		                                ?>
		                        </div>
		                </div>
		        </div>
		</div>
		<div id="tstoneremix">
			The Chronicle polls all Upper School students in a survey sent out by email every month on relevant and timely issues affecting the school community
		</div>
	</div>
	<div class="clear"></div>
	
<!-- COLUMNS -->
	<div class="columns pop">
		<h4 class="usatoday uppercase opinion">Columns</h4>
		<div class="annoyingbar"></div>

	<?php
		$query = new WP_Query(array( 'post_type' => 'opinion', 'issue_month' => $curmonth, 'posts_per_page' => 1, 'opinion_type' => "column", 'meta_key' => '_thumbnail_id' ) );
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
	?>
		<div id="drawing2">
			<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}else{
					echo "<br/>";
				}
			?>		</div>
		<div class="opinion-column">
			<div class="mini-profile left">
				<?php
					$i = new CoAuthorsIterator();
					$i->iterate();
				?>
				<?php userphoto_the_author_photo(); ?>
			</div>
			<article class="right column-article">
				<p class="font20 bold"><?php the_full_title(); ?></p>
				<p class="uppercase gray mini left">By <?php yo_author(); ?></p>
				<div class="clear"></div>
				<div class="sans-serif1 font12"><?php the_excerpt(); ?></div>
			</article>
			<div class="clear"></div>
		</div>
	<?php
		}
	?>
		<hr>
	<?php
		$query = new WP_Query(array( 'post_type' => 'opinion', 'issue_month' => $curmonth, 'posts_per_page' => 1, 'opinion_type' => "column", 'post__not_in' => $poet) );
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
	?>
		<div class="opinion-column">
			<div class="mini-profile left">
				<?php
					$i = new CoAuthorsIterator();
					$i->iterate();
				?>
				<?php userphoto_the_author_photo(); ?>
			</div>
			<article class="right column-article">
				<p class="font20 bold"><?php the_full_title(); ?></p>
				<p class="uppercase gray mini left">By <?php the_author(); ?></p>
				<div class="clear"></div>
				<div class="sans-serif1 font12 "><?php the_excerpt(); ?></div>
			</article>
			<div class="clear"></div>
		</div>
	<?php
		}
	?>
	</div>
	
	<div class="blog pop">
		<h4 class="usatoday uppercase opinion">Blog</h4>
		<div class="annoyingbar"></div>
		<?php
			opinion_blog();
		?>
	</div>
<!-- 	LETTERS -->
	<div class="letters pop">
		<h4 class="usatoday uppercase opinion">Letters to the editor</h4>
		<div class="annoyingbar"></div>

	<?php
		$query = new WP_Query(array( 'post_type' => 'opinion', 'posts_per_page' => 3, 'opinion_type' => "letter"));
		while($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		$wp_query->in_the_loop = true;
	?>
		<div class="opinion-letter">
			<article class="letter-article expandable">
				<p class="font20 bold"><?php the_full_title(); ?></p>
				<p class="uppercase gray mini left">From <?php echo get_post_meta(get_the_ID(), 'letter_from', true); ?></p>
				<div class="clear"></div>
				<div class="sans-serif1 font12"><?php the_excerpt(); ?></div>
			</article>
		</div>
	<?php
		}
	?>
	</div>
	<div class="clear"></div>
	
<!-- 	MORE COLUMNS -->
	<div class="more-columns pop">
		<h4 class="usatoday uppercase opinion">More Columns</h4>
		<div class="annoyingbar"></div>
		<div class="left more-column">
	<?php
		opinion_column($curmonth, 2);
	?>
		</div>
		<div class="vr"></div>
		<div class="right more-column">
	<?php
		opinion_column($curmonth, 2)
	?>
	</div>
	<div class="clear"></div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive-opinion.js"></script>
<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>