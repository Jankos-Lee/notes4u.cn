<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Kent
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function kent_infinite_scroll_init() {

	$settings = array(
		'container' => 'main-content',
		'footer_widgets' => 'sidebar-1',
		'footer' => false,
	);

	add_theme_support( 'infinite-scroll', $settings );

	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'jetpack-social-menu' );

	add_theme_support(
		'social-links',
		array(
			'facebook',
			'twitter',
			'linkedin',
			'tumblr',
		)
	);

}

add_action( 'after_setup_theme', 'kent_infinite_scroll_init' );


/**
 * Get social links from jetpack publicise functionality
 * http://jetpack.me/support/social-links/
 */
function kent_social_links() {

	/**
	 * If Jetpack social menu is active, and has some menu items then display
	 * that. Else use the older social links.
	 */
	if ( function_exists( 'jetpack_social_menu' ) && has_nav_menu( 'jetpack-social-menu' ) ) {
		jetpack_social_menu();
		return;
	}

	$social_links = array(
		'twitter',
		'facebook',
		'google_plus',
		'tumblr',
		'linkedin',
	);
	$links = '';

	foreach ( $social_links as $social ) {

		$url = get_theme_mod( 'jetpack-' . $social );
		if ( $url ) {
			$links .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( 'social_link_' . $social ) . '"><span>' . $social . '</span></a>';
		}
	}

	if ( $links ) {
		echo '<div class="social_links">' . $links . '</div>';
	}

}
