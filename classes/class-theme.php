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
}
