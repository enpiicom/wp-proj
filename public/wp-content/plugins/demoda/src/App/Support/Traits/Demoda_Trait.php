<?php

declare(strict_types=1);

namespace Enpii\Demoda\App\Support\Traits;

use Enpii\Demoda\App\WP\Demoda_WP_Plugin;
use Illuminate\Contracts\Container\BindingResolutionException;

trait Demoda_Trait {
	/**
	 *
	 * @return Demoda_WP_Plugin
	 * @throws BindingResolutionException
	 */
	public function demoda_wp_plugin(): Demoda_WP_Plugin {
		return Demoda_WP_Plugin::wp_app_instance();
	}
}
