<?php
/**
 * Reusable theme functions
 *
 * @package Kent
 */

// This is the max width - it's the same on all pages.
// Keep in mind the theme is responsive so the width is likely to be narrower.
if ( ! isset( $content_width ) ) {
	$content_width = 656;
}

require 'inc/jetpack.php';


/**
 * Do custom colours using theme customiser to select options
 *
 * @return array
 */
function kent_colour_styles() {

?>
<style>
<?php
	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) {
?>
	#cover-image {
		background-image: url( <?php echo esc_url( $header_image ); ?> );
	}
<?php
	}

	if ( 'blank' === get_header_textcolor() ) {
?>
	#branding { display:none; }
<?php
	} else {
?>
	#branding h1#logo a { color:#<?php echo esc_attr( get_header_textcolor() ); ?>; }
	#branding h1#logo a:hover { color:#<?php echo esc_attr( get_header_textcolor() ); ?>; }
<?php
	}
?>
</style>
<?php

	return true;

}

// Changed priority so that it fires before the custom wp.com colours.
add_action( 'wp_head', 'kent_colour_styles', 9 );


/**
 * Enqueue all the styles.
 */
function kent_enqueue() {

	if ( ! is_admin() ) {

		wp_enqueue_style( 'kent-style', get_template_directory_uri() . '/styles/css/styles.css', null, '1.2' );
		wp_enqueue_style( 'kent-animate', get_template_directory_uri() . '/styles/css/animate.css', null, '1.0' );
		wp_enqueue_style( 'genericons', get_template_directory_uri() . '/styles/genericons/genericons.css', array(), '3.0.3' );

		// Fonts.
		$fonts_url = kent_fonts();

		if ( $fonts_url ) {
			wp_enqueue_style( 'kent-fonts', $fonts_url, array(), '1.0' );
		}
	}

	wp_enqueue_script( 'kent-script-main', get_template_directory_uri() . '/js/main.js', array( 'jquery', 'masonry' ), '1.1', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'kent_enqueue' );


/**
 * Set up all the theme properties and extras
 */
function kent_after_setup_theme() {

	load_theme_textdomain( 'kent', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	// Post thumbnails.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'kent-archive', 160, 160, true );

	// HTML5 FTW.
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'search-form',
			'comment-form',
			'navigation-widgets',
		)
	);

	// Custom background.
	$args = array(
		'default-color' => 'fff',
	);
	add_theme_support( 'custom-background', $args );

	add_theme_support(
		'custom-header',
		array(
			'default-image' => apply_filters( 'kent_header_image', '%s/images/headers/corn.jpg' ),
			'default-text-color' => apply_filters( 'kent_header_textcolor', 'cccccc' ),
			'random-default' => false,
			'width' => 900,
			'height' => 900,
			'flex-height' => false,
			'header-text' => true,
			'uploads' => true,
			'wp-head-callback' => 'kent_custom_header',
			'admin-head-callback' => '',
			'admin-preview-callback' => '',
		)
	);

	register_default_headers(
		array(
			'corn' => array(
				'url' => '%s/images/headers/corn.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/corn.jpg',
				'description' => __( 'Corn', 'kent' ),
			),
			'hills' => array(
				'url' => '%s/images/headers/hills.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/hills.jpg',
				'description' => __( 'Hills', 'kent' ),
			),
			'barcelona-traffic' => array(
				'url' => '%s/images/headers/barcelona-traffic.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/barcelona-traffic.jpg',
				'description' => __( 'Barcelona Traffic', 'kent' ),
			),
			'blurred-lines' => array(
				'url' => '%s/images/headers/blurred-lines.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/blurred-lines.jpg',
				'description' => __( 'Blurred Lines', 'kent' ),
			),
			'bright-lights-big-city' => array(
				'url' => '%s/images/headers/bright-lights-big-city.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/bright-lights-big-city.jpg',
				'description' => __( 'Bright Lights Big City', 'kent' ),
			),
			'carmel' => array(
				'url' => '%s/images/headers/carmel.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/carmel.jpg',
				'description' => __( 'Carmel', 'kent' ),
			),
			'ocean' => array(
				'url' => '%s/images/headers/ocean.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/ocean.jpg',
				'description' => __( 'Ocean', 'kent' ),
			),
			'deep-in-the-forest' => array(
				'url' => '%s/images/headers/deep-in-the-forest.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/deep-in-the-forest.jpg',
				'description' => __( 'Deep in the Forest', 'kent' ),
			),
			'dew' => array(
				'url' => '%s/images/headers/dew.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/dew.jpg',
				'description' => __( 'Dew', 'kent' ),
			),
			'jet-sky' => array(
				'url' => '%s/images/headers/jet-sky.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/jet-sky.jpg',
				'description' => __( 'Jet Sky', 'kent' ),
			),
			'maldives' => array(
				'url' => '%s/images/headers/maldives.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/maldives.jpg',
				'description' => __( 'Maldives', 'kent' ),
			),
			'missionpeak' => array(
				'url' => '%s/images/headers/missionpeak.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/missionpeak.jpg',
				'description' => __( 'Mission Peak', 'kent' ),
			),
			'stones' => array(
				'url' => '%s/images/headers/stones.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/stones.jpg',
				'description' => __( 'Stars', 'kent' ),
			),
			'tuscany' => array(
				'url' => '%s/images/headers/tuscany.jpg',
				'thumbnail_url' => '%s/images/headers-thumbs/tuscany.jpg',
				'description' => __( 'Tuscany', 'kent' ),
			),
		)
	);

	// Other random filters.
	add_filter( 'the_content_more_link', 'kent_more_link', 10, 2 );
	add_filter( 'excerpt_length', 'kent_excerpt_length', 999 );
	add_filter( 'wp_page_menu', 'kent_add_menu_class' );

	// Register menu.
	register_nav_menu(
		'top_menu',
		esc_html__( 'Top Menu', 'kent' )
	);

	// Add support for full width images and other content such as videos.
	add_theme_support( 'align-wide' );

	// Disable custom font sizes, ensuring consistent vertical rhythm.
	add_theme_support( 'disable-custom-font-sizes' );

	// Make Gutenberg embeds responsive.
	add_theme_support( 'responsive-embeds' );

	// Editor font sizes.
	// Uses the default slugs to ensure consistency across themes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => esc_html__( 'small', 'kent' ),
				'size' => 14.45,
				'slug' => 'small',
			),
			array(
				'name' => esc_html__( 'normal', 'kent' ),
				'size' => 18,
				'slug' => 'normal',
			),
			array(
				'name' => esc_html__( 'medium', 'kent' ),
				'size' => 21,
				'slug' => 'medium',
			),
			array(
				'name' => esc_html__( 'large', 'kent' ),
				'size' => 24,
				'slug' => 'large',
			),
			array(
				'name' => esc_html__( 'huge', 'kent' ),
				'size' => 36,
				'slug' => 'huge',
			),
		)
	);

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Editor Style.
	$fonts_url = kent_fonts();

	if ( $fonts_url ) {
		add_editor_style( $fonts_url );
	}

	add_editor_style( 'styles/css/editor-styles.css' );

}


/**
 * Get url for google fonts.
 *
 * @return string|false
 */
function kent_fonts() {

	$fonts = array();

	/**
	 * Translators: If there are characters in your language that are not
	 * supported, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$font = esc_html_x( 'on', 'Roboto Slab: on or off', 'kent' );

	if ( 'off' !== $font ) {
		$fonts['roboto-slab'] = 'Roboto Slab:300,400';
	}

	/**
	 * Translators: If there are characters in your language that are not
	 * supported, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$font = esc_html_x( 'on', 'Open Sans: on or off', 'kent' );

	if ( 'off' !== $font ) {
		$fonts['open-sans'] = 'Open+Sans:700';
	}

	$fonts = apply_filters( 'kent_fonts', $fonts );

	if ( $fonts ) {
		$query_args = array(
			'family' => rawurlencode( implode( '|', $fonts ) ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		);

		return add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return false;

}


/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function kent_editor_blocks_styles() {

	// Load the additional editor styles.
	// This covers things like the editor title that can't be styled with the normal editor styles.
	wp_enqueue_style( 'kent-editor-blocks', get_theme_file_uri( '/styles/css/editor-blocks.css' ), null, '1' );

	/**
	 * Overwrite Core theme styles with empty styles.
	 * @see https://github.com/WordPress/gutenberg/issues/7776#issuecomment-406700703
	 */
	wp_deregister_style( 'wp-block-library-theme' );
	wp_register_style( 'wp-block-library-theme', '' );

}

add_action( 'enqueue_block_editor_assets', 'kent_editor_blocks_styles' );
add_action( 'enqueue_block_assets', 'kent_editor_blocks_styles' );


/**
 * Register footer widgets
 */
function kent_widgets_init() {

	// Footer widgets.
	register_sidebar(
		array(
			'name' => __( 'Footer Widgets', 'kent' ),
			'id' => 'sidebar-1',
			'description' => __( 'Widgets that display at the bottom of your website.', 'kent' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		)
	);

}

add_action( 'widgets_init', 'kent_widgets_init' );


/**
 * Custom header
 */
function kent_custom_header() {

	$text_colour = get_header_textcolor();
	if ( 'blank' === $text_colour ) {
		$header_style = 'text-indent:-9999em;';
	} else {
		$header_style = 'color:#' . get_header_textcolor() . ';';
	}
?>
<style>
#main header.masthead h1.logo a,
#main header.masthead h2.description {
<?php echo esc_html( $header_style ); ?>
}
<?php
	if ( 'blank' === $text_colour ) {
?>
	#main header.masthead { display:none; }
<?php
	}
?>
</style>
<?php

}


/**
 * Change 'read more' link
 *
 * @param type $more_link
 * @param type $more_link_text
 * @return type
 */
function kent_more_link( $more_link, $more_link_text ) {

	return str_replace( $more_link_text, __( 'Continue reading &rarr;', 'kent' ), $more_link );

}


/**
 * Custom excerpt length
 *
 * @param type $length Default excerpt length.
 * @return int
 */
function kent_excerpt_length( $length ) {

	return 50;

}


/**
 * Add an id to the menu list item for easier tageting.
 *
 * @param string $html Menu html.
 * @return string
 */
function kent_add_menu_class( $html ) {

	return preg_replace( '/<ul>/', '<ul id="nav">', $html, 1 );

}


/**
 * Add header image if it's visible and make sure it links to the homepage.
 */
function kent_header() {

	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) {
?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="header-image">
			<img src="<?php header_image(); ?>" width="<?php echo (int) get_custom_header()->width; ?>" height="<?php echo (int) get_custom_header()->height; ?>" alt="" />
		</a>
<?php
	}

}

add_action( 'after_setup_theme', 'kent_after_setup_theme' );


/**
 * Estimate time required to read the article
 *
 * @return string
 */
function kent_estimated_reading_time() {

	$post = get_post();

	$words = str_word_count( wp_strip_all_tags( $post->post_content ) );
	$minutes = floor( $words / 120 );
	$seconds = floor( $words % 120 / ( 120 / 60 ) );

	if ( 1 <= $minutes ) {
		// translators: %d = time in minutes.
		$estimated_time = sprintf( _n( '%d minute', '%d minutes', $minutes, 'kent' ), $minutes );
	} else {
		// translators: %d = time in seconds.
		$estimated_time = sprintf( _n( '%d second', '%d seconds', $seconds, 'kent' ), $seconds );
	}

	return $estimated_time;

}


/**
 * Display the avatar for the selected user
 */
function kent_user_avatar() {

	$username = get_theme_mod( 'kent_avatar_username', '' );

	if ( $username ) {
		$user_id = username_exists( $username );
		if ( $user_id ) {
			echo get_avatar( $user_id );
		}
	}

}


/**
 * Theme customizer properties
 *
 * @param object $wp_customize Customizer object.
 */
function kent_customizer_settings( $wp_customize ) {

	// Kent theme options section.
	$wp_customize->add_section(
		'kent_options',
		array(
			'title' => esc_html__( 'Theme', 'kent' ),
			'description' => esc_html__( 'Options for the Kent theme.', 'kent' ),
		)
	);

	// Setting to display a user avatar in the sidebar.
	$wp_customize->add_setting(
		'kent_avatar_username',
		array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'kent_avatar_username',
		array(
			'label' => esc_html__( 'Username for avatar to show in sidebar', 'kent' ),
			'section' => 'kent_options',
			'type' => 'text',
		)
	);

}


add_action( 'customize_register', 'kent_customizer_settings' );

add_filter( 'use_default_gallery_style', '__return_false' );
