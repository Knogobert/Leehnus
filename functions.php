<?php
/* Functions for our theme
 *
 *
 * @theme Leehnus
 */

// $main_js_part = '/js/main.js';
// $main_style_part = '/css/main.css';

// $version = '1.0';

set_post_thumbnail_size( 256, 256, array( 'center', 'center')  ); // 50 pixels wide by 50 pixels tall, crop from the center 

function leehnus_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}
add_action("wp_enqueue_scripts", "leehnus_jquery_enqueue", 11);

// loads gallery JS if jquery is loaded
function leehnus_scripts_method() {
	wp_enqueue_script(
		'jquery.slides.min.js',
		get_stylesheet_directory_uri() . '/js/jquery.slides.min.js',
		array( 'jquery' )
	);
}

add_action( 'wp_enqueue_scripts', 'leehnus_scripts_method' );

function leehnus_excerpt_length( $length ) {
	return 160;
}
add_filter('excerpt_length', 'leehnus_excerpt_length');

function load_fonts() {
    wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Permanent+Marker|Source+Sans+Pro:400,600italic');
    wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'load_fonts');

function leehnus_add_styles_scripts( ) {
	if( WP_DEBUG == true ) {
		wp_enqueue_script( 'debug-js', get_template_directory_uri().'/js/debug.js');
	} else {
		wp_enqueue_script( 'live-js', get_template_directory_uri().'/js/live.js');
	}
	
	// Gets the js files in the header through the wp_head hook
	wp_enqueue_script( 'main-js', get_template_directory_uri().'/js/main.js');
	
	// Gets the css files in the header through the wp_head hook
	wp_enqueue_style( 'normalize', get_template_directory_uri().'/css/normalize.css', array());
	wp_enqueue_style( 'skeleton', get_template_directory_uri().'/css/skeleton.css', array());
	wp_enqueue_style( 'main', get_template_directory_uri().'/css/main.css', array());
}
add_action('wp_enqueue_scripts', 'leehnus_add_styles_scripts');


function leehnus_add_theme_support() {
	add_theme_support('custom-background');
	add_theme_support('custom-header', array(
		'width'         => 60,
		'height'        => 60,
		'default-image' => get_template_directory_uri() . '/img/header.png',
		'uploads'       => true,
	));
	add_theme_support('html5', array('search-form'));
	add_theme_support('post-thumbnails');
	add_theme_support('post-formats', array('aside', 'video', 'gallery'));
	add_theme_support('woocommerce');

	register_nav_menus(array(
		'main_menu' => 'Main menu',
		'footer_menu' => 'Footer menu'
	));
}
add_action('init', 'leehnus_add_theme_support');

/**
 * Register our sidebars and widgetized areas.
 *
 */
function leehnus_widgets_init() {
	// Area 1, located in the footer.
    register_sidebar( array(
        'name'          => 'Footer Social',
        'id'            => 'footer_social',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
    
    // Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'leehnus' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'leehnus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'leehnus' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'leehnus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'leehnus' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'leehnus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'leehnus' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'An optional widget area for your site footer.', 'leehnus' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'leehnus_widgets_init' );

/* Our custom post types */
function leehnus_post_types() {
	register_post_type( 'contact', array(
		'public' => true,
		'labels' => array(
			'name' => 'Contacts',
			'singular_name' => 'Contact' ),
		'hierarchical' => false,
		'supports' => array(
			'title', 'editor', 'thumbnail', 'author'
		),

	) );
}
add_action('init', 'leehnus_post_types');

/*
// 1. Vad som sker i annan kod
do_filter('gallery_item', $item);
// 2. Vi fångar upp det "samtalet"
add_filter('gallery_item', 'our_gallery_item');
// 3. Ändra om den koden såhär
function our_gallery_item( $item ) {

return $item;
}
*/

// Changes the DOM in the gallery page
//___________________________________________________

add_filter('post_gallery', 'leehnus_post_gallery', 10, 2);
function leehnus_post_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

    // Here's your actual output, you may customize it to your need
//  $output = "<div class=\"slideshow-wrapper\">\n";
//  $output .= "<div class=\"preloader\"></div>\n";
    $output .= "<ul class=\"galleryList\">\n";

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        // Fetch the thumbnail (or full image, it's up to you)
        $img = wp_get_attachment_image_src($id, 'medium');
//      $img = wp_get_attachment_image_src($id, 'leehnus-custom-image-size');
//      $img = wp_get_attachment_image_src($id, 'full');
        $ref = get_attachment_link($id, 'true');

        $output .= "<li>\n";
        $output .= "<a href=\"{$ref}\">\n";
        $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
        $output .= "</a>\n";
        $output .= "</li>\n";
    }

    $output .= "</ul>\n";
//  $output .= "</div>\n";

    return $output;
}

// ------- Adding metaboxes for Post-type Contacts -------


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function leehnus_add_meta_box() {


	$screens = array( 'contact' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'leehnus_sectionid',
			__( 'E-mail', 'leehnus_textdomain' ),
			'leehnus_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'leehnus_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function leehnus_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'leehnus_save_meta_box_data', 'leehnus_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_leehnus_meta_value_key', true );

	echo '<label for="leehnus_new_field">';
	_e( 'Add your e-mail', 'leehnus_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="leehnus_new_field" name="leehnus_new_field" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function leehnus_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['leehnus_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['leehnus_meta_box_nonce'], 'leehnus_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['leehnus_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$leehnus_data = sanitize_text_field( $_POST['leehnus_new_field'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_leehnus_meta_value_key', $leehnus_data );
}
add_action( 'save_post', 'leehnus_save_meta_box_data' );

// Search field
// _____________________________________________________

function leehnus_search(){
	$query_string = $_GET['q'];

	$s = new WP_Query(array( 's' => $query_string ));

	echo '<ul>';
	while($s->have_posts()){ 
		$s->the_post();?>

		<li>

			<?php the_post_thumbnail(); ?>

			<?php the_title(); ?>
			
		</li>

	<?php }
	echo '</ul>';

	wp_die();
}

add_action('wp_ajax_search', 'leehnus_search');
add_action('wp_ajax_nopriv_search', 'leehnus_search');


// WOOCOMMERCE REST API STUFF
// _____________________________________________________

/*
Home
 $consumer_key = 'ck_a11f79f316bbbfb6a83c387116a7dc36d76aed1a';
 $consumer_secret = 'cs_48e3dd9684e82a13cb218639128b847e33068160';
 $store_url = 'testy.dev/';
*/

/*
Macbook
 $consumer_key = 'ck_15e0cd32645659600b8171ced9a9f9f3cef8ed81'; // Add your own Consumer Key here
 $consumer_secret = 'cs_ea812ece722de9dbc6d1dad3d7ed8854c61746e9'; // Add your own Consumer Secret here
 $store_url = 'testy.dev/'; // Add the home URL to the store you want to connect to here
*

require_once( 'lib/woocommerce-api.php' );
$options = array(
	'debug'           => false,
	'return_as_array' => false,
	'validate_url'    => false,
	'timeout'         => 3,
	'ssl_verify'      => false,
);
try {
	$client = new WC_API_Client( 'http://testy.dev/', 'ck_a11f79f316bbbfb6a83c387116a7dc36d76aed1a', 'cs_48e3dd9684e82a13cb218639128b847e33068160', $options );
	
	//print_r( $client);
	//print_r( $client->customers->get( $customer_id ) );
	print_r( $client->products->get_count() );
	
} catch ( WC_API_Client_Exception $e ) {
	echo $e->getMessage() . PHP_EOL;
	echo $e->getCode() . PHP_EOL;
	if ( $e instanceof WC_API_Client_HTTP_Exception ) {
		print_r( $e->get_request() );
		print_r( $e->get_response() );
	}
}
*/
?>
