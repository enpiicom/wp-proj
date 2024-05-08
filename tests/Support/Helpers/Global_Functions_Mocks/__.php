<?php
/**
 * We need to add all the namespaces that use the function `add_action` to this file
 * 	to be able to mock them
 */
namespace Enpii\Appeara_Alpha\App\Support\Traits;

use Tests\Support\Global_Functions_Mocker;

function __(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, '__'], $args);
}

namespace Enpii\Demoda\App\Support\Traits;

use Tests\Support\Global_Functions_Mocker;

function __(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, '__'], $args);
}
