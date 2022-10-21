<?php
/**
 * Generic content
 *
 * @package Kent
 */

	$image = get_the_post_thumbnail( get_the_ID(), 'kent-archive' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h2 class="posttitle">
		<a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink for: %s', 'kent' ), esc_attr( get_the_title() ) ); ?>" rel="bookmark">
			<?php the_title(); ?>
		</a>
	</h2>
	<section class="excerpt">
<?php
	if ( $image ) {
?>
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumbnail">
		<?php echo $image; ?>
	</a>
<?php
	}
	the_excerpt();
?>
		<p class="postmetadata">
		<?php
	printf( __( '<span class="author vcard"></span>  <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', 'kent' ),
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
	</section>
</article>
