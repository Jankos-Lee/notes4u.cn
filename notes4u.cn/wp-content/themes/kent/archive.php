<?php
/**
 * Archive Template
 *
 * @package Kent
 */

	get_header();

	if ( have_posts() ) {

		if ( is_category() ) {

			$title = single_cat_title( '', false );

		} elseif ( is_tag() ) {

			$title = single_tag_title( '', false );

		} elseif ( is_author() ) {

			$title = sprintf( __( 'Author: %s', 'kent' ), '<span class="vcard">' . get_the_author() . '</span>' );

		} elseif ( is_day() ) {

			$title = sprintf( __( 'Day: %s', 'kent' ), '<span>' . get_the_date() . '</span>' );

		} elseif ( is_month() ) {

			$title = sprintf( __( 'Month: %s', 'kent' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'kent' ) ) . '</span>' );

		} elseif ( is_year() ) {

			$title = sprintf( __( 'Year: %s', 'kent' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'kent' ) ) . '</span>' );

		} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {

			$title = __( 'Asides', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {

			$title = __( 'Galleries', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {

			$title = __( 'Images', 'kent');

		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = __( 'Videos', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {

			$title = __( 'Quotes', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {

			$title = __( 'Links', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {

			$title = __( 'Statuses', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {

			$title = __( 'Audios', 'kent' );

		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {

			$title = __( 'Chats', 'kent' );

		} else {

			$title = __( 'Archives', 'kent' );

		}
?>
	<div class="page-header">
		<h1 class="pagetitle"><?php echo $title; ?></h1>
<?php
		the_archive_description( '<div class="category-description">', '</div>' );
?>
	</div>
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
