<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo is_front_page() ? bloginfo('name') : wp_title() ?></title>
	<?php wp_head(); ?>
</head>
<body>
	<div class="page-wrapper">
		<header>
			<center>
				<a href="<?php bloginfo('url'); ?>">
					<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="Home" />
				</a>
			</center>
			<?php wp_nav_menu( array(
				'menu' => 'main menu',
				'theme_location' => 'main_menu',
				'container' => 'nav'
			) ); ?>
		</header>