<?php

function get_list_page_num(){
	return array('A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'A9', 'A10', 'A11', 'A12', 'A13', 'A14', 'A15', 
				'B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10', 'B11', 'B12',
				'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7', 'C8');
}
function get_list_page_num_slug(){
	return array('a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 
				'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10', 'b11', 'b12',
				'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8');
}

function setup_chronicle_settings() {
    add_menu_page('HW Chronicle Settings', 'Chronicle Settings', 'manage_options',
        'hw_chronicle_theme_settings', 'init_chronicle_page');
}


add_filter('template_include', create_function(
	'$the_template',
	'if(!is_single())return $the_template;
	$slug=basename(get_permalink());
		if ( file_exists(TEMPLATEPATH . "/single-{$slug}.php") )
		return TEMPLATEPATH . "/single-{$slug}.php"; 
	return $the_template;' )
);

add_action("admin_menu", "setup_chronicle_settings");

function init_chronicle_page() {

if (isset($_POST["update_settings"])) {
	$issue_month = esc_attr($_POST["issue_month"]);
	update_option("current_issue_month", $issue_month);
	$issue_year = esc_attr($_POST["issue_year"]);
	update_option("current_issue_year", $issue_year);
	?>
	    <div id="message" class="updated">Settings saved</div>
	<?php
}
	$current_issue_month = get_option("current_issue_month");
	$current_issue_year = get_option("current_issue_year");


?>
    <div class="wrap">
        <?php screen_icon('themes'); ?> <h2>The Global Options Page for the HW Chronicle.  Should only be available to Admins.</h2>
        <form method="POST" action="">
<?php
	$months = get_terms('issue_month', 'hide_empty=0'); 
?>
		<br/>
		<label for="issue_month">Select Active MONTH you know wadda I mean?:</label>
		<select name='issue_month' id='post_issue_month'>
			<!-- Display themes as options -->
		        <?php
			foreach ($months as $month) {
				if (!strcmp($month->slug, $current_issue_month))
					echo "<option class='theme-option' value='" . $month->slug . "' selected>" . $month->name . "</option>\n"; 
				else
					echo "<option class='theme-option' value='" . $month->slug . "'>" . $month->name . "</option>\n"; 
			}
		   ?>
		</select><br/>
		
		
		
<!-- 		CHECK FOR ERROR -->
<?php
	$args = array(
		'post_type' => 'issue',
		'issue_month' => $current_issue_month, 
	);
	$check = get_posts($args);
	if(sizeof($check) == 0){
		echo "<p><strong>ERROR:</strong> There is no ISSUE that has that month selected.  Please go to ISSUE tab and edit the ISSUE article that you want to be connected to this month there.</p>";
	}
?>
		
		
		
		<br/>
		
<?php
	$years = get_terms('issues', 'hide_empty=0'); 
?>
		<label for="issue_month">Select Active YEAR across da whole site yo:</label>
		<select name='issue_year' id='post_issues'>
			<!-- Display themes as options -->
		        <?php
			foreach ($years as $year) {
				if (!strcmp($year->slug, $current_issue_year))
					echo "<option class='theme-option' value='" . $year->slug . "' selected>" . $year->name . "</option>\n"; 
				else
					echo "<option class='theme-option' value='" . $year->slug . "'>" . $year->name . "</option>\n"; 
			}
		   ?>
		</select>  


<!-- 		CHECK FOR ERROR -->
<?php
	$args = array(
		'post_type' => 'issue',
		'issues' => $current_issue_year, 
	);
	$check = get_posts($args);
	if(sizeof($check) == 0){
		echo "<p><strong>ERROR:</strong> There is no ISSUE that has that year selected.  Please go to ISSUE tab and edit the ISSUE article that you want to be connected to this year there.</p>";
	}
?>

            <input type="hidden" name="update_settings" value="Y" />
            <p>
			    <input type="submit" value="Save settings" class="button-primary"/>
			</p>
        </form>
    </div>
<?php

}



function package_thumbnail($size = 'thumbnail'){
	echo "<div class='image1'>";
	if(has_post_thumbnail()){
		echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
		echo yo_post_thumbnail($size, get_the_ID());
		echo '</a>';
	}
	echo '</div>';
}

function get_formal_issue_month($issue_month){
	$term = get_term_by( 'slug', $issue_month, 'issue_month' );
	return $term->name;
}
function first_word($name){
	$arr = explode(' ',trim($name));
	return $arr[0];
}
function just_tell_me($issue_month){
	echo first_word(get_formal_issue_month($issue_month));
}
function get_raw_issue($issue_month){
	$term = get_term_by( 'slug', $issue_month, 'issue_month' );
			
	$args = array('post_type' => 'issue', 	
	'tax_query' => array(
		array(
			'taxonomy' => 'issue_month',
			'field' => 'id',
			'terms' => $term->term_id
		)
	));
	return new WP_Query($args);
}
function the_issue_link($issue_month){
	$da_query = get_raw_issue($issue_month);
	if($da_query->have_posts()) { $da_query->the_post();
		the_full_title_1();
	}
}
function the_issue_image($issue_month, $size = ""){
	$da_query = get_raw_issue($issue_month);
	if($da_query->have_posts()) { $da_query->the_post();
		if(has_post_thumbnail()){
			the_post_thumbnail($size);
		}
	}
}



	function get_placard($issue_month = 'september_2012'){
		$term = get_term_by( 'slug', $issue_month, 'issue_month' );
		$name = $term->name;
				
		$args = array('post_type' => 'issue', 	
		'tax_query' => array(
			array(
				'taxonomy' => 'issue_month',
				'field' => 'id',
				'terms' => $term->term_id
			)
		));
		$da_query = new WP_Query($args);
		if($da_query->have_posts()){
		$da_query->the_post();

		$arr = explode(' ',trim($name));
		$first_month = $arr[0];
		
		$background_image = get_post_meta(get_the_id(), 'issue_background', true);
?>
		<div class="backface-wrapper">
				<?php
				if(!is_single()){
					the_full_title_1();
					if(has_post_thumbnail(get_the_id())){
						the_post_thumbnail('medium');
					}else{
				?>
					<img id="cover" src="<?php echo get_template_directory_uri(); ?>/images/issue.png" />
				<?php
					}
				?></a>
				<?php
				}
				?>		
			<div id="text">
			<?php
				if(is_single()){
?>

<?php
				}else{
?>
				<h2 class="">In the <?php the_full_title_1();echo $first_month; ?> Issue</a></h2>

<?php
				}
			?>
				<div class="sans-serif2 bold font16 uppercase front-page-stories">Front Page Stories</div>
				<ul>
<?php
				$args = array(
					'posts_per_page' => 3,
					'order' => 'ASC',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'page_num',
							'field' => 'slug',
							'terms' => 'a1'
						),
						array(
							'taxonomy' => 'issue_month',
							'field' => 'slug',
							'terms' => $issue_month	
						)
					)
				);
				$the_query = new WP_Query( $args );
				while ( $the_query->have_posts() ) : $the_query->the_post();
?>
					<article>
						<li>
							<p class="font20 bold title"><?php the_full_title(); ?></p>
						</li>
						<div class="sans-serif1 font12 excerpt">
							<?php the_excerpt(); ?>						
						</div>
					</article>
<?php
				endwhile;
				wp_reset_query();
?>
				<?php
					if(!is_single()){
				?>
				<div class="more"><?php the_issue_link($issue_month); ?>See all of <?php just_tell_me($issue_month); ?> Issue >></a></div>
				<?php
					}
				?>

				</ul>
			</div>
		</div>
		<style>
			.backface-wrapper{
				position:relative;
				min-height:450px !important;
				background-image: url('<?php if($background_image != ''){echo $background_image;}else{echo get_template_directory_uri()."/images/placard.jpg"; } ?>') !important;
				background-size:cover !important;
				background-position:center center !important;
			}
			.backface-wrapper img{
				position:absolute;
				top:49px;
				left:99px;
				height:348px;
				width:227px;
				border:1px solid #888;
				opacity:.80;
			}
			.backface-wrapper img:hover{
				opacity:.95;
			}	
			.backface-wrapper #text{
				position:absolute;
				top:50px;
				width:auto;
				padding-right:20px;
				left:355px;
				color:white;

			}
			.backface-wrapper #text h2{
				color:white;
				margin-top:-15px;
				margin-left:20px;
				font-size:56px;
				text-shadow:2px 1px 4px black;
			}
			.backface-wrapper #text h2 a{
				color:white;
				display:inline;
			}
			.backface-wrapper #text ul .more{
				margin-left:15px;
				font-family:Helvetica, Arial;
				text-transform:uppercase;
				font-size:13px;
			}
			.backface-wrapper #text ul .more a{
				color:white;
			}
			.backface-wrapper ul{
				margin-top:5px;
				padding:5px 20px 10px 20px;
				width:450px;
				background:rgba(0,0,0,.8);
			}
			.backface-wrapper ul li{
				list-style-type:square;
				list-style-position:outside;
				margin-left:17px;
				margin-top:5px;
			}
			.backface-wrapper ul li a{
				color:white;
			}
			.backface-wrapper .excerpt{
				margin-left:18px;
			}
			.backface-wrapper article{
				margin-bottom:10px;
			}
			.backface-wrapper article .title{
				line-height:1em;
				margin-bottom:5px;
			}
			.front-page-stories{
				margin:0 20px;
				margin-top:10px;
				text-shadow:1px 1px 4px black;
			}
		</style>
<?php
		}
	}
	
	
	function the_issue_box(){
		$is_old = is_object_in_term( get_the_id(), 'is_old_issue', 'yes' );

	if( $is_old ){

?>
	<div class="issue-box">
		<div class="issue-month sans-serif2 bold"><?php the_title(); ?></div>
		<?php the_content(); ?>
	</div>
<?php
	}else{
?>
			<a href="<?php the_permalink(); ?>">
				<div class="issue-box">
					<div class="issue-month sans-serif2 bold"><?php the_title(); ?></div>
				<?php
					if(has_post_thumbnail(get_the_id())){
						the_post_thumbnail('medium');
					}else{
				?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/issue.png" />
				<?php
				}
				?>
				</div>
			</a>
<?php	
	}
?>
<?php
	}
function term_name_from_slug($slug){
	$term = get_term_by( 'slug', $slug, 'issues' );
	return $term->name;
}
function get_current_month_alone(){
	$arr = explode(' ',trim(get_option('current_issue_month')));
	return $arr[0];
}


function section_box($post_type){
?>
				<div class="one">
<?php
			if($post_type == 'news'){
				$tax_query = array(
					array(
						'taxonomy' => 'page_num',
						'field' => 'slug',
						'terms' => array( 'a1', 'a2', 'a3' )
					)
				);
			}elseif($post_type == 'sports'){
				$tax_query = array(
					array(
						'taxonomy' => 'page_num',
						'field' => 'slug',
						'terms' => array( 'c1', 'c2' )
					)
				);
			}elseif($post_type == 'features'){
				$tax_query = array(
					array(
						'taxonomy' => 'page_num',
						'field' => 'slug',
						'terms' => array( 'b1', 'b2', 'b3' )
					)
				);
			}elseif($post_type == 'opinion'){
				$tax_query = array(
					array(
						'taxonomy' => 'page_num',
						'field' => 'slug',
						'terms' => array( 'a12', 'a13', 'a14' )
					)
				);
			}
			$query = new WP_Query(array( 'post_type' => $post_type, 'issue_month' => $this_month, 'tax_query' => $tax_query, 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
?>
					<div class="image1 left">
						<?php the_full_title_1(); ?>
						<?php the_post_thumbnail(); ?>
						<?php echo "</a>"; ?>
					</div>
					<div class="text right">
						<h3><?php the_full_title(); ?></h3>
						<div class="writer mini gray uppercase">By <?php yo_author(); ?></div>
						<div class="sans-serif1 font11 excerpt"><?php the_excerpt(); ?></div>
					</div>
					<div class="clear"></div>
<?php
			}
			wp_reset_query();
?>
				</div>
				<hr class="nonflair" />
<?php
			$query = new WP_Query(array( 'post_type' => $post_type, 'issue_month' => $this_month, 'tax_query' => $tax_query, 'posts_per_page' => 2, 'post__not_in' => $poet) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
?>
				<div class="two">
					<div class="text right">
						<h3><?php the_full_title(); ?></h3>
						<div class="writer mini gray uppercase">By <?php yo_author(); ?></div>
						<div class="sans-serif1 font11 excerpt"><?php the_excerpt(); ?></div>
					</div>
					<div class="clear"></div>
				</div>
<?php
			}
			if($query->have_posts()) { $query->the_post();

?>
				<div class="two">
					<div class="text right">
						<h3><?php the_full_title(); ?></h3>
						<div class="writer mini gray uppercase">By <?php yo_author(); ?></div>
						<div class="sans-serif1 font11 excerpt"><?php the_excerpt(); ?></div>
					</div>
					<div class="clear"></div>
				</div>
<?php
			}
			wp_reset_query();
}

function i_have_no_friends($issue_month){
	$left = false;
	$count = 1;
	$backgroun_array = array();
	$list = get_list_page_num_slug();
	foreach($list as $page){
?>

    <div class="loser-row" id="<?php echo strtoupper($page); ?>">
        <div class="loser-left">
            <h2 id="november">Page</h2>
        </div>
        <div class="loser-right">
            <h2><?php echo strtoupper($page); ?></h2>
        </div>
    </div>

<?php
		
		$tax_query = array(
			array(
				'taxonomy' => 'page_num',
				'field' => 'slug',
				'terms' => $page
			)
		);
		$query = new WP_Query(array( 'issue_month' => $issue_month, 'tax_query' => $tax_query, 'posts_per_page' => -1) );
		while($query->have_posts()) { $query->the_post();
			$wp_query->in_the_loop = false;
			
			$count++;
			$last_was_left = !$last_was_left;
			if($last_was_left){
?>
		    <div class="loser-row loser-medium">
		        <div class="loser-left">
			<?php
				if(has_post_thumbnail()){
			?>
		            <a href="<?php the_permalink(); ?>" class="loser-circle loser-circle-deco loser-circle-<?php echo $count; ?>"></a>
			<?php
				}
			?>
		        </div>
		        <div class="loser-right">
		            <h3 class="<?php echo get_post_type(); ?>">
		                <span class="top uppercase"><?php echo get_post_type(); ?></span>
		                <?php the_full_title(); ?>
		            </h3>
		        </div>
		    </div>
<?php
			}else{
?>
		    <div class="loser-row loser-medium">
		        <div class="loser-left">
		            <h3 class="<?php echo get_post_type(); ?>">
		                <span class="top uppercase"><?php echo get_post_type(); ?></span>
		                <?php the_full_title(); ?>
		            </h3>
		        </div>
		        <div class="loser-right">
			<?php
				if(has_post_thumbnail()){
			?>
		            <a href="<?php the_permalink(); ?>" class="loser-circle loser-circle-deco loser-circle-<?php echo $count; ?>"></a>
			<?php
				}
			?>
		        </div>
		    </div>
<?php
			}
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
			$url = $thumb['0'];
			$background_array[$count] = $url;
		}
		wp_reset_query();
	}
	echo "<style>";
	foreach($background_array as $key => $bg){
		echo '.loser-circle-'.$key.'{background-image:url(\''.$bg.'\');}';
	}
	echo "</style>";
	
}

	function section_tri($post_type, $what_type, $type){
			global $poet, $wp_query;
			$query = new WP_Query(array( 'post_type' => $post_type, $what_type => $type, 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
		<div class="one">
			<div class="image1">
				<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}
				?>	
			</div>
			<div class="second">
				<div class="font16 bold title">
					<?php the_full_title(); ?>
				</div>
				<div class="mini gray uppercase sans-serif1">
					By <?php yo_author(); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<hr class="nonflair"/>
		<?php
			}
			$query = new WP_Query(array( 'post_type' => $post_type, $what_type => $type, 'posts_per_page' => 4, 'post__not_in' => $poet ) );
			
			while($query->have_posts()) : $query->the_post();
			$poet[] = get_the_ID();
		?>
		
		<div class="two">
			<div class="title bold left font14">
				<?php the_full_title(); ?>
			</div>
			<div class="date red mini right uppercase sans-serif1">
				<?php the_checked_date(); ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php
			endwhile;
	}
	function section_tri_sans($post_type, $what_type, $type){
			global $poet, $wp_query;
			$query = new WP_Query(array( 'post_type' => $post_type, $what_type => $type, 'posts_per_page' => 1, 'post__not_in' => $poet ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
		<div class="one">
			<div class="second">
				<div class="font16 bold title">
					<?php the_full_title(); ?>
				</div>
				<div class="mini gray uppercase sans-serif1">
					By <?php yo_author(); ?>
				</div>
				<div class="sans-serif1 excerpt font11">
					<?php the_excerpt(); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<hr class="nonflair"/>
		<?php
			}
			$query = new WP_Query(array( 'post_type' => $post_type, $what_type => $type, 'posts_per_page' => 2, 'post__not_in' => $poet ) );
			
			while($query->have_posts()) : $query->the_post();
			$poet[] = get_the_ID();
		?>
		
		<div class="two">
			<div class="title bold left font14">
				<?php the_full_title(); ?>
			</div>
			<div class="date red mini right uppercase sans-serif1">
				<?php the_checked_date(); ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php
			endwhile;
	}
	
	function opinion_column($issue_month, $count){
		global $poet, $wp_query;
		$query = new WP_Query(array( 'post_type' => 'opinion', 'issue_month' => $issue_month, 'posts_per_page' => $count, 'opinion_type' => "column", 'post__not_in' => $poet) );
		while($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		$wp_query->in_the_loop = true;
	?>
			<article <?php post_class(); ?>>
				<div class="mini-profile left">
					<?php the_full_title_1(); ?>
					<?php
						$i = new CoAuthorsIterator();
						$i->iterate();
					?>
					<?php userphoto_the_author_photo(); ?>
					</a>
				</div>
				<div class="columns-article left">
					<p class="font20 bold"><?php the_full_title(); ?></p>
					<p class="uppercase gray mini left">By <?php the_author(); ?></p>
					<div class="clear"></div>
					<div class="sans-serif1 font12 "><?php the_excerpt(); ?></div>
				</div>
				<div class="clear"></div>
			</article>
	<?php
		}
	}
	function opinion_blog(){
		global $poet, $wp_query;
		$query = new WP_Query(array( 'post_type' => 'opinion', 'opinion_type' => 'blog', 'posts_per_page' => 1, 'post__not_in' => $poet) );
		if($query->have_posts()) { $query->the_post();
		$poet[] = get_the_ID();
		$wp_query->in_the_loop = true;
	?>
			<article <?php post_class(); ?>>
				<div class="mini-profile left">
					<?php the_full_title_1(); ?>
					<?php
						$i = new CoAuthorsIterator();
						$i->iterate();
					?>
					<?php userphoto_the_author_photo(); ?>
					</a>
				</div>
				<div class="blog-article left">
					<p class="font20 bold"><?php the_full_title(); ?></p>
					<p class="uppercase gray mini left">By <?php the_author(); ?></p>
					<div class="clear"></div>
					<div class="sans-serif1 font12 "><?php the_excerpt(); ?></div>
				</div>
				<div class="clear"></div>
			</article>
	<?php
		}
	}
	function picture_feature($month){
			global $poet, $wp_query;
			$query = new WP_Query(array( 'post_type' => 'features', 'issue_month' => $month, 'features_importance' => 'picture_feature', 'posts_per_page' => 1, 'post__not_in' => $poet ) );
			while($query->have_posts()) { $query->the_post();
				$wp_query->in_the_loop = true;
				$poet[] = get_the_ID();
		?>
		<h4 class="usatoday uppercase features"><?php echo get_post_meta(get_the_ID(), 'special_label', true); ?></h4>
		<div class="annoyingbar"></div>
		<div class="image1">
			<?php
			if(has_post_thumbnail()){
				echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
				echo yo_post_thumbnail("thumbnail", get_the_ID());
				echo '</a>';
			}
			?>	
		</div>
		<div class="text">
			<div class="font18 bold title">
				<?php the_full_title(); ?>
			</div>
			<div class="mini gray uppercase">
				By <?php yo_author(); ?>
			</div>
			<div class="sans-serif1 font11 justify">
				<?php the_excerpt(); ?>
			</div>
		</div>
		
		<?php
			}
	}
	
	function offbeat($post_type, $type, $value){
			global $poet, $wp_query;
			$query = new WP_Query(array( 'post_type' => $post_type, $type => $value, 'posts_per_page' => 1, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
		<div class="one">
			<div class="image1">
				<?php
				if(has_post_thumbnail()){
					echo '<a title="';the_title_attribute();echo '" href="';the_permalink();echo '">';
					echo yo_post_thumbnail("thumbnail", get_the_ID());
					echo '</a>';
				}
				?>	
			</div>
		</div>
		<div class="two">
			<div class="font14 bold">
				<?php the_full_title(); ?>
			</div>
			<div class="">
				<div class="left uppercase gray mini">
					By <?php yo_author(); ?>
				</div>
				<div class="right mini red">
					<?php the_checked_date(); ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php
			}
	}
	function section_video($video_type){
			global $poet, $wp_query;
			if($video_type == 'news'){
				$query = new WP_Query(array( 'post_type' => 'video', 'video_type' => 'news_video', 'posts_per_page' => 1, 'post__not_in' => $poet ) );
			}elseif($video_type == 'sports'){
				$query = new WP_Query(array( 'post_type' => 'video', 'video_type' => 'sports_video', 'posts_per_page' => 1, 'post__not_in' => $poet ) );
			}else{
				$query = new WP_Query(array( 'post_type' => 'video', 'video_type' => 'features_video', 'posts_per_page' => 1, 'post__not_in' => $poet ) );
			}
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;

		?>
		<div class="one">
			<div class="image1">
				<?php the_full_title_1(); ?>
				<img id="overlay" src="<?php echo get_template_directory_uri(); ?>/images/playbutton.png" height="120" width="180">
				<img src="<?php video_thumbnail(); ?>" />
				</a>
			</div>
		</div>
		<div class="two">
			<div class="font14 bold">
				<?php the_full_title(); ?>
			</div>
		</div>
		<?php
			}
	}
	function features_ae($issue_month) {
			global $poet, $wp_query;
			$query = new WP_Query(array( 'post_type' => 'ae', 'issue_month' => $issue_month, 'posts_per_page' => 1, 'post__not_in' => $poet, 'meta_key' => '_thumbnail_id' ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
		<div class="uno">
			<div class="one">
				<?php package_thumbnail(); ?>
			</div>
			<div class="two">
				<div class="font14 title bold">
					<?php the_full_title(); ?>
				</div>
				<div class=" sans-serif1 uppercase mini author gray">
					By <?php yo_author(); ?>
				</div>
			</div>
		</div>
		<hr class="nonflair" />
		<?php
			}
			$query = new WP_Query(array( 'post_type' => 'ae', 'issue_month' => $issue_month, 'posts_per_page' => 2, 'post__not_in' => $poet ) );
			while($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
		<div class="dos">
			<div class="one">
				<div class="mini gray left sans-serif1 uppercase">
					Upper School
				</div>
				<div class="red mini right sans-serif1 uppercase">
					<?php the_checked_date(); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="two">
				<div class="font12 title bold">
					<?php the_full_title(); ?>
				</div>
			</div>
		</div>
		<?php
			}
	}
	function sports_box($type){
			global $poet, $wp_query;
			$count = 0;
			$query = new WP_Query(array( 'post_type' => 'sports', 'sports_type' => $type, 'posts_per_page' => 4, 'post__not_in' => $poet ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<article class="one">
				<div class="bold title font20"><?php the_full_title(); ?></div>
				<div class="gray mini author uppercase sans-serif1">By <?php yo_author(); ?></div>
				<div class="excerpt font11 sans-serif1"><?php the_excerpt(); ?></div>
			</article>
			<hr class="nonflair" />
		<?php
			}
			while($query->have_posts()) { $query->the_post();
				$poet[] = get_the_id();
				$wp_query->in_the_loop = true;
				
		?>
			<article class="two">
				<div class="bold title font14 left">
					<?php the_full_title(); ?>
				</div>
				<div class="red mini date right"><?php the_checked_date(); ?></div>
				<div class="clear"></div>
			</article>
		<?php
			}
	}
	function more_sports(){
			global $poet, $wp_query;
			$type = 'more_sports';
			$count = 0;
			$query = new WP_Query(array( 'post_type' => 'sports', 'sports_type' => $type, 'posts_per_page' => 4, 'post__not_in' => $poet ) );
			while($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
		?>
			<article class="one">
				<div class="font20 bold">
					<?php the_full_title(); ?>
				</div>
				<div class="left mini uppercase gray">By <?php yo_author(); ?></div>
				<div class="right mini red"><?php the_checked_date(); ?></div>
				<div class="clear"></div>
			</article>
		<?php
			if($count != 3){
				echo '<hr class="nonflair" />';
				$count++;
			}
		}
	}
	
	function sports_box_short($type){
			global $poet, $wp_query;
			$count = 0;
			$query = new WP_Query(array( 'post_type' => 'sports', 'sports_type' => $type, 'posts_per_page' => 3, 'post__not_in' => $poet ) );
			if($query->have_posts()) { $query->the_post();
			$poet[] = get_the_ID();
			$wp_query->in_the_loop = true;
	?>
			<article class="one">
				<div class="font16 bold">
					<?php the_full_title(); ?>
				</div>
				<div class="left mini uppercase gray">By <?php yo_author(); ?></div>
				<div class="right mini red"><?php the_checked_date(); ?></div>
				<div class="clear"></div>
			</article>
			<hr class="nonflair" />
	<?php
			}
			if($query->have_posts()) { $query->the_post();
	?>
			<article class="two">
				<div class="bold title font12 left">
					<?php the_full_title(); ?>
				</div>
				<div class="red mini date right"><?php the_checked_date(); ?></div>
				<div class="clear"></div>
			</article>
	<?php
			}
	}
?>