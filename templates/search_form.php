<?php

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );

$has_advanced = is_post_type_archive( 'orbis_person' ) || is_post_type_archive( 'orbis_project' );

$action_url = '';

if ( is_post_type_archive() ) {
	$action_url = orbis_get_post_type_archive_link();
}

$search_term = ( isset( $_GET['s'] ) ) ? $_GET['s'] : '';

$sorting_terms = Array(
	'author'   => esc_html__( 'Author', 'orbis' ),
	'date'     => esc_html__( 'Date', 'orbis' ),
	'modified' => esc_html__( 'Modified', 'orbis' ),
	'title'    => esc_html__( 'Title', 'orbis' ),
);

$sorting_keys = array_keys( $sorting_terms );

switch ( get_query_var( 'post_type' ) ) {
	case 'orbis_subscription':
		$specific_sorting = Array(
			'active_subscriptions' => esc_html__( 'Active Subscriptions', 'orbis' ),
		);
		$specific_sorting_keys = array_keys( $specific_sorting );
		break;
	
	case 'orbis_project':
		$specific_sorting = Array(
			'project_finished_modified'       => esc_html__( 'Modified and Finished', 'orbis' ),
			'project_invoice_number'          => esc_html__( 'Invoice Number', 'orbis' ),
			'project_invoice_number_modified' => esc_html__( 'Invoice Number Modified', 'orbis' ),
		);
		$specific_sorting_keys = array_keys( $specific_sorting );
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

						wp_enqueue_script( 'select2' );
						wp_enqueue_style( 'select2' );
						wp_enqueue_style( 'select2-bootstrap4' );

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
						<script type="text/javascript">
							jQuery( document ).ready( function( $ ) {
								$( '.select2' ).select2( {
									theme: 'bootstrap4',
								});
							} );
						</script>

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

			<div class="dropdown show">
				<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php esc_html_e( 'Sort by...', 'orbis' ); ?>
				</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

					<?php $num = 0; ?>
					<?php foreach ( $sorting_terms as $sort ) : ?>
						<?php $order = orbis_invert_sort_order( $sorting_keys[$num] ); ?>
						<a class="dropdown-item clearfix <?php orbis_is_active( $sorting_keys[$num] ) ?>" href="?orderby=<?php echo $sorting_keys[$num] ?>&order=<?php echo $order ?>">
							<?php echo $sort ?>
							<?php orbis_sorting_icon( $order, $sorting_keys[$num] ); ?>
						</a>
					<?php
						$num++;
						endforeach;
					?>

					<?php $num = 0; ?>
					<?php if ( isset( $specific_sorting ) ) : ?>
						<div class="dropdown-divider"></div>
						<?php foreach ( $specific_sorting as $sort ) : ?>
							<?php $order = orbis_invert_sort_order( $specific_sorting_keys[$num] ); ?>
							<a class="dropdown-item clearfix <?php orbis_is_active( $specific_sorting_keys[$num] ) ?>" href="?orderby=<?php echo $specific_sorting_keys[$num] ?>&order=<?php echo $order ?>">
								<?php echo $sort ?>
								<?php orbis_sorting_icon( $order, $specific_sorting_keys[$num] ); ?>
							</a>
						<?php
							$num++;
							endforeach;
						?>
					<?php endif; ?>

				</div>
			</div>

			<?php if ( is_post_type_archive( 'orbis_person' ) ) : ?>

				<div>

					<?php

					$csv_url = add_query_arg( $_GET, get_post_type_archive_link( 'orbis_person' ) . 'csv' );
					$xls_url = add_query_arg( $_GET, get_post_type_archive_link( 'orbis_person' ) . 'xls' );

					?>
					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php esc_html_e( 'Download', 'orbis' ); ?></button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="<?php echo esc_url( $xls_url ); ?>" target="_blank"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <?php esc_html_e( 'Excel', 'orbis' ); ?></a>
							<a class="dropdown-item" href="<?php echo esc_url( $csv_url ); ?>" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> <?php esc_html_e( 'CSV', 'orbis' ); ?></a>
						</div>
					</div>
				</div>

			<?php endif; ?>

			<?php // get_template_part( 'templates/filter', get_query_var( 'post_type' ) ); ?>
		</div>

		<?php get_template_part( 'templates/filter_advanced', get_query_var( 'post_type' ) ); ?>
	</form>
</div>
