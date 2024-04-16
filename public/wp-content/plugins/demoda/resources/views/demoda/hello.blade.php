<?php
use Enpii\Demoda\App\WP\Demoda_WP_Plugin;
?>@extends('demoda::demoda/layout')

@section('content')
	<p>
		<?php
		echo esc_html(
			sprintf(
				Demoda_WP_Plugin::wp_app_instance()->_t( 'Hello from %s plugin.' ),
				Demoda_WP_Plugin::wp_app_instance()->get_name(),
			)
		);
		?>
	</p>
@endsection
