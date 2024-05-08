<?php

namespace Tests\Unit\Demoda\App\Support\Traits;

use Enpii\Demoda\App\Support\Traits\Demoda_Trans_Trait;
use Mockery;
use Tests\Support\Global_Functions_Mock_Placeholder;
use Tests\Support\Global_Functions_Mocker;

class Demoda_Trans_Trait_Test extends \PHPUnit\Framework\TestCase {

	use Demoda_Trans_Trait;

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

	public function test__() {
		// Mock the global functions
		// We expect `__()` to be invoked twice with 2 set of arguments
		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );

		$mock_global_functions->expects( $this->once() )
			->method( '__' )
			->withAnyParameters()
			->willReturn( 'translated text' );

		Global_Functions_Mocker::$mock = $mock_global_functions;

		$result = $this->__( 'test' );

		$this->assertEquals( 'translated text', $result, 'translation should match' );
	}
}
