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
add_action("wp_enqueue_scripts", "leehnus_jquery_enqueue", 11);

function leehnus_excerpt_length( $length ) {
	return 160;
}
add_filter('excerpt_length', 'leehnus_excerpt_length');

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

function load_fonts() {
    wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Knewave');
    wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'load_fonts');

function leehnus_add_theme_support() {
	add_theme_support('custom-background');
	add_theme_support('custom-header', array(
		'width'         => 60,
		'height'        => 60,
		'default-image' => get_template_directory_uri() . '/img/header.png',
		'uploads'       => true,
	));
	add_theme_support('post-thumbnails');
	add_theme_support('post-formats', array('aside', 'video'));

	register_nav_menus(array(
		'main_menu' => 'Main menu',
		'footer_menu' => 'Footer menu'
	));
}
add_action('init', 'leehnus_add_theme_support');



/* Our custom post types */
function leehnus_post_types() {
	register_post_type( 'person', array(
		'public' => true,
		'labels' => array(
			'name' => 'Persons' ),
		'hierarchical' => false,
		'supports' => array(
			'title', 'editor', 'author'
		)
	) );
}
add_action('init', 'leehnus_post_types');


// ____________________________WOOCOMMERCE___________________________

// Declares WC support
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

// Unhook WC wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Hook leehnus wrappers
add_action('woocommerce_before_main_content', 'leehnus_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'leehnus_wrapper_end', 10);

function leehnus_wrapper_start() {
  echo '<main id="main">';
}

function leehnus_wrapper_end() {
  echo '</main>';
}

?>
