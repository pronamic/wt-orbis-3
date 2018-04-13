<?php

/**
 * List posts widget
 */
class Orbis_List_Posts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'orbis-list-posts', __( 'Orbis - Posts List', 'orbis' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title          = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$number         = isset( $instance['number'] ) ? $instance['number'] : null;
		$post_type_name = isset( $instance['post_type_name'] ) ? $instance['post_type_name'] : null;

		echo $before_widget; // WPCS: XSS ok.

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title; // WPCS: XSS ok.
		}

		$query = new WP_Query( array(
			'post_type'      => $post_type_name,
			'posts_per_page' => $number,
			'no_found_rows'  => true,
		) );

		if ( $query->have_posts() ) : ?>

			<?php if ( 'orbis_person' === $post_type_name ) : ?>

				<ul class="post-list">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
					?>

						<li>
							<a href="<?php the_permalink(); ?>" class="post-image">
								<?php if ( has_post_thumbnail() ) : ?>

									<?php the_post_thumbnail( 'avatar', array( 'class' => 'avatar' ) ); ?>

								<?php else : ?>

									<img class="avatar" src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">

								<?php endif; ?>
							</a>

							<div class="post-content">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <br />

								<p>
									<?php if ( get_post_meta( get_the_ID(), '_orbis_person_email_address', true ) ) : ?>

										<span class="entry-meta"><?php echo esc_html( get_post_meta( get_the_ID(), '_orbis_person_email_address', true ) ); ?></span> <br />

									<?php endif; ?>

									<?php if ( get_post_meta( get_the_ID(), '_orbis_person_phone_number', true ) ) : ?>

										<span class="entry-meta"><?php echo esc_html( get_post_meta( get_the_ID(), '_orbis_person_phone_number', true ) ); ?></span>

									<?php endif; ?>
								</p>
							</div>
						</li>

					<?php endwhile; ?>
				</ul>

			<?php else : ?>

				<ul class="list-group list-group-flush">
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
					?>

						<li class="list-group-item">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>

					<?php endwhile; ?>
				</ul>

			<?php endif; ?>

			<div class="card-body">
				<a href="<?php echo esc_attr( get_post_type_archive_link( $post_type_name ) ); ?>"><?php esc_html_e( 'Show all', 'orbis' ); ?></a>
			</div>

		<?php wp_reset_postdata(); else : ?>

			<div class="content">
				<p class="alt">
					<?php

					$post_type_object = get_post_type_object( $post_type_name );

					printf( // WPCS: XSS ok.
						__( 'No %3$s found. <a href="%1$s">Add your first %2$s</a>.', 'orbis' ),
						esc_url( add_query_arg( 'post_type', $post_type_name, admin_url( 'post-new.php' ) ) ),
						esc_html( strtolower( $post_type_object->labels->singular_name ) ),
						esc_html( strtolower( $post_type_object->labels->name ) )
					);

					?>
				</p>
			</div>

		<?php endif; ?>

		<?php

		echo $after_widget; // WPCS: XSS ok.
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']          = $new_instance['title'];
		$instance['post_type_name'] = $new_instance['post_type_name'];
		$instance['number']         = $new_instance['number'];

		return $instance;
	}

	public function form( $instance ) {
		$title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number         = isset( $instance['number'] ) ? intval( $instance['number'] ) : '';
		$post_type_name = isset( $instance['post_type_name'] ) ? esc_attr( $instance['post_type_name'] ) : '';

		$i = 1;

		$post_types = get_post_types( array( 'public' => true ), 'object' );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'orbis' ); ?>
			</label>

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_type_name' ) ); ?>">
				<?php esc_html_e( 'Post type:', 'orbis' ); ?>
			</label>

			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type_name' ) ); ?>">
				<option value=""></option>

				<?php foreach ( $post_types as $post_type ) : ?>

					<option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $post_type->name === $post_type_name ); ?>>
						<?php echo esc_html( $post_type->label ); ?>
					</option>

				<?php endforeach; ?>
			</select>
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
