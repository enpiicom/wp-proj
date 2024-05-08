<?php

namespace Tests\Unit\Appeara_Alpha\App\Support\Traits;

use Enpii\Appeara_Alpha\App\Support\Traits\Appeara_Alpha_Trans_Trait;
use Mockery;
use Tests\Support\Global_Functions_Mock_Placeholder;
use Tests\Support\Global_Functions_Mocker;

class Appeara_Alpha_Trans_Trait_Test extends \PHPUnit\Framework\TestCase {

	use Appeara_Alpha_Trans_Trait;

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
