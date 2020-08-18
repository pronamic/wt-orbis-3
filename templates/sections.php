<?php

$sections = array();

$content = get_the_content();

$content = apply_filters( 'the_content', $content );

if ( has_post_thumbnail() || ! empty( $content ) ) :

	$sections[] = array(
		'id'            => 'description',
		'name'          => __( 'Description', 'orbis' ),
		'template_part' => 'templates/section-description',
	);

endif;

$sections = apply_filters( get_post_type() . '_sections', $sections );

if ( ! empty( $sections ) ) : ?>

	<div class="card mb-3 with-cols clearfix">

		<?php if ( count( $sections ) > 1 ) : ?>

			<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs" id="company-tabs">
					<?php $active = true; ?>

					<?php foreach ( $sections as $section ) : ?>

						<li class="nav-item">
							<a href="#<?php echo esc_attr( $section['id'] ); ?>" class="nav-link <?php echo esc_attr( $active ? 'active' : '' ); ?>" data-toggle="tab"><?php echo esc_html( $section['name'] ); ?></a>
						</li>

						<?php $active = false; ?>

					<?php endforeach; ?>
				</ul>
			</div>

			<div class="tab-content">
				<?php $active = true; ?>

				<?php foreach ( $sections as $section ) : ?>

					<div id="<?php echo esc_attr( $section['id'] ); ?>" class="tab-pane <?php echo esc_attr( $active ? 'active' : '' ); ?>">
						<?php

						if ( isset( $section['action'] ) ) {
							do_action( $section['action'] );
						}

						if ( isset( $section['callback'] ) ) {
							call_user_func( $section['callback'] );
						}

						if ( isset( $section['template_part'] ) ) {
							get_template_part( $section['template_part'] );
						}

						?>
					</div>

					<?php $active = false; ?>

				<?php endforeach; ?>
			</div>

		<?php else: ?>

			<?php foreach ( $sections as $section ) : ?>

				<div class="card-header">

					<?php echo esc_html( $section['name'] ); ?>

				</div>

				<?php

				if ( isset( $section['action'] ) ) {
					do_action( $section['action'] );
				}

				if ( isset( $section['callback'] ) ) {
					call_user_func( $section['callback'] );
				}

				if ( isset( $section['template_part'] ) ) {
					get_template_part( $section['template_part'] );
				}

				?>

			<?php endforeach; ?>

		<?php endif; ?>

	</div>

<?php endif; ?>
