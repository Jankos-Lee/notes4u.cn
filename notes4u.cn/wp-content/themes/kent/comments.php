<?php
/**
 * Comments template.
 *
 * @package Kent
 */

	if ( post_password_required() ) {
		return;
	}

	// Show the comments.
	if ( have_comments() ) {
?>
<section id="comments-container">
	<h3 id="comments">
<?php
		printf( _n( '1 reply', '%1$s replies', get_comments_number(), 'kent' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
?>
		<a href="#respond" title="<?php esc_attr_e( 'Leave a comment', 'kent' ); ?>">&rsaquo;</a>
	</h3>
	<ol class="commentlist" id="singlecomments">
<?php
	wp_list_comments(
		array(
			'style' => 'ol',
			'short_ping' => true,
			'avatar_size' => 54,
		)
	);
?>
	</ol>
</section>
<div class="postnav">
	<div class="prev">
		<?php previous_comments_link( __( 'Older Comments', 'kent' ) ); ?>
	</div>
	<div class="next">
		<?php next_comments_link( __( 'Newer Comments', 'kent' ) ); ?>
	</div>
</div>
<?php
	}

	if ( 'open' === $post->comment_status ) {
		comment_form();
	}
