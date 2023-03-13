<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

	<header id="header" class="header">
		<div class="header__brand">
			<?php
			if ( is_front_page() || is_home() ) : ?>
				<h1 class="header__brand_logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</h1>
			<?php else : ?>
				<p class="header__brand_logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</p>
			<?php
			endif;
			?>

		</div>

		<nav id="header-navigation" class="main-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'menu-main', 'menu_id' => 'menu-main' ) ); ?>
		</nav>
		<!-- #header-navigation -->
	</header>
	<!-- #header -->

	<div id="content" class="content">
