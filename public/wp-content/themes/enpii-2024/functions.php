<?php
/**
 * Theme Name: Enpii Theme 2024
 * Theme URI:  https://enpii.com/wordpress/enpii-theme
 * Description: Enpii master theme to use Enpii Base for development, use legacy theme structure
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     1.0.0
 * Text Domain: enpii
 */

use WP_Theme_Enpii_2024\App\WP\Enpii_2024_WP_Theme;

// Update these constants whenever you bump the version
defined( 'ENPII_VERSION' ) || define( 'ENPII_VERSION', '1.0.0' );

// We set the slug for the theme here.
// This slug will be used to identify the theme instance from the WP_Application container
defined( 'ENPII_SLUG' ) || define( 'ENPII_SLUG', 'enpii-2024' );


// We include composer autoload here
if ( ! class_exists( Enpii_2024_WP_Theme::class ) ) {
	require_once __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';
}

// We register this theme as a Service Provider
Enpii_2024_WP_Theme::init_with_wp_app( ENPII_SLUG );
