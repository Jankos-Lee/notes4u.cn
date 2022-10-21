<?php
/**
 * Contributors listing
 *
 * @package Kent
 */

$contributor_ids = get_users(
	array(
		'fields'  => 'ID',
		'order'   => 'DESC',
		'who'     => 'authors',
	)
);

foreach ( $contributor_ids as $contributor_id ) {
	$post_count = count_user_posts( $contributor_id );

	// Move on if user has not published a post (yet).
	if ( ! $post_count ) {
		continue;
	}
?>
<div class="contributor">
	<?php echo get_avatar( $contributor_id, 140 ); ?>
	<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
	<p><?php echo get_the_author_meta( 'description', $contributor_id ); ?></p>
	<a class="contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
		<?php printf( _n( '%d Article', '%d Articles', $post_count, 'kent' ), (int) $post_count ); ?>
	</a>
</div>
<?php
}
