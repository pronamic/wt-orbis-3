<!DOCTYPE html>

<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php // @codingStandardsIgnoreStart ?>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		<?php 
		// @codingStandardsIgnoreEnd
		// Ignoring WordPress.WP.EnqueuedResources.NonEnqueuedScript: only loading script when IE9 is used.
		?>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div class="page-wrapper">
			<div class="sidebar-wrapper">
				<div class="site-title">
					<a href="<?php echo esc_attr( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
						<?php if ( get_theme_mod( 'orbis_logo' ) ) : ?>

							<img src="<?php echo esc_url( get_theme_mod( 'orbis_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />

						<?php else : ?>

							<?php bloginfo( 'name' ); ?>

						<?php endif; ?>
					</a>
				</div>

				<div class="primary-nav" role="navigation">
					<h3><?php esc_html_e( 'Menu', 'orbis' ); ?></h3>

					<?php

					wp_nav_menu( array(
						'container'      => false,
						'theme_location' => 'primary',
						'depth'          => 2,
						'fallback_cb'    => '',
					) );

					?>

					<span class="orbis-toggle-nav text-light mt-2"><span class="nav-label"><?php esc_html_e( 'Collapse menu', 'orbis' ); ?></span></span>
				</div>
			</div>

			<div class="main-wrapper">
				<div class="page-header d-flex justify-content-between">
					<div>
						<h1 class="orbis-page-title">
							<?php echo esc_html( orbis_get_title() ); ?>
						</h1>

						<?php get_template_part( 'templates/breadcrumbs' ); ?>
					</div>

					<?php if ( is_user_logged_in() ) : ?>

						<?php $current_user = wp_get_current_user(); ?>

						<ul class="nav nav-inline pull-right">
							<li class="nav-item dropdown mr-3">
								<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo get_avatar( $current_user->ID, 24 ); ?> <?php echo esc_html( $current_user->display_name ); ?> <b class="caret"></b></a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li class="dropdown-item">
										<a href="http://orbiswp.com/help/"><i class="fa fa-question-circle"></i> <?php esc_html_e( 'Help', 'orbis' ); ?></a>
									</li>
									<li class="dropdown-item">
										<a href="<?php echo esc_attr( admin_url( 'profile.php' ) ); ?>"><i class="fa fa-user"></i> <?php esc_html_e( 'Edit profile', 'orbis' ); ?></a>
									</li>
									<li class="dropdown-divider"></li>
									<li class="dropdown-item">
										<a href="<?php echo esc_attr( wp_logout_url() ); ?>"><i class="fa fa-power-off"></i> <?php esc_html_e( 'Log out', 'orbis' ); ?></a>
										</li>
								</ul>
							</li>

							<li class="nav-item dropdown mr-3">
								<a data-toggle="dropdown" class="dropdown-toggle search-btn" href="#"><i class="fa fa-search"></i></a>

								<div class="dropdown-menu dropdown-menu-right">
									<form method="get" class="navbar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
										<div class="form-group">
											<input type="search" name="s" class="form-control search-input" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>">
										</div>
									</form>
								</div>
							</li>
						</ul>

					<?php endif; ?>
				</div>

				<div class="main-content">

					<?php if ( is_post_type_archive() || is_home() ) : ?>

						<?php get_template_part( 'templates/add-new-post' ); ?>

					<?php endif; ?>
