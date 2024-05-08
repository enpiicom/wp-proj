<?php
/**
 * Plugin Name: Demoda
 * Plugin URI:  https://enpii.com/wp-plugin-demoda/
 * Description: Demo plugin to use Enpii Base for development
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     1.0.0
 * Text Domain: demoda
 */
use Enpii_Base\App\Support\App_Const;
use Enpii\Demoda\App\WP\Demoda_WP_Plugin;
use Enpii\Demoda\App\Support\Demoda_Helper;

// Update these constants whenever you bump the version
//  We put this constant here for the convenience when bump the version
defined( 'DEMODA_PLUGIN_VERSION' ) || define( 'DEMODA_PLUGIN_VERSION', '1.0.0' );
defined( 'DEMODA_PLUGIN_SLUG' ) || define( 'DEMODA_PLUGIN_SLUG', 'demoda' );

if ( ! class_exists( Demoda_WP_Plugin::class ) ) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

/**
| We need to check the plugin mandatory requirements first
 */
// It's better to check the prerequisites using the `plugins_loaded`, low priority,
//  rather than the activation hook because there is a case where this plugin is already
//  enabled but then the mandatory prerequisites are disabled after
// We need to use the hook `plugins_loaded` here rather than put to the WP Plugin class
//  because there is the posibility Enpii Base or WooCommerce not loaded
//  and the WP Plugin use the resources from these 2 therefore it may produce errrors
add_action(
	'plugins_loaded',
	function () {
		$error_message = '';
		if ( ! Demoda_Helper::check_enpii_base_plugin() ) {
			$error_message .= $error_message ? '<br />' : '';
			$error_message .= sprintf( __( 'Plugin <strong>%s</strong> is required.', 'enpii' ), 'Enpii Base' );
		}

		if ( $error_message ) {
			add_action(
				'admin_notices',
				function () use ( $error_message ) {
					$error_message = sprintf(
						__( 'Plugin <strong>%s</strong> is disabled.', 'enpii' ),
						'Demoda'
					) . '<br />' . $error_message;

					?>
			<div class="notice notice-warning is-dismissible">
					<p><?php echo esc_html( $error_message ); ?></p>
			</div>
					<?php
				}
			);
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}

		/**
		| We initiate the plugin later
		*/
		if ( Demoda_Helper::check_mandatory_prerequisites() ) {
			// We register Tamara_Checkout_WP_Plugin as a Service Provider
			add_action(
				App_Const::ACTION_WP_APP_LOADED,
				function () {
					Demoda_WP_Plugin::init_with_wp_app(
						DEMODA_PLUGIN_SLUG,
						__DIR__,
						plugin_dir_url( __FILE__ )
					);
				}
			);
		}
	},
	-111
);
