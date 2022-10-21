<?php
/**
 * Error - file not found
 *
 * @package Kent
 */

	get_header();
?>

<article>

	<h1 class="pagetitle"><?php esc_html_e( 'Error 404 - Not Found', 'kent' ); ?></h1>
	<p class="page-404"><?php esc_html_e( 'Sorry, but the page you are looking for has not been found. Try checking the URL for errors, then hit the refresh button in your browser.', 'kent' ); ?></p>

<?php
	$args = array(
		'posts_per_page' => 5,
		'ignore_sticky_posts' => true,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
?>
	<h3><?php esc_html_e( 'Recent Posts', 'kent' ); ?></h3>

	<ul>
<?php
		while ( $query->have_posts() ) {
			$query->the_post();
?>
		<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
		}
?>
	</ul>
<?php
	}

	wp_reset_postdata();

	get_search_form();
?>
</article>
<?php

	get_footer();
