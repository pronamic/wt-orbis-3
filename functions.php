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
require_once get_template_directory() . '/includes/monitors.php';

if ( function_exists( 'orbis_tasks_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/tasks.php';
}

if ( function_exists( 'orbis_timesheets_bootstrap' ) ) {
	require_once get_template_directory() . '/includes/timesheets.php';
}

function orbis_plugin_activated( $plugin ) {
	return function_exists( 'orbis_' . $plugin . '_bootstrap' );
}

/**
 * Add custom fields to project status taxonomy
 */
function orbis_status_taxonomy_add_field() {
	?>

	<tr class="form-field">  
		<th scope="row" valign="top">  
			<label for="status_type"><?php esc_html_e( 'Status type.', 'orbis' ); ?></label>
		</th>  
		<td>
			<select name="status_type" id="status_type" >
				<option value="primary">Primary</option>
				<option value="secondary">Secondary</option>
				<option value="success">Success</option>
				<option value="danger">Danger</option>
				<option value="warning">Warning</option>
				<option value="info">Info</option>
				<option value="light">Light</option>
				<option value="dark">Dark</option>
			</select>
			<span class="description"><?php esc_html_e( 'The type of status to show.', 'orbis' ); ?></span>
		</td>
	</tr>
	<br /><br />

	<?php
}

function orbis_status_taxonomy_edit_field( $term ) {
	$term_id   = $term->term_id;
	$term_meta = get_term_meta( $term_id, 'orbis_status_type', true );
	?>

	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="status_type"><?php esc_html_e( 'Status type.', 'orbis' ); ?></label>
		</th>
		<td>
			<select name="status_type" id="status_type" >
				<?php

				printf(
					'<option selected disabled hidden value="%s">%s</option>',
					esc_attr( $term_meta ),
					esc_attr( ucfirst( $term_meta ) )
				);

				?>
				<option value="primary">Primary</option>
				<option value="secondary">Secondary</option>
				<option value="success">Success</option>
				<option value="danger">Danger</option>
				<option value="warning">Warning</option>
				<option value="info">Info</option>
				<option value="light">Light</option>
				<option value="dark">Dark</option>
			</select>
			<span class="description"><?php esc_html_e( 'The type of status to show.', 'orbis' ); ?></span>
		</td>
	</tr>
	<br /><br />

	<?php
}

/**
 * Save custom fields for any taxonomy
 */
function orbis_status_save_custom_fields( $term_id ) {
	if ( isset( $_POST['status_type'] ) ) {
		$status_type = sanitize_text_field( wp_unslash( $_POST['status_type'] ) );
		update_term_meta( $term_id, 'orbis_status_type', $status_type );
	}
}

add_action( 'orbis_project_status_add_form_fields', 'orbis_status_taxonomy_add_field', 10, 2 );
add_action( 'orbis_project_status_edit_form_fields', 'orbis_status_taxonomy_edit_field', 10, 2 );

add_action( 'create_orbis_project_status', 'orbis_status_save_custom_fields', 10, 2 );
add_action( 'edited_orbis_project_status', 'orbis_status_save_custom_fields', 10, 2 );

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
function orbis_invert_sort_order( $order ) {
	if ( 'asc' === $order ) {
		return 'desc';
	} elseif ( 'desc' === $order ) {
		return 'asc';
	}

	return 'asc';
}

/**
 * Get sorting order from URL when necessary
 */
function orbis_get_sort_order( $sort_term ) {
	// phpcs:disable
	$orderby = ( isset( $_GET['orderby'] ) ) ? $_GET['orderby'] : '';
	$order   = ( isset( $_GET['order'] ) ) ? $_GET['order'] : '';
	// phpcs:enable

	$order_set = ( isset( $order ) && ( strtolower( $orderby ) === strtolower( $sort_term ) ) ) ? $order : 'desc';

	if ( isset( $order ) && ( strtolower( $orderby ) === strtolower( $sort_term ) ) ) {
		if ( 'asc' === $order || 'desc' === $order ) {
			return $order;
		}
	}

	return $order_set;
}

/**
 * Echoes correct arrow for sorting order
 */
function orbis_sorting_icon( $order ) {
	$icon_format = '<span>%s</span>';
	$direction   = ( 'asc' === $order ) ? '↓' : '↑';

	return sprintf( $icon_format, $direction ); // WPCS: XSS ok.
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
