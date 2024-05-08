<?php

namespace Tests\Unit\Demoda\App\Controllers;

use Enpii\Demoda\App\Controllers\Demoda_Api_Controller;
use Illuminate\Http\JsonResponse;
use Mockery as m;
use Tests\Support\Global_Functions_Mock_Placeholder;
use Tests\Support\Global_Functions_Mocker;

class Demoda_Api_Controller_Test extends \PHPUnit\Framework\TestCase {

	/**
	 * You need to use PHPUnit setUp funciton instead of Codecetion _before()
	 *  to be able to run with phpunit
	 * @return void
	 */
	protected function setUp(): void {
	}

	protected function tearDown(): void {
		m::close();
	}

	public function test_hello() {
		$testing_obj = new Demoda_Api_Controller();

		// Mock the global functions
		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );
		$mock_global_functions->expects( $this->once() )
			->method( 'wp_app_response' )
			->willReturn(
				new class() {
					public function json( $data ) {
						return new JsonResponse( $data );
					}
				}
			);
		Global_Functions_Mocker::$mock = $mock_global_functions;

		$response = $testing_obj->hello();

		$this->assertInstanceOf( JsonResponse::class, $response, 'response should be a string' );
		$this->assertEquals( 200, $response->getStatusCode(), 'response http code should be 200' );
	}
}
