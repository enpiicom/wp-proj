<?php

namespace Tests\Unit\Demoda\App\Controllers;

use Enpii\Demoda\App\Controllers\Demoda_Controller;
use Enpii\Demoda\App\WP\Demoda_WP_Plugin;
use Mockery as m;

class Demoda_Controller_Test extends \PHPUnit\Framework\TestCase {

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

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_hello() {
		$testing_obj = new Demoda_Controller();
		$mock_plugin = m::mock(
			Demoda_WP_Plugin::class,
			[
				'view' => 'demoda/hello',
			],
		);
		$view = $testing_obj->hello( $mock_plugin );

		$this->assertEquals( 'demoda/hello', $view, 'view name should be demoda/hello' );
	}
}
