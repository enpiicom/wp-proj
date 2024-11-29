<?php

namespace Tests\Unit\Demoda\App\Jobs;

use Enpii\Demoda\App\Controllers\Demoda_Controller;
use Enpii\Demoda\App\Jobs\Register_Demoda_Routes;
use Illuminate\Support\Facades\Route;

class Register_Demoda_Routes_Test extends \PHPUnit\Framework\TestCase {
	/**
	 * You need to use PHPUnit setUp funciton instead of Codecetion _before()
	 *  to be able to run with phpunit
	 * @return void
	 */
	protected function setUp(): void {
	}

	protected function tearDown(): void {
	}

	public function test_handle() {
		$testing_obj = new Register_Demoda_Routes();
		// A route using get method with first argument 'demoda' should be expectd to
		//  registered once
		Route::shouldReceive( 'get' )
			->with( 'demoda', [ Demoda_Controller::class, 'hello' ] )
			->once();

		$response = $testing_obj->handle();

		$this->assertEmpty( $response );
	}
}
