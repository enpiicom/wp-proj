<?php

declare(strict_types=1);

namespace WP_Theme_Enpii_2024\App\Support;

class Enpii_Theme_Helper {
	public static function check_mandatory_prerequisites(): bool {
		return version_compare( phpversion(), '7.3.0', '>=' );
	}

	public static function check_enpii_base_plugin(): bool {
		return (bool) class_exists( \Enpii_Base\App\WP\WP_Application::class );
	}
}
