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
						<th><?php esc_html_e( 'Task', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Assignee', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Due At', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ( have_posts() ) :
						the_post();

						$due_at = get_post_meta( get_the_ID(), '_orbis_task_due_at', true );

						if ( empty( $due_at ) ) {
								$due_at_ouput = '—';
						} else {
							$seconds = strtotime( $due_at );
							$delta   = $seconds - time();
							$days    = round( $delta / ( 3600 * 24 ) );

							if ( $days < 0 ) {
								$due_at_ouput = sprintf( __( '<span class="label label-danger">%d days</span>', 'orbis' ), $days ); //phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
							} else {
								$due_at_ouput = '';
							}
						}

						?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

								<div class="entry-meta">
									<i class="fa fa-file" aria-hidden="true"></i> <?php orbis_task_project(); ?> <i class="fa fa-user" aria-hidden="true"></i> <?php orbis_task_assignee(); ?> <i class="fa fa-clock-o" aria-hidden="true"></i> <?php orbis_task_time(); ?>
								</div>
							</td>
							<td>
								<?php echo get_avatar( get_post_meta( get_the_ID(), '_orbis_task_assignee_id', true ), 40 ); ?>
							</td>
							<td>
								<?php orbis_task_due_at(); ?> <?php echo esc_html( $due_at_ouput ); ?>
							</td>
							<td>
								<?php get_template_part( 'templates/table-cell-actions' ); ?>

								<?php orbis_finish_task_link(); ?>
							</td>
						</tr>

					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>

		<?php get_template_part( 'templates/content-none' ); ?>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
