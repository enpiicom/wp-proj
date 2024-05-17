<?php

declare(strict_types=1);

namespace WP_Theme_Enpii_2024\App\Support\Traits;

trait Enpii_Theme_Trans_Trait {
	protected function __( $message ) {
		// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
		return __( $message, 'enpii' );
	}
}
