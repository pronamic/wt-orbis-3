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
		monitored_date DESC
", $post->ID ) );

foreach ( $response_times as $i => $response ) {
	$format_date = strtotime( $response->monitored_date ) * 1000;

	$graph_values[] = [ $i, $response->duration ];
}

$response_times_json = wp_json_encode( $graph_values, JSON_NUMERIC_CHECK );

?>

<div class="card mb-3">
	<div class="card-header"><?php esc_html_e( 'Monitor Graph - Response Time', 'orbis' ); ?></div>
	<div class="card-body">
		<div id="graph" style="width:100%;height:300px"></div>
	</div>

	<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			var options = { xaxis: {
					mode: "time"
				} };
			$.plot("#graph", [<?php echo esc_attr( $response_times_json ); ?>] );
		});
	</script>
</div>
