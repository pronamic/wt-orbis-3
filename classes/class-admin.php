<?php

/**
 * Admin
 */
class Orbis_Theme_Admin {
	/**
	 * Construct
	 */
	public function __construct() {
		// Filters
		add_filter( 'mce_buttons_2', array( $this, 'mce_buttons_2' ) );

		add_filter( 'tiny_mce_before_init', array( $this, 'tiny_mce_before_init' ) );
	}

	/**
	 * Add extra styles to the TinyMCE editor
	 */
	public function mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}

	/**
	 * TinyMCE before init
	 */
	public function tiny_mce_before_init( $settings ) {
		$settings['style_formats_merge'] = false;
		$settings['style_formats']       = wp_json_encode( $this->get_tiny_mce_style_formats() );

		return $settings;
	}

	/**
	 * Get TinyMCE style format
	 */
	private function get_tiny_mce_style_formats() {
		return array(
			// @see http://v4-alpha.getbootstrap.com/components/buttons/
			array(
				'title' => __( 'Buttons', 'orbis' ),
				'items' => array(
					array(
						'title'    => __( 'Default', 'orbis' ),
						'selector' => 'a',
						'classes'  => 'btn',
					),
					array(
						'title'    => __( 'Primary', 'orbis' ),
						'selector' => '.btn',
						'classes'  => 'btn-primary',
					),
					array(
						'title'    => __( 'Success', 'orbis' ),
						'selector' => '.btn',
						'classes'  => 'btn-success',
					),
					array(
						'title'    => __( 'Info', 'orbis' ),
						'selector' => '.btn',
						'classes'  => 'btn-info',
					),
					array(
						'title'    => __( 'Warning', 'orbis' ),
						'selector' => '.btn',
						'classes'  => 'btn-warning',
					),
					array(
						'title'    => __( 'Danger', 'orbis' ),
						'selector' => '.btn',
						'classes'  => 'btn-danger',
					),
					array(
						'title'    => __( 'Link', 'orbis' ),
						'selector' => '.btn',
						'classes'  => 'btn-link',
					),
				),
			),
			// @see http://v4-alpha.getbootstrap.com/content/tables/
			array(
				'title' => __( 'Tables', 'orbis' ),
				'items' => array(
					array(
						'title'    => __( 'Default', 'orbis' ),
						'selector' => 'table',
						'classes'  => 'table',
					),
					array(
						'title'    => __( 'Inverse', 'orbis' ),
						'selector' => '.table',
						'classes'  => 'table-inverse',
					),
					array(
						'title'    => __( 'Striped Rows', 'orbis' ),
						'selector' => '.table',
						'classes'  => 'table-striped',
					),
					array(
						'title'    => __( 'Bordered Table', 'orbis' ),
						'selector' => '.table',
						'classes'  => 'table-bordered',
					),
					array(
						'title'    => __( 'Hover Rows', 'orbis' ),
						'selector' => '.table',
						'classes'  => 'table-hover',
					),
					array(
						'title'    => __( 'Small Table', 'orbis' ),
						'selector' => '.table',
						'classes'  => 'table-sm',
					),
				),
			),
			// @see http://v4-alpha.getbootstrap.com/content/typography/#blockquotes
			array(
				'title' => __( 'Blockquotes', 'orbis' ),
				'items' => array(
					array(
						'title'    => __( 'Default', 'orbis' ),
						'selector' => 'blockquote',
						'classes'  => 'blockquote',
					),
					array(
						'title'    => __( 'Reverse Layout', 'orbis' ),
						'selector' => '.blockquote',
						'classes'  => 'blockquote-reverse',
					),
				),
			),
		);
	}
}
