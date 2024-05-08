<?php

namespace Tests\Unit\Demoda\App\WP;

use Enpii\Demoda\App\Jobs\Register_Demoda_Api_Routes;
use Enpii\Demoda\App\Jobs\Register_Demoda_Routes;
use Enpii\Demoda\App\Jobs\Write_Meta_Tag;
use Enpii\Demoda\App\WP\Demoda_WP_Plugin;
use Enpii_Base\App\WP\WP_Application;
use Mockery as m;
use Tests\Support\Global_Functions_Mock_Placeholder;
use Tests\Support\Global_Functions_Mocker;
use WP_Mock;

/**
 * @runInSeparateProcess
 * @preserveGlobalState disabled
 */
class Demoda_WP_Plugin_Test extends \PHPUnit\Framework\TestCase {
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

	public function test_manipulate_hooks() {
		$wp_app_mock = m::mock( WP_Application::class );
		$testing_obj = new Demoda_WP_Plugin( $wp_app_mock );

		// Mock the global functions
		// We expect `add_action()` to be invoked once with provided arguments
		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );
		$mock_global_functions->expects( $this->once() )
			->method( 'add_action' )
			->with( 'wp_head', [ $testing_obj, 'add_meta_tag' ] )
			->willReturn( null );
		// We expect `wp_app()` to be invoked twice
		$mock_global_functions->expects( $this->exactly( 2 ) )
			->method( 'wp_app' )
			->willReturn(
				new class() {
					public function register_routes( $callback ) {
						return $callback;
					}
					public function register_api_routes( $callback ) {
						return $callback;
					}
				}
			);
		Global_Functions_Mocker::$mock = $mock_global_functions;

		$response = $testing_obj->manipulate_hooks();

		$this->assertTrue( empty( $response ), 'nothing return' );
	}

	public function test_get_name() {
		$wp_app_mock = m::mock( WP_Application::class );
		$testing_obj = new Demoda_WP_Plugin( $wp_app_mock );
		$name = $testing_obj->get_name();

		$this->assertEquals( 'Demoda', $name, 'name should be Demoda' );
	}

	public function test_get_version() {
		$wp_app_mock = m::mock( WP_Application::class );
		$testing_obj = new Demoda_WP_Plugin( $wp_app_mock );
		$version = $testing_obj->get_version();

		$this->assertEquals( '1.2.2', $version, 'version should be const' );
	}

	public function test_add_meta_tag() {
		$wp_app_mock = m::mock( WP_Application::class );
		$testing_obj = new Demoda_WP_Plugin( $wp_app_mock );
		// We mock to the class Write_Meta_Tag
		//  to override the static function `execute_now()`
		m::mock( 'overload:' . Write_Meta_Tag::class )
			->allows()
			->execute_now()
			->withAnyArgs()
			->andReturns( null );

		$response = $testing_obj->add_meta_tag();

		$this->assertTrue( empty( $response ), 'nothing return' );
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_register_routes() {
		$wp_app_mock = m::mock( WP_Application::class );
		$testing_obj = new Demoda_WP_Plugin( $wp_app_mock );
		// We mock to the class Register_Demoda_Routes
		//  to override the static function `execute_now()`
		//  that should be called once
		m::mock( 'overload:' . Register_Demoda_Routes::class )
			->allows()
			->execute_now()
			->withAnyArgs()
			->between( 1, 1 )
			->andReturns( null );

		$response = $testing_obj->register_routes();

		$this->assertTrue( empty( $response ), 'nothing return' );
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_register_api_routes() {
		$wp_app_mock = m::mock( WP_Application::class );
		$testing_obj = new Demoda_WP_Plugin( $wp_app_mock );
		// We mock to the class Register_Demoda_Routes
		//  to override the static function `execute_now()`
		//  that should be called once
		m::mock( 'overload:' . Register_Demoda_Api_Routes::class )
			->allows()
			->execute_now()
			->withAnyArgs()
			->between( 1, 1 )
			->andReturns( null );

		$response = $testing_obj->register_api_routes();

		$this->assertTrue( empty( $response ), 'nothing return' );
	}
}
