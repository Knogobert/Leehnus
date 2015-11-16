<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo is_front_page() ? bloginfo('name') : wp_title() ?></title>
	<?php wp_head(); ?>
</head>
<body>
	<header>
		<div id="logoContainer">
			<a href="<?php echo esc_url( home_url() ) ; ?>" style="width:<?php echo get_custom_header()->width; ?>px;">
				<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="Home" />
			</a>
			<?php get_search_form(); ?>
		</div>
		<?php wp_nav_menu( array(
			'menu' => 'main menu',
			'theme_location' => 'main_menu',
			'container' => 'nav'
			) ); ?>
	</header>
	<div class="page-wrapper">
