<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>

<header class="dark-header tint">
	<a href="<?php echo home_url(); ?>/video/">
		<img src="<?php bloginfo('template_directory'); ?>/images/cool/broadcast.png" id="announce" class="broadcast single"/>
	</a>
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

<div id="SingleBottom" class="broadcast inner">
	<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 
		$wp_query->in_the_loop = true;
		$commentary = get_post_meta( get_the_id(), 'broadcast_commentary', true );
		$video = get_post_meta( get_the_id(), 'broadcast_video', true );
		$photos = get_post_meta( get_the_id(), 'broadcast_photos', true );
		$twitter = get_post_meta( get_the_id(), 'broadcast_twitter', true );
	?>
		<div class="vidarea">
			<?php the_content(); ?>
		</div>
		<?php
			if(get_post_meta(get_the_ID(), 'preview_post_id', true) ){
				$preview = get_post_meta(get_the_ID(), 'preview_post_id', true);
				$obj = wp_get_single_post($preview, "OBJECT");
				
		?>
		<div class="previewarea tint">
			<h4 class="sans-serif2">GAME PREVIEW</h4>
			<p class="title"><a href="<?=$obj->guid?>"><?=$obj->post_title?></a></p>
			<p class="byline">BY LUKE HOLTHOUSE</p>
			<p class="description"><?=$obj->post_excerpt?></p>
		</div>
		<?php
			}
		?>
		<div class="recommendarea tint">
			<?php facebook_code_4(); ?>
		</div>
		<div class="twitterarea tint">
			<a class="twitter-timeline" href="https://twitter.com/hw_chronicle" data-widget-id="246757630419288064">Tweets by @hw_chronicle</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div class="descarea tint">
			<h2 class="sans-serif2 font30"><?php the_title(); ?></h2>
			<p class="sans-serif1 font10"><?php the_excerpt(); ?></p>
			<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>

		</div>
		<div class="commentarea tint">
			<h4 class="sans-serif2">COMMENTS</h4><br/>
			<div class="fb-comments" data-href="http://www.hwchronicle.com/hwvssylmar/" data-num-posts="10" data-width="490" data-colorscheme="dark"></div>
		</div>
		<div class="teamarea tint">
			<div>
				<h4 class="sans-serif2">TONIGHT'S BROADCASTING TEAM</h4>
				<div class="left">
					<a href="<?php echo home_url(); ?>/video/">
						<img src="<?php echo get_template_directory_uri(); ?>/images/team.png" />
					</a>
				</div>
				<div class="right">
					<?php if($commentary){ ?>
					<strong>COMMENTARY: </strong><?=$commentary; ?><br/><br/>
					<?php }if($video){ ?>
					<strong>Twitter Coverage: </strong><?=$video; ?><br/><br/>
					<?php }if($photos){ ?>
					<strong>Photos: </strong><?=$photos; ?><br/><br/>
					<?php }if($twitter){ ?>
					<strong>Video: </strong><?=$video; ?><br/>
					<?php } ?>
				</div>
			</div>
		</div>
	<div style="clear:both"></div>
	<div class="disclaimarea tint">
		The Harvard-Westlake Chronicle is not responsible for the content of the comments on the site. <br/>The Harvard-Westlake Chronicle &copy;2012
	</div>

	<?php endwhile;endif; ?>
</div>



<?php include 'inc/darkbackground.php'; ?>
<?php get_footer(); ?>