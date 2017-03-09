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

					$url = add_query_arg( $_GET, get_post_type_archive_link( 'orbis_person' ) . 'csv' );

					printf(
						'<a href="%s" target="_blank" class="btn btn-secondary" role="button">%s</a>',
						esc_url( $url ),
						esc_html__( 'Download', 'orbis' )
					);

					?>
				</div>

			<?php endif; ?>

			<?php get_template_part( 'templates/filter', get_query_var( 'post_type' ) ); ?>
		</div>

		<?php get_template_part( 'templates/filter_advanced', get_query_var( 'post_type' ) ); ?>
	</form>
</div>
