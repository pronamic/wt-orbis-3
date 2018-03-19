<?php

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );

$has_advanced = is_post_type_archive( 'orbis_person' ) || is_post_type_archive( 'orbis_project' );

$action_url = '';

if ( is_post_type_archive() ) {
	$action_url = orbis_get_post_type_archive_link();
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
				
				<div class="input-group float-right">
					<select class="custom-select float-right" onchange="javascript:handleSelect(this)">
						<option selected><?php esc_html_e( 'Sort by...', 'orbis' ); ?></option>
						<option value="?orderby=title&order=ASC"><?php esc_html_e( 'Title: Ascending', 'orbis' ); ?></option>
						<option value="?orderby=title&order=DESC"><?php esc_html_e( 'Title: Descending', 'orbis' ); ?></option>
					</select>
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

			<?php get_template_part( 'templates/filter', get_query_var( 'post_type' ) ); ?>
		</div>

		<?php get_template_part( 'templates/filter_advanced', get_query_var( 'post_type' ) ); ?>
	</form>
</div>

<script type="text/javascript">
	function handleSelect( select ) {
		var baseUrl = window.location.href.split(/[?#]/)[0];
		window.location = baseUrl + select.value;
	}
</script>
