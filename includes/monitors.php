<?php

function orbis_monitor_render_details() {
	if ( is_singular( 'orbis_monitor' ) ) {
		global $orbis_subscriptions_plugin;

		get_template_part( 'templates/monitor_details' );
	}
}

add_action( 'orbis_before_side_content', 'orbis_monitor_render_details' );

function orbis_monitor_render_graph() {
	if ( is_singular( 'orbis_monitor' ) ) {
		global $orbis_subscriptions_plugin;

		get_template_part( 'templates/monitor_graph' );
	}
}

add_action( 'orbis_before_main_content', 'orbis_monitor_render_graph' );

function orbis_monitor_render_responses() {
	if ( is_singular( 'orbis_monitor' ) ) {
		global $orbis_subscriptions_plugin;

		get_template_part( 'templates/monitor_responses' );
	}
}

add_action( 'orbis_before_main_content', 'orbis_monitor_render_responses' );
