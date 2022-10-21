<?php
/**
 * Post meta data
 *
 * @package Kent
 */
?>
	<p class="postmetadata">
<?php
	printf( __( 'By <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span> on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', 'kent' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'kent' ), get_the_author() ) ),
		get_the_author()
	);

	if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
?>
	&bull; <span class="commentcount">( <?php comments_popup_link( __( 'Leave a comment', 'kent'), __( '1 Comment', 'kent' ), __( '% Comments', 'kent' ) ); ?> )</span>
<?php
	}
?>
	</p>
