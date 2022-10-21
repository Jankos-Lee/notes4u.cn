<?php
/**
 * Author post listing
 *
 * @package Kent
 */

	get_header();
?>
	<h1 class="pagetitle">
		<?php esc_html_e( 'Author Archives', 'kent' ); ?>
	</h1>
<?php
	get_template_part( 'author-details' );

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
