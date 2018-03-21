<?php get_header(); ?>

<?php while ( have_posts() ) : ?>

	<?php the_post(); ?>
	<?php the_content(); ?>

<?php endwhile; ?>

<?php
get_footer();
