<?php

$sections = apply_filters( 'orbis_company_sections', array() );

if ( ! empty( $sections ) ) : ?>

	<div class="card mb-3 with-cols clearfix">
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
	</div>

<?php endif; ?>
