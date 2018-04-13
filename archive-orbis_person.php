<?php get_header(); ?>

<div class="card">
	<div class="card-block">
		<?php get_template_part( 'templates/search_form' ); ?>
	</div>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<col width="84" />

				<thead>
					<tr>
						<th></th>
						<th><?php esc_html_e( 'Name', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Company', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Address', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Author', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					while ( have_posts() ) :
						the_post();
						$contact = new Orbis_Contact();
					?>

						<tr>
							<td>
								<?php

								$url = get_template_directory_uri() . '/placeholders/avatar.png';

								if ( has_post_thumbnail() ) {
									$url = get_the_post_thumbnail_url( get_post(), 'avatar' );
								}

								printf(
									'<img src="%s" alt="" class="rounded-circle" />',
									esc_url( $url )
								);

								?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

								<span class="orbis-person-meta">
									<?php if ( get_post_meta( $post->ID, '_orbis_email', true ) ) : ?>

										<?php echo esc_html( get_post_meta( $post->ID, '_orbis_email', true ) ); ?><br />

									<?php endif; ?>

									<?php if ( get_post_meta( $post->ID, '_orbis_phone_number', true ) ) : ?>

										<?php echo esc_html( get_post_meta( $post->ID, '_orbis_phone_number', true ) ); ?>

									<?php endif; ?>
								</span>
							</td>
							<td>
								<?php

								$data = array_filter( array(
									$contact->get_title(),
									$contact->get_organization(),
								) );

								echo esc_html( implode( ', ', $data ) );

								?>
							</td>
							<td>
								<?php

								$address = $contact->get_address();

								printf(
									'%s<br />%s %s',
									esc_html( $address->get_address() ),
									esc_html( $address->get_postcode() ),
									esc_html( $address->get_city() )
								);

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
