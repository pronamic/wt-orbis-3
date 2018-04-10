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

			<ul class="list-unstyled px-3 pt-3">
				<?php while ( $connected->have_posts() ) : ?>

					<?php $connected->the_post(); ?>

					<li class="media mb-3">
						<a href="<?php the_permalink(); ?>" class="mr-3">
							<?php if ( has_post_thumbnail() ) : ?>

								<?php the_post_thumbnail( 'avatar' ); ?>

							<?php else : ?>

								<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">

							<?php endif; ?>
						</a>
						<div class="media-body">
							<a href="<?php the_permalink(); ?>"><h5 class="mt-0 mb-1"><?php the_title(); ?></h5></a>
							<?php if ( get_post_meta( $post->ID, '_orbis_email', true ) ) : ?>

									<span><?php echo esc_html( get_post_meta( $post->ID, '_orbis_email', true ) ); ?></span> <br />

								<?php endif; ?>

								<?php if ( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ) : ?>

									<span><?php echo esc_html( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ); ?></span>

								<?php endif; ?>
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