<?php
wp_enqueue_script( 'flotcharts' );
wp_enqueue_script( 'flotcharts-time' );

global $wpdb;

$period = isset( $_GET['period'] ) ? sanitize_text_field( wp_unslash( $_GET['period'] ) ) : '';

switch ( $period ) {
	case 'd':
		$groupby = 'DAY';
		$label   = esc_html__( 'Day', 'orbis' );
		break;

	case 'w':
		$groupby = 'WEEKOFYEAR';
		$label   = esc_html__( 'Week', 'orbis' );
		break;

	case 'm':
		$groupby = 'MONTH';
		$label   = esc_html__( 'Month', 'orbis' );
		break;

	default:
		$groupby = 'WEEKOFYEAR';
		$label   = esc_html__( 'Week', 'orbis' );
		break;
}

$last_year   = mktime( 0, 0, 0, date( 'm' ), date( 'd' ), date( 'Y' ) - 1 );
$graph_title = esc_html__( 'Average Response Time Per ', 'orbis' ) . $label;

$response_times = $wpdb->get_results( $wpdb->prepare( "
	SELECT
		AVG( duration ) AS avg_duration,
		monitored_date
	FROM
		$wpdb->orbis_monitor_responses
	WHERE
		post_id = %d
			AND
		monitored_date > %s
	GROUP BY 
		$groupby( monitored_date )
	ORDER BY
		monitored_date ASC
",
	$post->ID,
	$last_year
) );

foreach ( $response_times as $response ) {
	$date = strtotime( $response->monitored_date ) * 1000;

	$average_durations[] = [ $date, $response->avg_duration ];
}

$response_times_json = wp_json_encode( $average_durations, JSON_NUMERIC_CHECK );
?>

<div class="card mb-3">
	<div class="card-header">
		<?php echo esc_html( $graph_title ); ?>
		<button class="btn btn-light dropdown-toggle m-0 p-0 float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo esc_html( ucfirst( $label ) ); ?></button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'period', 'd' ) ); ?>"><?php echo esc_html( ucfirst( __( 'Day', 'orbis' ) ) ); ?></a>
			<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'period', 'w' ) ); ?>"><?php echo esc_html( ucfirst( __( 'Week', 'orbis' ) ) ); ?></a>
			<a class="dropdown-item" href="<?php echo esc_url( add_query_arg( 'period', 'm' ) ); ?>"><?php echo esc_html( ucfirst( __( 'Month', 'orbis' ) ) ); ?></a>
		</div>
	</div>
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
					lines: {
						show: true,
						lineWidth: 4
					},
					points: {
						show: true,
						fill: true,
						fillColor: "#007bff",
						radius: 4
					},
					shadowSize: 0
				},
				grid: {
					color: "#BBB",
					borderWidth: 0.5
				},
				colors: [ "#007bff" ]
			}
			$.plot( "#graph", [<?php echo wp_kses_post( $response_times_json ); ?>], options );
		} );
	</script>
</div>
