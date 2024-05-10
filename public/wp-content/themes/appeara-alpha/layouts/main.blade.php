<?php
do_action( 'get_header' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<?php echo '<title>' . esc_html( wp_get_document_title() ) . '</title>'; ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="site-placeholder" class="site">

		@include('sections/site-header')

		<div id="content" class="site-content" tabindex="0">
			<div class="col-full">

				<main class="site-main">
					<div class="site-main__inner">
						@yield('content')
					</div>
				</main>

			</div><!-- .col-full -->
		</div><!-- #content -->

		@include('sections/site-footer')

	</div><!-- #site-placeholder -->

<?php
do_action( 'get_footer' );
wp_footer();
?>

</body>
</html>

