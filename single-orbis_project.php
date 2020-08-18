<?php

use Pronamic\WordPress\Money\Money;

get_header();

?>

<?php
while ( have_posts() ) :
	the_post();
?>

	<div class="row">
		<div class="col-md-8">

			<?php if ( ! empty( get_the_content() ) ) : ?>

			<div class="card mb-3">
				<div class="card-header"><?php esc_html_e( 'Description', 'orbis' ); ?></div>

				<div class="card-body">
					<?php the_content(); ?>
				</div>

				<?php get_template_part( 'templates/post-card-footer' ); ?>
			</div>

			<?php endif; ?>

			<?php get_template_part( 'templates/project_sections' ); ?>

			<?php do_action( 'orbis_after_main_content' ); ?>

			<?php comments_template( '', true ); ?>
		</div>

		<div class="col-md-4">
			<div class="card">
				<div class="card-header"><?php esc_html_e( 'Project Status', 'orbis' ); ?></div>

				<div class="card-body">
					<h5 class="entry-meta"><?php esc_html_e( 'Project budget', 'orbis' ); ?></h5>

					<?php

					$price = $orbis_project->get_price();

					if ( $price ) :
					?>

						<p class="project-time">
							<?php
							$price = new Money( $price, 'EUR' );
							echo esc_html( $price->format_i18n() );
							?>
						</p>

					<?php endif; ?>

					<p class="project-time">
						<?php echo esc_html( $orbis_project->get_available_time()->format() ); ?>

						<?php if ( function_exists( 'orbis_project_the_logged_time' ) ) : ?>

							<?php

							$classes   = array();
							$classes[] = orbis_project_in_time() ? 'text-success' : 'text-error';

							?>

							<span class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php orbis_project_the_logged_time(); ?></span>

						<?php endif; ?>
					</p>
				</div>
			</div>

			<div class="card mt-3">
				<div class="card-header"><?php esc_html_e( 'Project Details', 'orbis' ); ?></div>

				<div class="card-body">
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

						if ( ! empty( $agreement_id ) ) :
							$agreement = get_post( $agreement_id );
						?>

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
							<?php

							$project_statuses = wp_get_post_terms( $orbis_project->post->ID, 'orbis_project_status' );

							foreach ( $project_statuses as $project_status ) {
								$status_type = get_term_meta( $project_status->term_id, 'orbis_status_type', true ) ? get_term_meta( $project_status->term_id, 'orbis_status_type', true ) : 'primary';
								printf(
									'<span class="badge badge-%s orbis-status">%s</span>',
									esc_attr( $status_type ),
									esc_attr( $project_status->name )
								);
							}

							?>
						</dd>

						<?php if ( has_term( null, 'orbis_payment_method' ) ) : ?>

							<dt><?php esc_html_e( 'Payment Method', 'orbis' ); ?></dt>
							<dd><?php the_terms( null, 'orbis_payment_method' ); ?></dd>

						<?php endif; ?>

						<?php

						$invoice_header_text      = get_post_meta( $post->ID, '_orbis_invoice_header_text', true );
						$invoice_footer_text      = get_post_meta( $post->ID, '_orbis_invoice_footer_text', true );
						$invoice_line_description = get_post_meta( $post->ID, '_orbis_invoice_line_description', true );

						?>

						<?php if ( ! empty( $invoice_header_text ) ) : ?>

							<dt><?php esc_html_e( 'Invoice Header Text', 'orbis' ); ?></dt>
							<dd>
								<?php echo nl2br( esc_html( $invoice_header_text ) ); ?></a>
							</dd>

						<?php endif; ?>

						<?php if ( ! empty( $invoice_footer_text ) ) : ?>

							<dt><?php esc_html_e( 'Invoice Footer Text', 'orbis' ); ?></dt>
							<dd>
								<?php echo nl2br( esc_html( $invoice_footer_text ) ); ?></a>
							</dd>

						<?php endif; ?>

						<?php if ( ! empty( $invoice_line_description ) ) : ?>

							<dt><?php esc_html_e( 'Invoice Line Description', 'orbis' ); ?></dt>
							<dd>
								<?php echo nl2br( esc_html( $invoice_line_description ) ); ?></a>
							</dd>

						<?php endif; ?>

						<?php

						$invoice_number = get_post_meta( get_the_ID(), '_orbis_project_invoice_number', true );

						if ( ! empty( $invoice_number ) ) :
						?>

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

						<?php if ( null !== get_edit_post_link() ) : ?>

							<dt><?php esc_html_e( 'Actions', 'orbis' ); ?></dt>
							<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>

						<?php endif; ?>
					</dl>
				</div>
			</div>

			<div class="card" style="display: none;">
				<div class="card-header"><?php esc_html_e( 'Project Invoices', 'orbis' ); ?></div>

				<div class="card-body">
					<dl>
						<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
						<dd><?php echo esc_html( get_the_author() ); ?></dd>
					</dl>
				</div>

			</div>

			<?php if ( function_exists( 'p2p_register_connection_type' ) ) : ?>

				<?php get_template_part( 'templates/project_persons' ); ?>

			<?php endif; ?>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
