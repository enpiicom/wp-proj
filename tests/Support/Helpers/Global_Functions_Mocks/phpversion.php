<?php
/**
 * We need to add all the namespaces that use the function `add_action` to this file
 * 	to be able to mock them
 */
namespace Enpii\Appeara_Alpha\App\Support;

use Tests\Support\Global_Functions_Mocker;

function phpversion() {
	return call_user_func([Global_Functions_Mocker::class, 'phpversion']);
}

namespace Enpii\Demoda\App\Support;

use Tests\Support\Global_Functions_Mocker;

function phpversion() {
	return call_user_func([Global_Functions_Mocker::class, 'phpversion']);
}
