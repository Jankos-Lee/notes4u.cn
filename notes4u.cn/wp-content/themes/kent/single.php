<?php
/**
 * Single post template
 *
 * @package Kent
 */

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content-single' );
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template( '', true );
			}
		}
	} else {
		get_template_part( 'content-empty' );
	}

	get_footer();