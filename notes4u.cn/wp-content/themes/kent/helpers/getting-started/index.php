<?php
/**
 * Theme updater admin page and functions.
 *
 * @package kent
 */

/**
 * Redirect to Getting Started page on theme activation
 */
function kent_redirect_on_activation() {

    global $pagenow;

    if ( is_admin() && 'themes.php' === $pagenow && isset( $_GET['activated'] ) ) {

        wp_redirect( admin_url( 'themes.php?page=kent-getting-started' ) );

    }

}

add_action( 'admin_init', 'kent_redirect_on_activation' );


/**
 * Load Getting Started styles in the admin
 * @return [type] [description]
 */
function kent_load_admin_scripts() {

    // Load styles only on our page.
    global $pagenow;

    if ( 'themes.php' !== $pagenow ) {
        return false;
    }

    // Getting Started styles.
    wp_register_style( 'kent-getting-started', get_stylesheet_directory_uri() . '/helpers/getting-started/getting-started.css', false, '1.0.0' );
    wp_enqueue_style( 'kent-getting-started' );

}

add_action( 'admin_enqueue_scripts', 'kent_load_admin_scripts' );


/**
 * Adds a menu item for the Getting Started page
 */
function kent_getting_started_menu() {

    add_theme_page(
        esc_html__( 'Getting Started', 'kent' ),
        esc_html__( 'Getting Started', 'kent' ),
        'manage_options',
        'kent-getting-started',
        'kent_getting_started'
    );

}

add_action( 'admin_menu', 'kent_getting_started_menu' );


/**
 * Outputs the getting started page.
 */
function kent_getting_started() {

    // Include slimdown.
    include( get_stylesheet_directory() . '/helpers/inc/slimdown.php' );

    // Theme info.
    $theme = wp_get_theme();
    $theme_name = $theme->get( 'Name' );
    $theme_description = $theme->get( 'Description' );
    $theme_slug = basename( get_stylesheet_directory() );
    $theme_user = wp_get_current_user();

?>

        <div class="wrap getting-started about-wrap">

            <h1><?php printf( esc_html__( 'Getting started with %s', 'kent' ), esc_html( $theme_name ) ); ?></h1>

            <div class="about-text"><?php printf( esc_html__( 'Hi %s, thank you for installing %s! %s', 'kent' ), esc_html( $theme_user->display_name ), esc_html( $theme_name ), esc_html( $theme_description ) ); ?></div>

            <div class="panels">

<?php
    include( 'parts/help.php' );
    include( 'parts/plugins.php' );
?>

            </div>

        </div>

<?php

}
