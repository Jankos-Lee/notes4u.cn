<?php
/**
 * Page content
 *
 * @package Kent
 */
?>
<article class="no-results not-found">
	<section class="entry">
<?php

	if ( is_home() && current_user_can( 'publish_posts' ) ) {

?>
		<h1 class="posttitle"><?php esc_html_e( 'Nothing Found', 'kent' ); ?></h1>
		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kent' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
<?php

	} if ( is_search() ) {

?>
		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kent' ); ?></p>
<?php
		get_search_form();

	} else {
?>
		<h1 class="posttitle"><?php esc_html_e( 'Nothing Found', 'kent' ); ?></h1>
		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'kent' ); ?></p>
<?php
		get_search_form();

	}
?>
	</section>
</article>
