<?php
/**
 * Attachment template
 *
 * @package Kent
 */

	get_header();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<h1 class="posttitle"><?php the_title( '&#8216;', '&#8217;' ); ?></h1>

		<section class="entry">
<?php
	if ( $post->post_parent ) {
		$metadata = wp_get_attachment_metadata();
		printf( __( '<p class="postmetadata">Published <span class="entry-date"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a></p>', 'kent' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( wp_get_attachment_url() ),
			(int) $metadata['width'],
			(int) $metadata['height'],
			esc_url( get_permalink( $post->post_parent ) ),
			get_the_title( $post->post_parent )
		);
	}
?>
	<div class="attachment-image"><?php echo wp_get_attachment_link( $post->ID, array( 700, 500 ) ); ?></div>
<?php
	if ( ! has_excerpt() ) {
?>
		<div class="entry-caption">
			<?php the_excerpt(); ?>
		</div>
<?php
	}

	if ( $post->post_parent ) {
?>
			<p><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" rev="attachment"><?php esc_html_e( '&lsaquo; Back', 'kent' ); ?></a></p>
<?php
	}

	if ( comments_open() || '0' != get_comments_number() ) {
		comments_template( '', true );
	}
?>
		</section>
	</article>
<?php
	get_footer();
