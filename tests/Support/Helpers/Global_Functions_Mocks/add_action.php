<?php
/**
 * We need to add all the namespaces that use the function `add_action` to this file
 * 	to be able to mock them
 */
namespace Enpii\Demoda\App\WP;

use Tests\Support\Global_Functions_Mocker;

function add_action(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, 'add_action'], $args);
}

namespace Enpii\Appeara_Alpha\App\WP;

use Tests\Support\Global_Functions_Mocker;

function add_action(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, 'add_action'], $args);
}
