<?php

$project_sections = apply_filters( 'orbis_project_sections', array() );

$tab = get_query_var( 'tabs', 'timesheet' );

if ( ! empty( $project_sections ) ) : ?>

	<div class="card my-3 with-cols clearfix">
		<header class="with-tabs">
			<ul class="nav nav-tabs">

				<?php foreach ( $project_sections as $section ) : ?>
					<?php $active = ( $section['id'] === $tab ); ?>

					<li class="">
						<a href="<?php echo esc_url( get_permalink() . 'tabs/' . $section['id'] ); ?>" class="nav-link <?php echo esc_attr( $active ? 'active' : '' ); ?>" ><?php echo esc_html( $section['name'] ); ?></a>
					</li>

					<?php $active = false; ?>

				<?php endforeach; ?>
			</ul>
		</header>

		<div class="tab-content">
			<?php $active = true; ?>

			<?php
			foreach ( $project_sections as $section ) {
				if ( $section['id'] === $tab ) {
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
