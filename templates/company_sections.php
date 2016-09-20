<?php

$sections = apply_filters( 'orbis_company_sections', array() );

if ( ! empty( $sections ) ) : ?>

	<div class="panel with-cols clearfix">
		<header class="with-tabs">
			<ul id="tabs" class="nav nav-tabs">
				<?php $active = true; ?>

				<?php foreach ( $sections as $section ) : ?>

					<li class="<?php echo esc_attr( $active ? 'active' : '' ); ?>">
						<a href="#<?php echo esc_attr( $section['id'] ); ?>"><?php echo esc_html( $section['name'] ); ?></a>
					</li>

					<?php $active = false; ?>

				<?php endforeach; ?>
			</ul>
		</header>

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
