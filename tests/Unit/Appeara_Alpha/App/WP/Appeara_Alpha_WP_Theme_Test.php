<?php

namespace Tests\Unit\Appeara_Alpha\App\WP;

use Codeception\Test\Feature\Stub;
use Enpii\Appeara_Alpha\App\WP\Appeara_Alpha_WP_Theme;
use Enpii_Base\App\WP\WP_Application;
use Mockery;
use Tests\Support\Global_Functions_Mock_Placeholder;
use Tests\Support\Global_Functions_Mocker;
use Tests\Support\Traits\Non_Public_Accessor_Trait;

class Appeara_Alpha_WP_Theme_Test extends \PHPUnit\Framework\TestCase {

	use Stub;
	use Non_Public_Accessor_Trait;

	protected function setUp(): void {
	}

	protected function tearDown(): void {
		Mockery::close();
	}

	public function test_get_name() {
		// We use CodeCeption mock
		//  to override the function `__`
		$mock_obj = $this->make(
			Appeara_Alpha_WP_Theme::class,
			[
				'__' => function () {
					return 'name';
				},
			]
		);
		$result = $mock_obj->get_name();

		$this->assertEquals( 'name', $result, 'name should be Appeara Alpha' );
	}

	public function test_get_version() {
		$wp_app_mock = Mockery::mock( WP_Application::class );
		$testing_obj = new Appeara_Alpha_WP_Theme( $wp_app_mock );
		$result = $testing_obj->get_version();

		$this->assertEquals( '1.0.0', $result, 'version should match' );
	}

	public function test_manipulate_hooks() {
		$wp_app_mock = Mockery::mock( WP_Application::class );
		$testing_obj = new Appeara_Alpha_WP_Theme( $wp_app_mock );

		// Mock the global functions
		// We expect `add_action()` to be invoked twice with 2 set of arguments
		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );
		$mock_global_functions->expects( $this->exactly( 2 ) )
			->method( 'add_action' )
			->willReturnMap(
				[
					[ [ 'after_setup_theme', [ $testing_obj, 'setup_theme' ] ], null ],
					[ [ 'wp_enqueue_scripts', [ $testing_obj, 'enqueue_scripts' ] ], null ],
				]
			);
		Global_Functions_Mocker::$mock = $mock_global_functions;

		$response = $testing_obj->manipulate_hooks();

		$this->assertTrue( empty( $response ), 'nothing return' );
	}

	public function test_setup_theme() {
		$wp_app_mock = Mockery::mock( WP_Application::class );
		$testing_obj = new Appeara_Alpha_WP_Theme( $wp_app_mock );
		// We use CodeCeption mock
		//  to override the function `get_theme_slug`
		$mock_obj = $this->make(
			$testing_obj,
			[
				'get_theme_slug' => function () {
					return 'slug';
				},
			]
		);

		// Mock the global functions
		// We expect `add_post_type_support()` to be invoked twice with 2 set of arguments
		$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );
		$mock_global_functions->expects( $this->exactly( 2 ) )
			->method( 'add_post_type_support' )
			->willReturnMap(
				[
					[ [ 'page', 'page-attributes' ], null ],
					[ [ 'post', 'page-attributes' ], null ],
				]
			);

		$mock_global_functions->expects( $this->any() )
			->method( 'apply_filters' )
			->withAnyParameters()
			->willReturn( [] );

		// We want to expect the function `add_theme_support` to receive
		//  the first argument = 'custom-logo'
		$mock_global_functions->expects( $this->any() )
			->method( 'add_theme_support' )
			->with(
				'custom-logo',
				$this->anything()
			)
			->willReturn( null );

		Global_Functions_Mocker::$mock = $mock_global_functions;

		$ressult = $mock_obj->setup_theme();

		$this->assertTrue( empty( $ressult ), 'nothing return' );
	}

	// public function test_enqueue_scripts() {
	// 	$wp_app_mock = Mockery::mock( WP_Application::class );
	// 	$testing_obj = new Appeara_Alpha_WP_Theme( $wp_app_mock );
	// 	// We use CodeCeption mock
	// 	//  to override the function `get_theme_slug`
	// 	$mock_obj = $this->make(
	// 		$testing_obj,
	// 		[
	// 			'get_theme_slug' => function () {
	// 				return 'slug';
	// 			},
	// 			'get_version' => function () {
	// 				return '1.0';
	// 			},
	// 			'get_base_url' => function () {
	// 				return 'https://abc.com';
	// 			},
	// 		]
	// 	);

	// 	// Mock the global functions
	// 	// We expect `add_post_type_support()` to be invoked twice with 2 set of arguments
	// 	$mock_global_functions = $this->createMock( Global_Functions_Mock_Placeholder::class );

	// 	$mock_global_functions->expects( $this->exactly( 1 ) )
	// 		->method( 'wp_enqueue_style' )
	// 		->willReturnMap(
	// 			[
	// 				[
	// 					[ $mock_obj->get_theme_slug() . 'main-style', $mock_obj->get_base_url() . '/public-assets/dist/css/main.css', [], $mock_obj->get_version() ],
	// 					null,
	// 				],
	// 			]
	// 		);

	// 	$mock_global_functions->expects( $this->exactly( 1 ) )
	// 		->method( 'wp_enqueue_script' )
	// 		->willReturnMap(
	// 			[
	// 				[
	// 					[ $mock_obj->get_theme_slug() . 'main-script', $mock_obj->get_base_url() . '/public-assets/dist/js/main.js', [], $mock_obj->get_version(), true ],
	// 					null,
	// 				],
	// 			]
	// 		);

	// 	$mock_global_functions->expects( $this->any() )
	// 		->method( 'admin_url' )
	// 		->willReturnMap(
	// 			[
	// 				[
	// 					[ 'admin-ajax.php' ],
	// 					'https://abc.com/wp-admin/admin-ajax.php',
	// 				],
	// 			]
	// 		);

	// 	$mock_global_functions->expects( $this->any() )
	// 		->method( 'wp_localize_script' )
	// 		->willReturnMap(
	// 			[
	// 				[
	// 					[
	// 						$mock_obj->get_theme_slug() . 'main-localize_script',
	// 						'wpAjax',
	// 						[
	// 							'ajax_url' => 'https://abc.com/wp-admin/admin-ajax.php',
	// 						],
	// 					],
	// 					null,
	// 				],
	// 			]
	// 		);

	// 	Global_Functions_Mocker::$mock = $mock_global_functions;

	// 	$ressult = $mock_obj->enqueue_scripts();

	// 	$this->assertTrue( empty( $ressult ), 'nothing return' );
	// }
}
