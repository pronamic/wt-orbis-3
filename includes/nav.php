<?php

/**
 * Navigation icons
 */
function orbis_nav_menu_icons( $classes, $item, $args ) {
	$fa = 'far fa-file';

	foreach ( $classes as $class ) {
		$icon = strpos( $class, 'icon-' );

		if ( 0 === $icon ) {
			$class = str_replace( 'icon-fab-', 'fab fa-', $class );
			$class = str_replace( 'icon-far-', 'far fa-', $class );
			$class = str_replace( 'icon-fas-', 'fas fa-', $class );			

			$fa = $class;
		}
	}

	$item->title = '<i class="' . $fa . ' fa-fw"></i> <span class="nav-label ml-2">' . $item->title . '</span>';

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$item->title .= '';
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'orbis_nav_menu_icons', 10, 3 );
