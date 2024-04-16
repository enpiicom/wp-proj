@extends('layouts/main')

@section('content')
	<?php
	if ( have_posts() ) :
		the_post();
		?>

	@include('loop')

		<?php
	else :
		?>

	<p>This is the index.php of <strong>appeara-alpha</strong> theme.</p>

		<?php
	endif;
	?>
@endsection
