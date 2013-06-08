<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>


<?php
		$url_without_query = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
		$poet = array();
		if (have_posts()) : the_post(); 
		$wp_query->in_the_loop = true;
		$this_month = wp_get_post_terms(get_the_id(), 'issue_month');
		$this_month = $this_month[0]->slug;
		$is_old = is_object_in_term( get_the_id(), 'is_old_issue', 'yes' );
		$is_non_chron = is_object_in_term( get_the_id(), 'is_other_publication', 'yes' );
		$inside = true;
?>



<header id="snubbed-header" class="pop extra ArchiveTop">
	<div id="SingleTop" class="issue inner">
		<div class="start">
			<a href="<?php echo home_url(); ?>/archives/"><img src="<?php bloginfo('template_directory'); ?>/images/cool/archives.png" id="announce"/></a>
		</div>

		<div class="issue-info">
			<h5 class="font16 bold">The Chronicle Print Archives 2006-<?php echo date("Y"); ?> for articles, videos, and photos.</h5>
			<p class="sans-serif1 font11">Digital versions of The Chronicle's Print Edition are available through Issuu, starting in 2008.  All articles in the Print Edition are also stored in the Archives Online Database.</p>
		</div>
	</div>
	<div id="fauxbottomborder"></div>	
</header>

<div id="SingleBottom" class="inner issue">
	<?php
		
		if($is_old){
	?>
		

		<article class="pop" id="single-article">
		<div id="<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<?php if(has_post_thumbnail()){
				echo "<div id='feat-image'>";
				echo yo_post_thumbnail("single-article");
				echo "<p>";
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
			<h4 class="title1">Related Issues</h4>
			<?php get_related_posts(); ?>
		</div>
		
		<?php
			}else{
			$terms = get_the_terms( get_the_id(), 'issue_month' );
			$term = $terms[0];
		?>
			<div class="information pop">
				<h2 class="font36 left"><?php the_title(); ?> Chronicle</h2>
				<div class="social right">
					<?php facebook_code_5(); ?>
					<?php twitter_code_1(); ?>
				</div>
				<div class="clear"></div>
				<div class="date uppercase">Published <?php the_date("F j, Y"); ?></div>
				<div class="excerpt">
					<?php the_excerpt(); ?>
				</div>
				<div class="issuu">
					<?php the_content(); ?>
				</div>
			</div>
			<div class="clear"></div>
			<?php
			if(!$is_non_chron){
			?>
			<link href="<?php echo get_template_directory_uri(); ?>/css/lonely.css" rel="stylesheet" type="text/css" />
			<!-- THANKS CODROPS!!!! YOU'RE THE BEST!!! but I still have no friendss... :_(-->
			<div class="awesome loser-container pop">
				<?php
					get_placard($term->slug);
				?>
				<?php i_have_no_friends($this_month); ?>
			</div>
			<?php
			}

		}
?>
	<?php endif; ?>
</div>

<?php include 'inc/bodybackground.php'; ?>

<?php get_footer(); ?>