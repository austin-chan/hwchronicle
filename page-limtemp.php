<?php
$args = array(
	'post_type' => array('news', 'sports', 'features', 'opinion', 'video', 'photo', 'broadcast'),
	'meta_key' => '_thumbnail_id',
	'posts_per_page' => 100,
	'orderby' => 'rand'
);
$daquery = new WP_Query($args);
while($daquery->have_posts()){
	$daquery->the_post();
	echo '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID) ).'">';
	the_post_thumbnail();
	echo '</a>';
}

?>
<style>
img{
height:200px !important;
}
</style>