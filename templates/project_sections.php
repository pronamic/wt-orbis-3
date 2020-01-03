<?php

$project_sections = apply_filters( 'orbis_project_sections', array() );

$tab = get_query_var( 'tabs', __( 'timesheet', 'orbis' ) );

if ( ! empty( $project_sections ) ) : ?>

	<div class="card mb-3 with-cols clearfix">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs" id="project-tabs">

				<?php foreach ( $project_sections as $section ) : ?>
					<?php $active = ( $section['slug'] === $tab ); ?>

					<li class="nav-item">
						<a href="<?php echo esc_url( get_permalink() . 'tabs/' . $section['slug'] ); ?>" class="nav-link <?php echo esc_attr( $active ? 'active' : '' ); ?>" ><?php echo esc_html( $section['name'] ); ?></a>
					</li>

					<?php $active = false; ?>

				<?php endforeach; ?>
			</ul>
		</div>

		<div class="tab-content">
			<?php $active = true; ?>

			<?php
			foreach ( $project_sections as $section ) {
				if ( $section['slug'] === $tab ) {
					break;
				}
			}
			?>

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
		</div>
	</div>

<?php endif; ?>
