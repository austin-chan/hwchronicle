<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<header id="snubbed-header" class="pop inner opinion">

<?php 
	global $post;
	$tmp_post = $post;
	
	$is_editorial = is_object_in_term($post->ID, 'opinion_type', 'editorial');
	$is_letter = is_object_in_term($post->ID, 'opinion_type', 'letter');
	$is_column = is_object_in_term($post->ID, 'opinion_type', 'column');
	
	$page_num = get_page_num(); 
	$issue_month = get_issue_month();
	if (have_posts()) : while (have_posts()) : the_post(); 
	$wp_query->in_the_loop = true;


?>





	<div id="SingleTop" >
		<div class="start">
			<a href="<?php echo home_url(); ?>/opinion/"><img src="<?php bloginfo('template_directory'); ?>/images/cool/opinion.png" id="announce" class="opinion"/></a>
		</div>
		
		<?php
		if(!$issue_month){
			$top_object = generic_opinion_top(curmonth(), $post->ID);
			generic_echo_top($top_object);
		}elseif(!$page_num || $is_letter){
			$top_object = generic_opinion_top($issue_month, $post->ID);
			generic_echo_top($top_object);
		}elseif($is_column){
			$top_object = column_top($issue_month, $page_num, $post->ID);
			column_echo_top($top_object);
		}elseif($is_editorial){
			$top_object = editorial_top($issue_month);
			editorial_echo_top($top_object);
		}
		
		?>
	</div>
</header>


<?php $post = $tmp_post; ?>

<div id="SingleBottom" class="inner opinion">
		<article class="pop" id="single-article">
			<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php 
				if($is_column){
					$i = new CoAuthorsIterator();
					$i->iterate();
					echo '<div class="left author-photo">';
					userphoto_the_author_photo();
					echo '</div>';
				}
				?>
				<div id="opinion-head" class="relative <?= $is_column ? 'column' : ''; ?>">
				<div class="<?= $is_editorial ? 'editorial' : 'non-editorial' ?>">
					<h1 class="entry-title">
						<?php 
						if($is_editorial){
							echo "<p class='title-indicator'>Editorial:</p> ";
						}elseif($is_letter){
							echo "<p class='title-indicator'>Letter:</p> ";
						}
						?>
						<?php the_title(); ?>
					</h1>
					<?php if($is_editorial && has_post_thumbnail()){
						echo "<div id='feat-image'>";
						echo "<a class='fancybox' href='".wp_get_attachment_url( get_post_thumbnail_id($post->ID) )."'>";
						echo yo_post_thumbnail("single-article");
						echo "</a>";
						echo "<p class='credit'>";
						echo get_media_credit(get_post_thumbnail_id($post->ID));
						echo "</p>";
						echo "<p class='caption'>";
						the_post_thumbnail_caption();
						echo "</p>";
						echo "</div>";					
					}
					?>
					<?php if(!$is_editorial){?>

					<div class="short-desc"><?php the_excerpt(); ?></div>
					<?php }else{ ?>
					<div class="clear"></div>
					<?php } ?>
					<div class="meta left">
						<?php if(!$is_editorial && !$is_letter){?>
						<p class="opinion-author">By <?php yo_author(); ?></p>
						<?php }elseif($is_letter){ ?>
						<p class="opinion-author">From <?php echo get_post_meta(get_the_ID(), 'letter_from', true); ?></p>
						<?php } ?>
						<p class="gray mini date"><?php the_date("F j, Y"); ?></p>

					</div>
					<div class="buttons right">
						<?php facebook_code_3(); ?>				
						<?php twitter_code_1(); ?>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<?php if(!$is_editorial){ ?>
			<hr class="nonflair">
			<?php } ?>
			<?php if($is_editorial){?>
			<div class="editorial-byline"><?php the_excerpt(); ?></div>
			<?php } ?>
<?php $post = $tmp_post; ?>

			<div class="entry-content">
				
				<?php the_content(); ?>
			</div>
			
			<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>
		
		</div>
		</article>
		<div id="related-stories" class="pop">
			<h4 class="title1">Related Stories</h4>
			<?php get_related_posts(); ?>
		</div>
		<div class="clearleft"></div>
		<div id="comments" class="pop">
			<h4 class="title1">Comments</h4>
			<?php facebook_code_2(); ?>
		</div>

	<?php endwhile; endif; ?>
</div>

<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>