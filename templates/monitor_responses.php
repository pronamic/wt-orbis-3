<?php

global $wpdb;

$amount = isset( $_GET['amount'] ) ? intval( $_GET['amount'] ) : '10'; //PHPCS:ignore WordPress.VIP.ValidatedSanitizedInput.InputNotValidated

$responses = $wpdb->get_results( $wpdb->prepare( "
	SELECT
		*
	FROM
		$wpdb->orbis_monitor_responses
	WHERE
		post_id = %d
	ORDER BY
		monitored_date DESC
	LIMIT
		0, %d",
	$post->ID,
	$amount
) );

$table_title = sprintf(
	__( 'Last %d Responses', 'orbis' ),
	$amount
);
?>

<div class="card mb-3">
	<div class="card-header">
		<?php echo esc_html( $table_title ); ?>
		<button class="btn btn-light dropdown-toggle m-0 p-0 float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo esc_html( $amount ); ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'amount', '10' ) ); ?>"><?php echo esc_html( '10' ); ?></a>
			<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'amount', '50' ) ); ?>"><?php echo esc_html( '50' ); ?></a>
			<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'amount', '100' ) ); ?>"><?php echo esc_html( '100' ); ?></a>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-striped mb-0">
			<thead>
				<tr>
					<th class="border-top-0" scope="col"><?php esc_html_e( 'Date', 'orbis' ); ?></th>
					<th class="border-top-0" scope="col"><?php esc_html_e( 'Duration', 'orbis' ); ?></th>
					<th class="border-top-0" scope="col"><?php esc_html_e( 'Code', 'orbis' ); ?></th>
					<th class="border-top-0" scope="col"><?php esc_html_e( 'Message', 'orbis' ); ?></th>
					<th class="border-top-0" scope="col"><?php esc_html_e( 'Content Length', 'orbis' ); ?></th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ( $responses as $response ) : ?>

					<tr>
						<td>
							<?php echo esc_html( date( 'd-m-Y H:i', strtotime( $response->monitored_date ) ) ); ?>
						</td>
						<td>
							<?php
							if ( empty( $response->duration ) ) {
								echo '—';
							} else {
								echo esc_html( number_format_i18n( $response->duration, 2 ) );
							}
							?>
						</td>
						<td>
							<?php echo esc_html( $response->response_code ); ?>
						</td>
						<td>
							<?php echo esc_html( $response->response_message ); ?>
						</td>
						<td>
							<?php echo esc_html( $response->response_content_length ); ?>
						</td>
					</tr>

				<?php endforeach; ?>

			</tbody>
		</table>
	</div>

</div>
