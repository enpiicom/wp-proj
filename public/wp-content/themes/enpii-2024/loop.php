<article class="single-article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h1>
	<div class="post-content">
		<?php the_content(); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
