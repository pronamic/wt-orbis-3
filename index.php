<?php get_header(); ?>

<div class="card">
	<div class="card-block">
		<?php get_template_part( 'templates/search_form' ); ?>
	</div>

	<?php if ( have_posts() ) : ?>

		<table class="table table-striped table-condense table-hover">
			<thead>
				<tr>
					<?php if ( is_search() ) : ?>
					<th><?php esc_html_e( 'Type', 'orbis' ); ?></th><?php endif; ?>
					<th><?php esc_html_e( 'Title', 'orbis' ); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ( have_posts() ) :
					the_post();
				?>

					<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( is_search() ) : ?>

							<td>
								<?php

								$post_type = get_post_type_object( get_post_type( $post ) );

								echo esc_html( $post_type->labels->singular_name );

								?>
							</td>

						<?php endif; ?>
						<td>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

							<?php get_template_part( 'templates/table-cell-comments' ); ?>
						</td>
						<td>
							<?php get_template_part( 'templates/table-cell-actions' ); ?>
						</td>
					</tr>

				<?php endwhile; ?>
			</tbody>
		</table>

	<?php else : ?>

		<?php get_template_part( 'templates/content-none' ); ?>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
