<?php

namespace Tests\Unit\Demoda\App\Support;

use Enpii\Demoda\App\Support\Demoda_Helper;
use Mockery;
use Tests\Support\Global_Functions_Mock_Placeholder;
use Tests\Support\Global_Functions_Mocker;

class Demoda_Helper_Test extends \PHPUnit\Framework\TestCase {

	/**
	 * You need to use PHPUnit setUp funciton instead of Codecetion _before()
	 *  to be able to run with phpunit
	 * @return void
	 */
	protected function setUp(): void {
	}

	protected function tearDown(): void {
		Mockery::close();
	}

	public function test_check_mandatory_prerequisites() {
		// Mock the global functions
		// We expect `phpversion()` to be invoked twice with 2 set of arguments
		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );

		$mock_global_functions->expects( $this->once() )
			->method( 'phpversion' )
			->withAnyParameters()
			->willReturn( '7.2.0' );

		Global_Functions_Mocker::$mock = $mock_global_functions;
		$result = Demoda_Helper::check_mandatory_prerequisites();

		$this->assertFalse( $result, 'phpversion must be >= 7.3.0' );

		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );

		$mock_global_functions->expects( $this->once() )
			->method( 'phpversion' )
			->withAnyParameters()
			->willReturn( '7.3.0' );

		Global_Functions_Mocker::$mock = $mock_global_functions;

		$result = Demoda_Helper::check_mandatory_prerequisites();

		$this->assertTrue( $result, 'phpversion must be >= 7.3.0' );
	}

	public function test_check_enpii_base_plugin() {
		$result = Demoda_Helper::check_enpii_base_plugin();

		$this->assertEquals( class_exists( \Enpii_Base\App\WP\WP_Application::class ), $result, 'WP_Application checking should work' );
	}
}
