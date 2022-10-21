<?php
/**
 * Single post content
 *
 * @package Kent
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="posttitle">
		<?php the_title(); ?>
	</h1>
	<?php get_template_part( 'inc/postmetadata' ); ?>
	<section class="entry">
<?php
	the_content();

	edit_post_link();

	wp_link_pages( array(
		'before' => '<div class="archive-pagination">' . __( 'Pages: ', 'kent' ),
		'after'  => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
	) );
?>
		<p class="categories"><?php
	_e( 'Categories: ', 'kent' );
	the_category( ' ' );
?>
		</p>
<?php

	// display tags (if there are any
	if ( get_the_tags() ) {
		the_tags( '<p class="tags">' . __( 'Tagged as: ', 'kent' ), ' ', '</p>' );
	}

	get_template_part( 'author-details' );
?>
	</section>
</article>

<nav class="postnav" role="navigation">
	<div class="prev">
		<?php previous_post_link( __( '<span class="more-link">%link</span>', 'kent' ) ); ?>
	</div>
	<div class="next">
		<?php next_post_link( __( '<span class="more-link">%link</span>', 'kent' ) ); ?>
	</div>
</nav>
