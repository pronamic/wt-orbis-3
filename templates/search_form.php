<?php

$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );

$has_advanced = is_post_type_archive( 'orbis_person' ) || is_post_type_archive( 'orbis_project' );

$action_url = '';

if ( is_post_type_archive() ) {
	$action_url = orbis_get_post_type_archive_link();
}

?>
<div class="well">
	<form class="form-inline" method="get" action="<?php echo esc_attr( $action_url ); ?>">
		<div class="form-search">
			<div class="form-group">
				<label for="orbis_search_query" class="sr-only"><?php esc_html_e( 'Search', 'orbis' ); ?></label>
				<input id="orbis_search_query" type="search" class="form-control" name="s" placeholder="<?php esc_attr_e( 'Search', 'orbis' ); ?>" value="<?php echo esc_attr( $s ); ?>" />
			</div>

			<button type="submit" class="btn btn-default"><?php esc_html_e( 'Search', 'orbis' ); ?></button> 

			<?php if ( is_post_type_archive( 'orbis_person' ) ) : ?>

				<div class="form-group">
					<?php

					wp_dropdown_categories( array(
						'show_option_all' => __( 'All Categories', 'orbis' ),
						'name'            => 'orbis_person_category',
						'class'           => 'form-control',
						'selected'        => filter_input( INPUT_GET, 'orbis_person_category', FILTER_SANITIZE_STRING ),
						'taxonomy'        => 'orbis_person_category',
						'value_field'     => 'slug',
					) );

					?>
				</div>

				<button type="submit" class="btn btn-default"><?php esc_html_e( 'Filter', 'orbis' ); ?></button>

			<?php endif; ?>

			<?php if ( $has_advanced ) : ?>

				<small><a href="#" class="advanced-search-link" data-toggle="collapse" data-target="#advanced-search"><?php esc_html_e( 'Advanced Search', 'orbis' ); ?></a></small>

			<?php endif; ?>

			<?php if ( is_post_type_archive( 'orbis_person' ) ) : ?>

				<div class="float-sm-right">

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
