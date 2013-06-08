<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<header id="snubbed-header" class="pop inner features">

<?php $page_num = get_page_num(); ?>
<?php $issue_month = get_issue_month(); 
	global $post;
	$tmp_post = $post;
?>




	<div id="SingleTop" >
		<div class="start">
			<a href="<?php echo home_url(); ?>/features/"><img src="<?php bloginfo('template_directory'); ?>/images/cool/features.png" id="announce" class="features"/></a>
		</div>
		<?php 
		
		$top_object = features_top($issue_month, $page_num, 'features', $post->ID);
		
		
		?>
		<div class="issue myhome left">


				<div class="home">
				<?php
					if($top_object[0] != null){
						$post = get_post($top_object[0]);
						setup_postdata( $post );
global $post;
				?>
					<h4 class="uppercase">Previous Article</h4>
					<?php the_full_title_1(); ?>
					<div class="featured-image">
<?php
				if(has_post_thumbnail()){
					echo yo_post_thumbnail("post-thumbnail");
				}
?>
					</div>
					</a>
					<div class="text <?=(has_post_thumbnail()? 'thumbnail' : ''); ?>">
						<div class="bold"><?php the_full_title(); ?></div>
					</div>
				<?php
				}
				?>
				</div>



				<div class="home last">
				<?php
					if($top_object[1] != null){
						$post = get_post($top_object[1]);
						setup_postdata( $post );
				?>
					<h4 class="uppercase font12">Next Article</h4>
					<?php the_full_title_1(); ?>
					<div class="featured-image">
<?php
				if(has_post_thumbnail()){
					echo yo_post_thumbnail("single-top");
				}
?>
					</div>
					</a>
					<div class="text <?=(has_post_thumbnail()? 'thumbnail' : ''); ?>">
						<div class="bold"><?php the_full_title(); ?></div>
					</div>
				<?php
					}
				?>
				</div>
		</div>
	</div>
	
</header>

<div id="SingleBottom" class="inner">
	<?php 
		$post = $tmp_post;
		setup_postdata($post);
		$wp_query->in_the_loop = true;
	?>
		

		<article class="pop" id="single-article">
		<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<?php if(has_post_thumbnail()){
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
			
			<div class="meta left">
				<p class="uppercase">By <?php yo_author(); ?></p>
				<p class="gray mini date"><?php the_checked_date(); ?></p>
			</div>
			<div class="buttons right">
				<?php facebook_code_3(); ?>				
				<?php twitter_code_1(); ?>
			</div>			
			<div class="clear"></div>
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
</div>

<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>