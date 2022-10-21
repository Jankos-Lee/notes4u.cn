<?php
/**
 * Header Template
 *
 * @package Kent
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<nav class="menu" role="navigation">
		<a href="#" class="menu-close"><?php esc_html_e( '&lsaquo; 返回', 'kent' ); ?></a>
<?php
		get_search_form();
		wp_nav_menu(
			array(
				'theme_location' => 'top_menu',
				'menu_id' => 'nav',
				'menu_class' => 'menu-wrap animated',
			)
		);
?>
	</nav>

	<div class="container">
		<div class="page-main-nav">
			<a class="link-open-nav"><span><?php esc_html_e( '菜单', 'kent' ); ?></span></a>
			<a class="link-home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php esc_html_e( 'Home', 'kent' ); ?></span></a>
		</div>

		<div id="aside">
			<div id="cover-image">
				<div class="social_container animated fadeInDown">
<?php
	kent_user_avatar();
	kent_social_links();
?>
				</div>
			</div>
		</div>

		<div id="main" class="main">
			<header class="masthead animated fadeInLeft" role="banner">
				<div class="branding">
					<h1 class="logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'kent' ); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
					<h2 class="description">
						<?php bloginfo( 'description' ); ?>
					</h2>
				</div>
			</header>
