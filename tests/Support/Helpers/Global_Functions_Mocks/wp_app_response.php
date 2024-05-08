<?php
/**
 * We need to add all the namespaces that use the function `wp_app_resonse` to this file
 * 	to be able to mock them
 */
namespace Enpii\Demoda\App\Controllers;

use Tests\Support\Global_Functions_Mocker;

function wp_app_response() {
	return call_user_func([Global_Functions_Mocker::class, 'wp_app_response']);
}
