<?php
/**
 * Author meta info
 *
 * @package Kent
 */

	if ( is_single() ) {
		$user_id = get_the_author_meta( 'ID' );
	} else {
		$user_id = get_query_var( 'author' );
	}
?>
	<div class="writer">
		<?php echo get_avatar( get_the_author_meta( 'user_email', $user_id ), '100' ); ?>
		<h3><?php the_author_meta( 'display_name', $user_id ); ?></h3>
		<?php echo wpautop( get_the_author_meta( 'description', $user_id ) ); ?>
	</div>
