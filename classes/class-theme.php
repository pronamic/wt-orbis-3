<?php

/**
 * Theme
 */
class Orbis_Theme {
	/**
	 * Construct
	 */
	public function __construct() {
		// Scripts
		$this->scripts = new Orbis_Theme_Scripts();

		// Admin
		if ( is_admin() ) {
			$this->admin = new Orbis_Theme_Admin();
		}

		// Actions
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
		add_filter( 'query_vars', array( $this, 'query_vars' ) );
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

		add_filter( 'navigation_markup_template', array( $this, 'navigation_markup_template' ), 10, 2 );
	}

	/**
	 * After Setup Theme
	 */
	public function after_setup_theme() {
		/* Editor Style */
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		add_editor_style( '/css/editor-style' . $min . '.css' );

		/* Text Domain */
		load_theme_textdomain( 'orbis', get_template_directory() . '/languages' );
		load_theme_textdomain( 'pronamic-money', get_template_directory() . '/vendor/pronamic/wp-money/languages/' );

		/* Theme support */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat' ) );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

		/* Navigation menu's */
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'orbis' ),
		) );

		/* Image sizes */
		add_image_size( 'featured', 244, 150, true );
		add_image_size( 'avatar', 60, 60, true );
	}

	public function template_redirect() {
		if ( ! is_post_type_archive( 'orbis_person' ) ) {
			return;
		}

		$url = get_post_type_archive_linK( 'orbis_person' );

		$args = $_GET; // WPCS: CSRF ok.

		$args = array_filter( $args );

		if ( isset( $args['c'] ) && is_array( $args['c'] ) ) {
			$terms = get_terms( array(
				'taxonomy' => 'orbis_person_category',
				'include'  => $args['c'],
			) );

			$args['c'] = implode( ',', wp_list_pluck( $terms, 'slug' ) );
		}

		if ( $args !== $_GET ) { // WPCS: CSRF ok.
			$url = add_query_arg( $args, $url );

			wp_safe_redirect( $url );

			exit;
		}
	}

	/**
	 * Query vars.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
	 * @param array $query_vars
	 * @return array
	 */
	public function query_vars( $query_vars ) {
		$query_vars[] = 'c';

		return $query_vars;
	}

	/**
	 * Pre get posts.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
	 * @see https://codex.wordpress.org/Class_Reference/WP_Query
	 * @param WP_Query $query
	 */
	public function pre_get_posts( $query ) {
		$c = $query->get( 'c' );

		if ( '' === $c ) {
			return;
		}

		$slugs = explode( ',', $c );

		$tax_query = $query->get( 'tax_query' );
		$tax_query = is_array( $tax_query ) ? $tax_query : array();

		$tax_query[] = array(
			'taxonomy' => 'orbis_person_category',
			'field'    => 'slug',
			'terms'    => $slugs,
		);

		$query->set( 'tax_query', $tax_query );
	}

	/**
	 * Navigation markup template.
	 *
	 * @see https://getbootstrap.com/docs/4.0/components/pagination/
	 * @see https://github.com/WordPress/WordPress/blob/4.8/wp-includes/link-template.php#L2567-L2610
	 * @see https://codex.wordpress.org/Function_Reference/the_posts_pagination
	 * @see https://codex.wordpress.org/Function_Reference/get_the_posts_pagination
	 */
	public function navigation_markup_template( $template, $class ) {
		return '<nav aria-label="%2$s">%3$s</nav>';
	}
}
