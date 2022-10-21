<?php
/**
 * Template Name: Contributor Page
 *
 * @package Kent
 */

	get_header();

	if ( have_posts() ) {
?>
	<div class="main-content">
<?php
		while ( have_posts() ) {
			the_post();
?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
			the_title( '<h1 class="title">', '</h1>' );
?>
			<section class="entry">
<?php
			the_content();
?>
				<hr />
<?php
			get_template_part( 'content-contributors' );
			edit_post_link();
?>
			</section>
		</article>
<?php
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template( '', true );
			}
		}
?>
	</div>
<?php
	} else {
		get_template_part( 'content-empty' );
	}

	get_footer();
