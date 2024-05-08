<?php
/**
 * We need to add all the namespaces that use the function `add_action` to this file
 * 	to be able to mock them
 */
namespace Enpii\Appeara_Alpha\App\WP;

use Tests\Support\Global_Functions_Mocker;

function add_post_type_support(...$args) {
	return call_user_func_array([Global_Functions_Mocker::class, 'add_post_type_support'], $args);
}
