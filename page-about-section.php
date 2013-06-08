<div class="about-section section pop">
<!--
	<div id="about-construction">
		<h2>Under Construction...</h2>
	</div>
-->
	<?php 
	if(have_posts()){
		global $post, $wp_query;
		the_post();
		$wp_query->in_the_loop = true;
		echo "<div ";post_class();echo ">";
		the_content();
		echo "</div>";
	}
	?>
	<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>
</div>
<style>
.section a{
	display:inline;
}
</style>