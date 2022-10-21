<?php
/**
 * Page content
 *
 * @package Kent
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( '<h1 class="pagetitle">', '</h1>' ); ?>
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
	</section>
</article>
