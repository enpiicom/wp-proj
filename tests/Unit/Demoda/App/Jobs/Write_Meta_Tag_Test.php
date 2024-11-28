<?php

namespace Tests\Unit\Demoda\App\Jobs;

use Enpii\Demoda\App\Jobs\Write_Meta_Tag;
use Mockery;
use Tests\Support\Traits\Non_Public_Accessor_Trait;

class Write_Meta_Tag_Test extends \PHPUnit\Framework\TestCase {
	use Non_Public_Accessor_Trait;

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

	// /**
	//  * @runInSeparateProcess
	//  * @preserveGlobalState disabled
	//  */
	// public function test_construct() {
	// 	$mock_testing_obj = new Write_Meta_Tag(
	// 		[
	// 			'version' => '0.2.1',
	// 		]
	// 	);

	// 	$this->assertEquals( '0.2.1', $this->get_object_property( $mock_testing_obj, 'version' ), 'version should match' );

	// 	Mockery::close();
	// }

	// /**
	//  * @runInSeparateProcess
	//  * @preserveGlobalState disabled
	//  */
	// public function test_handle() {
	// 	$mock_testing_obj = new Write_Meta_Tag(
	// 		[
	// 			'version' => '0.2.1',
	// 		]
	// 	);

	// 	ob_start();
	// 	$mock_testing_obj->handle();
	// 	$content = ob_get_clean();

	// 	$this->assertStringContainsString( 'Demoda 0.2.1', (string) $content, 'version should be contained in the output' );
	// }
}
