<?php
/**
 * Homepage Template
 *
 * @package Kent
 */

	get_header();

	if ( have_posts() ) {
?>
	<div id="main-content">
<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content' );
		}

		the_posts_pagination();
?>
	</div>
<?php
	} else {
		get_template_part( 'content-empty' );
	}

	get_footer();
