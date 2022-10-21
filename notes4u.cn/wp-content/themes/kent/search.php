<?php
/**
 * Search results template
 *
 * @package Kent
 */

	get_header();
?>

	<div class="page-header">		
		<h1 class="pagetitle">
			<?php printf( __( 'Search results for &#8216;<em>%s</em>&#8217;', 'kent' ), get_search_query() ); ?>
		</h1>
	</div>
<?php
	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();
			get_template_part( 'content' );
		}

		the_posts_pagination();

	} else {

		get_template_part( 'content-empty' );

	}

	get_footer();
