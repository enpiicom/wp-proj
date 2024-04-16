<?php

declare(strict_types=1);

namespace Enpii\Demoda\App\Support\Traits;

use Enpii\Demoda\App\WP\Demoda_WP_Plugin;

trait Demoda_Trans_Trait {
	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	protected function _t( $untranslated_text ) {
		return Demoda_WP_Plugin::wp_app_instance()->_t( $untranslated_text );
	}
}
