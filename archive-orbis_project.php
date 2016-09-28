<?php get_header(); ?>

<div class="card">
	<div class="card-block">
		<?php get_template_part( 'templates/search_form' ); ?>
	</div>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Client', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Project', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Time', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php while ( have_posts() ) : the_post(); ?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<?php

								if ( function_exists( 'orbis_project_has_principal' ) ) {
									if ( orbis_project_has_principal() ) {
										printf(
											'<a href="%s">%s</a>',
											esc_attr( orbis_project_principal_get_permalink() ),
											esc_html( orbis_project_principel_get_the_name() )
										);
									}
								}

								?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php get_template_part( 'templates/table-cell-comments' ); ?>
							</td>
							<td class="project-time">
								<?php

								if ( function_exists( 'orbis_project_the_time' ) ) {
									orbis_project_the_time();
								}

								if ( function_exists( 'orbis_project_the_logged_time' ) ) :

									$classes = array();
									$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';

									?>

									<span class="<?php echo esc_attr( implode( $classes, ' ' ) ); ?>"><?php orbis_project_the_logged_time(); ?></span>

								<?php endif; ?>
							</td>
							<td>
								<?php get_template_part( 'templates/table-cell-actions' ); ?>
							</td>
						</tr>

					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php esc_html_e( 'No results found.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
