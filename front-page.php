<?php get_header(); ?>

<?php if ( is_active_sidebar( 'frontpage-top-widget' ) ) : ?>

	<div class="row">
		<?php dynamic_sidebar( 'frontpage-top-widget' ); ?>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-left-widget' ) || is_active_sidebar( 'frontpage-right-widget' ) ) : ?>

	<div class="row">
		<div class="col-md-6">
			<?php dynamic_sidebar( 'frontpage-left-widget' ); ?>
		</div>

		<div class="col-md-6">
			<?php dynamic_sidebar( 'frontpage-right-widget' ); ?>
		</div>
	</div>

<?php endif; ?>

<?php if ( is_active_sidebar( 'frontpage-bottom-widget' ) ) : ?>

	<div class="row">
		<?php dynamic_sidebar( 'frontpage-bottom-widget' ); ?>
	</div>

<?php else : ?>

	<div class="row">
		<?php

		if ( post_type_exists( 'orbis_company' ) ) {
			the_widget(
				'Orbis_List_Posts_Widget',
				array(
					'post_type_name' => 'orbis_company',
					'number'         => 8,
					'title'          => __( 'Companies', 'orbis' ),
				),
				array(
					'before_widget' => '<div class="col-md-4"><div class="card"><div class="card-body">',
					'after_widget'  => '</div></div></div>',
					'before_title'  => '<h3 class="card-title">',
					'after_title'   => '</h3>',
				)
			);
		}

		if ( post_type_exists( 'orbis_project' ) ) {
			the_widget(
				'Orbis_List_Posts_Widget',
				array(
					'post_type_name' => 'orbis_project',
					'number'         => 8,
					'title'          => __( 'Projects', 'orbis' ),
				), array(
					'before_widget' => '<div class="col-md-4"><div class="card"><div class="card-body">',
					'after_widget'  => '</div></div></div>',
					'before_title'  => '<h3 class="card-title">',
					'after_title'   => '</h3>',
				)
			);
		}

		if ( post_type_exists( 'orbis_person' ) ) {
			the_widget(
				'Orbis_List_Posts_Widget',
				array(
					'post_type_name' => 'orbis_person',
					'number'         => 8,
					'title'          => __( 'Persons', 'orbis' ),
				), array(
					'before_widget' => '<div class="col-md-4"><div class="card"><div class="card-body">',
					'after_widget'  => '</div></div></div>',
					'before_title'  => '<h3 class="card-title">',
					'after_title'   => '</h3>',
				)
			);
		}

		?>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
