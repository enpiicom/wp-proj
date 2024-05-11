<?php

declare(strict_types=1);

namespace Enpii\Appeara_Alpha\App\WP;

use Enpii\Appeara_Alpha\App\Support\Traits\Appeara_Alpha_Trans_Trait;
use Enpii_Base\Deps\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii_Base\Foundation\WP\WP_Theme;

class Appeara_Alpha_WP_Theme extends WP_Theme {
	use Appeara_Alpha_Trans_Trait;

	public function get_name(): string {
		return $this->__( 'Appeara Alpha' );
	}

	public function get_version(): string {
		return APPEARA_ALPHA_VERSION;
	}

	/**
	 * All hooks shuold be registered here, inside this method
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function manipulate_hooks(): void {
		add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public function setup_theme(): void {
		/**
		 * Enable support for site logo.
		 */
		add_theme_support(
			'custom-logo',
			apply_filters(
				$this->get_theme_slug() . '_custom_logo_args',
				[
					'height'      => 110,
					'width'       => 470,
					'flex-width'  => true,
					'flex-height' => true,
				]
			)
		);

		add_post_type_support( 'page', 'page-attributes' );
		add_post_type_support( 'post', 'page-attributes' );
	}

	public function enqueue_scripts() {
		$is_local = defined( 'WP_ENV' ) && WP_ENV === 'local';
		$version = $is_local ? time() : $this->get_version();

		wp_enqueue_style( $this->get_theme_slug() . 'main-style', $this->get_base_url() . '/public-assets/dist/css/main.css', [], $version );
		wp_enqueue_script( $this->get_theme_slug() . 'main-script', $this->get_base_url() . '/public-assets/dist/js/main.js', [], $version, true );
		wp_enqueue_script( $this->get_theme_slug() . 'app-script', $this->get_base_url() . '/public-assets/dist/js/app.js', [], $version, true );
		wp_localize_script(
			$this->get_theme_slug() . 'main-localize_script',
			'wpAjax',
			[
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			]
		);
	}
}
