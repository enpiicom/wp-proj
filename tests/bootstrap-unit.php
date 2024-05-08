<?php
/**
 * Now we include any plugin files that we need to be able to run the tests. This
 * should be files that define the functions and classes you're going to test.
 */

require_once dirname( __DIR__ ) . '/public/vendor/autoload.php';

$helpers_files = glob(dirname( __FILE__ ) . '/Support/Helpers/*.php');
foreach ($helpers_files as $file) {
    require_once $file;
}

$helpers_mocks_files = glob(dirname( __FILE__ ) . '/Support/Helpers/Global_Functions_Mocks/*.php');
foreach ($helpers_mocks_files as $file) {
    require_once $file;
}

function output_debug( $debug_string ) {
	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r, WordPressVIPMinimum.Functions.RestrictedFunctions.file_ops_fwrite
	fwrite( STDERR, print_r( "\n\n", true ) );
	fwrite( STDERR, print_r( $debug_string, true ) );
	fwrite( STDERR, print_r( "\n", true ) );
}

// Bootstrap WP_Mock to initialize built-in features
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();
