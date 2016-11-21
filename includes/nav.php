<?php

/**
 * Navigation icons
 */
function orbis_nav_menu_icons( $classes, $item, $args ) {
	$fa = 'fa-file-o';

	foreach ( $classes as $class ) {
		$icon = strpos( $class, 'icon-' );

		if ( 0 === $icon ) {
			$class = str_replace( 'icon-', 'fa-', $class );

			$fa = $class;
		}
	}

	$item->title = '<i class="fa ' . $fa . '"></i> <span class="nav-label">' . $item->title . '</span>';

	return $classes;
}

add_filter( 'nav_menu_css_class', 'orbis_nav_menu_icons', 10, 3 );
