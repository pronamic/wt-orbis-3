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
						<th><?php esc_html_e( 'Title', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'IP address', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Hostname', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Hostname Provider', 'orbis' ); ?></th>
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
								<?php echo esc_html( get_post_meta( $post->ID, '_orbis_hosting_group_ip_address', true ) ); ?>
							</td>
							<td>
								<?php echo esc_html( get_post_meta( $post->ID, '_orbis_hosting_group_hostname', true ) ); ?>
							</td>
							<td>
								<?php echo esc_html( get_post_meta( $post->ID, '_orbis_hosting_group_hostname_provider', true ) ); ?>
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
