<?php

declare(strict_types=1);

namespace Enpii\Appeara_Alpha\App\Support\Traits;

trait Appeara_Alpha_Trans_Trait {
	protected function __( $message ) {
		// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
		return __( $message, 'enpii' );
	}
}
