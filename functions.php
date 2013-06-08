<?php
include 'functions2.php';
    @ini_set( 'upload_max_size' , '20M' );
    @ini_set( 'post_max_size', '20M');
    @ini_set( 'max_execution_time', '300' );
/*
if (
  !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))
  && !is_admin()
  && !is_user_logged_in()
) {
  wp_redirect('http://chronicle.hw.com', 302);
  exit;
}
*/

function my_custom_login_logo() {
    echo '<style type="text/css">
        h1{margin-bottom:20px !important;}h1 a { margin: 0 auto !important; padding-bottom: 0px !important;margin-bottom:10px; background-image:url('.get_bloginfo('template_directory').'/images/cool/custom-logo.png) !important;background-size:100% 100% !important; height:140px !important; width:140px !important; }
    </style>';
}

add_action('login_head', 'my_custom_login_logo');

function say_adios_to_howdy($translation, $text, $domain) {
    if ($text == 'Howdy, %1$s')
        $translation = '%1$s';
 
    return $translation;
}
 
add_filter('gettext', 'say_adios_to_howdy', 10, 3);


/*
if ( ! function_exists( 'fb_set_featured_image' ) ) {
	add_action( 'save_post', 'fb_set_featured_image' );
	function fb_set_featured_image() {
			
			if ( ! isset( $GLOBALS['post']->ID ) )
				return NULL;
				
			if ( has_post_thumbnail( get_the_ID() ) )
				return NULL;
			
			$args = array(
				'numberposts'    => 1,
				'order'          => 'ASC', // DESC for the last image
				'post_mime_type' => 'image',
				'post_parent'    => get_the_ID(),
				'post_status'    => NULL,
				'post_type'      => 'attachment'
			);
			
			$attached_image = get_children( $args );
			if ( $attached_image ) {
				foreach ( $attached_image as $attachment_id => $attachment )
					set_post_thumbnail( get_the_ID(), $attachment_id );
			}
			
	}
}
*/

// Change author to staff
add_action('init', 'set_new_author_base');
function set_new_author_base() {
    global $wp_rewrite;
    $author_slug = 'staff';
    $wp_rewrite->author_base = $author_slug;
}

// Part 1 of the hard work
add_filter( 'request', 'wpse5742_request' );
function wpse5742_request( $query_vars )
{
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='nickname' AND meta_value = %s", $query_vars['author_name'] ) );
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );    
        }
    }
    return $query_vars;
}

//Part 2 of the hard work

add_filter( 'author_link', 'wpse5742_author_link', 10, 3 );
function wpse5742_author_link( $link, $author_id, $author_nicename )
{
    $author_nickname = get_user_meta( $author_id, 'nickname', true );
    if ( $author_nickname ) {
        $link = str_replace( $author_nicename, $author_nickname, $link );
    }
    return $link;
}



add_action('show_user_profile', 'my_user_profile_edit_action');
add_action('edit_user_profile', 'my_user_profile_edit_action');
function my_user_profile_edit_action($user) {

?>
  <h3>Other</h3>
  <label for="section">Section: </label>
    <input name="section" type="text" id="section" value="<?php echo $user->section ?>">
<?php 
}
add_action('personal_options_update', 'my_user_profile_update_action');
add_action('edit_user_profile_update', 'my_user_profile_update_action');
function my_user_profile_update_action($user_id) {
  update_user_meta($user_id, 'section', isset($_POST['section']));
}

function curmonth(){
	return get_option('current_issue_month');
}

function curyear(){
	return get_option('current_issue_year');
}


//Remove Pages from search

function remove_pages_from_search() {
    global $wp_post_types;
    $wp_post_types['page']->exclude_from_search = true;
}
add_action('init', 'remove_pages_from_search');


function customAdmin() {
    $url = get_settings('siteurl');
    $url = $url . '/wp-content/themes/my-theme/styles/wp-admin.css';
    echo '<!-- custom admin css -->
          <style>
          	#wp_dashboard_chat .inside #new_message textarea{
          		display:block !important;
          	}
          	#wp-admin-bar-wp-logo{
          		display:none !important;
          	}
			.coauthor-gravatar{
				display:none !important;
			}
			.coauthor-tag{
				border-bottom:none !important;
			}
			.coauthor-tag:hover{
				cursor:move !important;
			}
          </style>
          <!-- /end custom admin css -->';
}
add_action('admin_head', 'customAdmin');

function removeStupidCircle(){
	echo "<style>
          	#wp-admin-bar-wp-logo{
          		display:none !important;
          	}
          </style>";
}
add_action('wp_head', 'removeStupidCircle');

	    date_default_timezone_set('America/Los_Angeles');


        // Translations can be filed in the /languages/ directory
        load_theme_textdomain( 'html5reset', TEMPLATEPATH . '/languages' );
 
        $locale = get_locale();
        $locale_file = TEMPLATEPATH . "/languages/$locale.php";
        if ( is_readable($locale_file) )
            require_once($locale_file);
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
	function my_jquery_enqueue() {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
	   wp_enqueue_script('jquery');
	}

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    // Add support for the sidebar
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => __('Sidebar Widgets','html5reset' ),
    		'id'   => 'sidebar-widgets',
    		'description'   => __( 'These are widgets for the sidebar.','html5reset' ),
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }
    
    add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.

	// Allow featured post image sizes
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 234, 156, true );
/* 	add_image_size( 'article-image', 640, 9999, false ); //The New Large*/
	add_image_size( 'archive-photo', 750, 500, true ); //The New Medium
	add_image_size( 'section-slider', 540, 360, true ); //The New Medium
	add_image_size( 'single-article', 640, 9999, false );
	add_image_size( 'single-top', 75, 50, true );
	add_image_size( 'issue-thumb', 175, 270, true );
	
	// Add function for image caption

add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}



	function the_post_thumbnail_caption(){
		echo get_post(get_post_thumbnail_id())->post_excerpt;
	}
	
	// WHY DO WE FALL?	
	function remove_footer_admin () {
	    echo "You are currently logged in to The Harvard-Westlake Chronicle";
	}
	add_filter('admin_footer_text', 'remove_footer_admin');
	
	// Remove dashboard widgets
	function example_remove_dashboard_widgets() {
	    // Globalize the metaboxes array, this holds all the widgets for wp-admin
	    global $wp_meta_boxes;
	 
	    // Remove the incomming links widget
	    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);   
	 
	    // Remove right now
	    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
 
	// Hoook into the 'wp_dashboard_setup' action to register our function
	add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );

	function example_dashboard_widget_function() {
	// Display whatever it is you want to show
	echo "";
	} 
	
	// Create the function use in the action hook
	function example_add_dashboard_widgets() {
	wp_add_dashboard_widget('example_dashboard_widget', 'General Info', 'example_dashboard_widget_function');
	}
	// Hoook into the 'wp_dashboard_setup' action to register our other functions
	add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );

	// Enable editing for everyone
	function add_theme_caps() {
		$role = get_role( 'author' );
		$role->add_cap( 'edit_others_posts' ); // would allow the author to edit others' posts for current theme only
		
		$role = get_role( 'contributor' );
		$role->add_cap( 'edit_others_posts' ); // would allow the author to edit others' posts for current theme only
		$role->add_cap( 'edit_published_posts' ); // would allow the author to edit others' posts for current theme only
	}
	add_action( 'admin_init', 'add_theme_caps');
	
	
	
	
	
	// Shortcut function to echo out linked title
	function the_full_title(){
	?>
		 <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
	<?php
	}
	function the_full_title_1($id = ""){
	?>
		 <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?><?php if($id){ ?>#jp-carousel-<?php echo $id; } ?>">
	<?php
	}
	function the_full_title_2(){
	?>
		 </a>
	<?php
	}
	
	// Yo Author 
	function yo_author(){
		if(function_exists('coauthors_posts_links')){
			$i = new CoAuthorsIterator();
			print $i->count() == 1 ? '' : '';
			$i->iterate();
			the_author();
			while($i->iterate()){
			    print $i->is_last() ? ' and ' : ', ';
			    the_author();
			}
		}else{
			the_author();
		}
	}
	function yo_break_author(){
		if(function_exists('coauthors_posts_links')){
			$i = new CoAuthorsIterator();
			print $i->count() == 1 ? '' : '';
			$i->iterate();
			the_author();
			while($i->iterate()){
			    print $i->is_last() ? '<br/>and ' : ',<br/>';
			    the_author();
			}
		}else{
			the_author();
		}
	}
	
add_filter('the_content', 'remove_img_titles');
add_filter('post_thumbnail_html', 'remove_img_titles');

function remove_img_titles($text) {

    // Get all title="..." tags from the html.
    $result = array();
    preg_match_all('|title="[^"]*"|U', $text, $result);

    // Replace all occurances with an empty string.
    foreach($result[0] as $img_tag) {
        $text = str_replace($img_tag, '', $text);
    }

    return $text;
}
	
	
	
	// Unregister category as a taxonomy
	
	add_action( 'init', 'unregister_taxonomy');
	function unregister_taxonomy(){
/* 		register_taxonomy('category', array()); */
	}
	
/* 	Remove Posts from admin menu */
	function remove_menus () {
		global $menu;
		$restricted = array(/* __('Posts'),  */__('Links'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
		if ( !current_user_can( 'manage_options' ) ) {
			$restricted = array(__('Posts'), __('Issue'));
			end ($menu);
			while (prev($menu)){
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
			}
		} 
	}
	add_action('admin_menu', 'remove_menus');

	function change_post_menu_label() {
	    global $menu;
	    global $submenu;
	    $menu[5][0] = 'Archives';
	    $submenu['edit.php'][5][0] = 'Archive';
	    $submenu['edit.php'][10][0] = 'Add Archive';
	    echo '';
	}
	
	function change_post_object_label() {
	    global $wp_post_types;
	    $labels = &$wp_post_types['post']->labels;
	    $labels->name = 'Archives';
	    $labels->singular_name = 'Archives';
	    $labels->add_new = 'Add Archives';
	    $labels->add_new_item = 'Add Archives';
	    $labels->edit_item = 'Edit Archives';
	    $labels->new_item = 'Archives';
	    $labels->view_item = 'View Archives';
	    $labels->search_items = 'Search Archives';
	    $labels->not_found = 'No Archives found';
	    $labels->not_found_in_trash = 'No Archives found in Trash';
	}
	add_action( 'init', 'change_post_object_label' );
	add_action( 'admin_menu', 'change_post_menu_label' );














/* 	Hide posts */
	function remove_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('new-post');
	}
	add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );









    // Issue Year ----------------------------------------------------
    add_action( 'init', 'register_taxonomy_year' );
	function register_taxonomy_year() {
	
	    $labels = array( 
	        'name' => _x( 'Year', 'year' ),
	        'singular_name' => _x( 'Year', 'year' ),
	        'search_items' => _x( 'Search Year', 'year' ),
	        'popular_items' => _x( 'Popular Year', 'year' ),
	        'all_items' => _x( 'All Year', 'year' ),
	        'parent_item' => _x( 'Parent Year', 'year' ),
	        'parent_item_colon' => _x( 'Parent Year:', 'year' ),
	        'edit_item' => _x( 'Edit Year', 'year' ),
	        'update_item' => _x( 'Update Year', 'year' ),
	        'add_new_item' => _x( 'Add New Year', 'year' ),
	        'new_item_name' => _x( 'New Year', 'year' ),
	        'separate_items_with_commas' => _x( 'Separate year with commas', 'year' ),
	        'add_or_remove_items' => _x( 'Add or remove Year', 'year' ),
	        'choose_from_most_used' => _x( 'Choose from most used Year', 'year' ),
	        'menu_name' => _x( 'Year', 'year' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'issues', 'issue', $args );
    }
    
    // Is other publication ----------------------------------------------------
    add_action( 'init', 'register_taxonomy_other_publication' );
	function register_taxonomy_other_publication() {
	
	    $labels = array( 
	        'name' => _x( 'Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'singular_name' => _x( 'Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'search_items' => _x( 'Search Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'popular_items' => _x( 'Popular Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'all_items' => _x( 'All', 'other' ),
	        'parent_item' => _x( 'Parent Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'parent_item_colon' => _x( 'Parent Is from other publication (not Chronicle)?:', 'Is from other publication (not Chronicle)?' ),
	        'edit_item' => _x( 'Edit Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'update_item' => _x( 'Update Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'add_new_item' => _x( 'Add New Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'new_item_name' => _x( 'New Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'separate_items_with_commas' => _x( 'Separate Is from other publication (not Chronicle)? with commas', 'Is from other publication (not Chronicle)?' ),
	        'add_or_remove_items' => _x( 'Add or remove Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'choose_from_most_used' => _x( 'Choose from most used Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	        'menu_name' => _x( 'Is from other publication (not Chronicle)?', 'Is from other publication (not Chronicle)?' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'is_other_publication', 'issue', $args );
    }	
    	
    // Is Old Issue ----------------------------------------------------
    add_action( 'init', 'register_taxonomy_old_issue' );
	function register_taxonomy_old_issue() {
	
	    $labels = array( 
	        'name' => _x( 'Issue is from the old site?', 'issue is from the old site?' ),
	        'singular_name' => _x( 'Issue is from the old site?', 'issue is from the old site?' ),
	        'search_items' => _x( 'Search Issue is from the old site?', 'issue is from the old site?' ),
	        'popular_items' => _x( 'Popular Issue is from the old site?', 'issue is from the old site?' ),
	        'all_items' => _x( 'All Issue is from the old site?', 'issue is from the old site?' ),
	        'parent_item' => _x( 'Parent Issue is from the old site?', 'issue is from the old site?' ),
	        'parent_item_colon' => _x( 'Parent Issue is from the old site?:', 'issue is from the old site?' ),
	        'edit_item' => _x( 'Edit Issue is from the old site?', 'issue is from the old site?' ),
	        'update_item' => _x( 'Update Issue is from the old site?', 'issue is from the old site?' ),
	        'add_new_item' => _x( 'Add New Issue is from the old site?', 'issue is from the old site?' ),
	        'new_item_name' => _x( 'New Issue is from the old site?', 'issue is from the old site?' ),
	        'separate_items_with_commas' => _x( 'Separate issue is from the old site? with commas', 'issue is from the old site?' ),
	        'add_or_remove_items' => _x( 'Add or remove Issue is from the old site?', 'issue is from the old site?' ),
	        'choose_from_most_used' => _x( 'Choose from most used Issue is from the old site?', 'issue is from the old site?' ),
	        'menu_name' => _x( 'Issue is from the old site?', 'issue is from the old site?' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'is_old_issue', 'issue', $args );
    }		


	// Front -------------------------------------------------
	add_action( 'init', 'register_taxonomy_front' );
	function register_taxonomy_front() {
	
	    $labels = array( 
	        'name' => _x( 'Front (M-Team only)', 'front' ),
	        'singular_name' => _x( 'Front', 'front' ),
	        'search_items' => _x( 'Search Front', 'front' ),
	        'popular_items' => _x( 'Popular Front', 'front' ),
	        'all_items' => _x( 'All Front', 'front' ),
	        'parent_item' => _x( 'Parent Front', 'front' ),
	        'parent_item_colon' => _x( 'Parent Front:', 'front' ),
	        'edit_item' => _x( 'Edit Front', 'front' ),
	        'update_item' => _x( 'Update Front', 'front' ),
	        'add_new_item' => _x( 'Add New Front', 'front' ),
	        'new_item_name' => _x( 'New Front', 'front' ),
	        'separate_items_with_commas' => _x( 'Separate front with commas', 'front' ),
	        'add_or_remove_items' => _x( 'Add or remove Front', 'front' ),
	        'choose_from_most_used' => _x( 'Choose from most used Front', 'front' ),
	        'menu_name' => _x( 'Front', 'front' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'unfiltered_html'
            )
	    );
	
	    register_taxonomy( 'front', array('news', 'sports', 'features', 'ae', 'opinion', 'video', 'broadcasts', 'photo'), $args );
    }	





			
						
	// Add Sports
	add_action( 'init', 'register_cpt_chronicle' );
	function register_cpt_chronicle() {
		
		$types = array('news', 'sports', 'features', 'opinion', 'ae', 'video', 'broadcast', 'photo');
		
		foreach($types as $type){
			if($type == "ae"){
				$Type = "A&E";
			}else{
				$Type = ucfirst($type);
			}
		    $labels = array( 
		        'name' => _x( $Type, $type ),
		        'singular_name' => _x( $Type, $type ),
		        'add_new' => _x( 'Add New', $type ),
		        'add_new_item' => _x( 'Add New '.$Type, $type ),
		        'edit_item' => _x( 'Edit This '.$Type.' Article', $type ),
		        'new_item' => _x( 'New '.$Type, $type ),
		        'view_item' => _x( 'View Article', $type ),
		        'search_items' => _x( 'Search '.$Type, $type ),
		        'not_found' => _x( 'No '.$type.' found', $type ),
		        'not_found_in_trash' => _x( 'No '.$type.' found in Trash', $type ),
		        'parent_item_colon' => _x( 'Parent '.$Type.':', $type ),
		        'menu_name' => _x( $Type, $type ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => $Type.' Articles for the Harvard-Westlake Chronicle',
		        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions'),
		        
		        'public' => true,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'menu_position' => null,
		        
		        'show_in_nav_menus' => true,
		        'publicly_queryable' => true,
		        'exclude_from_search' => false,
		        'has_archive' => true,
		        'query_var' => true,
		        'can_export' => true,
		        'rewrite' => true,
		        'capability_type' => 'post',
		        'taxonomies' => array('front', 'post_tag')
		    );
		
		    register_post_type( $type, $args );
	    }
	    flush_rewrite_rules( true );
    }	


	add_action( 'init', 'register_cpt_print_issues' );
	function register_cpt_print_issues() {
		
		$types = array('Issue');
		
		foreach($types as $type){
			$Type = 'Issue';
		    $labels = array( 
		        'name' => _x( $Type, $type ),
		        'singular_name' => _x( $Type, $type ),
		        'add_new' => _x( 'Add New', $type ),
		        'add_new_item' => _x( 'Add New '.$Type, $type ),
		        'edit_item' => _x( 'Edit This '.$Type, $type ),
		        'new_item' => _x( 'New '.$Type, $type ),
		        'view_item' => _x( 'View Article', $type ),
		        'search_items' => _x( 'Search '.$Type, $type ),
		        'not_found' => _x( 'No '.$type.' found', $type ),
		        'not_found_in_trash' => _x( 'No '.$type.' found in Trash', $type ),
		        'parent_item_colon' => _x( 'Parent '.$Type.':', $type ),
		        'menu_name' => _x( $Type, $type ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => $Type.' Articles for the Harvard-Westlake Chronicle',
		        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
		        
		        'public' => true,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'menu_position' => null,
		        'exclude_from_search' => true,
		        
		        'show_in_nav_menus' => true,
		        'publicly_queryable' => true,
		        'exclude_from_search' => true,
		        'has_archive' => false,
		        'query_var' => true,
		        'can_export' => true,
		        'rewrite' => true,
		        'capability_type' => 'post',
		        'capabilities' => array(
		        	'edit_post' => 'manage_options',
		        	'read_post' => 'manage_options',
		        	'delete_post' => 'manage_options',
		        ),
		        'taxonomies' => array()
		    );
		
		    register_post_type( 'issue', $args );
	    }
	    flush_rewrite_rules( true );
    }

	// News Importance --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_news_importance' );
	function register_taxonomy_news_importance() {
	
	    $labels = array( 
	        'name' => _x( 'News Importance (optional)', 'news importance' ),
	        'singular_name' => _x( 'News Importance', 'news importance' ),
	        'search_items' => _x( 'Search News Importance', 'news importance' ),
	        'popular_items' => _x( 'Popular News Importance', 'news importance' ),
	        'all_items' => _x( 'All News Importance', 'news importance' ),
	        'parent_item' => _x( 'Parent News Importance', 'news importance' ),
	        'parent_item_colon' => _x( 'Parent News Importance:', 'news importance' ),
	        'edit_item' => _x( 'Edit News Importance', 'news importance' ),
	        'update_item' => _x( 'Update News Importance', 'news importance' ),
	        'add_new_item' => _x( 'Add New News Importance', 'news importance' ),
	        'new_item_name' => _x( 'New News Importance', 'news importance' ),
	        'separate_items_with_commas' => _x( 'Separate news importance with commas', 'news importance' ),
	        'add_or_remove_items' => _x( 'Add or remove News Importance', 'news importance' ),
	        'choose_from_most_used' => _x( 'Choose from most used News Importance', 'news importance' ),
	        'menu_name' => _x( 'News Importance', 'news importance' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'news_importance', 'news', $args );
    }		
    

	// News Type --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_news_type' );
	function register_taxonomy_news_type() {
	
	    $labels = array( 
	        'name' => _x( 'News Type (choose one)', 'news type' ),
	        'singular_name' => _x( 'News Type', 'news type' ),
	        'search_items' => _x( 'Search News Type', 'news type' ),
	        'popular_items' => _x( 'Popular News Type', 'news type' ),
	        'all_items' => _x( 'All News Type', 'news type' ),
	        'parent_item' => _x( 'Parent News Type', 'news type' ),
	        'parent_item_colon' => _x( 'Parent News Type:', 'news type' ),
	        'edit_item' => _x( 'Edit News Type', 'news type' ),
	        'update_item' => _x( 'Update News Type', 'news type' ),
	        'add_new_item' => _x( 'Add New News Type', 'news type' ),
	        'new_item_name' => _x( 'New News Type', 'news type' ),
	        'separate_items_with_commas' => _x( 'Separate news type with commas', 'news type' ),
	        'add_or_remove_items' => _x( 'Add or remove News Type', 'news type' ),
	        'choose_from_most_used' => _x( 'Choose from most used News Type', 'news type' ),
	        'menu_name' => _x( 'News Type', 'news type' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'news_type', 'news', $args );
    }	
    
    
	// Sports Importance --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_sports_importance' );
	function register_taxonomy_sports_importance() {
	
	    $labels = array( 
	        'name' => _x( 'Sports Importance (optional)', 'sports importance' ),
	        'singular_name' => _x( 'Sports Importance', 'sports importance' ),
	        'search_items' => _x( 'Search Sports Importance', 'sports importance' ),
	        'popular_items' => _x( 'Popular Sports Importance', 'sports importance' ),
	        'all_items' => _x( 'All Sports Importance', 'sports importance' ),
	        'parent_item' => _x( 'Parent Sports Importance', 'sports importance' ),
	        'parent_item_colon' => _x( 'Parent Sports Importance:', 'sports importance' ),
	        'edit_item' => _x( 'Edit Sports Importance', 'sports importance' ),
	        'update_item' => _x( 'Update Sports Importance', 'sports importance' ),
	        'add_new_item' => _x( 'Add New Sports Importance', 'sports importance' ),
	        'new_item_name' => _x( 'New Sports Importance', 'sports importance' ),
	        'separate_items_with_commas' => _x( 'Separate sports importance with commas', 'sports importance' ),
	        'add_or_remove_items' => _x( 'Add or remove Sports Importance', 'sports importance' ),
	        'choose_from_most_used' => _x( 'Choose from most used Sports Importance', 'sports importance' ),
	        'menu_name' => _x( 'Sports Importance', 'sports importance' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'sports_importance', 'sports', $args );
    }		
    

	// Sports Type --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_sports_type' );
	function register_taxonomy_sports_type() {
	
	    $labels = array( 
	        'name' => _x( 'Sports Type (choose one)', 'sports type' ),
	        'singular_name' => _x( 'Sports Type', 'sports type' ),
	        'search_items' => _x( 'Search Sports Type', 'sports type' ),
	        'popular_items' => _x( 'Popular Sports Type', 'sports type' ),
	        'all_items' => _x( 'All Sports Type', 'sports type' ),
	        'parent_item' => _x( 'Parent Sports Type', 'sports type' ),
	        'parent_item_colon' => _x( 'Parent Sports Type:', 'sports type' ),
	        'edit_item' => _x( 'Edit Sports Type', 'sports type' ),
	        'update_item' => _x( 'Update Sports Type', 'sports type' ),
	        'add_new_item' => _x( 'Add New Sports Type', 'sports type' ),
	        'new_item_name' => _x( 'New Sports Type', 'sports type' ),
	        'separate_items_with_commas' => _x( 'Separate sports type with commas', 'sports type' ),
	        'add_or_remove_items' => _x( 'Add or remove Sports Type', 'sports type' ),
	        'choose_from_most_used' => _x( 'Choose from most used Sports Type', 'sports type' ),
	        'menu_name' => _x( 'Sports Type', 'sports type' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'sports_type', 'sports', $args );
    }	

    
	// Features Importance --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_features_importance' );
	function register_taxonomy_features_importance() {
	
	    $labels = array( 
	        'name' => _x( 'Features Importance (optional)', 'features importance' ),
	        'singular_name' => _x( 'Features Importance', 'features importance' ),
	        'search_items' => _x( 'Search Features Importance', 'features importance' ),
	        'popular_items' => _x( 'Popular Features Importance', 'features importance' ),
	        'all_items' => _x( 'All Features Importance', 'features importance' ),
	        'parent_item' => _x( 'Parent Features Importance', 'features importance' ),
	        'parent_item_colon' => _x( 'Parent Features Importance:', 'features importance' ),
	        'edit_item' => _x( 'Edit Features Importance', 'features importance' ),
	        'update_item' => _x( 'Update Features Importance', 'features importance' ),
	        'add_new_item' => _x( 'Add New Features Importance', 'features importance' ),
	        'new_item_name' => _x( 'New Features Importance', 'features importance' ),
	        'separate_items_with_commas' => _x( 'Separate features importance with commas', 'features importance' ),
	        'add_or_remove_items' => _x( 'Add or remove Features Importance', 'features importance' ),
	        'choose_from_most_used' => _x( 'Choose from most used Features Importance', 'features importance' ),
	        'menu_name' => _x( 'Features Importance', 'features importance' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'features_importance', 'features', $args );
    }		
	// Features Importance --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_video_type' );
	function register_taxonomy_video_type() {
	
	    $labels = array( 
	        'name' => _x( 'Video Type', 'video type' ),
	        'singular_name' => _x( 'Video Type', 'video type' ),
	        'search_items' => _x( 'Search Video Type', 'video type' ),
	        'popular_items' => _x( 'Popular Video Type', 'video type' ),
	        'all_items' => _x( 'All Video Type', 'video type' ),
	        'parent_item' => _x( 'Parent Video Type', 'video type' ),
	        'parent_item_colon' => _x( 'Parent Video Type:', 'video type' ),
	        'edit_item' => _x( 'Edit Video Type', 'video type' ),
	        'update_item' => _x( 'Update Video Type', 'video type' ),
	        'add_new_item' => _x( 'Add New Video Type', 'video type' ),
	        'new_item_name' => _x( 'New Video Type', 'video type' ),
	        'separate_items_with_commas' => _x( 'Separate video type with commas', 'video type' ),
	        'add_or_remove_items' => _x( 'Add or remove Video Type', 'video type' ),
	        'choose_from_most_used' => _x( 'Choose from most used Video Type', 'video type' ),
	        'menu_name' => _x( 'Video Type', 'video type' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'video_type', 'video', $args );
    }		

	// Issue Month --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_issue_month' );
	function register_taxonomy_issue_month() {
	
	    $labels = array( 
	        'name' => _x( 'Issue Month (choose page num too)', 'issue month' ),
	        'singular_name' => _x( 'Issue Month', 'issue month' ),
	        'search_items' => _x( 'Search Issue Month', 'issue month' ),
	        'popular_items' => _x( 'Popular Issue Month', 'issue month' ),
	        'all_items' => _x( 'All Issue Month', 'issue month' ),
	        'parent_item' => _x( 'Parent Issue Month', 'issue month' ),
	        'parent_item_colon' => _x( 'Parent Issue Month:', 'issue month' ),
	        'edit_item' => _x( 'Edit Issue Month', 'issue month' ),
	        'update_item' => _x( 'Update Issue Month', 'issue month' ),
	        'add_new_item' => _x( 'Add New Issue Month', 'issue month' ),
	        'new_item_name' => _x( 'New Issue Month', 'issue month' ),
	        'separate_items_with_commas' => _x( 'Separate issue month with commas', 'issue month' ),
	        'add_or_remove_items' => _x( 'Add or remove Issue Month', 'issue month' ),
	        'choose_from_most_used' => _x( 'Choose from most used Issue Month', 'issue month' ),
	        'menu_name' => _x( 'Issue Month', 'issue month' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'issue_month', array('news', 'sports', 'opinion', 'features', 'ae', 'video', 'broadcast', 'photo'), $args );
    }	
    

	// Page Number --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_page_number' );
	function register_taxonomy_page_number() {
	
	    $labels = array( 
	        'name' => _x( 'Page Number', 'page number' ),
	        'singular_name' => _x( 'Page Number', 'page number' ),
	        'search_items' => _x( 'Search Page Number', 'page number' ),
	        'popular_items' => _x( 'Popular Page Number', 'page number' ),
	        'all_items' => _x( 'All Page Number', 'page number' ),
	        'parent_item' => _x( 'Parent Page Number', 'page number' ),
	        'parent_item_colon' => _x( 'Parent Page Number:', 'page number' ),
	        'edit_item' => _x( 'Edit Page Number', 'page number' ),
	        'update_item' => _x( 'Update Page Number', 'page number' ),
	        'add_new_item' => _x( 'Add New Page Number', 'page number' ),
	        'new_item_name' => _x( 'New Page Number', 'page number' ),
	        'separate_items_with_commas' => _x( 'Separate page number with commas', 'page number' ),
	        'add_or_remove_items' => _x( 'Add or remove Page Number', 'page number' ),
	        'choose_from_most_used' => _x( 'Choose from most used Page Number', 'page number' ),
	        'menu_name' => _x( 'Page Number', 'page number' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => false,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'page_num', array('news', 'sports', 'opinion', 'features', 'ae'), $args );
    }
   
	function add_page_num_box(){
		remove_meta_box('tagsdiv-page_num', 'news', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'news', 'side', 'core');
		remove_meta_box('tagsdiv-page_num', 'sports', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'sports', 'side', 'core');
		remove_meta_box('tagsdiv-page_num', 'opinion', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'opinion', 'side', 'core');
		remove_meta_box('tagsdiv-page_num', 'features', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'features', 'side', 'core');
		remove_meta_box('tagsdiv-page_num', 'ae', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'ae', 'side', 'core');
		remove_meta_box('tagsdiv-page_num', 'video', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'video', 'side', 'core');
		remove_meta_box('tagsdiv-page_num', 'photo', 'core');
		add_meta_box('page_num_ID', __('Page Number'), 'page_num_function', 'photo', 'side', 'core');
	}
	function add_page_num_menus(){
		if(!is_admin()){
			return;
		}
		add_action('admin_menu', 'add_page_num_box');
		add_action('save_post','save_page_num_data');
	}
	add_page_num_menus();
	
	function page_num_function($post) {

	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_theme' ) . '" />';
 
 
	// Get all theme taxonomy terms
	$themes = get_terms('page_num', 'hide_empty=0'); 
?>
<select name='post_page_num' id='post_page_num'>
	<!-- Display themes as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'page_num'); 
        ?>
        <option class='page_num-option' value='' 
        <?php if (!count($names)) echo "selected";?>>None</option>
        <?php
	foreach ($themes as $theme) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug)) 
			echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n"; 
		else
			echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n"; 
	}
   ?>
</select>    
<?php
	}
	
	function save_page_num_data($post_id) {
	// verify this came from our screen and with proper authorization.
	 
	 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_theme' )) {
	    	return $post_id;
	  	}
	 
	  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
	  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
	    	return $post_id;
	 
	 

    	if ( !current_user_can( 'edit_post', $post_id ) )
	      	return $post_id;
	 
	  	// OK, we're authenticated: we need to find and save the data
		$post = get_post($post_id);
		$array = array('news', 'sports', 'features', 'opinion', 'ae');
		if (in_array($post->post_type, $array)) { 
	           // OR $post->post_type != 'revision'
	           $theme = $_POST['post_page_num'];
		   wp_set_object_terms( $post_id, $theme, 'page_num' );
	        }
		return $theme;
	}
	// Issue Month --------------------------------------------------
   
	function add_issue_month_box(){
		remove_meta_box('tagsdiv-issue_month', 'issue', 'core');
		add_meta_box('page_num_ID', __('Issue Month'), 'issue_month_connect', 'issue', 'side', 'core');
	}
	function add_issue_month_connect_menus(){
		if(!is_admin()){
			return;
		}
		add_action('admin_menu', 'add_issue_month_box');
		add_action('save_post','save_issue_month_data');
	}
	add_issue_month_connect_menus();
	
	function issue_month_connect($post) {

	echo '<input type="hidden" name="taxonomy_noncename" id="taxonomy_noncename" value="' . 
    		wp_create_nonce( 'taxonomy_theme' ) . '" />';
 
 
	// Get all theme taxonomy terms
	$themes = get_terms('issue_month', 'hide_empty=0'); 
?>
<select name='post_issue_month' id='post_issue_month'>
	<!-- Display themes as options -->
    <?php 
        $names = wp_get_object_terms($post->ID, 'issue_month'); 
        ?>
        <option class='page_num-option' value='' 
        <?php if (!count($names)) echo "selected";?>>None</option>
        <?php
	foreach ($themes as $theme) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($theme->slug, $names[0]->slug)) 
			echo "<option class='theme-option' value='" . $theme->slug . "' selected>" . $theme->name . "</option>\n"; 
		else
			echo "<option class='theme-option' value='" . $theme->slug . "'>" . $theme->name . "</option>\n"; 
	}
   ?>
</select>    
<?php
	}
	
	function save_issue_month_data($post_id) {
	// verify this came from our screen and with proper authorization.
	 
	 	if ( !wp_verify_nonce( $_POST['taxonomy_noncename'], 'taxonomy_theme' )) {
	    	return $post_id;
	  	}
	 
	  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
	  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
	    	return $post_id;
	 
	 

    	if ( !current_user_can( 'edit_post', $post_id ) )
	      	return $post_id;
	 
	  	// OK, we're authenticated: we need to find and save the data
		$post = get_post($post_id);
		$array = array('issue');
		if (in_array($post->post_type, $array)) { 
	           // OR $post->post_type != 'revision'
	           $theme = $_POST['post_issue_month'];
		   wp_set_object_terms( $post_id, $theme, 'issue_month' );
	        }
		return $theme;
	}


	// DONE PAGE NUMBER
    	
	// Opinion type --------------------------------------------------
	
    add_action( 'init', 'register_taxonomy_opinion_type' );
	function register_taxonomy_opinion_type() {
	
	    $labels = array( 
	        'name' => _x( 'Opinion Type (select one)', 'opinion type' ),
	        'singular_name' => _x( 'Opinion Type', 'opinion type' ),
	        'search_items' => _x( 'Search Opinion Type', 'opinion type' ),
	        'popular_items' => _x( 'Popular Opinion Type', 'opinion type' ),
	        'all_items' => _x( 'All Opinion Type', 'opinion type' ),
	        'parent_item' => _x( 'Parent Opinion Type', 'opinion type' ),
	        'parent_item_colon' => _x( 'Parent Opinion Type:', 'opinion type' ),
	        'edit_item' => _x( 'Edit Opinion Type', 'opinion type' ),
	        'update_item' => _x( 'Update Opinion Type', 'opinion type' ),
	        'add_new_item' => _x( 'Add New Opinion Type', 'opinion type' ),
	        'new_item_name' => _x( 'New Opinion Type', 'opinion type' ),
	        'separate_items_with_commas' => _x( 'Separate opinion type with commas', 'opinion type' ),
	        'add_or_remove_items' => _x( 'Add or remove Opinion Type', 'opinion type' ),
	        'choose_from_most_used' => _x( 'Choose from most used Opinion Type', 'opinion type' ),
	        'menu_name' => _x( 'Opinion Type', 'opinion type' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'opinion_type', 'opinion', $args );
    }		
    
    // Photo type ----------------------------------------------------
    add_action( 'init', 'register_taxonomy_photo_type' );
	function register_taxonomy_photo_type() {
	
	    $labels = array( 
	        'name' => _x( 'Photo Type', 'photo type' ),
	        'singular_name' => _x( 'Photo Type', 'photo type' ),
	        'search_items' => _x( 'Search Photo Type', 'photo type' ),
	        'popular_items' => _x( 'Popular Photo Type', 'photo type' ),
	        'all_items' => _x( 'All Photo Type', 'photo type' ),
	        'parent_item' => _x( 'Parent Photo Type', 'photo type' ),
	        'parent_item_colon' => _x( 'Parent Photo Type:', 'photo type' ),
	        'edit_item' => _x( 'Edit Photo Type', 'photo type' ),
	        'update_item' => _x( 'Update Photo Type', 'photo type' ),
	        'add_new_item' => _x( 'Add New Photo Type', 'photo type' ),
	        'new_item_name' => _x( 'New Photo Type', 'photo type' ),
	        'separate_items_with_commas' => _x( 'Separate photo type with commas', 'photo type' ),
	        'add_or_remove_items' => _x( 'Add or remove Photo Type', 'photo type' ),
	        'choose_from_most_used' => _x( 'Choose from most used Photo Type', 'photo type' ),
	        'menu_name' => _x( 'Photo Type', 'photo type' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'public' => true,
	        'show_ui' => true,
	        'show_tagcloud' => false,
	        'hierarchical' => true,
	        'capabilities' => array (
	            'manage_terms' => 'manage_options',
	            'edit_terms' => 'manage_options',
	            'delete_terms' => 'manage_options',
	            'assign_terms' => 'edit_posts'
            )
	    );
	
	    register_taxonomy( 'photo_type', 'photo', $args );
    }		


	// Post correct date format    
    function correct_ap_month($input){
    	$output = $input;
    	$output = str_replace('Mar', 'March' ,$output);
	    $output = str_replace('Apr', 'April' ,$output);
	    $output = str_replace('Jun', 'June' ,$output);
	    $output = str_replace('Jul', 'July' ,$output);
	    $output = str_replace('Sep', 'Sept' ,$output);
	    return $output;
    }
    function the_checked_date(){
    	$output = "";
    	$mylimit = 7 * 86400; //7 * seconds in a day
    	$mylimit2 = 86400; //seconds in a day

    	if(get_the_date("F j, Y") == date("F j, Y")){
    		$output = get_the_date("g:i A");
    	}else if(date('U') - get_the_date('U') < $mylimit){
    		$output = get_the_date("l");
    	}else if( ( (date('U')/365) - (get_the_date('U')/365) ) < $mylimit2){
    		$output = get_the_date("M j");
			$output = correct_ap_month($output);
    	}else{
    		$output = get_the_date("M j, Y");
			$output = correct_ap_month($output);    	
    	}
		echo $output;
    }
    function the_checked_mini_date(){
    	echo correct_ap_month(get_the_date('M j'));
    }

    
    //	Get first taxonomy value
    function first_tax_value($terms){
    	if ( $terms && ! is_wp_error( $terms ) ){
	    	foreach ( $terms as $term ) {
				return $term->name;
			}
		}
	}
  	function first_tax_slug($terms){
    	if ( $terms && ! is_wp_error( $terms ) ){
	    	foreach ( $terms as $term ) {
				return $term->slug;
			}
		}
	}
    
    // Clean WYSIWYG editor
    
    function myformatTinyMCE($in)
	{
		$in['paste_auto_cleanup_on_paste']=true;
		return $in;
	}
	add_filter('tiny_mce_before_init', 'myformatTinyMCE' );
    
    // Check if page already has article
    
    function is_already_on_page($text, $array){
    	$bool = false;
    	foreach($array as $unit){
    		if( is_array($unit) ){
    			$bool = is_already_on_page($text, $unit);
    		}else{
    			$bool = ($text == $unit);
    		}
    		if($bool)
    			return true;
    	}
    	return false;
    }
    
    function get_related_posts( $count=3 ) {
	    global $post;
	    $orig_post = $post;

	    $tags = wp_get_post_tags($post->ID);
	    if ($tags) {
	        $tag_ids = array();
	        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

	        $args=array(
	        	'tag__in' => $tag_ids,
	        	'post__not_in' => array($post->ID),
	        	'post_type' => array('news', 'sports', 'features', 'opinion', 'ae'),
	        	'posts_per_page' => $count
	        );
	        $my_query = new WP_Query( $args );
	        if( $my_query->have_posts() ) { ?>
	            <?php
	            while( $my_query->have_posts() ) {
	            $my_query->the_post(); ?>
	            <li class="related-article">
	            <a class="related-title" href="<?php the_permalink()?>" rel="bookmark">
	                <?php the_title(); ?>
	            </a>
	            <div class="related-excerpt"><?php the_excerpt(); ?></div>
	             
	            </li>
	            <?php }
	        }
	    }
	    $post = $orig_post;
	    wp_reset_query();
	}
    function get_related_videos( $count=2 ) {
	    global $post;
	    $orig_post = $post;

	    $tags = wp_get_post_tags($post->ID);
	    if ($tags) {
	        $tag_ids = array();
	        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

	        $args=array(
	        	'tag__in' => $tag_ids,
	        	'post__not_in' => array($post->ID),
	        	'post_type' => array('video', 'broadcast')
	        );
	        $my_query = new WP_Query( $args );
	        if( $my_query->have_posts() ) { ?>
	            <?php
	            while( $my_query->have_posts() ) {
	            $my_query->the_post(); ?>
	            <li class="related-video">
    			<div class="related-thumbnail">
		            <a href="<?php the_permalink()?>">
						<img src="<?php video_thumbnail(); ?>" width="120"/>
					</a>
				</div>
	            <a class="related-title" href="<?php the_permalink()?>" rel="bookmark">
	                <?php the_title(); ?>
	            </a>
	            <div class="clear"></div>
	            </li>
	            <?php }
	        }
	    }
	    $post = $orig_post;
	    wp_reset_query();
	}
	

// Rename Featured Image
function custom_admin_post_thumbnail_html( $content ) {
    return $content = str_replace( __( 'Set featured image' ), __( 'Add an image to article' ), $content );
}

function mycustom_embed_defaults($embed_size){
    if( is_single() ){ // If displaying a single post
        $embed_size['width'] = 700; // Adjust values to your needs
        $embed_size['height'] = 400; 
    }else if( is_home() ){
		$embed_size['width'] = 480; // Adjust values to your needs
		$embed_size['height'] = 320; 
    }else if( is_archive() ){
		$embed_size['width'] = 640; // Adjust values to your needs
		$embed_size['height'] = 370; 
    }
     
    return $embed_size; // Return new size
}
 
add_filter('embed_defaults', 'mycustom_embed_defaults');

add_filter( 'admin_post_thumbnail_html', 'custom_admin_post_thumbnail_html' );
	

	// Add Meta Box for Opinion
	
	add_action( 'add_meta_boxes', 'add_issue_background' );
	function add_issue_background() {
	    add_meta_box('issue_background', 'Issue Background Image (url of image here):', 'issue_background', 'issue', 'advanced', 'default');
	}	
	add_action( 'add_meta_boxes', 'add_special_label' );
	function add_special_label() {
		$types = array('news', 'sports', 'opinion', 'features', 'photo', 'video', 'broadcast');
		foreach($types as $type){
		    add_meta_box('special_label', 'Special Article Label', 'special_label', $type, 'advanced', 'default');
		}
	}	
	add_action( 'add_meta_boxes', 'add_letter_from' );
	function add_letter_from() {
	    add_meta_box('letter_from', 'Letter From:', 'letter_from', 'opinion', 'advanced', 'default');
	}	
	add_action( 'add_meta_boxes', 'add_a_section' );
	function add_a_section() {
	    add_meta_box('a_section', 'A Section Pages:', 'a_section', 'issue', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_b_section' );
	function add_b_section() {
	    add_meta_box('b_section', 'B Section Pages:', 'b_section', 'issue', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_c_section' );
	function add_c_section() {
	    add_meta_box('c_section', 'C Section Pages:', 'c_section', 'issue', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_editors_in_chief' );
	function add_editors_in_chief() {
	    add_meta_box('editors_in_chief', 'Editors in Chief:', 'editors_in_chief', 'issue', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_broadcast_commentary' );
	function add_broadcast_commentary() {
	    add_meta_box('broadcast_commentary', 'Commentary by:', 'broadcast_commentary', 'broadcast', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_broadcast_video' );
	function add_broadcast_video() {
	    add_meta_box('broadcast_video', 'Video By:', 'broadcast_video', 'broadcast', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_broadcast_photos' );
	function add_broadcast_photos() {
	    add_meta_box('broadcast_photos', 'Photos by:', 'broadcast_photos', 'broadcast', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_broadcast_twitter' );
	function add_broadcast_twitter() {
	    add_meta_box('broadcast_twitter', 'Twitter Coverage By:', 'broadcast_twitter', 'broadcast', 'advanced', 'default');
	}
	add_action( 'add_meta_boxes', 'add_preview_post_id' );
	function add_preview_post_id() {
	    add_meta_box('preview_post_id', 'ID# of the Preview Article:', 'preview_post_id', 'broadcast', 'advanced', 'default');
	}
	// Add Meta Box for Features
/*
	
	add_action( 'add_meta_boxes', 'add_pageorder_metaboxes2' );
	function add_pageorder_metaboxes2() {
	    add_meta_box('page_order', 'Page Order', 'page_order', 'features', 'advanced', 'default');
	}
	
*/
	

	
/*
	function video_desc() {
	    global $post;
	    // Noncename needed to verify where the data originated
	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	    // Get the location data if its already been entered
	    $location = get_post_meta($post->ID, 'video_desc', true);
	    // Echo out the field
	    echo '<textarea type="text" name="video_desc" class="widefat" >'.$location.'</textarea>';
	}
*/
	
	function issue_background() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $background = get_post_meta($post->ID, 'issue_background', true);

	    echo '<input type="text" name="issue_background" class="widefat" value="'.$background.'" />';
	}
	function special_label() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $background = get_post_meta($post->ID, 'special_label', true);

	    echo '<input type="text" name="special_label" class="widefat" value="'.$background.'" />';
	}
	function letter_from() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $background = get_post_meta($post->ID, 'letter_from', true);

	    echo '<input type="text" name="letter_from" class="widefat" value="'.$background.'" />';
	}
	function a_section() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'a_section', true);

	    echo '<input type="text" name="a_section" class="widefat" value="'.$section.'" />';
	}
	function b_section() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'b_section', true);

	    echo '<input type="text" name="b_section" class="widefat" value="'.$section.'" />';
	}
	function c_section() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'c_section', true);

	    echo '<input type="text" name="c_section" class="widefat" value="'.$section.'" />';
	}
	function editors_in_chief() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'editors_in_chief', true);

	    echo '<input type="text" name="editors_in_chief" class="widefat" value="'.$section.'" />';
	}
	function broadcast_commentary() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'broadcast_commentary', true);

	    echo '<input type="text" name="broadcast_commentary" class="widefat" value="'.$section.'" />';
	}
	function broadcast_video() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'broadcast_video', true);

	    echo '<input type="text" name="broadcast_video" class="widefat" value="'.$section.'" />';
	}
	function broadcast_photos() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'broadcast_photos', true);

	    echo '<input type="text" name="broadcast_photos" class="widefat" value="'.$section.'" />';
	}
	function broadcast_twitter() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'broadcast_twitter', true);

	    echo '<input type="text" name="broadcast_twitter" class="widefat" value="'.$section.'" />';
	}
	function preview_post_id() {
	    global $post;

	    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
	    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	    $section = get_post_meta($post->ID, 'preview_post_id', true);

	    echo '<input type="text" name="preview_post_id" class="widefat" value="'.$section.'" />';
	}
		/* Save the meta box's post metadata. */
	function wpt_save_events_meta($post_id, $post) {
	    // verify this came from the our screen and with proper authorization,
	    // because save_post can be triggered at other times
	    if ( !wp_verify_nonce( $_POST['eventmeta_noncename'], plugin_basename(__FILE__) )) {
	    return $post->ID;
	    }
	    // Is the user allowed to edit the post or page?
	    if ( !current_user_can( 'edit_post', $post->ID ))
	        return $post->ID;
	    // OK, we're authenticated: we need to find and save the data
	    // We'll put it into an array to make it easier to loop though.
	    $events_meta['issue_background'] = $_POST['issue_background'];
	    $events_meta['special_label'] = $_POST['special_label'];
	    $events_meta['letter_from'] = $_POST['letter_from'];
	    $events_meta['a_section'] = $_POST['a_section'];
	    $events_meta['b_section'] = $_POST['b_section'];
	    $events_meta['c_section'] = $_POST['c_section'];
	    $events_meta['editors_in_chief'] = $_POST['editors_in_chief'];
	    $events_meta['broadcast_commentary'] = $_POST['broadcast_commentary'];
	    $events_meta['broadcast_video'] = $_POST['broadcast_video'];
	    $events_meta['broadcast_photos'] = $_POST['broadcast_photos'];
	    $events_meta['broadcast_twitter'] = $_POST['broadcast_twitter'];
	    $events_meta['preview_post_id'] = $_POST['preview_post_id'];
	    // Add values of $events_meta as custom fields
	    foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
	        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
	        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
	        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
	            update_post_meta($post->ID, $key, $value);
	        } else { // If the custom field doesn't have a value
	            add_post_meta($post->ID, $key, $value);
	        }
	        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	    }
	}
	add_action('save_post', 'wpt_save_events_meta', 1, 2); // save the custom fields
		
	
	function yo_post_thumbnail($size = 'article-image', $id = ''){
		$post = $GLOBALS['post'];
		$post = $id ? get_post($id) : $post;
		
		if(has_post_thumbnail($post->ID)){
			$thumbnail = get_the_post_thumbnail($post->ID, $size);
			$start = strpos($thumbnail,'<img');
			$end = strpos($thumbnail, '>', $start)+1;
			return $thumbnail = substr($thumbnail, $start, $end - $start);
		}else{
			return '';
		}
	}

	function inject_featured_photo($content) {
		$post = $GLOBALS['post'];

		if (is_single() && $post->post_type == "opinion") {
			$needle = "</p>";
			$finds = explode($needle, $content);
			
			$thumbnail = yo_post_thumbnail('single-article');

			if(is_editorial($post->ID)){
				
			}
			elseif (count($finds) > 3) {
				$yack;
				if($thumbnail){
					$yack = "<p class='credit'>".get_media_credit(get_post_thumbnail_id($post->ID))."</p>";
				}
				$finds[3] = "{$finds[3]}".$thumbnail.$yack;
			}
			$content = implode("</p>", $finds);
		}
		return $content;
	}
	add_filter('the_content', 'inject_featured_photo');
	
	function is_editorial($id){
		return is_object_in_term($id, 'opinion_type', 'editorial');
	}
	
	function get_page_num(){
		global $post;
		$array = wp_get_post_terms($post->ID, 'page_num');

		foreach($array as $arr){
			return $arr->name;
		}
	}
	function get_issue_month(){
		global $post;
		 return first_tax_slug(get_the_terms($post->ID, 'issue_month'));
	}
	
	function get_first_sentence($text){
		$array = explode('.',$text);
		return $array[0];
	}
		
	// Iterator ----------------------------------------------- OPINION AND FEATURES
	

	function grab_editorial_of_month($issue_month){
		global $post;
		$temp = $post;
		$args = array( 'issue_month' => $issue_month, 'post_type' => 'opinion', 'opinion_type' => 'editorial', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
		$myposts = get_posts( $args );
		foreach( $myposts as $post ) : setup_postdata($post);
			return get_the_ID();
		endforeach;
		return null;
		$post = $temp;
	}
	
	
	
	// You don't wanna know.  I don't either.  No one ever appreciates me.  It's 2am in the morning. I'm so lonely
	function features_top($issue_month, $page_num, $type, $id){
		global $post;
		$tmp_post = $post;
		$array = array();
		
		$args = array( 'issue_month' => $issue_month, 'page_num' => $page_num, 'post_type' => $type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
		$myposts = get_posts( $args );
		
		$found = false;
		$before = null;
		$after = null;
		foreach( $myposts as $post ) : setup_postdata($post);
			
			if(get_the_ID() != $id && !$found){
				$before = get_the_ID();
			}else if(get_the_ID() == $id){
				$found = true;
			}else if(get_the_ID() != $id && $found){
				$after = get_the_ID();
				break;
			}
			
		endforeach;

		
		if($before == null){
			$found = null;
			$prev_page = $page_num;
			while(get_prev_page_num($prev_page) != -1 && !$found && get_prev_page_num($prev_page) != $page_num){
				$prev_page = get_prev_page_num($prev_page);
				$args = array( 'issue_month' => $issue_month, 'page_num'=> $prev_page, 'post_type' => $type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
				$myposts = get_posts( $args );
				foreach( $myposts as $post ) : setup_postdata($post);
					$before = get_the_ID();
					$found = true;
				endforeach;
			}
		}
		if($after == null){
			$found = null;
			$next_page = $page_num;
			while(get_next_page_num($next_page) != -1 && !$found && get_next_page_num($next_page) != $page_num){
				$next_page = get_next_page_num($next_page);
				$args = array( 'issue_month' => $issue_month, 'page_num'=> $next_page, 'post_type' => $type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
				$myposts = get_posts( $args );
				foreach( $myposts as $post ) : setup_postdata($post);
					$after = get_the_ID();
					$found = true;
					break;
				endforeach;
			}
			
		}
		$array[0] = $before;
		$array[1] = $after;
		
		$post = $tmp_post;
		
		return $array;
	}
	function generic_opinion_top($issue_month, $id){
		global $post;
		$array = array();
		$array[] = grab_editorial_of_month($issue_month);

		$args = array( 'issue_month' => $issue_month, 'opinion_type' => 'column', 'post_type' => 'opinion', 'posts_per_page' => -1, 'orderby' => 'rand' );
		$count = 0;
		$myposts = get_posts( $args );
		foreach( $myposts as $post ) : setup_postdata($post);
			$array[] = get_the_ID();
			if($count >= 2){
				break;
			}
			$count++;
		endforeach;
		return $array;
	}
	function column_top($issue_month, $page_num, $id){
		global $post;
		$temp = $post;
		$array = array();
		$array[] = grab_editorial_of_month($issue_month);


		$args = array( 'issue_month' => $issue_month, 'page_num' => $page_num, 'post_type' => 'opinion', 'opinion_type' => 'column', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' );
		$myposts = get_posts( $args );
		
		$found = false;
		$before = null;
		$after = null;
		foreach( $myposts as $post ) : setup_postdata($post);
			
			if(get_the_ID() != $id && !$found){
				$before = get_the_ID();
			}else if(get_the_ID() == $id){
				$found = true;
			}else if(get_the_ID() != $id && $found){
				$after = get_the_ID();
				break;
			}
			
		endforeach;

		if($before == null){
			$found = null;
			$prev_page = $page_num;
			while(get_prev_page_num($prev_page) != -1 && !$found && get_prev_page_num($prev_page) != $page_num){
				$prev_page = get_prev_page_num($prev_page);
				$args = array( 'issue_month' => $issue_month, 'page_num' => $prev_page, 'post_type' => 'opinion', 'opinion_type' => 'column', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post__not_in' => array($id) );
				$myposts = get_posts( $args );
				foreach( $myposts as $post ) : setup_postdata($post);
					$before = get_the_ID();
					$found = true;
				endforeach;
				$count++;
			}
		}
		if($after == null){
			$found = null;
			$next_page = $page_num;
			$count = 0;
			while(get_next_page_num($next_page) != -1 && !$found && get_next_page_num($next_page) != $page_num){
				$next_page = get_next_page_num($next_page);
				$args = array( 'issue_month' => $issue_month, 'page_num' => $next_page, 'post_type' => 'opinion', 'opinion_type' => 'column', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC', 'post__not_in' => array($id) );
				$myposts = get_posts( $args );
				foreach( $myposts as $post ) : setup_postdata($post);
					$after = get_the_ID();
					$found = true;
					break;
				endforeach;
				wp_reset_postdata();
			}
			
		}
		$array[1] = $before;
		$array[2] = $after;
		
		$post = $temp;
		
		return $array;
	}
	function editorial_top($issue_month){
		global $post;
		
		$array = array();
		$args = array( 'issue_month' => $issue_month, 'opinion_type' => 'column', 'post_type' => 'opinion', 'posts_per_page' => -1, 'orderby' => 'rand' );
		$count = 0;
		$myposts = get_posts( $args );
		foreach( $myposts as $post ) : setup_postdata($post);
			$array[] = get_the_ID();
			if($count >= 2){
				break;
			}
			$count++;
		endforeach;
		return $array;
	}
	
	function generic_echo_top($top_object){
		global $post;
	?>
		<div class="issue salts left">
			<?php
			if($top_object[0]){
				$post = get_post($top_object[0]);
				setup_postdata( $post );
			?>
			<div class="left salt">
				<h4 class="uppercase two">EDITORIAL</h4>
					<?php
						if(has_post_thumbnail()){
							package_thumbnail();
						}
					?>
				<div class="text hasthumbnail">
					<?php the_full_title(); ?>
				</div>
			</div>
			<?php
				wp_reset_postdata();
			}
			if($top_object[1]){
				$post = get_post($top_object[1]);
				setup_postdata( $post );
			?>
			<div class="left salt">
				<h4 class="uppercase two">COLUMN</h4>
				<div class="text">
					<?php the_full_title(); ?>
				</div>
			</div>
			<?php 
				wp_reset_postdata();
			}
			if($top_object[2]){
				$post = get_post($top_object[2]);
				setup_postdata( $post );
			?>
			<div class="left salt lastone">
				<h4 class="uppercase two">COLUMN</h4>
				<div class="text">
					<?php the_full_title(); ?>
				</div>
			</div>
			<?php
				wp_reset_postdata();
			}
			?>
		</div>	
	<?php
	}
	function column_echo_top($top_object){
		global $post;
	?>
		<div class="issue salts left">
			<?php
			if($top_object[0]){
				$post = get_post($top_object[0]);
				setup_postdata( $post );
			?>
			<div class="left salt">
				<h4 class="uppercase two">EDITORIAL</h4>
					<?php
						if(has_post_thumbnail()){
							package_thumbnail();
						}
					?>
				<div class="text hasthumbnail">
					<?php the_full_title(); ?>
				</div>
			</div>
			<?php
				wp_reset_postdata();
			}
			?>
			<?php
			if($top_object[1]){
				$post = get_post($top_object[1]);
				setup_postdata( $post );
			?>
			<div class="left salt">
				<h4 class="uppercase two">PREVIOUS COLUMN</h4>
				<div class="text">
					<?php the_full_title(); ?>
				</div>
			</div>
			<?php 
				wp_reset_postdata();
			}
			if($top_object[2]){
				$post = get_post($top_object[2]);
				setup_postdata( $post );
			?>
			<div class="left salt lastone">
				<h4 class="uppercase two">NeXT COLUMN</h4>
				<div class="text">
					<?php the_full_title(); ?>
				</div>
			</div>
			<?php
				wp_reset_postdata();
			}
			?>
		</div>	
	<?php
	}
	function editorial_echo_top($top_object){
		global $post;
?>
		<div class="issue myhome left">
				<div class="home">
				<?php
					if($top_object[0] != null){
						$post = get_post($top_object[0]);
						setup_postdata( $post );
				?>
					<h4 class="uppercase">Column</h4>
					<?php the_full_title_1(); ?>
					<div class="featured-image">
<?php
				if(has_post_thumbnail()){
					echo yo_post_thumbnail("post-thumbnail");
				}
?>
					</div>
					</a>
					<div class="text <?=(has_post_thumbnail()? 'thumbnail' : ''); ?>">
						<div class="bold"><?php the_full_title(); ?></div>
					</div>
				<?php
				wp_reset_postdata();
				}
				?>
				</div>



				<div class="home last">
				<?php
					if($top_object[1] != null){
						$post = get_post($top_object[1]);
						setup_postdata( $post );
				?>
					<h4 class="uppercase font12">Column</h4>
					<?php the_full_title_1(); ?>
					<div class="featured-image">
<?php
				if(has_post_thumbnail()){
					echo yo_post_thumbnail("single-top");
				}
?>
					</div>
					</a>
					<div class="text <?=(has_post_thumbnail()? 'thumbnail' : ''); ?>">
						<div class="bold"><?php the_full_title(); ?></div>
					</div>
				<?php
				wp_reset_postdata();
				}
				?>
				</div>
		</div>
<?php
	}
	

	function get_next_page_num($page_num){
		$list = get_list_page_num();
		$index = array_search($page_num, $list);
		
		if($index == -1){
			return -1;
		}
		$next_index = $index + 1;
		if($next_index >= sizeof($list)){
			return $list[0];
		}else{
			return $list[$next_index];
		}
	}
	function get_prev_page_num($page_num){
		$list = get_list_page_num();
		$index = array_search($page_num, $list);
		
		if($index == -1){
			return -1;
		}
		$prev_index = $index - 1;
		if($prev_index == -1){
			return $list[count($list) - 1];
		}else{
			return $list[$prev_index];
		}
	}
	
	function current_url(){
		return "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
	}
	
	function facebook_code_1(){
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
	}
	
	function facebook_code_2($width = 650, $colorscheme = 'light'){
	?>
		<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-num-posts="5" data-width="<?=$width; ?>" data-colorscheme="<?=$colorscheme; ?>"></div>
	<?php
	}
	
	function facebook_code_3(){
	?>
		<div class="fb-like" data-href="<?php echo current_url(); ?>" data-layout="button_count" data-width="130" data-show-faces="true" data-action="recommend"></div>
	<?php
	}
	function facebook_code_4(){
?>
	<div class="fb-like" data-show_faces="false" data-href="<?php echo current_url(); ?>" data-send="true" data-width="340" data-show-faces="false" data-colorscheme="dark"></div>
<?php
	}
	function facebook_code_5(){
?>
	<div class="fb-like" data-href="<?php echo current_url(); ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
<?php
	}
	
	function twitter_code_1(){
	?>
<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<?php
	}
	
	function twitter_code_2(){
?>
<a href="https://twitter.com/intent/tweet?screen_name=hw_chronicle" class="twitter-mention-button" data-size="large">Tweet to @hw_chronicle</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
	}
	function twitter_code_3(){
?>
<a href="https://twitter.com/hw_chronicle" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @hw_chronicle</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
	}
	function twitter_code_4(){
?>
<a href="https://twitter.com/hw_chronicle" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @hw_chronicle</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
	}

	function last_updated(){
		date_default_timezone_set('America/Los_Angeles');
		global $wpdb;
		$last = $wpdb->get_var("SELECT post_modified FROM $wpdb->posts order by post_modified DESC LIMIT 1");
		if(date('l jS F Y') == mysql2date('l jS F Y', $last)){
			echo mysql2date('g:i A', $last);
		}else{
			echo mysql2date('F j', $last);
		}						
	}
	function truncate($string,$length=100,$appendStr="..."){
	    $truncated_str = "";
	    $useAppendStr = (strlen($string) > intval($length))? true:false;
	    $truncated_str = substr($string,0,$length);
	    $truncated_str .= ($useAppendStr)? $appendStr:"";
	    return $truncated_str;
	}
	function first_tag($id){
		$tags = wp_get_post_tags($id, array('orderby' => 'term_order'));
		if($tags){
			foreach($tags as $tag){
				return $tag->name;
			}
		}
		return "";
	}
	function get_recent_tags($type){
		$args = array(
			'post_type' => $type,
			'numberposts' => '7'
		);
		$posts = get_posts($args);
		$tag_string = "";
		foreach($posts as $p){
			$tags = wp_get_post_tags($p->ID);
			if($tags){
				foreach($tags as $tag){
					$tag_string .= '<p><a href="'.site_url().'?s='.urlencode($tag->name).'">'.$tag->name."</a></p>";
				}
			}
		}
		echo $tag_string;
	}
	
	function new_excerpt_length()
	{
	  return 15;
	}
	add_filter('excerpt_length', 'new_excerpt_length');
	
	
	function gallery_columns($content){	
		$columns = 4;
		$pattern = array(
			'#(\[gallery(.*?)columns="([0-9])"(.*?)\])#ie',
			'#(\[gallery\])#ie', 
			'#(\[gallery(.*?)\])#ie'
		);	 	
		$replace = 'stripslashes(strstr("\1", "columns=\"$columns\"") ? "\1" : "[gallery \2 \4 columns=\"$columns\"]")';
	
		return preg_replace($pattern, $replace, $content);
	}
	
	add_filter('the_content', 'gallery_columns');
	
	// Default USER DISPLAY NAME
	function sd_new_login_filter ($login) {
	/* Don't do anything to login, just see if already in database.*/
	   global $wpdb, $sd_is_new_login;
	
	   $id = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$login'");
	   $sd_is_new_login = (isset($id)) ? false : true;
	   return $login;
	}
	
	function sd_substitute_displayname_filter ($display_name) {
	   global $sd_is_new_login;
	
	   if ($sd_is_new_login) $display_name = $_POST['first_name']." ".$_POST['last_name'];
	   return $display_name;
	}
	add_filter('pre_user_login', 'sd_new_login_filter');
	add_filter('pre_user_display_name', 'sd_substitute_displayname_filter');
	
	// 	
	function new_excerpt_more( $more ) {
		return '...';
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	
	
?>