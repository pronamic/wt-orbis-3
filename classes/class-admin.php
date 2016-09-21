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
			array(
				'title'	=> __( 'General', 'ase' ),
				'items'	=> array(
					array(
						'title'    => __( 'H1 Style', 'ase' ),
						'selector' => 'p',
						'classes'  => 'h1',
					),
					array(
						'title'    => __( 'H2 Style', 'ase' ),
						'selector' => 'p',
						'classes'  => 'h2',
					), array(
						'title'    => __( 'H3 Style', 'ase' ),
						'selector' => 'p',
						'classes'  => 'h3',
					), array(
						'title'    => __( 'H4 Style', 'ase' ),
						'selector' => 'p',
						'classes'  => 'h4',
					), array(
						'title'    => __( 'H5 Style', 'ase' ),
						'selector' => 'p',
						'classes'  => 'h5',
					), array(
						'title'    => __( 'H6 Style', 'ase' ),
						'selector' => 'p',
						'classes'  => 'h6',
					),
					array(
						'title'    => __( 'Lead Text', 'ase' ),
						'selector' => 'p',
						'classes'  => 'lead',
					),
					array(
						'title'    => __( 'Alt Text', 'ase' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6',
						'classes'  => 'alt',
					),
					array(
						'title'    => __( 'Quiet Text', 'ase' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6',
						'classes'  => 'quiet',
					),
				),
			),
			array(
				'title'	=> __( 'Buttons', 'ase' ),
				'items'	=> array(
					array(
						'title'    => __( 'Button', 'ase' ),
						'selector' => 'a',
						'classes'  => 'btn',
					),
					array(
						'title'    => __( 'Button default', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'btn-default',
					),
					array(
						'title'    => __( 'Button primary', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'btn-primary',
					),
					array(
						'title'    => __( 'Button inversed', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'pt-btn-inversed',
					),
					array(
						'title'    => __( 'Button large', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'btn-lg',
					),
					array(
						'title'    => __( 'Button small', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'btn-sm',
					),
					array(
						'title'    => __( 'Button block', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'btn-block',
					),
					array(
						'title'    => __( 'Button with arrow', 'ase' ),
						'selector' => 'a.btn',
						'classes'  => 'pt-btn-with-arrow',
					),
				),
			),
			array(
				'title'	=> __( 'Lists', 'ase' ),
				'items'	=> array(
					array(
						'title'    => __( 'List', 'ase' ),
						'selector' => 'ul',
						'classes'  => 'list',
					),
					array(
						'title'    => __( 'Checklist', 'ase' ),
						'selector' => 'ul.list',
						'classes'  => 'list-benefits',
					),
					array(
						'title'    => __( 'Links', 'ase' ),
						'selector' => 'ul.list',
						'classes'  => 'list-links',
					),
				),
			),
			array(
				'title'	=> __( 'Images', 'ase' ),
				'items'	=> array(
					array(
						'title'    => __( 'Featured image', 'ase' ),
						'block'    => 'figure',
						'classes'  => 'pt-image',
					),
				),
			),
			array(
				'title'	=> __( 'Visibility', 'ase' ),
				'items'	=> array(
					array(
						'title'    => __( 'Hide on extra small devices', 'ase' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, img',
						'classes'  => 'hidden-xs',
					),
					array(
						'title'    => __( 'Hide on small devices', 'ase' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, img',
						'classes'  => 'hidden-sm',
					),
					array(
						'title'    => __( 'Hide on medium devices', 'ase' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, img',
						'classes'  => 'hidden-md',
					),
					array(
						'title'    => __( 'Hide on large devices', 'ase' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, img',
						'classes'  => 'hidden-lg',
					),
				),
			),
		);
	}
}
