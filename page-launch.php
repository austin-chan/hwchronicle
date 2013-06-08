<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Harvard-Westlake Chronicle - Launch Page</title>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/splash.css" />
    </head>
    <body>
    <?php facebook_code_1(); ?>
<?php include("inc/snubbed-nav.php"); ?>
<!--
		<div id="overlay">
			<div id="box">
				<div id="overlay-slogan">The Harvard-Westlake Chronicle</div>
				<img id="spinner" src="<?php echo get_template_directory_uri(); ?>/images/ajax-loader-black.gif" />
				<div id="overlay-text">
					Loading...
				</div>
			</div>
		</div>
-->
<!--
		<div class="container">
			<div class="am-container" id="am-container">
-->
<?php



/*
$query_images_args = array(
    'post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => 100, 'orderby' => 'rand'
);

$query_images = new WP_Query( $query_images_args );
$used_posts = array();

foreach ( $query_images->posts as $image) {
	if(!in_array( $image->post_parent, $used_posts )){
		$img = wp_get_attachment_image_src( $image->ID, 'medium' );
	    echo "<a href='#'><img src=".$img[0]."></img></a>";
    }
	$used_posts[] = $image->post_parent;
}
*/


/*
$args = array(
	'post_type' => array('news', 'sports', 'features', 'opinion', 'video', 'photo', 'broadcast'),
	'meta_key' => '_thumbnail_id',
	'posts_per_page' => 35,
	'orderby' => 'rand'
);
$daquery = new WP_Query($args);
while($daquery->have_posts()){
	$daquery->the_post();
	echo '<a href="'.get_permalink().'">';
	the_post_thumbnail();
	echo '<div class="fill">'.get_the_title().'</div>';
	echo '</a>';
}
*/
?>
<!--
			</div>
		</div>
-->
		<div id="content">
			<div id="vid" class="death">
				
			</div>
						<div class="clear"></div>

			<a id="first" class="death" href="<?php echo site_url(); ?>">
				<img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/404-logo.jpg" />
				<h4 id="logo-text" class="bold uppercase">Continue to Hwchronicle.com</h4>
				<p class="logo-desc">
					The new online home of the Chronicle, the student newspaper of Harvard-Westlake School
				</p>
			</a>
			<div id="second" class="death">
				<h4 class="uppercase">Stay Updated</h4>
				<div class="fb-like" data-href="http://facebook.com/thehwchronicle" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
				<?php twitter_code_4(); ?>
				<p>Like us on Facebook and follow us on Twitter for the latest updates on all things Harvard-Westlake.
			</div>
			<div id="third" class="death">
				<div class="left">
					<h4 class="one"><a href="<?php echo site_url(); ?>/about/#website">About the site</a></h4>
					<h4 class="two"><a href="http://www.hwchronicle.com/opinion/your-paper-as-always/">Letter from the Editors</a></h4>
					<h4 class="three"><a href="<?php echo site_url(); ?>/about/#staff">Staff</a></h4>
					<h4 class="four"><a href="<?php echo site_url(); ?>/about/#contact">Contact Us</a></h4>
				</div>
				<div class="right">
					<img id="switch" src="<?php echo get_template_directory_uri(); ?>/images/aboutaustin.jpg" />
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.livequery.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/_/js/functions.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.montage.min.js"></script>
		<script type="text/javascript">
/*
			$(window).load(function(){
				setTimeout(function(){
					$('#overlay').css('pointer-events', 'none').animate({'opacity': '.3'}, 2000);
			
					$('#box').fadeOut(2000);
				}, 500);
				var $container 	= $('#am-container');

							$container.montage({
								fillLastRow	: true,
									alternateHeight	: true,
									alternateHeightRange : {
										min	: 130,
										max	: 200
									},
									margin : 0
							});
							
				$('.am-container a').hover(function(){
					$(this).find('.fill').css('opacity', '1');
				}, function(){
					$(this).find('.fill').css('opacity', '0');
				});
						
			});
*/
		$('h4.one').hover(function(){
			$('#switch').attr('src', '<?php echo get_template_directory_uri(); ?>/images/aboutaustin.jpg');
		});
		$('h4.two').hover(function(){
			$('#switch').attr('src', '<?php echo get_template_directory_uri(); ?>/images/lettereditor.jpg');
		});
		$('h4.three').hover(function(){
			$('#switch').attr('src', '<?php echo get_template_directory_uri(); ?>/images/staffintro.jpg');
		});
		</script>
	<?php wp_footer(); ?>
	<style>
		body{
			background-size:cover !important;
			background-position:top center !important;
			/* background-image:url('<?php echo get_template_directory_uri(); ?>/images/vignette/background<?php echo rand(1,5) ?>.jpg'); */
		}
	</style>


<!-- here comes the javascript -->

<!-- jQuery is called via the Wordpress-friendly way via functions.php -->

<!-- this is where we put our custom functions -->
<script src="<?php bloginfo('template_directory'); ?>/_/js/functions.js"></script>

<!-- No FOUC -->

<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35308943-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();



	$('<img/>').attr('src', '<?php echo get_template_directory_uri(); ?>/images/vignette/background<?php echo rand(1,5) ?>.jpg').load(function() {
	
	   $('body').css('background-image', 'url(<?php echo get_template_directory_uri(); ?>/images/vignette/background<?php echo rand(1,5) ?>.jpg)');
	   $("#vid").html('<iframe width="980" height="550" src="http://www.youtube.com/embed/M7Utck6iW2E?rel=0&autohide=1&autoplay=1&modestbranding=1" frameborder="0" allowfullscreen></iframe>');
	});


</script>

<script src="<?php bloginfo('template_directory'); ?>/js/creative.js"></script>

</body>

</html>
