<?php

/**
 * Stats widget
 */
class Orbis_Stats_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'orbis-stats', __( 'Orbis - Stats', 'orbis' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget; // WPCS: XSS ok.

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}

		?>

		<div class="content stats">
			<div class="row">
				<div class="col-md-3">
					<?php $count_posts = wp_count_posts(); ?>

					<span class="entry-meta"><?php esc_html_e( 'Posts', 'orbis' ); ?></span> <p class="important"><?php echo esc_html( $count_posts->publish ); ?></p>
				</div>

				<div class="col-md-3">
					<?php $count_posts = wp_count_posts( 'orbis_company' ); ?>

					<span class="entry-meta"><?php esc_html_e( 'Companies', 'orbis' ); ?></span> <p class="important"><?php echo esc_html( $count_posts->publish ); ?></p>
				</div>

				<div class="col-md-3">
					<?php $count_posts = wp_count_posts( 'orbis_project' ); ?>

					<span class="entry-meta"><?php esc_html_e( 'Projects', 'orbis' ); ?></span> <p class="important"><?php echo esc_html( $count_posts->publish ); ?></p>
				</div>

				<div class="col-md-3">
					<?php $count_posts = wp_count_posts( 'orbis_person' ); ?>

					<span class="entry-meta"><?php esc_html_e( 'Persons', 'orbis' ); ?></span> <p class="important"><?php echo esc_html( $count_posts->publish ); ?></p>
				</div>
			</div>
		</div>

		<?php

		echo $after_widget; // WPCS: XSS ok.
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		return $instance;
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php
	}
}
