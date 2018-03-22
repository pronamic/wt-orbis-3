<div class="card mt-3">
	<div class="card-body">
		<h3 class="card-title"><?php esc_html_e( 'Involved Persons', 'orbis' ); ?></h3>

		<?php

		$query = new WP_Query( array(
			'connected_type'  => 'orbis_projects_to_persons',
			'connected_items' => get_queried_object(),
			'nopaging'        => true, // phpcs:ignore WordPress.VIP.PostsPerPage.posts_per_page_nopaging
		) );

		if ( $query->have_posts() ) :
		?>

			<ul class="post-list">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
				?>

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
								<?php if ( get_post_meta( $post->ID, '_orbis_person_email_address', true ) ) : ?>

									<span class="entry-meta"><?php echo esc_html( get_post_meta( $post->ID, '_orbis_person_email_address', true ) ); ?></span> <br />

								<?php endif; ?>

								<?php if ( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ) : ?>

									<span class="entry-meta"><?php echo esc_html( get_post_meta( $post->ID, '_orbis_person_phone_number', true ) ); ?></span>

								<?php endif; ?>
							</p>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>

			<div class="content">
				<p class="alt">
					<?php esc_html_e( 'No persons involved.', 'orbis' ); ?>
				</p>
			</div>

		<?php endif; ?>
	</div>
</div>
