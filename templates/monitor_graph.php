<?php
wp_enqueue_script( 'flotcharts' );
wp_enqueue_script( 'flotcharts-time' );

global $wpdb;

$response_times = $wpdb->get_results( $wpdb->prepare( "
	SELECT
		AVG( duration ) AS avg_duration,
		monitored_date
	FROM
		$wpdb->orbis_monitor_responses
	WHERE
		post_id = %d
	GROUP BY 
		WEEKOFYEAR( monitored_date )
	ORDER BY
		monitored_date ASC
",
	$post->ID
) );

foreach ( $response_times as $response ) {
	$date = strtotime( $response->monitored_date ) * 1000; // WPCS: precision alignment ok.
	$average_period_durations[] = [ $date, $response->avg_duration ];
}

$response_times_json = wp_json_encode( $average_period_durations, JSON_NUMERIC_CHECK );
?>

<div class="card mb-3">
	<div class="card-header"><?php esc_html__( 'Monitor Graph - Average Response Time Per Time Period', 'orbis' ); ?></div>
	<div class="card-body">

		<div id="graph" style="width:100%;height:300px"></div>
	</div>

	<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			var options = {
				xaxis: {
					mode: "time",
					timeformat: "%d/%m"
				},
				series: {
					lines: { show: true },
					points: { show: true }
				}
			}
			$.plot( "#graph", [<?php echo wp_kses_post( $response_times_json ); ?>], options );
		} );
	</script>
</div>
