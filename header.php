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
		<center>
			<a href="<?php echo esc_url( home_url() ) ; ?>">
				<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="Home" />
			</a>
		</center>
		<!-- CUSTOM 4 rows below-->
		<form id="searchbar">
			<input type="text" placeholder="Live Search" onkeyup="showResult(this.value)">		
		</form>
		<div id="livesearch"></div> <!---Här syns resultaten-->
		<?php wp_nav_menu( array(
			'menu' => 'main menu',
			'theme_location' => 'main_menu',
			'container' => 'nav'
			) ); ?>
	</header>
	<div class="page-wrapper">
