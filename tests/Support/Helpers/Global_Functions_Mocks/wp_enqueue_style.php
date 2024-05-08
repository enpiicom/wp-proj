<?php

namespace Enpii\Appeara_Alpha\App\WP;

use Tests\Support\Global_Functions_Mocker;

function wp_enqueue_style(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, 'wp_enqueue_style'], $args);
}
