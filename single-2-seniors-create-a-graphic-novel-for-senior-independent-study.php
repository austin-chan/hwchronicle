<?php get_header(); ?>

<?php
function detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}
?>

<?php if(!empty($_GET) && $_GET['mode'] == 'normal' || detect_ie() ){ ?>

<?php include("inc/snubbed-nav.php"); ?>
<header id="snubbed-header" class="pop inner ae">
	<div id="SingleTop" >
		<div class="start">
			<a href="<?php echo home_url(); ?>/features"><img src="<?php bloginfo('template_directory'); ?>/images/cool/ae.png" id="announce" class="ae"/></a>
		</div>
	</div>
	
</header>

<div id="SingleBottom" class="inner">
	<?php 
		if (have_posts()) : while (have_posts()) : the_post(); 
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
			
			<div class="meta">
				<p class="uppercase">By <?php yo_author(); ?></p>
				<p class="gray mini date"><?php the_checked_date(); ?></p>
			</div>
			<br/>
			<?php if(!detect_ie()){ ?><a href="?" style="text-decoration:underline;">Read this article in Presentation Mode</a><?php } ?>
			
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

<?php }else{ ?>
<!-- YES I AM AWARE THAT THIS IS THE WORST, WORST PROGRAMMING PRACTICE - BUT THIS DISCLAIMER MAKES IT OK. -->

	<link href='http://fonts.googleapis.com/css?family=PT+Sans:700italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>
	<link href="<?=get_stylesheet_directory_uri()?>/css/curtain.css" rel="stylesheet" />

<style>
		#section-1{
			background: url('<?=get_stylesheet_directory_uri()?>/images/firstparallax/version1.jpg');
			background-size: cover;

			box-shadow: 0px 0px 10px black;

		}
		
		#section-1 header{
			position: absolute;
			top:30%;
			left:50%;
			width: 700px;
			margin-left:-350px;
			text-align: center;
		}
		#section-1 header h1{
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			
			width: 600px;
			margin: 0px 50px;
			padding:15px;
			
			font-size: 90px;
			font-style: italic;
			font-family: PT Sans;
			color:rgb(255,203,0);
			text-transform: uppercase;
			
			background: rgba(0,0,0,.85);
			box-shadow: 0px 0px 10px black;
			-webkit-box-shadow: 0px 0px 10px black;
			-moz-box-shadow: 0px 0px 10px black;
			display: block;
		}
		#section-1 header p{
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			
			width:500px;
			margin:0 100px;
			margin-top: 10px;
			padding: 15px;
			
			font-size: 20px;
			font-family: Helvetica, Arial;
			line-height: 24px;
			
			background: rgba(255,255,255,.9);
			display: block;
		}
		#section-1 header p strong{
			font-weight: bold;
		}
		#section-1 header h2{
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			
			width:300px;
			margin:0 200px;
			margin-top: 10px;
			padding: 5px;
			
			font-size: 36px;
			font-style: italic;
			font-family: PT Sans;
			color:rgb(255,203,0);
			text-transform: uppercase;
			
			background: rgba(0,0,0,.85);
			box-shadow: 0px 0px 10px black;
			-webkit-box-shadow: 0px 0px 10px black;
			-moz-box-shadow: 0px 0px 10px black;
			display: block;
		}
		
		#section-2{
			background: url('<?=get_stylesheet_directory_uri()?>/images/firstparallax/linedpaper.png');
			border-bottom: 1px solid black;
			box-shadow: 0px 0px 5px black;
			-webkit-box-shadow: 0px 0px 5px black;
			-moz-box-shadow: 0px 0px 5px black;
		}
		#section-2 article{
			width:960px;
			font-family: PT Serif, Georgia, serif;
			
			margin:0 auto;
			margin-top:100px;
			padding-bottom: 20px;
		}
		#section-2 article .text{
			width:400px;
			line-height:24px;
			float:left;
			margin-bottom: 100px;
		}
		#section-2 article .text p{
			margin-top:20px;
		}
		#section-2 article .pics{
			float:right;
			text-align: right;
			top:200px;
			width:500px;
			height:500px;
		}
		#section-2 article .pics img{
			opacity: 0;
			width:400px;
			position: relative;
			box-shadow: 0px 0px 10px black;
			-webkit-box-shadow: 0px 0px 10px black;
			-moz-box-shadow: 0px 0px 10px black;
		}
		#section-2 article .pics #pic2{
			top: -400px;
		}
		#section-2 article .pics #pic3{
			top: -826px;
		}
		#section-2 article .pics #pic4{
			top:-1246px;
		}
		
		#section-3{
			background: url('<?=get_stylesheet_directory_uri()?>/images/firstparallax/lastframe.jpg');
			background-size: cover;
			overflow: visible;
		}
		
		#section-3 #end{
			width:720px;
			margin: 0 auto;
			margin-top:50px;
		}
		#section-3 #end h3{
			color:rgb(255,203,0);
			font-style: italic;
			font-family: PT Sans;
			font-size:30px;
			background: rgba(0,0,0,.85);
			box-shadow: 0px 0px 10px black;
			-webkit-box-shadow: 0px 0px 10px black;
			-moz-box-shadow: 0px 0px 10px black;
			display: inline-block;
			margin-bottom: 20px;
			padding:5px 10px;
		}
		#section-3 #end h2{
			color:rgb(255,203,0);
			font-style: italic;
			font-family: PT Sans;
			font-size:20px;
			background: rgba(0,0,0,.85);
			box-shadow: 0px 0px 10px black;
			-webkit-box-shadow: 0px 0px 10px black;
			-moz-box-shadow: 0px 0px 10px black;
			display: inline-block;
			margin-top: 20px;
			padding:5px 10px;
		}
		#section-3 .video{
			width:720px;
			background: rgba(0,0,0,.95);
			padding:20px;
			display: block;
		}
		#section-3 .video iframe{
			border: 1px solid black;
		}
		#section-3 .info{
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			line-height: 24px;
			width:222px;
			margin-top:100px;
			padding:20px;
			float:right;
			font-family: PT Serif;
			font-size: 20px;
			color:white;
			text-shadow: 1px 1px 0px black;
			background:rgba(0,0,0,.3);
		}
		#section-3 #blackbottom{
			width:100%;
			position: absolute;
			bottom:-16px;
			height:100px;
			background:black;
		}
		#section-3 #blackbottom .leftpart{
			width:340px;
			height:110px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding:10px 20px;
			margin-left: -100%;
			float:left;
		}
		#section-3 #blackbottom .leftpart img{
			height:80px;
			float: left;
		}
		#section-3 #blackbottom .leftpart .device{
			float:left;
			margin-top:15px;
			margin-left:30px;
			text-shadow: 0px 1px 1px black;
		}
		#section-3 #blackbottom .leftpart .device .one{
			font-family: Helvetica, Arial;
			font-size:20px;
			color: white;
		}
		#section-3 #blackbottom .leftpart .device .two{
			font-family: Helvetica, Arial;
			font-size:16px;
			margin-top:3px;
			color: white;
		}
		#section-3 #blackbottom .middlepart{
			width:100%;
			height:110px;
			float:left;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			border-left: 1px solid gray;
			border-right: 1px solid gray;
			padding:20px 30px;
		}
		#section-3 #blackbottom .middlepart .inside{
			margin: 0px 300px;
			padding: 0 40px;
			height:64px;
			color:white;
			font-family: Helvetica, Arial;
			text-shadow: 0px 1px 1px black;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			border-left: 1px solid gray;
			border-right: 1px solid gray;
		}
		#section-3 #blackbottom .rightpart{
			float:right;
			height:110px;
			width:340px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			margin-left:-340px;
			color:white;
			text-shadow: 0px 1px 1px black;
			font-family: Helvetica, Arial;
			font-size:14px;
			padding: 16px 35px;
		}
		#section-3 #blackbottom .middlepart .fbplugin{
			margin-top:10px;
			display: inline-block;
			float:left;
		}
		#section-3 #blackbottom .middlepart .twplugin{
			margin-left: 30px;
			margin-top:10px;
			display: inline-block;
			float:left;
		}
		.closecurtain{
			cursor: pointer;
			position:fixed;
			overflow: hidden;
			opacity:.3;
			width:42px;
			z-index: 99999;
			font-family: Helvetica, Arial;
			font-size:18px;
			margin:10px 0px 0px 10px;
			height:42px;
			background:rgba(0,0,0,.6);
			color:rgba(255,255,255,.6);
		}
		.closecurtainleft{
			background:rgba(0,0,0,.7);
			padding:10px 13px;
			display: inline-block;
		}
		.closecurtainright{
			display:inline-block;
			padding:10px 10px;
		}
		.closecurtain i{
			font-size:20px;
		}
		.closecurtain:hover{
			background: rgba(0,0,0,.7);
		}
		.closecurtain:hover .closecurtainleft{
			background:rgba(0,0,0,.7);
		}
		#hoverpad{
			height:150px;
			width:150px;
			position: fixed;
			top:0px;
			left:0px;
			z-index: 99998;
		}

</style>






	<a href="?mode=normal">
	<div class="closecurtain">
		<div class="closecurtainleft">
			<i class="icon-remove"></i>
		</div>
		<div class="closecurtainright">
			Exit
		</div>
	</div>
	</a>
	<div id="hoverpad">
	
	</div>
	
	<ol class="curtains">
		<li id="section-1" class="cover">
			<header data-fade="300" data-slow-scroll="7">
				<h1>
					Page by Page
				</h1>
				<p>
					<strong>Lucas Foster '13</strong> and <strong>Avalon Nuovo '13</strong> created a 40-page graphic novel, titled <strong>"Cop Out,"</strong> for their Senior Independent Study project.
				</p>
				<h2>
					By Rebecca Katz
				</h2>
			</header>
		</li>
		<li id="section-2">
			<article>
				<div class="text">
	<?php 
		if (have_posts()) : the_post(); 
		$wp_query->in_the_loop = true;	
		the_content(); 
		endif;
?>
				</div>
				<div class="pics">
					<img id="pic1" src="<?=get_stylesheet_directory_uri()?>/images/firstparallax/pic1.jpg" />
					<img id="pic2" src="<?=get_stylesheet_directory_uri()?>/images/firstparallax/pic2.jpg" />
					<img id="pic3" src="<?=get_stylesheet_directory_uri()?>/images/firstparallax/pic3.jpg" />
					<img id="pic4" src="<?=get_stylesheet_directory_uri()?>/images/firstparallax/pic4.jpg" />
				</div>
				<div class="clear"></div>
			</article>
			<div>
			
			</div>
		</li>
		<li id="section-3">
			<div id="end">
				<h3 class="uppercase finalh">Interview: Creating "Cop Out"</h3>
				<div class="video">
					<iframe width="720" height="380" src="http://www.youtube.com/embed/P_Dj81iXBTo?rel=0&showinfo=0&disablekb=1&modestbranding=1&autohide=1&color=white" frameborder="0" allowfullscreen></iframe>
				</div>
				<h2>Video by Jack Goldfisher</h2>
			</div>
			<div id="blackbottom">
				<div class="middlepart">
					<div class="inside">
						Share this online feature
						<div class="buttons">
							<div class="fbplugin">
<?php
						facebook_code_3();
?>
							</div>
							<div class="twplugin">
<?php
						twitter_code_1();
?>
							</div>
						</div>
					</div>
				</div>
				<div class="leftpart">
					<a href="http://hwchronicle.com/"><img src="<?=get_stylesheet_directory_uri()?>/images/firstparallax/404-logo.jpg" /></a>
					<div class="device">
						<div class="one uppercase">
							Online feature
						</div>
						<div class="two">
							February 2013 Issue
						</div>
					</div>
				</div>
				<div class="rightpart">
					Editing: Julia Aizuss<br/>
					<br/>
					Web Presentation: Austin Chan<br/>
					Design: David Lim<br/>
				</div>
			</div>
		</li>
	</ol>



<script src="<?=get_stylesheet_directory_uri()?>/js/curtain.js"></script>
<?php include 'inc/bodybackground.php'; ?>
	<script>
	
		$('.closecurtain');
		
		$('#hoverpad, .closecurtain').hover(function(){
			$('.closecurtain').stop().animate({
				width : '100px',
				opacity : 1
			}, 200);
		}, function(){
			$('.closecurtain').stop().animate({
				width : '42px', 
				opacity : .3
			}, 200);
		});
	
	
		var curSlide = 1;
		$('.curtains').curtain({
			scrollSpeed: 400,
			nextSlide: function(){
				curSlide ++;

			},
			prevSlide: function(){
				curSlide --;

			}
			
		});
		function showPics(){
			$('.pics').stop(true, true).fadeIn();
		}
		function hidePics(){
			$('.pics').stop(true, true).fadeOut();			
		}
		$(window).scroll(function(){

			var scroll = $(window).scrollTop();
			var height = $(window).height();
			
			if(scroll > height){
				var dif = scroll - height;
				
				$('.pics').css('marginTop', dif/1.5);
				
				var pic1 = 0;
				var pic2 = 0;
				var pic3 = 0;
				var pic4 = 0;
				
				var one = 100;
				var two = 400;
				var three = 700;
				var four = 1100;
				if(dif < 100){
					pic1 = dif/one;
				}
				else if(dif < 300){
					pic1 = 1;
				}
				else if(dif < 400){
					pic1 = (two - dif)/100;
					pic2 = (dif - 300)/100;
				}
				else if(dif < 600){
					pic2 = 1;
				}
				else if(dif < 700){
					pic2 = (three - dif)/100;
					pic3 = (dif - 600)/100;
				}
				else if(dif < 1000){
					pic3 = 1;
				}
				else if(dif < 1100){
					pic3 = (four - dif)/100;
					pic4 = (dif - 1000)/100;
				}else{
					pic4 = 1;
				}
				
				$('#pic1').css('opacity', pic1);
				$('#pic2').css('opacity', pic2);
				$('#pic3').css('opacity', pic3);
				$('#pic4').css('opacity', pic4);
			}
			
		});
	</script>
<?php } ?>
<?php get_footer(); ?>
