<?php

declare(strict_types=1);

namespace Tests\Support;

class Global_Functions_Mocker {
	/** @var Global_Functions_Mock_Placeholder $mock */
	static $mock;

	public static function wp_app_response() {
		return call_user_func([static::$mock, 'wp_app_response']);
	}

	public static function wp_app() {
		return call_user_func([static::$mock, 'wp_app']);
	}

	public static function phpversion() {
		return call_user_func([static::$mock, 'phpversion']);
	}

	public static function add_action(...$args) {
		return call_user_func_array([static::$mock, 'add_action'], $args);
	}

	public static function add_post_type_support(...$args) {
		return call_user_func_array([static::$mock, 'add_post_type_support'], $args);
	}

	public static function add_theme_support(...$args) {
		return call_user_func_array([static::$mock, 'add_theme_support'], $args);
	}

	public static function apply_filters(...$args) {
		return call_user_func_array([static::$mock, 'apply_filters'], $args);
	}

	public static function wp_enqueue_script(...$args) {
		return call_user_func_array([static::$mock, 'wp_enqueue_script'], $args);
	}

	public static function wp_enqueue_style(...$args) {
		return call_user_func_array([static::$mock, 'wp_enqueue_style'], $args);
	}

	public static function wp_localize_script(...$args) {
		return call_user_func_array([static::$mock, 'wp_localize_script'], $args);
	}

	public static function admin_url(...$args) {
		return call_user_func_array([static::$mock, 'wp_localize_script'], $args);
	}

	public static function __(...$args) {
		return call_user_func_array([static::$mock, '__'], $args);
	}
}
