<?php

namespace Enpii\Appeara_Alpha\App\WP;

use Tests\Support\Global_Functions_Mocker;

function apply_filters(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, 'apply_filters'], $args);
}
