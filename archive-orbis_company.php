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
						<th><?php esc_html_e( 'Name', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Address', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Online', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Author', 'orbis' ); ?></th>
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
								<?php

								$favicon_url = orbis_get_favicon_url( get_post_meta( get_the_ID(), '_orbis_website', true ) );

								if ( ! empty( $favicon_url ) ) :
								?>

									<img src="<?php echo esc_attr( $favicon_url ); ?>" alt="" />

								<?php endif; ?>

								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php get_template_part( 'templates/table-cell-comments' ); ?>
							</td>
							<td>
								<?php

								$address  = get_post_meta( $post->ID, '_orbis_address', true );
								$postcode = get_post_meta( $post->ID, '_orbis_postcode', true );
								$city     = get_post_meta( $post->ID, '_orbis_city', true );

								printf(
									'%s<br />%s %s',
									esc_html( $address ),
									esc_html( $postcode ),
									esc_html( $city )
								);

								?>
							</td>
							<td>
								<?php

								$break = '';

								$website = get_post_meta( $post->ID, '_orbis_website', true );

								if ( ! empty( $website ) ) {
									printf(
										'<a href="%s" target="_blank">%s</a>',
										esc_attr( $website ),
										esc_html( $website )
									);

									$break = '<br />';
								}

								$email = get_post_meta( $post->ID, '_orbis_email', true );

								if ( ! empty( $email ) ) {
									printf( wp_kses_post( $break ) );

									printf(
										'<a href="mailto:%s" target="_blank">%s</a>',
										esc_attr( $email ),
										esc_html( $email )
									);
								}

								?>
							</td>
							<td>
								<?php the_author(); ?>
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
