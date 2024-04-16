<?php
/**
 * Template Name: Sample Tmpl
 * Template Post Type: post, page
 */
?>@extends('layouts/style01')

@section('content')
	<p>This is the tmpl-sample.blade.php of <strong>appeara-alpha</strong> theme.</p>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		the_content();
		?>
	</article><!-- #post-## -->
@endsection
