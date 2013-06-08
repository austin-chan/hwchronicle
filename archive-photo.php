<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

<header class="dark-header tint">
	<img src="<?php bloginfo('template_directory'); ?>/images/cool/photos.png" id="announce" class="photos"/>
<!--
	<div class="info sans-serif1 font12">
		The Chronicle provides timely coverage of Harvard-Westlake student events including athletics and performing arts as well as profiles of individuals in the school community throughout the year.
	</div>
-->
	<div class="colored clear">
		<div class="one"></div>
		<div class="two"></div>
		<div class="three"></div>
		<div class="four"></div>
	</div>
</header>
<div id="ArchiveBottom" class="photos inner">
	<div class="main pop tint">
		<div id="photo-showcase" class="showcase">
		<?php
			$query = new WP_Query(array( 'post_type' => 'photo', 'posts_per_page' => 3, ) );
			while($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<div class="showcase-slide">
				<div class="showcase-content">
					<div class="showcase-content-wrapper">
						<div class="image1">
					<?php
						$Images = & get_children ( 'post_type=attachment&posts_per_page=1&post_mime_type=image&post_parent=' . get_the_ID() );
						$img;
						
						foreach ( $Images as $image ) {
							$img = $image;
						}
												
						$title = $img->post_title;
						$caption = $img->post_excerpt;
						$description = $img->post_content;
						$url = wp_get_attachment_image_src($img->ID, "archive-photo");
						
						the_full_title_1($img->ID);
						echo "<img src='".$url[0]."' />";
						the_full_title_2();
					?>
						</div>					
					</div>
					<div class="showcase-caption">

						<div class="imagedetails">
							<p class="bold sans-serif2 font14 album uppercase">In Album:</p>
							<p class="bold sans-serif2 font24"><?php the_full_title(); ?></p>
							<div class="sans-serif1 font13 excerpt">
								<?php
									echo $description;
								?>
							</div>
							<div class="bottom">
								<div class="date uppercase sans-serif2"><?php echo get_the_date('F j');?></div>
								<div class="byline sans-serif2 font14"><?php echo get_media_credit(get_post_thumbnail_id($post->ID)); ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>


	</div>
	<div class="clear"></div>
		<?php
			$query = new WP_Query(array( 'post_type' => 'photo', 'posts_per_page' => 9, ) );
			while($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
			
			$Images = & get_children ( 'post_type=attachment&orderby=rand&post_mime_type=image&post_parent=' . get_the_ID() );
			$img = array();
			
			foreach ( $Images as $image ) {
				$img[] = $image;
			}
		?>
	<div class="photo-box pop tint">
		<div class="image2">
			<span></span>

			<?php $i1 = wp_get_attachment_image_src($img[0]->ID, "section-slider"); ?>
			<?php $i2 = wp_get_attachment_image_src($img[1]->ID, "section-slider"); ?>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $i1[0]; ?>" /></a>
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $i2[0]; ?>" /></a>	
		</div>
		<div class="sans-serif2 font20 title bold">
			<?php the_full_title(); ?>
		</div>
		<div class="date uppercase sans-serif2 font12 bold">Posted <?php echo correct_ap_month(get_the_date("M j")); ?></div>
		<div class="sans-serif2 font12">
			<?php the_excerpt(); ?>
		</div>
		
	</div>
		<?php } ?>
	<div class="clear"></div>
</div>




<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.aw-showcase.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/archive-photos.js"></script>
<?php include 'inc/darkbackground.php'; ?>
<?php get_footer(); ?>