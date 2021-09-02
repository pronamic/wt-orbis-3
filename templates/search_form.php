<?php

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );

$has_advanced = is_post_type_archive( 'orbis_person' ) || is_post_type_archive( 'orbis_project' );

$action_url = '';

if ( is_post_type_archive() ) {
	$action_url = orbis_get_post_type_archive_link();
}

$sorting_terms = array(
	'author'   => esc_html__( 'Author', 'orbis' ),
	'date'     => esc_html__( 'Date', 'orbis' ),
	'modified' => esc_html__( 'Modified', 'orbis' ),
	'title'    => esc_html__( 'Title', 'orbis' ),
);

/*
 * add specific sorting terms per post type here
 */
switch ( get_query_var( 'post_type' ) ) {
	case 'orbis_subscription':
		$sorting_terms[] = '-';

		$sorting_terms['active_subscriptions'] = esc_html__( 'Active Subscriptions', 'orbis' );
		break;

	case 'orbis_project':
		$sorting_terms[] = '-';

		$sorting_terms['project_finished_modified']       = esc_html__( 'Modified and Finished', 'orbis' );
		$sorting_terms['project_invoice_number']          = esc_html__( 'Invoice Number', 'orbis' );
		$sorting_terms['project_invoice_number_modified'] = esc_html__( 'Invoice Number Modified', 'orbis' );
		break;

	default:
		break;
}

?>
<div class="card-body">
	<form method="get" action="<?php echo esc_attr( $action_url ); ?>">
		<div class="d-flex justify-content-between">

			<div class="form-inline">
				<span>
					<label for="orbis_search_query" class="sr-only"><?php esc_html_e( 'Search', 'orbis' ); ?></label>

					<input id="orbis_search_query" type="search" class="form-control" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>"> <button type="submit" class="btn btn-secondary"><?php esc_html_e( 'Search', 'orbis' ); ?></button> 

					<?php if ( is_post_type_archive( 'orbis_person' ) ) : ?>

						<?php

						$slugs = filter_input( INPUT_GET, 'c', FILTER_SANITIZE_STRING );
						$slugs = explode( ',', $slugs );

						$terms = get_terms( array(
							'taxonomy' => 'orbis_person_category',
						) );

						printf(
							'<select name="%s" class="select2" multiple="multiple" style="width: 30em;" placeholder="%s">',
							esc_attr( 'c[]' ),
							esc_attr__( 'All Categories', 'orbis' )
						);

						foreach ( $terms as $term ) {
							printf(
								'<option value="%s" %s">%s</option>',
								esc_attr( $term->term_id ),
								selected( in_array( $term->slug, $slugs, true ), true, false ),
								esc_html( $term->name )
							);
						}

						echo '</select>';

						?>

						<style type="text/css">
							.select2-choices {
								background-image: none;

								border: 1px solid rgba(0, 0, 0, 0.15);
								border-radius: 0.25rem;
							}
						</style>

						<button type="submit" class="btn btn-secondary"><?php esc_html_e( 'Filter', 'orbis' ); ?></button>

					<?php endif; ?>

					<?php if ( $has_advanced ) : ?>

						<small><a href="#" class="advanced-search-link" data-toggle="collapse" data-target="#advanced-search"><?php esc_html_e( 'Advanced Search', 'orbis' ); ?></a></small>

					<?php endif; ?>
				</span>
			</div>

			<div class="form-inline">
				<div class="dropdown show ml-1">
					<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php

						//phpcs:disable
						$orderby   = ( isset( $_GET['orderby'] ) ) ? $sorting_terms[$_GET['orderby']] : '';
						$sort_text = ( $orderby ) ? $orderby : esc_html__( 'Sort by…', 'orbis' );
						//phpcs:enable
						echo esc_html( $sort_text );

						if ( isset( $_GET['order'] ) ) {
							$order = orbis_invert_sort_order( sanitize_text_field( wp_unslash( $_GET['order'] ) ) );
							echo ' ' . wp_kses_post( orbis_sorting_icon( $order ) );
						}
						?>
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

						<?php
						foreach ( $sorting_terms as $sorting_term => $label ) {
							if ( '-' === $label ) {
								echo '<div class="dropdown-divider"></div>';

								continue;
							}

							$classes = array(
								'dropdown-item',
								'clearfix',
							);

							$orderby = ( isset( $_GET['orderby'] ) ) ? $_GET['orderby'] : ''; // phpcs:ignore
							$order   = orbis_get_sort_order( $sorting_term );

							if ( $sorting_term === $orderby ) {
								$classes[] = 'active';

								$icon = orbis_sorting_icon( $order );
							} else {
								$icon = '';
							}

							$order = orbis_invert_sort_order( $order );

							$link = add_query_arg( array(
								'orderby' => $sorting_term,
								'order'   => $order,
							) );

							echo sprintf(
								"<a class='%s' href='%s'> %s %s </a>",
								esc_attr( implode( ' ', $classes ) ),
								esc_url( $link ),
								esc_html( $label ),
								wp_kses_post( $icon )
							);
						}
						?>

					</div>
				</div>

				<?php if ( is_post_type_archive( 'orbis_person' ) ) : ?>

					<div>

						<?php

						$csv_url = add_query_arg( $_GET, get_post_type_archive_link( 'orbis_person' ) . 'csv' );
						$xls_url = add_query_arg( $_GET, get_post_type_archive_link( 'orbis_person' ) . 'xls' );

						?>
						<div class="dropdown">
							<button class="btn btn-secondary dropdown-toggle ml-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php esc_html_e( 'Download', 'orbis' ); ?></button>

							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<a class="dropdown-item" href="<?php echo esc_url( $xls_url ); ?>" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <?php esc_html_e( 'Excel', 'orbis' ); ?></a>
								<a class="dropdown-item" href="<?php echo esc_url( $csv_url ); ?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php esc_html_e( 'CSV', 'orbis' ); ?></a>
							</div>
						</div>
					</div>

				<?php endif; ?>
			</div>
			<?php get_template_part( 'templates/filter', get_query_var( 'post_type' ) ); ?>
		</div>

		<?php get_template_part( 'templates/filter_advanced', get_query_var( 'post_type' ) ); ?>
	</form>
</div>
