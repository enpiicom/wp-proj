<?php

declare(strict_types=1);

namespace Enpii\Demoda\App\Controllers;

use Enpii\Demoda\App\Support\Traits\Demoda_Trait;
use Enpii_Base\Foundation\Http\Base_Controller;

class Demoda_Controller extends Base_Controller {
	use Demoda_Trait;

	public function hello() {
		return $this->wp_plugin()->view( 'demoda/hello' );
	}
}
