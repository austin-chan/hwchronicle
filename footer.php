		<footer id="footer" class="source-org vcard copyright clear">
			<div id="footer-three" class="inner">
				<a class="url" href="<?php echo site_url(); ?>">hwchronicle.com</a>
				<li class="copyright">&copy; 1992-<?php echo date("Y"); ?> Harvard-Westlake Chronicle. All Rights Reserved.</li>
				<li class="about"><a href="<?php echo site_url(); ?>/about/">About the Chronicle</a></li>
				<li class="website"><a href="<?php echo site_url(); ?>/about/#website">About the website</a></li>
				<li id="loginout" class="loginout"><?php wp_loginout(); ?></li>
			</div>
		</footer>


	<?php wp_footer(); ?>


<!-- here comes the javascript -->

<!-- jQuery is called via the Wordpress-friendly way via functions.php -->

<!-- this is where we put our custom functions -->
<script src="<?php bloginfo('template_directory'); ?>/_/js/functions.js"></script>

<!-- No FOUC -->

<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.
	 -->
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35308943-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script src="<?php bloginfo('template_directory'); ?>/js/creative.js"></script>

</body>

</html>
