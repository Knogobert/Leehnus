<?php
/* Functions for our theme
 *
 *
 * @theme Leehnus
 */

// $main_js_part = '/js/main.js';
// $main_style_part = '/css/main.css';

// $version = '1.0';

function leehnus_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}
//add_action("wp_enqueue_scripts", "leehnus_jquery_enqueue", 11);

// loads gallery JS if jquery is loaded
function my_scripts_method() {
	wp_enqueue_script(
		'masonry.pkgd.min.js',
		get_stylesheet_directory_uri() . '/js/masonry.pkgd.min.js',
		array( 'jquery' )
	);
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function leehnus_excerpt_length( $length ) {
	return 160;
}
add_filter('excerpt_length', 'leehnus_excerpt_length');

function load_fonts() {
    wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Bangers|Permanent+Marker');
    wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'load_fonts');

function leehnus_add_styles_scripts( ) {
	if( WP_DEBUG == true ) {
		wp_enqueue_script( 'debug-js', get_template_directory_uri().'/js/debug.js');
	} else {
		wp_enqueue_script( 'main-js', get_template_directory_uri().'/js/main.js');
	}
	
	//Gets our css files in the header through the wp_head hook
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
	add_theme_support('post-thumbnails');
	add_theme_support('post-formats', array('aside', 'video', 'gallery'));
	add_theme_support( 'woocommerce' );

	register_nav_menus(array(
		'main_menu' => 'Main menu',
		'footer_menu' => 'Footer menu'
	));
}
add_action('init', 'leehnus_add_theme_support');



/* Our custom post types */
function leehnus_post_types() {
	register_post_type( 'contact', array(
		'public' => true,
		'labels' => array(
			'name' => 'Leehnus Contacts',
			'singular_name'      => 'Leehnus Contact' ),
		'hierarchical' => false,
		'supports' => array(
			'title', 'editor', 'thumbnail', 'author'
		)
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

// Shortcode for contact form

function leehnus_contact_form_sc( $atts ) {
	
}
add_shortcode( 'contact', 'leehnus_contact_form_sc' );

// Changes the DOM in the gallery page 

add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr) {
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
//      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
//      $img = wp_get_attachment_image_src($id, 'full');
        $ref = wp_get_attachment_link($id, 'true');

        $output .= "<li>\n";
        $output .= "<a href=\"{$ref[0]}\">\n";
        $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />\n";
        $output .= "</a>\n";
        $output .= "</li>\n";
    }

    $output .= "</ul>\n";
//  $output .= "</div>\n";

    return $output;
}

?>
