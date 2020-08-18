<?php get_header(); ?>

<?php
while ( have_posts() ) :
	the_post();
?>

	<div class="row">
		<div class="col-md-8">
			<div class="card with-cols clearfix mb-3">
				<div class="card-header"><?php esc_html_e( 'About this contact', 'orbis' ); ?></div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="content">
								<?php if ( has_post_thumbnail() ) : ?>

									<div class="thumbnail">
										<?php the_post_thumbnail( 'thumbnail' ); ?>
									</div>

								<?php endif; ?>

								<?php the_content(); ?>
							</div>
						</div>

						<div class="col-md-6">
							<div class="content">
								<?php $contact = new Orbis_Contact(); ?>

								<dl>
									<?php

									$data = array_filter( array(
										$contact->get_title(),
										$contact->get_organization(),
										$contact->get_department(),
									) );

									if ( ! empty( $data ) ) :
									?>

										<dt><?php esc_html_e( 'Company', 'orbis' ); ?></dt>
										<dd>
											<?php echo esc_html( implode( ', ', $data ) ); ?>
										</dd>

									<?php endif; ?>

									<?php if ( get_post_meta( $post->ID, '_orbis_phone_number', true ) ) : ?>

										<dt><?php esc_html_e( 'Phone number', 'orbis' ); ?></dt>
										<dd><a href="tel:<?php echo esc_attr( get_post_meta( $post->ID, '_orbis_phone_number', true ) ); ?>" class="anchor-tooltip" title="<?php esc_attr_e( 'Call this number', 'orbis' ); ?>"><?php echo esc_html( get_post_meta( $post->ID, '_orbis_phone_number', true ) ); ?></a></dd>

									<?php endif; ?>

									<?php if ( get_post_meta( $post->ID, '_orbis_mobile_number', true ) ) : ?>

										<dt><?php esc_html_e( 'Mobile number', 'orbis' ); ?></dt>
										<dd><a href="tel:<?php echo esc_attr( get_post_meta( $post->ID, '_orbis_mobile_number', true ) ); ?>" class="anchor-tooltip" title="<?php esc_attr_e( 'Call this number', 'orbis' ); ?>"><?php echo esc_html( get_post_meta( $post->ID, '_orbis_mobile_number', true ) ); ?></a></dd>

									<?php endif; ?>

									<?php

									$email = $contact->get_email();

									if ( ! empty( $email ) ) :
									?>

										<dt><?php esc_html_e( 'E-mail address', 'orbis' ); ?></dt>
										<dd>
											<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
										</dd>

									<?php endif; ?>

									<?php

									$gender = $contact->get_gender();

									if ( ! empty( $gender ) ) :
									?>

										<dt><?php esc_html_e( 'Gender', 'orbis' ); ?></dt>
										<dd>
											<?php echo esc_html( $gender->name ); ?>
										</dd>

									<?php endif; ?>

									<?php

									$address = (string) $contact->get_address();

									if ( ! empty( $address ) ) :
									?>

										<dt><?php esc_html_e( 'Address', 'orbis' ); ?></dt>
										<dd>
											<?php echo nl2br( esc_html( $address ) ); ?>
										</dd>

									<?php endif; ?>

									<?php

									$iban = get_post_meta( $post->ID, '_orbis_iban', true );

									if ( ! empty( $iban ) ) :
									?>

										<dt><?php esc_html_e( 'IBAN Number', 'orbis' ); ?></dt>
										<dd>
											<?php echo esc_attr( get_post_meta( $post->ID, '_orbis_iban', true ) ); ?>
										</dd>

									<?php endif; ?>

									<?php

									$birth_date = $contact->get_birth_date();

									if ( $birth_date ) :
									?>

										<dt><?php esc_html_e( 'Birth Date', 'orbis' ); ?></dt>
										<dd>
											<?php echo esc_html( date_i18n( __( 'j F Y', 'orbis' ), $birth_date->getTimestamp() ) ); ?>
										</dd>

										<dt><?php esc_html_e( 'Age', 'orbis' ); ?></dt>
										<dd>
											<?php echo esc_html( $contact->get_age() ); ?>
										</dd>

									<?php endif; ?>

									<?php if ( has_term( null, 'orbis_person_category' ) ) : ?>

										<dt><?php esc_html_e( 'Categories', 'orbis' ); ?></dt>
										<dd>
											<?php the_terms( get_the_ID(), 'orbis_person_category' ); ?>
										</dd>

									<?php endif; ?>

									<dt><?php esc_html_e( 'vCard', 'orbis' ); ?></dt>
									<dd>
										<?php

										printf(
											'<a href="%s">%s</a>',
											esc_attr( get_permalink() . 'vcard/' ),
											esc_html__( 'Download vCard', 'orbis' )
										);

										?>
									</dd>

									<?php if ( get_post_meta( $post->ID, '_orbis_twitter', true ) || get_post_meta( $post->ID, '_orbis_facebook', true ) || get_post_meta( $post->ID, '_orbis_linkedin', true ) ) : ?>

										<dt><?php esc_html_e( 'Social media', 'orbis' ); ?></dt>
										<dd>
											<ul class="social clearfix">
												<?php if ( get_post_meta( $post->ID, '_orbis_twitter', true ) ) : ?>

													<li class="twitter">
														<?php $twitter_url = 'https://twitter.com/' . get_post_meta( $post->ID, '_orbis_twitter', true ); ?>													
														<a href="<?php echo esc_attr( $twitter_url ); ?>">
															<i class="fab fa-twitter"></i>

															<span class="sr-only"><?php esc_html_e( 'Twitter', 'orbis' ); ?></span>
														</a>
													</li>

												<?php endif; ?>

												<?php if ( get_post_meta( $post->ID, '_orbis_facebook', true ) ) : ?>

													<li class="facebook">
														<?php $facebook_url = get_post_meta( $post->ID, '_orbis_facebook', true ); ?>
														<a href="<?php echo esc_attr( $facebook_url ); ?>">
															<i class="fab fa-facebook"></i>

															<span class="sr-only"><?php esc_html_e( 'Facebook', 'orbis' ); ?></span>
														</a>
													</li>

												<?php endif; ?>

												<?php if ( get_post_meta( $post->ID, '_orbis_linkedin', true ) ) : ?>

													<li class="linkedin">
														<?php $linkedin_url = get_post_meta( $post->ID, '_orbis_linkedin', true ); ?>
														<a href="<?php echo esc_attr( $linkedin_url ); ?>">
															<i class="fab fa-linkedin"></i>

															<span class="sr-only"><?php esc_html_e( 'LinkedIn', 'orbis' ); ?></span>
														</a>
													</li>

												<?php endif; ?>
											</ul>
										</dd>

									<?php endif; ?>
								</dl>
							</div>
						</div>
					</div>

					<?php get_template_part( 'templates/post-card-footer' ); ?>
				</div>

			</div>

			<?php comments_template( '', true ); ?>
		</div>

		<div class="col-md-4">
			<?php get_template_part( 'templates/person_twitter' ); ?>

			<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>

				<?php get_template_part( 'templates/person_companies' ); ?>

			<?php endif; ?>

			<div class="card mb-3">
				<div class="card-header"><?php esc_html_e( 'Additional information', 'orbis' ); ?></div>

				<div class="card-body">
					<dl>
						<dt><?php esc_html_e( 'Posted on', 'orbis' ); ?></dt>
						<dd><?php echo esc_html( get_the_date() ); ?></dd>

						<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
						<dd><?php echo esc_html( get_the_author() ); ?></dd>

						<?php if ( null !== get_edit_post_link() ) : ?>

							<dt><?php esc_html_e( 'Actions', 'orbis' ); ?></dt>
							<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>

						<?php endif; ?>
					</dl>
				</div>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
