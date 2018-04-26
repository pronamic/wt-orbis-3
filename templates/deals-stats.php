<?php
use Pronamic\WordPress\Money\Money;

/**
 * Date query
 */
$date_query = array();

$date = filter_input( INPUT_GET, 'date', FILTER_SANITIZE_STRING );

if ( ! empty( $date ) ) {
	$date = explode( '-', $date );

	$year  = $date[0];
	$month = $date[1];
	$day   = $date[2];

	$date_query[] = array(
		'after'     => array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day,
		),
		'inclusive' => true,
	);
} else {
	$date_query[] = array(
		'column' => 'post_date_gmt',
		'after'  => '1 year ago',
	);
}

/**
 * Pending deals
 */
$pending_deals_query = new WP_Query(
	array(
		'post_type'      => 'orbis_deal',
		'posts_per_page' => 50,
		'date_query'     => $date_query,
		'meta_query'     => array( // WPCS: slow query ok.
			array(
				'key'     => '_orbis_deal_status',
				'value'   => 'pending',
				'compare' => 'LIKE',
			),
		),
	)
);

$pending_deals = $pending_deals_query->found_posts;

/**
 * Open amount
 */
$total_amount = 0;

if ( $pending_deals_query->have_posts() ) {
	while ( $pending_deals_query->have_posts() ) {
		$pending_deals_query->the_post();
		$deal_price = get_post_meta( $post->ID, '_orbis_deal_price', true );

		if ( empty( $deal_price ) ) {
			continue;
		}

		$total_amount += floatval( $deal_price );
	}
}

/**
 * Won deals
 */
$won_deals_query = new WP_Query(
	array(
		'post_type'      => 'orbis_deal',
		'posts_per_page' => 50,
		'date_query'     => $date_query,
		'meta_query'     => array( // WPCS: slow query ok.
			array(
				'key'     => '_orbis_deal_status',
				'value'   => 'won',
				'compare' => 'LIKE',
			),
		),
	)
);

$won_deals = $won_deals_query->found_posts;

/**
 * Lost deals
 */
$lost_deals_query = new WP_Query(
	array(
		'post_type'      => 'orbis_deal',
		'posts_per_page' => 50,
		'date_query'     => $date_query,
		'meta_query'     => array( // WPCS: slow query ok.
			array(
				'key'     => '_orbis_deal_status',
				'value'   => 'lost',
				'compare' => 'LIKE',
			),
		),
	)
);

$lost_deals = $lost_deals_query->found_posts;

/**
 * Total deals
 */
$total_deals = $pending_deals + $won_deals + $lost_deals;

$percentage = 0;

if ( $total_deals ) {
	$percentage = ( $won_deals / $total_deals ) * 100;
}

?>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<h1><?php echo esc_html( round( $percentage ) ) . '%'; ?> <span style="font-size: 16px; font-weight: normal;">of the deals have been won</span> </h1>

				<div class="progress progress-striped active">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_html( round( $total ) ); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html( round( $percentage ) ) . '%'; ?>;">
						<span class="sr-only"><?php echo esc_html( round( $percentage ) ) . '%'; ?> Complete</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<p><?php esc_html_e( 'Won deals', 'orbis' ); ?></p>
				<h1><?php echo esc_html( round( $won_deals, 2 ) ); ?></h1>
			</div>

			<div class="col-md-3">
				<p><?php esc_html_e( 'Lost deals', 'orbis' ); ?></p>
				<h1><?php echo esc_html( round( $lost_deals, 2 ) ); ?></h1>
			</div>

			<div class="col-md-3">
				<p><?php esc_html_e( 'Pending deals', 'orbis' ); ?></p>
				<h1><?php echo esc_html( round( $pending_deals, 2 ) ); ?></h1>
			</div>

			<div class="col-md-3">
				<p><?php esc_html_e( 'Total amount open', 'orbis' ); ?></p>
				<h1>
					<?php
					$total_amount = new Money( $total_amount, 'EUR' );
					echo esc_html( $total_amount->format_i18n() );
					?>
				</h1>
			</div>
		</div>
	</div>
</div>

