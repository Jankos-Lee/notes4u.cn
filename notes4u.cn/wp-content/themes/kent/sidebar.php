<?php
/**
 * Sidebar template
 *
 * @package Kent
 */

	if ( is_active_sidebar( 'sidebar-1' ) ) {
?>
<aside class="col-sidebar">
<?php
		do_action( 'before_sidebar' );
		dynamic_sidebar( 'sidebar-1' );
?>
</aside>
<?php
	}
