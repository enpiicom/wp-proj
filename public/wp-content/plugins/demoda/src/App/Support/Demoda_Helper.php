<?php

declare(strict_types=1);

namespace Enpii\Demoda\App\Support;

class Demoda_Helper {
	public const TEXT_DOMAIN = 'demoda';

	public static function check_mandatory_prerequisites(): bool {
		return version_compare( phpversion(), '7.3.0', '>=' );
	}

	public static function check_enpii_base_plugin(): bool {
		return ! ! class_exists( \Enpii_Base\App\WP\WP_Application::class );
	}
}
