<?php

declare(strict_types=1);

namespace Enpii\Demoda\App\WP;

use Enpii\Demoda\App\Jobs\Register_Demoda_Api_Routes;
use Enpii\Demoda\App\Jobs\Register_Demoda_Routes;
use Enpii\Demoda\App\Jobs\Write_Meta_Tag;
use Enpii_Base\Deps\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii_Base\Foundation\WP\WP_Plugin;

class Demoda_WP_Plugin extends WP_Plugin {
	/**
	 * All hooks shuold be registered here, inside this method
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function manipulate_hooks(): void {
		add_action( 'wp_head', [ $this, 'add_meta_tag' ] );

		// We must call the methods `register_routes` and `register_api_routes` here
		wp_app()->register_routes( [ $this, 'register_routes' ] );
		wp_app()->register_api_routes( [ $this, 'register_api_routes' ] );
	}

	public function get_name(): string {
		return 'Demoda';
	}

	public function get_version(): string {
		return DEMODA_PLUGIN_VERSION;
	}

	public function add_meta_tag(): void {
		// We use this class in the method body to avoid the loading of the class to the memory
		//  the job class is only loaded when the hook actually fires
		Write_Meta_Tag::execute_now(
			[
				'version' => DEMODA_PLUGIN_VERSION,
			]
		);
	}

	public function register_routes(): void {
		Register_Demoda_Routes::execute_now();
	}

	public function register_api_routes(): void {
		Register_Demoda_Api_Routes::execute_now();
	}
}
