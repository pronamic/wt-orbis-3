<?php

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Twitter widget
 */
class Orbis_Twitter_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'orbis_twitter', __( 'Orbis - Twitter', 'orbis' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title       = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$number      = isset( $instance['number'] ) ? $instance['number'] : null;
		$screen_name = isset( $instance['screen_name'] ) ? $instance['screen_name'] : null;

		echo $before_widget; // WPCS: XSS ok.

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}

		$consumer_key        = get_option( 'orbis_twitter_consumer_key' );
		$consumer_secret     = get_option( 'orbis_twitter_consumer_secret' );
		$access_token        = get_option( 'orbis_twitter_access_token' );
		$access_token_secret = get_option( 'orbis_twitter_access_token_secret' );

		$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );

		$tweets = $connection->get( 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $screen_name . '&count=' . $number );

		if ( $tweets && empty( $tweets->errors ) ) : ?>

			<ul class="post-list">
				<?php foreach ( $tweets as $tweet ) : ?>

					<li>
						<?php echo esc_html( $tweet->text ); ?>
					</li>

				<?php endforeach; ?>
			</ul>

		<?php
		endif;

		echo $after_widget; // WPCS: XSS ok.
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']       = $new_instance['title'];
		$instance['screen_name'] = $new_instance['screen_name'];
		$instance['number']      = $new_instance['number'];

		return $instance;
	}

	public function form( $instance ) {
		$title       = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number      = isset( $instance['number'] ) ? intval( $instance['number'] ) : '';
		$screen_name = isset( $instance['screen_name'] ) ? esc_attr( $instance['screen_name'] ) : '';

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'screen_name' ) ); ?>">
				<?php esc_html_e( 'User:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'screen_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'screen_name' ) ); ?>" type="text" value="<?php echo esc_attr( $screen_name ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number:', 'orbis' ); ?></label>

			<select id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>">
				<?php $i = 1; ?>

				<?php while ( $i <= 10 ) : ?>

					<option value="<?php echo esc_attr( $i ); ?>"<?php selected( $number === $i ); ?>><?php echo esc_html( $i ); ?></option>

					<?php $i++; ?>

				<?php endwhile; ?>
			</select>
		</p>

		<?php
	}
}
