<?php
wp_enqueue_script( 'flotcharts' );

global $wpdb;

$response_times = $wpdb->get_col( $wpdb->prepare( "
	SELECT
		duration
	FROM
		$wpdb->orbis_monitor_responses
	WHERE
		post_id = %d
	ORDER BY
		monitored_date DESC
", $post->ID ) );

foreach ( $response_times as $i => $response ) {
	$graph_values[] = [ $i, $response ];
}

$response_times_JSON = json_encode( $graph_values, JSON_NUMERIC_CHECK );

?>

<div class="card mb-3">
	<div class="card-header"><?php esc_html_e( 'Monitor Graph - Response Time', 'orbis' ); ?></div>
	<div class="card-body">
		<div id="graph" style="width:100%;height:300px"></div>
	</div>

	<script type="text/javascript">
		jQuery( document ).ready( function( $ ) {
			$.plot("#graph", [<?php echo $response_times_JSON; ?>] );
		});
	</script>
</div>