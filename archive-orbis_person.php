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
						<th><?php esc_html_e( 'Phone number', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>

						<tr>
							<td>
								<div class="person-wrapper">
									<div class="avatar">
										<?php if ( has_post_thumbnail() ) : ?>

											<?php the_post_thumbnail( 'avatar' ); ?>

										<?php else : ?>

											<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">

										<?php endif; ?>
									</div>

									<div class="details">
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
								</div>
							</td>
							<td>
								<?php

								$phone_number = get_post_meta( $post->ID, '_orbis_person_phone_number', true );

								if ( ! empty( $phone_number ) && function_exists( 'orbis_snom_call_form' ) ) {
									orbis_snom_call_form( $phone_number );
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
