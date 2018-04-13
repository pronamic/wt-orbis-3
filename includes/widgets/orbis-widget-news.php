<?php

/**
 * News widget
 */
class Orbis_News_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'orbis-news', __( 'Orbis - News', 'orbis' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget; // WPCS: XSS ok.

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}

		$query = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 11,
			'no_found_rows'  => true,
		) );

		?>

		<div class="card-body">

			<?php if ( $query->have_posts() ) : ?>

				<div class="news with-cols clearfix">
					<div class="row">
						<div class="col-md-6">
							<?php
							if ( $query->have_posts() ) :
								$query->the_post();
							?>

								<div class="content">
									<?php if ( has_post_thumbnail() ) : ?>

										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'featured' ); ?>
										</a>

									<?php endif; ?>

									<h4>
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h4>

									<?php the_excerpt(); ?>
								</div>

							<?php endif; ?>
						</div>

						<div class="col-md-6">
							<div class="content">
								<h4><?php esc_html_e( 'More news', 'orbis' ); ?></h4>

								<ul class="no-disc">
									<?php
									while ( $query->have_posts() ) :
										$query->the_post();
									?>

										<li>
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</li>

									<?php endwhile; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>

			<?php endif; ?>

		</div>

		<?php

		wp_reset_postdata();

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
