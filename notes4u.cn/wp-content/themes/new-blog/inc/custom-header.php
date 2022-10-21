<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package new_blog
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses new_blog_header_style()
 */
function new_blog_custom_header_setup() {
	
	add_theme_support( 'custom-header', apply_filters( 'new_blog_custom_header_args', array(
		'default-image'			=> get_parent_theme_file_uri( '/images/default-header-image.jpg'),
		'width'              => 1400,
		'height'             => 675,
		'flex-height'        => true,
		'wp-head-callback'   => 'new_blog_header_style',
	) ) );
	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/images/default-header-image.jpg',
			'thumbnail_url' => '%s/images/default-header-image.jpg',
			'description'   => __( 'Default Header Image', 'new-blog' ),
		),
	) );
}
add_action( 'after_setup_theme', 'new_blog_custom_header_setup' );

if ( ! function_exists( 'new_blog_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see new_blog_custom_header_setup().
	 */
	function new_blog_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
