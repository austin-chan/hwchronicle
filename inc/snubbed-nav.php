			<div class="menu-snubbedtop-container">
				<div class="inner">
					<ul id="menu-snubbedtop" class="menu">
						<li class="menu-item">
							<a id="snubbed-flag-link" href="<?php echo get_option("home"); ?>"><div id="snubbed-flag-placeholder"></div><img id="snubbed-flag-hover" src="<?php echo get_template_directory_uri(); ?>/images/mini-flag-hover.png" /><img id="snubbed-flag" src="<?php echo get_template_directory_uri(); ?>/images/mini-flag.jpg" /></a>
						</li>
						<?php wp_nav_menu(array("menu" => "Top", "items_wrap" => '%3$s', "container" => false)) ?>
						<li class="right-menu-item">
							<img id="glass" src="<?php echo get_template_directory_uri(); ?>/images/search-glass.png" height="25" width="25"/>
							<div class="hidden-search">
								<?php include (TEMPLATEPATH . '/searchform.php'); ?>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-snubbedtop-filler"></div>