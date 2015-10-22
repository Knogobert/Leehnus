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

/**
 * Register our sidebars and widgetized areas.
 *
 */
function alphabet_widgets_init() {

    register_sidebar( array(
        'name'          => 'Footer Social',
        'id'            => 'footer_social',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'alphabet_widgets_init' );

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

// Shortcode for contact form
//___________________________________________________

function leehnus_get_the_ip() {
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    else {
        return $_SERVER["REMOTE_ADDR"];
    }
}

function leehnus_contact_form_sc( $atts ) {
	extract( shortcode_atts( array(
	    // if you don't provide an e-mail address, the shortcode will pick the e-mail address of the admin:
	    "email" => get_bloginfo( 'admin_email' ),
	    "subject" => "",
	    "label_name" => "Name",
	    "label_email" => "E-mail",
	    "label_subject" => "Subject",
	    "label_message" => "Message",
	    "label_submit" => "Submit",
	    // the error message when at least one of the required fields are empty:
	    "error_empty" => "Please fill in all the required fields.",
	    // the error message when the e-mail address is not valid:
	    "error_noemail" => "Please enter a valid e-mail address.",
	    // and the success message when the e-mail is sent:
	    "success" => "Thanks for your e-mail! We'll get back to you as soon as we can."
	), $atts ) );
	
	// if there's no $result text (meaning there's no error or success, meaning the user just opened the page and did nothing) there's no need to show the $info variable
	if ( $result != "" ) {
	    $info = '<div class="info">' . $result . '</div>';
	}
	// anyways, let's build the form! (remember that we're using shortcode attributes as variables with their names) dont mind this: ' . get_permalink() . '
	$email_form = '<form class="contactForm" method="post" action="">
	    <input placeholder="' . $label_name . '" type="text" name="your_name" id="cf_name" class="contact-input" size="50" maxlength="50" value="' . $form_data['your_name'] . '" />
	    <input placeholder="' . $label_email . '" type="text" name="email" id="cf_email" class="contact-input" size="50" maxlength="50" value="' . $form_data['email'] . '" />
	    <textarea placeholder="' . $label_message . '" name="message" id="cf_message" class="contact-input">' . $form_data['message'] . '</textarea>
	    <input type="submit" value="' . $label_submit . '" name="send" id="cf_send" class="contact-input" />
	</form>';
	
	
	// if the <form> element is POSTed, run the following code
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	    $error = false;
	    // set the "required fields" to check
	    $required_fields = array( "your_name", "email", "message", );
	 
	    // this part fetches everything that has been POSTed, sanitizes them and lets us use them as $form_data['subject']
	    foreach ( $_POST as $field => $value ) {
	        if ( get_magic_quotes_gpc() ) {
	            $value = stripslashes( $value );
	        }
	        $form_data[$field] = strip_tags( $value );
	    }
	 
	    // if the required fields are empty, switch $error to TRUE and set the result text to the shortcode attribute named 'error_empty'
	    foreach ( $required_fields as $required_field ) {
	        $value = trim( $form_data[$required_field] );
	        if ( empty( $value ) ) {
	            $error = true;
	            $result = $error_empty;
	        }
	    }
	 
	    // and if the e-mail is not valid, switch $error to TRUE and set the result text to the shortcode attribute named 'error_noemail'
	    if ( ! is_email( $form_data['email'] ) ) {
	        $error = true;
	        $result = $error_noemail;
	    }
	 
	    if ( $error == false ) {
	        $email_subject = "[" . get_bloginfo( 'name' ) . "] " . "Contact Form";
	        $email_message = $form_data['message'] . "\n\nIP: " . leehnus_get_the_ip();
	        $headers  = "From: " . $form_data['name'] . " <" . $form_data['email'] . ">\n";
	        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
	        $headers .= "Content-Transfer-Encoding: 8bit\n";
	        wp_mail( $email, $email_subject, $email_message, $headers );
	        $result = $success;
	        $sent = true;
	    }
	    // but if $error is still FALSE, put together the POSTed variables and send the e-mail!
	    if ( $error == false ) {
	        // get the website's name and puts it in front of the subject
	        $email_subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'];
	        // get the message from the form and add the IP address of the user below it
	        $email_message = $form_data['message'] . "\n\nIP: " . leehnus_get_the_ip();
	        // set the e-mail headers with the user's name, e-mail address and character encoding
	        $headers  = "From: " . $form_data['your_name'] . " <" . $form_data['email'] . ">\n";
	        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
	        $headers .= "Content-Transfer-Encoding: 8bit\n";
	        // send the e-mail with the shortcode attribute named 'email' and the POSTed data
	        wp_mail( $email, $email_subject, $email_message, $headers );
	        // and set the result text to the shortcode attribute named 'success'
	        $result = $success;
	        // ...and switch the $sent variable to TRUE
	        $sent = true;
	    }
	}
	
	if ( $sent == true ) {
		echo "<script type='text/javascript'>alert('Your message has been sent!');</script>";
	    return $info . $email_form;
	} else {
	    return $info . $email_form;
	}
}
add_shortcode( 'contact', 'leehnus_contact_form_sc' );



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
//      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
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
function myplugin_add_meta_box($test) {


	$screens = array( 'post', 'page', 'contact' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'myplugin_sectionid',
			__( 'My Post Section Title', 'myplugin_textdomain' ),
			'myplugin_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_save_meta_box_data', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_my_meta_value_key', true );

	echo '<label for="myplugin_new_field">';
	_e( 'Description for this field', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function myplugin_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_save_meta_box_data' ) ) {
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
	if ( ! isset( $_POST['myplugin_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );

?>
