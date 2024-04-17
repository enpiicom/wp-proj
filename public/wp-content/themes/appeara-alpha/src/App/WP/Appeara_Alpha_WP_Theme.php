<?php

declare(strict_types=1);

namespace Enpii\Appeara_Alpha\App\WP;

use Enpii\Appeara_Alpha\App\Support\Appeara_Alpha_Helper;
use Enpii_Base\Deps\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii_Base\Foundation\WP\WP_Theme;

class Appeara_Alpha_WP_Theme extends WP_Theme {

	public function get_name(): string {
		$tmp = __( 'Appeara Alpha', 'enpii');
		$tmp .= __( 'Another translation');
		/* translators: %d: Number of string */
		$tmp .= _n( '%d thing.', '%d things.', 4, 'enpii' );
		$tmp .= $this->__( 'Some thing' );
		$tmp .= _x( 'Comment', 'noun' );
		$tmp = __( 'Another translation 01') . __( 'Appeara Alpha 04', 'enpii') . _n( '%d guy.', '%d guys.', 1, 'enpii' ) . $this->__( 'Some thing 02' ) . _x( 'Comment 02', 'noun' );
		return $tmp;
	}

	public function get_version(): string {
		return APPEARA_ALPHA_VERSION;
	}

	public function get_text_domain(): string {
		return Appeara_Alpha_Helper::TEXT_DOMAIN;
	}

	/**
	 * All hooks shuold be registered here, inside this method
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function manipulate_hooks(): void {
		add_action( 'after_setup_theme', [ $this, 'setup_theme' ] );
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

	public function __( string $text ): string {
		return __( $text, $this->get_text_domain() );
	}
}
