<div class="staff-section section pop">
<!--
	<div id="about-construction">
		<h2>Under Construction...</h2>
	</div>
-->
	<?php 
	if(have_posts()){
		the_post();
		$wp_query->in_the_loop = true;
		the_content();
	}
	?>
	<p id="edit-single-article"><?php edit_post_link('Edit this entry','',''); ?></p>

</div>
<style>
.section a{
	display:inline;
}
</style>