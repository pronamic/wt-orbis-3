<?php

/**
 * Scripts
 */
class Orbis_Theme_Scripts {
	/**
	 * Construct
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Register
	 */
	public function register() {
		$uri = get_template_directory_uri();

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Tether - http://tether.io/
		wp_register_script(
			'tether',
			$uri . '/assets/tether/js/tether' . $min . '.js',
			array(),
			'1.4.0',
			true
		);

		wp_register_style(
			'tether',
			$uri . '/assets/tether/css/tether' . $min . '.css',
			array(),
			'1.4.0'
		);

		// Popper.js - https://popper.js.org/
		wp_register_script(
			'popper',
			$uri . '/assets/popper/popper' . $min . '.js',
			array(),
			'1.12.5',
			true
		);

		// Bootstrap
		wp_register_script(
			'bootstrap',
			$uri . '/assets/bootstrap/js/bootstrap' . $min . '.js',
			array( 'jquery', 'popper' ),
			'4.0.0-beta',
			true
		);

		wp_register_style(
			'bootstrap',
			$uri . '/assets/bootstrap/css/bootstrap' . $min . '.css',
			array(),
			'4.0.0-beta'
		);

		// Select2
		wp_register_style(
			'select2-bootstrap',
			$uri . '/assets/select2-bootstrap/select2-bootstrap' . $min . '.css',
			array(
				'select2',
				'bootstrap',
			),
			'0.1.0-beta.10'
		);

		// Font Awesome - http://fortawesome.github.io/Font-Awesome/
		wp_register_style(
			'fontawesome',
			$uri . '/assets/fontawesome/css/font-awesome' . $min . '.css',
			array(),
			'4.6.3'
		);

		// Orbis
		wp_register_script(
			'wt-orbis',
			$uri . '/assets/orbis/js/script' . $min . '.js',
			array(
				'jquery',
				'bootstrap',
				'tether',
			),
			'3.0.0',
			true
		);

		wp_localize_script(
			'wt-orbis',
			'orbis_timesheets_vars',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);

		wp_register_style(
			'wt-orbis',
			$uri . '/css/style' . $min . '.css',
			array(
				'bootstrap',
				'fontawesome',
			),
			'3.0.0'
		);
	}

	/**
	 * Enqueue
	 */
	public function enqueue() {
		// Theme
		wp_enqueue_script( 'wt-orbis' );
		wp_enqueue_style( 'wt-orbis' );

		// Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
