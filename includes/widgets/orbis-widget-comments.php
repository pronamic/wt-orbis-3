<?php

/**
 * List comments widget
 */
class Orbis_Comments_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'orbis-comments', __( 'Orbis - Comments', 'orbis' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$number = isset( $instance['number'] ) ? $instance['number'] : null;
		$title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget; // WPCS: XSS ok.

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}

		$comments = get_comments( array(
			'number' => $number,
		) );

		?>

		<div class="card-body">
			<?php if ( $comments ) : ?>

				<ul class="no-disc comments">
					<?php foreach ( $comments as $comment ) : ?>

						<?php

						$comment_meta = get_comment_meta( $comment->comment_ID );

						if ( array_key_exists( 'orbis_keychain_password_request', $comment_meta ) ) {
							$label = __( 'Keychain', 'orbis' );
							$class = 'label-info';
						} elseif ( array_key_exists( 'orbis_subscription_extend_request', $comment_meta ) ) {
							$label = __( 'Subscription', 'orbis' );
							$class = 'label-success';
						} else {
							$label = __( 'Comment', 'orbis' );
							$class = 'label-default';
						}

						?>

						<li>
							<div class="comment-label">
								<span class="label <?php echo esc_attr( $class ); ?>"><?php echo esc_html( $label ); ?></span> 
							</div>

							<div class="comment-content">
								<a href="<?php echo esc_attr( get_comments_link( $comment->comment_post_ID ) ); ?>"><?php echo esc_html( get_the_title( $comment->comment_post_ID ) ); ?></a> <?php echo esc_html( orbis_custom_excerpt( $comment->comment_content ) ); ?>

								<span class="entry-meta">
									<?php

									printf(
										esc_html__( 'Posted by %1$s on %2$s', 'orbis' ),
										esc_html( $comment->comment_author ),
										esc_html( get_comment_date( 'H:i', $comment->comment_ID ) )
									);

									?>
								</span>
							</div>
						</li>

					<?php endforeach; ?>
				</ul>

			<?php endif; ?>
		</div>

		<?php

		wp_reset_postdata();

		echo $after_widget; // WPCS: XSS ok.
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']  = $new_instance['title'];
		$instance['number'] = $new_instance['number'];

		return $instance;
	}

	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? intval( $instance['number'] ) : '';

		$i = 1;

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number:', 'orbis' ); ?></label>

			<select id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>">
				<?php while ( $i <= 10 ) : ?>

					<option value="<?php echo esc_attr( $i ); ?>"<?php selected( $number === $i ); ?>><?php echo esc_html( $i ); ?></option>

					<?php $i++; ?>

				<?php endwhile; ?>
			</select>
		</p>

		<?php
	}
}
