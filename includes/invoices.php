<?php

function orbis_project_sections_invoices( $sections ) {
	$sections[] = array(
		'id'            => 'invoices',
		'name'          => __( 'Invoices', 'orbis' ),
		'template_part' => 'templates/project_invoices',
	);

	return $sections;
}

add_filter( 'orbis_project_sections', 'orbis_project_sections_invoices' );
