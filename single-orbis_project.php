<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title"><?php esc_html_e( 'Description', 'orbis' ); ?></h3>
					<?php the_content(); ?>
				</div>
				
			</div>

			<?php get_template_part( 'templates/project_sections' ); ?>

			<?php do_action( 'orbis_after_main_content' ); ?>

			<?php comments_template( '', true ); ?>
		</div>

		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title"><?php esc_html_e( 'Project Status', 'orbis' ); ?></h3>
					<h5 class="entry-meta card-subtitle"><?php esc_html_e( 'Project budget', 'orbis' ); ?></h5> <br />

					<?php

					$price = $orbis_project->get_price();

					if ( $price ) : ?>

						<p class="project-time">
							<?php echo esc_html( orbis_price( $price ) ); ?>
						</p>

					<?php endif; ?>

					<p class="project-time">
						<?php echo esc_html( $orbis_project->get_available_time()->format() ); ?>

						<?php if ( function_exists( 'orbis_project_the_logged_time' ) ) : ?>

							<?php

							$classes = array();
							$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';

							?>

							<span class="<?php echo esc_attr( implode( $classes, ' ' ) ); ?>"><?php orbis_project_the_logged_time(); ?></span>

						<?php endif; ?>
					</p>
				</div>
				
			</div>

			<div class="card mt-3">
				<div class="card-body">
					<h3 class="card-title"><?php esc_html_e( 'Project Details', 'orbis' ); ?></h3>

					<div class="content">
						<dl>
							<?php if ( $orbis_project->has_principal() ) : ?>

								<dt><?php esc_html_e( 'Client', 'orbis' ); ?></dt>
								<dd>
									<?php

									printf(
										'<a href="%s">%s</a>',
										esc_attr( get_permalink( $orbis_project->get_principal_post_id() ) ),
										esc_html( $orbis_project->get_principal_name() )
									);

									?>
								</dd>

							<?php endif; ?>

							<dt><?php esc_html_e( 'Posted on', 'orbis' ); ?></dt>
							<dd><?php echo esc_html( get_the_date() ); ?></dd>

							<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
							<dd><?php echo esc_html( get_the_author() ); ?></dd>

							<?php

							$agreement_id = get_post_meta( get_the_ID(), '_orbis_project_agreement_id', true );

							if ( ! empty( $agreement_id ) && $agreement = get_post( $agreement_id ) ) : ?>

								<dt><?php esc_html_e( 'Agreement', 'orbis' ); ?></dt>
								<dd>
									<a href="<?php echo esc_attr( get_permalink( $agreement ) ); ?>"><?php echo get_the_title( $agreement ); ?></a>
								</dd>

							<?php endif; ?>

							<dt><?php esc_html_e( 'Status', 'orbis' ); ?></dt>
							<dd>
								<?php if ( $orbis_project->is_finished() ) : ?>

									<span class="badge badge-success"><?php esc_html_e( 'Finished', 'orbis' ); ?></span>

								<?php else : ?>

									<span class="badge badge-secondary"><?php esc_html_e( 'Not finished', 'orbis' ); ?></span>

								<?php endif; ?>

								<?php if ( $orbis_project->is_invoiced() ) : ?>

									<span class="badge badge-success"><?php esc_html_e( 'Invoiced', 'orbis' ); ?></span>

								<?php else : ?>

									<span class="badge badge-secondary"><?php esc_html_e( 'Not invoiced', 'orbis' ); ?></span>

								<?php endif; ?>

								<?php if ( $orbis_project->is_invoicable() ) : ?>

									<span class="badge badge-success"><?php esc_html_e( 'Invoicable', 'orbis' ); ?></span>

								<?php else : ?>

									<span class="badge badge-secondary"><?php esc_html_e( 'Not invoicable', 'orbis' ); ?></span>

								<?php endif; ?>
							</dd>

							<?php if ( has_term( null, 'orbis_payment_method' ) ) : ?>

								<dt><?php esc_html_e( 'Payment Method', 'orbis' ); ?></dt>
								<dd><?php the_terms( null, 'orbis_payment_method' ); ?></dd>

							<?php endif; ?>

							<?php

							$invoice_number = get_post_meta( get_the_ID(), '_orbis_project_invoice_number', true );

							if ( ! empty( $invoice_number ) ) : ?>

								<dt><?php esc_html_e( 'Final Invoice', 'orbis' ); ?></dt>
								<dd>
									<?php

									$invoice_link = orbis_get_invoice_link( $invoice_number );

									if ( ! empty( $invoice_link ) ) {
										printf(
											'<a href="%s" target="_blank">%s</a>',
											esc_attr( $invoice_link ),
											esc_html( $invoice_number )
										);
									} else {
										echo esc_html( $invoice_number );
									}

									?>
								</dd>

							<?php endif; ?>

							<dt><?php esc_html_e( 'Actions', 'orbis' ); ?></dt>
							<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>
						</dl>
					</div>
				</div>
			</div>

			<div class="panel" style="display: none;">
				<header>
					<h3><?php esc_html_e( 'Project Invoices', 'orbis' ); ?></h3>
				</header>
				<div class="content">
					<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
					<dd><?php echo esc_html( get_the_author() ); ?></dd>
				</div>
			</div>

			<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>

				<?php get_template_part( 'templates/project_persons' ); ?>

			<?php endif; ?>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
