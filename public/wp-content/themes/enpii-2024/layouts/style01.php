<?php
do_action( 'get_header' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php echo '<title>' . esc_html(wp_get_document_title()) . '</title>'; ?>
    <meta property='og:title' content='<?php echo esc_html( get_bloginfo( 'name' ) ); ?>'/>
    <meta property='og:description' content='<?php echo esc_html( get_bloginfo( 'description' ) ); ?>'/>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<?php echo '<title>' . esc_html( wp_get_document_title() ) . '</title>'; ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="site-placeholder" class="site stye--style01">

		<div id="content" class="site-content" tabindex="0">
			<div class="col-full">

				<main class="site-main">
					<div class="site-main__inner">
						@yield('content')
					</div>
				</main>

			</div><!-- .col-full -->
		</div><!-- #content -->

		<footer class="site-footer" role="contentinfo">
			<div class="col-full">
			</div><!-- .col-full -->
		</footer>

	</div><!-- #site-placeholder -->

<?php
do_action( 'get_footer' );
wp_footer();
?>

</body>
</html>

