( function( $ ) {

	var $container = $( '.container' );
	var $aside = $( '#aside, .page-main-nav, body, nav.menu' );
	// widgets that may contain content that could change size during load
	var widget_footer_parent = '.col-sidebar';
	var masonry_footer_properties = {};
	var masonry_test_interval = 100;
	var masonry_old_height = 0;

	function masonry_reload() {

		$( widget_footer_parent ).masonry( masonry_footer_properties );

	}

	function masonry_widget_load_test() {

		var height = 0;

		// get combined height of all widgets
		$( widget_footer_parent ).find( '.widget' ).each( function() {
			height += $( this ).height();
		} );

		// if height has changed then reposition widgets
		// also reset interval in case something is still loading
		// note that because default 'old' height is 0 this will always get called first time around
		if ( masonry_old_height < height ) {
			masonry_reload();
			masonry_test_interval = 100;
		}

		masonry_old_height = height;
		masonry_test_interval = Math.floor( masonry_test_interval * 2 );

		// no resizing in 5 seconds
		if ( masonry_test_interval < 3000 ) {
			setTimeout( masonry_widget_load_test, masonry_test_interval );
		}

	}

	function toggleTOC() {

		var opened = $container.data( 'opened' );

		if ( opened ) {
			closeTOC();
		} else {
			openTOC();
		}

	}

	function openTOC() {

		$container.addClass( 'slide' );
		$container.data( 'opened', true );
		$aside.addClass( 'slide' );
		$( '.menu .searchform' ).removeClass( 'fadeOutUp' ).addClass( 'fadeInDown' );
		$( '.menu #nav' ).removeClass( 'fadeOutLeft' ).addClass( 'fadeInLeft' );
		$( '.page-main-nav, .social_links, #cover-image .avatar' ).fadeOut();

	}

	function closeTOC() {

		$container.removeClass( 'slide' );
		$container.data( 'opened', false );
		$aside.removeClass( 'slide' );
		$( '.menu .searchform' ).removeClass( 'fadeInDown' ).addClass( 'fadeOutUp' );
		$( '.menu #nav' ).removeClass( 'fadeInLeft' ).addClass( 'fadeOutLeft' );
		$( '.page-main-nav, .social_links, #cover-image .avatar' ).fadeIn();

	}

	$( document ).ready( function() {

		// Set default heights for social media widgets

		// Twitter
		$( 'a.twitter-timeline, iframe.twitter-timeline' ).each( function() {

			var thisHeight = $( this ).attr( 'height' );
			$( this ).parent().css( 'min-height', thisHeight + 'px' );

		} );

		// Facebook
		$( '.fb-page' ).each( function() {

			var $set_height = $( this ).data( 'height' );
			var $show_facepile = $( this ).data( 'show-facepile' );
			var $show_posts = $( this ).data( 'show-posts' ); // AKA stream
			var $min_height = $set_height; // set the default 'min-height'

			// These values are defaults from the FB widget.
			var $no_posts_no_faces = 130;
			var $no_posts = 220;

			if ( $show_posts ) {

				// Showing posts; may also be showing faces and/or cover - the latter doesn't affect the height at all.
				$min_height = $set_height;

			} else if ( $show_facepile ) {

				// Showing facepile with or without cover image - both would be same height.
				// If the user selected height is lower than the no_posts height, we'll use that instead
				$min_height = ( $set_height < $no_posts ) ? $set_height : $no_posts;

			} else {

				// Either just showing cover, or nothing is selected (both are same height).
				// If the user selected height is lower than the no_posts_no_faces height, we'll use that instead
				$min_height = ( $set_height < $no_posts_no_faces ) ? $set_height : $no_posts_no_faces;

			}

			// apply min-height to .fb-page container
			$( this ).css( 'min-height', $min_height + 'px' );

		} );


		// side menu open and close

		$( 'a.link-open-nav' ).on(
			'click',
			function() {
				toggleTOC();
			}
		);

		$( '.menu a.menu-close' ).on(
			'click',
			function() {
				closeTOC();
				return false;
			}
		);

		$( '.container' ).append( '<div class="slide_overlay" />' );

		$( '.slide_overlay' ).on(
			'click',
			function() {
				var opened = $container.data( 'opened' );
				if ( opened ) {
					closeTOC();
				}
			}
		);

		$( '.menu ul ul' ).hide().parent( 'li' ).find( 'a:first' ).addClass( 'menu-has-children' );

		// expandable menus
		var expand_link = $( '<a class="menu-expand">+</a>' );

		$( '.menu ul ul' ).before( expand_link );

		$( 'a.menu-expand, a.menu-has-children:not([href])' ).on(
			'click',
			function() {

				var $this = $( this );
				var $child = $this.parent().find( 'ul:first' );
				var $toggle = $this;
				var visible = $child.is( ':visible' );

				if ( $this.hasClass( 'menu-has-children' ) ) {
					$toggle = $this.parent().find( 'a.menu-expand' ).first();
				}

				if ( visible ) {
					$child.slideUp( 250 );
					$toggle.html( '+' );
				} else {
					$child.slideDown( 250 );
					$toggle.html( '-' );
				}

				return false;

			}
		);

		// Arrange footer widgets vertically.
		if ( typeof $.fn.masonry === 'function' ) {

			masonry_footer_properties = {
				itemSelector: '.widget',
				gutter: 0,
				isOriginLeft: !$( 'body' ).is( '.rtl' )
			};

			masonry_widget_load_test();

		}

	} );

} )( jQuery );
