<?php
global $post;

$orbis_project = new Orbis_Project( $post );
$invoices      = $orbis_project->get_invoices();

if ( $invoices && $invoices[0]->id ) : ?>

	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead>
				<tr>
					<th class="border-top-0"><?php esc_html_e( 'Date', 'orbis' ); ?></th>
					<th class="border-top-0"><?php esc_html_e( 'Amount', 'orbis' ); ?></th>
					<th class="border-top-0"><?php esc_html_e( 'Hours', 'orbis' ); ?></th>
					<th class="border-top-0"><?php esc_html_e( 'Invoice Number', 'orbis' ); ?></th>
					<th class="border-top-0"><?php esc_html_e( 'User', 'orbis' ); ?></th>
				</tr>
			</thead>
				<?php
					$amount_total = 0;
					$hours_total  = 0;
				?>
			<tbody>
				<?php foreach ( $invoices as $invoice ) : ?>
					<?php
						$amount_total += $invoice->amount;
						$hours_total  += $invoice->seconds;
					?>
					<tr id="post-<?php the_ID(); ?>">
						<td>
							<?php echo esc_html( date_format( new DateTime( $invoice->create_date ), 'd-m-Y' ) ); ?>
						</td>
						<td>
							<?php echo esc_html( orbis_price( $invoice->amount ) ); ?>
						</td>
						<td>
							<?php
							if ( $invoice->seconds ) {
								echo esc_html( orbis_time( $invoice->seconds ) );
							}
						?>
						</td>
						<td>
							<?php
							$invoice_link = orbis_get_invoice_link( $invoice->invoice_number );

							if ( ! empty( $invoice_link ) ) {
								printf(
									'<a href="%s" target="_blank">%s</a>',
									esc_attr( $invoice_link ),
									esc_html( $invoice->invoice_number )
								);
							} else {
								echo esc_html( $invoice->invoice_number );
							}
							echo ( $invoice->invoice_number === get_post_meta( $post->ID, '_orbis_project_invoice_number', true ) ) ? ' <span class="dashicons dashicons-yes"></span>' : '';
							?>
						</td>
						<td>
							<?php echo esc_html( $invoice->display_name ); ?>
						</td>
					</tr>

				<?php endforeach; ?>
					<tr>
						<td>
							<strong><?php esc_html_e( 'Total:', 'orbis' ); ?></strong>
						</td>
						<td>
							<strong><?php echo esc_html( orbis_price( $amount_total ) ); ?></strong>
						</td>
						<td>
							<strong><?php echo esc_html( orbis_time( $hours_total ) ); ?></strong>
						</td>
						<td></td>
						<td></td>
					</tr>
			</tbody>
		</table>
	</div>

	<?php wp_reset_postdata(); ?>

<?php else : ?>

	<div class="content">
		<p class="alt">
			<?php esc_html_e( 'No invoices found.', 'orbis' ); ?>
		</p>
	</div>

<?php endif; ?>
