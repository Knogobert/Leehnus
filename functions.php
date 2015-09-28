<?php
/* Functions for our theme
 *
 *
 * @theme Leehnus
 */

//$main_js_part = '/js/main.js';
//$main_style_part = '/css/main.css';

$version = '1.1';



function my_excerpt_length( $length ) {
	return 2;
}

add_filter('excerpt_length', 'my_excerpt_length');

function leehnus_add_styles_scripts( ) {

	if( WP_DEBUG == true ) {
		wp_enqueue_script( 'debug-js', get_template_directory_uri().'/js/debug.js');
	} else {
		wp_enqueue_script( 'main-js', get_template_directory_uri().'/js/main.js');
	}
	
	//Gets our css files in the header through the wp_head hook
	wp_enqueue_style( 'normalize', get_template_directory_uri().'/css/normalize.css', array(), $version );
	wp_enqueue_style( 'skeleton', get_template_directory_uri().'/css/skeleton.css', array(), $version );
	wp_enqueue_style( 'main', get_template_directory_uri().'/css/main.css', array(), $version );
}

add_action('wp_enqueue_scripts', 'leehnus_add_styles_scripts');

add_action('init', 'leehnus_add_theme_support');

function leehnus_add_theme_support() {
	add_theme_support('custom-background');
	add_theme_support('custom-header');
	add_theme_support('post-thumbnails');
	add_theme_support('post-formats', array('aside', 'video'));

	register_nav_menus(array(
		'main_menu' => 'Main menu',
		'footer_menu' => 'Footer menu'
	));
}

/* Our custom post types */
add_action('init', 'leehnus_post_types');

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

?>
