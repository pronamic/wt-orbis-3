<?php

/**
 * Autoload
 */
require get_template_directory() . '/vendor/autoload.php';

/**
 * Includes
 */
require_once get_template_directory() . '/includes/projects.php';
require_once get_template_directory() . '/includes/subscriptions.php';
require_once get_template_directory() . '/includes/template-tags.php';
require_once get_template_directory() . '/includes/widgets.php';
require_once get_template_directory() . '/includes/nav.php';
require_once get_template_directory() . '/includes/shortcodes.php';
require_once get_template_directory() . '/includes/customizer.php';
require_once get_template_directory() . '/includes/invoices.php';

if ( function_exists( 'orbis_tasks_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/tasks.php';
}

if ( function_exists( 'orbis_timesheets_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/timesheets.php';
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 728;
}

/**
 * Theme
 */
$orbis_theme = new Orbis_Theme();

/**
 * Sets the post excerpt length to 40 words.
 */
function orbis_excerpt_length( $length ) {
	return 24;
}

add_filter( 'excerpt_length', 'orbis_excerpt_length' );

function orbis_get_archive_post_type() {
	$post_type_obj = get_queried_object();
	$post_type     = $post_type_obj->name;

	return $post_type;
}

function orbis_get_post_type_archive_link( $post_type = null ) {
	if ( null === $post_type ) {
		$post_type = orbis_get_archive_post_type();
	}

	return get_post_type_archive_link( $post_type );
}

function orbis_get_url_post_new( $post_type = null ) {
	if ( null === $post_type ) {
		$post_type = orbis_get_archive_post_type();
	}

	$url = admin_url( 'post-new.php' );

	if ( ! empty( $post_type ) ) {
		$url = add_query_arg( 'post_type', $post_type, $url );
	}

	return $url;
}

if ( ! function_exists( 'orbis_price' ) ) {
	function orbis_price( $price ) {
		// @see https://en.wikipedia.org/wiki/Non-breaking_space#Keyboard_entry_methods
		$non_breaking_space = ' ';

		return '€' . $non_breaking_space . number_format_i18n( $price, 2 );
	}
}

function orbis_the_content_empty( $content ) {
	if ( is_singular( array( 'post', 'orbis_person', 'orbis_project' ) ) ) {
		if ( empty( $content ) ) {
			$content = '<p class="alt">' . __( 'No description.', 'orbis' ) . '</p>';
		}
	}

	return $content;
}

add_filter( 'the_content', 'orbis_the_content_empty', 200 );

function orbis_add_tabs_endpoint() {
	add_rewrite_endpoint( 'tabs', EP_ALL );
}

add_action( 'init', 'orbis_add_tabs_endpoint' );


/**
 * Orbis Companies
 */
function orbis_companies_render_contact_details() {
	if ( is_singular( 'orbis_company' ) ) {
		get_template_part( 'templates/company_contact' );
	}
}

add_action( 'orbis_before_side_content', 'orbis_companies_render_contact_details' );

/**
 * Custom excerpt
 */
function orbis_custom_excerpt( $excerpt, $charlength = 30 ) {
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );

	if ( strlen( $excerpt ) > $charlength ) {
		$excerpt = substr( $excerpt, 0, $charlength ) . '…';
	} else {
		$excerpt = $excerpt;
	}

	echo esc_html( $excerpt );
}

/**
 * Load timesheet data with AJAX
 */
function orbis_load_timesheet_data() {
	get_template_part( 'templates/widget_timesheets' );

	die();
}

add_action( 'wp_ajax_load_timesheet_data', 'orbis_load_timesheet_data' );

/**
 * Page title
 */
function orbis_get_title() {
	if ( is_front_page() ) {
		return __( 'Dashboard', 'orbis' );

	} elseif ( is_home() ) {
		return __( 'News', 'orbis' );

	} elseif ( is_page() || is_single() ) {
		return get_the_title();

	} elseif ( is_category() ) {
		return single_cat_title( '', false );

	} elseif ( is_tag() ) {
		return single_tag_title( '', false );

	} elseif ( is_author() ) {
		return get_the_author();

	} elseif ( is_archive() ) {
		return post_type_archive_title();

	} elseif ( is_search() ) {
		return __( 'Search', 'orbis' );

	} elseif ( is_404() ) {
		return __( '404 - Page not found', 'orbis' );

	} else {
		return __( 'Unknown', 'orbis' );

	}
}

/**
 * Invert sorting order ASC<->DESC
 */
function orbis_invert_sort_order( $sort_term ) {
	// phpcs:disable
	$orderby = ( isset( $_GET['orderby'] ) ) ? $_GET['orderby'] : '';
	$order   = ( isset( $_GET['order'] ) ) ? $_GET['order'] : '';
	// phpcs:enable

	$order_inverted = ( isset( $order ) && ( strtolower( $orderby ) === strtolower( $sort_term ) ) ) ? $order : 'desc';

	if ( isset( $order ) && ( strtolower( $orderby ) === strtolower( $sort_term ) ) ) {
		if ( 'asc' === $order ) {
			$order_inverted = 'desc';
		} elseif ( 'desc' === $order ) {
			$order_inverted = 'asc';
		}
	}

	return $order_inverted;
}

/**
 * Echoes correct arrow for sorting where necessary
 */
function orbis_sorting_icon( $order, $sorting_term ) {
	$orderby = ( isset( $_GET['orderby'] ) ) ? $_GET['orderby'] : ''; // phpcs:ignore

	if ( isset( $orderby ) && $sorting_term === $orderby ) {
		$icon_format = "<span class='dashicons dashicons-arrow-%s'></span>";
		$direction   = ( 'asc' === $order ) ? 'desc' : 'asc';

		return sprintf( $icon_format, $direction ); // WPCS: XSS ok.
	}
}

/**
 * Load custom CSS
 */
function orbis_load_css() {
	$style  = '';
	$style .= '<style type="text/css" media="screen">';
	$style .= 'a { color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.btn-primary, .panel.panel-featured { border-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.btn-primary { background-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: ' . get_option( 'orbis_primary_color' ) . '; border-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '.primary-nav > ul > li.active > a, .primary-nav > ul > li.current-menu-item > a, .primary-nav > ul > li.current-url-ancestor > a, .primary-nav > ul > li.current-menu-parent > a { border-color: ' . get_option( 'orbis_primary_color' ) . '; }';
	$style .= '</style>';

	echo $style; // WPCS: XSS ok.
}

add_action( 'wp_head', 'orbis_load_css' );

/**
 * Support SVG uploads
 */
function orbis_allowed_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'orbis_allowed_mime_types' );

/**
 * Orbis get website favicon URL
 */
function orbis_get_favicon_url( $domain ) {
	if ( ! empty( $domain ) ) {
		return add_query_arg( 'domain', $domain, 'https://plus.google.com/_/favicon' );
	}

	return null;
}
