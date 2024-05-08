<?php

namespace Tests\Unit\Demoda\App\Support\Traits;

use Codeception\Test\Feature\Stub;
use Enpii\Demoda\App\Support\Traits\Demoda_Trait;
use Enpii\Demoda\App\Support\Traits\Demoda_Trans_Trait;
use Enpii\Demoda\App\WP\Demoda_WP_Plugin;
use Mockery;

class Demoda_Trait_Test extends \PHPUnit\Framework\TestCase
{
	use Stub;
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

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_demoda_wp_plugin() {
		$mock_testing_obj = $this->make( Tmp_Test::class, [] );

		// $mock_demoda_wp_plugin = $this->makeEmpty( Demoda_WP_Plugin::class );

		$mockery_obj = Mockery::mock('overload:'.Demoda_WP_Plugin::class);
		$mockery_obj->allows()
		->wp_app_instance()
		->withAnyArgs()
		->andReturns( $mockery_obj );

		$result = $mock_testing_obj->demoda_wp_plugin();

		$this->assertEquals($mockery_obj, $result, 'object should match');
	}
}

class Tmp_Test {
	use Demoda_Trait;
}
