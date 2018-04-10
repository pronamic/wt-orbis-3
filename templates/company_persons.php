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

			<ul class="post-list">
				<?php while ( $connected->have_posts() ) : ?>

					<?php $connected->the_post(); ?>

					<li>
						<a href="<?php the_permalink(); ?>" class="post-image">
							<?php if ( has_post_thumbnail() ) : ?>

								<?php the_post_thumbnail( 'avatar' ); ?>

							<?php else : ?>

								<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">

							<?php endif; ?>
						</a>

						<div class="post-content">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

							<p>
								<?php if ( get_post_meta( $post->ID, '_orbis_email', true ) ) : ?>

									<span><?php echo esc_html( get_post_meta( $post->ID, '_orbis_email', true ) ); ?></span> <br />

								<?php endif; ?>

								<?php if ( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ) : ?>

									<span><?php echo esc_html( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ); ?></span>

								<?php endif; ?>
							</p>
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

<?php endif;