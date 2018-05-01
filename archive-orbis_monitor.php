<?php

global $post;

get_header();

?>

<div class="card">
	<div class="card-block">
		<?php get_template_part( 'templates/search_form' ); ?>
	</div>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Title', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'URL', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Required response code', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Last response code', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Last response message', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Last response duration', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Last time checked', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ( have_posts() ) :
						the_post();
					?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php get_template_part( 'templates/table-cell-comments' ); ?>
							</td>
							<td>
								<?php

								$url  = get_post_meta( $post->ID, '_orbis_monitor_url', true );
								$link = sprintf(
									'<a href="%s">%s</a>',
									$url,
									$url
								);

								echo empty( $url ) ? '—' : wp_kses_post( $link );

								?>
							</td>
							<td>
								<?php echo get_post_meta( $post->ID, '_orbis_monitor_required_response_code' ) ? esc_html( get_post_meta( $post->ID, '_orbis_monitor_required_response_code', true ) ) : ''; ?>
							</td>
							<td>
								<?php echo get_post_meta( $post->ID, '_orbis_monitor_response_code' ) ? esc_html( get_post_meta( $post->ID, '_orbis_monitor_response_code', true ) ) : ''; ?>
							</td>
							<td>
								<?php echo get_post_meta( $post->ID, '_orbis_monitor_response_message' ) ? esc_html( get_post_meta( $post->ID, '_orbis_monitor_response_message', true ) ) : ''; ?>
							</td>
							<td>
								<?php

								$duration = get_post_meta( $post->ID, '_orbis_monitor_duration', true );

								if ( empty( $duration ) ) {
									echo '—';
								} else {
									echo esc_html( number_format_i18n( $duration, 2 ) );
								}

								?>
							</td>
							<td>
								<?php

								$time = get_post_meta( $post->ID, '_orbis_monitor_response_date', true );

								if ( empty( $time ) ) {
									echo '—';
								} else {
									echo esc_html( date_i18n( __( 'd-m-Y H:i', 'orbis' ), $time ) );
								}

								?>
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

		<?php get_template_part( 'templates/content-none' ); ?>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
