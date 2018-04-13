<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>

	<div class="card mb-3">
		<div class="card-header"><?php esc_html_e( 'Connected persons', 'orbis' ); ?></div>

		<?php

		$connected = new WP_Query( array(
			'connected_type'  => 'orbis_persons_to_companies',
			'connected_items' => get_queried_object(),
			'nopaging'        => true, // phpcs:ignore WordPress.VIP.PostsPerPage.posts_per_page_nopaging
		) );

		if ( $connected->have_posts() ) :

		?>

			<ul class="list-group list-group-flush">
				<?php while ( $connected->have_posts() ) : ?>

					<?php $connected->the_post(); ?>

					<li class="list-group-item">
						<div class="media">
							<a href="<?php the_permalink(); ?>" class="mr-3">
								<?php if ( has_post_thumbnail() ) : ?>

									<?php the_post_thumbnail( 'avatar' ); ?>

								<?php else : ?>

									<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">

								<?php endif; ?>
							</a>

							<div class="media-body">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br />
								<?php
								if ( get_post_meta( $post->ID, '_orbis_email', true ) ) {
									$email = get_post_meta( $post->ID, '_orbis_email', true );

									printf(
										'<a class="text-secondary" style="font-size: .8em" href="mailto:%s">%s</a><br />',
										esc_html( $email ),
										esc_html( $email )
									);
								}
								?>
								<?php
								if ( get_post_meta( $post->ID, '_orbis_phone_number', true ) ) {
									$phone_number = get_post_meta( $post->ID, '_orbis_phone_number', true );

									printf(
										'<a class="text-secondary" style="font-size: .8em" href="tel:%s">%s</a><br />',
										esc_html( $phone_number ),
										esc_html( $phone_number )
									);
								}
								?>
							</div>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>

		<?php wp_reset_postdata(); else : ?>

			<div class="card-body">
				<p class="alt">
					<?php esc_html_e( 'No persons connected.', 'orbis' ); ?>
				</p>
			</div>

		<?php endif; ?>

	</div>

<?php
	endif;
