<?php

use Pronamic\WordPress\Money\Money;

$query = new WP_Query( array(
	'post_type'               => 'orbis_project',
	'posts_per_page'          => 25,
	'orbis_project_client_id' => get_the_ID(),
) );

if ( $query->have_posts() ) : ?>

	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead>
				<tr>
					<th class="border-top-0"><?php esc_html_e( 'Project', 'orbis' ); ?></th>
					<th class="border-top-0"><?php esc_html_e( 'Price', 'orbis' ); ?></th>
					<th class="border-top-0"><?php esc_html_e( 'Time', 'orbis' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
				?>

					<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php global $orbis_project; ?>
						<td>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

							<?php get_template_part( 'templates/table-cell-comments' ); ?>
						</td>
						<td>
							<?php
							$price = new Money( $orbis_project->get_price(), 'EUR' );
							echo esc_html( $price->format_i18n() );
							?>
						</td>
						<td class="project-time">
							<?php

							echo esc_html( $orbis_project->get_available_time()->format() );

							if ( function_exists( 'orbis_project_the_logged_time' ) ) :

								$classes   = array();
								$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';

								?>

								<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php orbis_project_the_logged_time(); ?></span>

							<?php endif; ?>
						</td>
					</tr>

				<?php endwhile; ?>
			</tbody>
		</table>
	</div>

	<?php wp_reset_postdata(); ?>

<?php else : ?>

	<div class="card-body">
		<p class="text-muted m-0">
			<?php esc_html_e( 'No projects found.', 'orbis' ); ?>
		</p>
	</div>

<?php endif; ?>
