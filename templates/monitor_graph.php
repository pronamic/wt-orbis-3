<?php
wp_enqueue_script( 'flotcharts' );
wp_enqueue_script( 'flotcharts-time' );

global $wpdb;

$response_times = $wpdb->get_results( $wpdb->prepare( "
	SELECT
		duration,
		monitored_date
	FROM
		$wpdb->orbis_monitor_responses
	WHERE
		post_id = %d
	ORDER BY
		monitored_date ASC
", $post->ID ) );

foreach ( $response_times as $response ) {
	$date   = new DateTime( $response->monitored_date );
	$period = $date->format( "W" );

	$all_period_durations[ $period ][] = (float) $response->duration;
}

foreach ( $all_period_durations as $period => $period_durations ) {
	$total = array_sum( $period_durations );
	$average_duration = $total / count( $period_durations );

	$average_period_durations[] = [ $period, $average_duration ];
}

$response_times_json = wp_json_encode( $average_period_durations );
?>

<div class="card mb-3">
	<div class="card-header"><?php esc_html_e( 'Monitor Graph - Average Response Time Per Week', 'orbis' ); ?></div>
	<div class="card-body">
		<div id="graph" style="width:100%;height:300px"></div>
	</div>

	<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			var options = {
				xaxis: {
					minTickSize: 1,
					tickDecimals: 0
				},
				series: {
					lines: { show: true },
					points: { show: true }
				}
			}
			$.plot( "#graph", [<?php echo $response_times_json; ?>], options );
		} );
	</script>
</div>
