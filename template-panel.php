<?php
/**
 * Template Name: Panel
 */

get_header(); ?>

<?php
while ( have_posts() ) :
	the_post();
?>

	<div class="card">
		<div class="card-body">
			<?php the_content(); ?>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
