<!--
		<?php if(is_user_logged_in()){ ?>
		<div id="dev-tool">
			<p>Click here to turn on sandbox mode</p>
			<p></p>
		</div>
		<?php } ?>
-->
		<header id="big-header" class="pop">
			<div class="inner">
				<p id="big-header-lastupdated">
					LAST UPDATED: 
					<span class="red">
						<?php last_updated(); ?>
					</span>
				</p>
				<a id="big-header-flaglink" href="<?php echo get_option("home"); ?>"><img id="big-header-flag" src="<?php echo get_template_directory_uri(); ?>/images/flag.png" /></a>
				<div id="big-header-rightstuff">
					<div id="big-header-switcher">
						<div class="switcher one showen">
							<div id="papa-image">
								<?php the_issue_image(curmonth(), 'issue-thumb'); ?>
							</div>
							<p class="uppercase">PRINT EDITION <span class="red"><?php echo first_word(get_formal_issue_month(curmonth())); ?></span></p>
							<div class="clear"></div>
						</div>
						<div class="switcher two hidden">
							<img id="online" src="<?php echo get_template_directory_uri(); ?>/images/online.jpg" />
							<p>SEE TOP <span class="red">ONLINE ARTICLES</span></p>
						</div>
					</div>
					<div id="big-header-day">
						<p class="one"><?php echo date("F j, Y"); ?></p>
						<div class="two">						
							<a target="_blank" href="<?php echo site_url(); ?>/about/"><img src="<?php echo get_template_directory_uri(); ?>/images/mini-crest.png" /></a>
							<p class="three">THE ONLINE STUDENT NEWSPAPER <br/>OF HARVARD-WESTLAKE SCHOOL</p>
						</div>
					</div>
				</div>
			</div>
			<div id="red-top-bar"></div>
			<div class="menu-top-container">
				<ul id="menu-top" class="inner relative">
					<?php wp_nav_menu(array("menu" => "Top", "items_wrap" => '%3$s', "container" => false)); ?>
					<div id="big-header-search">
						<?php include (TEMPLATEPATH . '/searchform.php'); ?>
					</div>
				</ul>
			</div>
		</header>