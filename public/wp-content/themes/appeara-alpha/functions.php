<?php
/**
 * Theme Name: Appeara Alpha
 * Theme URI:  https://enpii.com/wordpress/appeara-alpha
 * Description: Demo theme to use Enpii Base for development, use legacy theme structure
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     1.0.0
 * Text Domain: enpii
 */

use Enpii\Appeara_Alpha\App\WP\Appeara_Alpha_WP_Theme;

// Update these constants whenever you bump the version
defined( 'APPEARA_ALPHA_VERSION' ) || define( 'APPEARA_ALPHA_VERSION', '1.0.0' );

// We set the slug for the theme here.
// This slug will be used to identify the theme instance from the WP_Application container
defined( 'APPEARA_ALPHA_SLUG' ) || define( 'APPEARA_ALPHA_SLUG', 'appeara-alpha' );


// We include composer autoload here
if ( ! class_exists( Appeara_Alpha_WP_Theme::class ) ) {
	require_once __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';
}

// We register this theme as a Service Provider
Appeara_Alpha_WP_Theme::init_with_wp_app( APPEARA_ALPHA_SLUG );
