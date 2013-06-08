<?php get_header(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<div id="Author" class="inner">

<!-- This sets the $curauth variable -->

    <?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); $cur
    ?>
	
	<div id="AuthorCenter" class="inner pop">
	    	<?php
	    		if(userphoto_exists($curauth->ID)){
		    		echo '<div class="author-thumb">';
			    	userphoto($curauth->ID); 
	    		echo '</div>';
    		}

	    	?>
	    	<div class="author-info <?php if(userphoto_exists($curauth->ID)){echo "has-thumbnail"; } ?>">
		   	    <h2><?php echo $curauth->first_name.' '.$curauth->last_name; ?></h2>
	
			    <div class="sans-serif1 bold font14">News Section Head</div>
		    </div>
		    <div class="clear"></div>
		    <div class="author-description sans-serif1 font13">
		    	OPTION STAFF BIO/PULL FROM PROFILE DESCRIPTION xxxComnistibus doluptat rerecat qui ari consendae et autam ex es sum renducitati doluptatem eum volupis ut debissimil et eati destion perum rerovit, nusda vit qui no
		    </div>
		    <div class="clear"></div>
		</div>
	<div id="AuthorSide" class="pop sans-serif2">
		<h3 class="sans-serif2 font16">NEWS SECTION</h3>
		<p>Managing Editors:</p>
		<p>Michael Sugerman and Ally White</p>

		RETURN TO FULL STAFF LIST
	</div>
	<div id="AuthorRecent" class="pop">



    <h2 class="uppercase sans-serif1 font18">Recent articles/photos/videos</h2>

    <ul>
<!-- The Loop -->

	<?php
	    $current_author = $curauth->ID;
		$query = new WP_Query(array( 'author' => $current_author,'post_type' => array('news', 'sports', 'opinion', 'features', 'video', 'photo', 'broadcast'), 'posts_per_page' => 6 ) );
		while($query->have_posts()) : $query->the_post();
			$wp_query->in_the_loop = true;
	?>
        <article>
			<?php
				if(has_post_thumbnail()){
					echo '<div class="result-thumbnail">';
					the_full_title_1();
					echo yo_post_thumbnail("thumbnail");
					echo '</a>';
					echo '</div>';
				}	
			?>
   			<div class="article-text <?php if(has_post_thumbnail()){ echo "has-thumbnail";} ?>">
	            <h2><?php the_full_title(); ?></h2>
	            <div class="meta">
	            	<div class="gray mini uppercase sans-serif1 left">By <?php yo_author(); ?></div>
	            	<div class="red mini uppercase sans-serif1 right"><?php the_checked_date(); ?></div>
	            	<div class="clear"></div>
	            </div>
	            <div class="entry-description sans-serif1 font12">
	            	<?php the_excerpt(); ?>
	            </div>
            </div>
            <div class="clear"></div>
        </article>
        <hr class="nonflair"/>
    <?php endwhile; ?>

<!-- End Loop -->

    </ul>



	</div>
	<div class="clear"></div>

</div>

<?php include 'inc/bodybackground.php'; ?>
<?php get_footer(); ?>