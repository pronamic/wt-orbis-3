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
						<th><?php esc_html_e( 'Last response time', 'orbis' ); ?></th>
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
								<?php echo get_post_meta( $post->ID, '_orbis_monitor_url' ) ? esc_html( get_post_meta( $post->ID, '_orbis_monitor_url', true ) ) : ''; ?>
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
								<?php echo get_post_meta( $post->ID, '_orbis_monitor_duration' ) ? esc_html( get_post_meta( $post->ID, '_orbis_monitor_duration', true ) ) : ''; ?>
							</td>
							<td>
								<?php
								if ( get_post_meta( $post->ID, '_orbis_monitor_response_date' ) ) {
									$time = esc_html( get_post_meta( $post->ID, '_orbis_monitor_response_date', true ) );
									echo date( 'd-m-Y H:i:s', $time );
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
