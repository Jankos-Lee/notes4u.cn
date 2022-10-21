<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package new_blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function new_blog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'new_blog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function new_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'new_blog_pingback_header' );

function new_blog_modal() {
		if(absint(get_theme_mod('new_blog_popup_enable','1'))==1): ?>
			<a class=" btn " data-toggle="modal" data-target="#post-content-<?php the_ID(); ?>"><?php echo esc_html(get_theme_mod('new_blog_read_more_title',__('Read More', 'new-blog'))); ?></a>
			<!-- Modal -->
			<div class="modal fade" id="post-content-<?php the_ID(); ?>" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<a class=" btn " href="<?php the_permalink(); ?>"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
						<button type="button btn-dark" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body text-justify">
							<?php the_content();?>
						</div>

					</div>
				</div>
			</div>
		<?php else : ?>
			<a class=" btn float-left" href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('new_blog_read_more_title',__('Read More', 'new-blog'))); ?></a>
		<?php endif; 
	
}
