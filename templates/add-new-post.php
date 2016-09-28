<?php

$labels = get_post_type_labels( get_queried_object() );

if ( $labels->add_new_item ) : ?>

	<header class="section-header clearfix">
		<a class="btn btn-primary pull-right" href="<?php echo esc_url( orbis_get_url_post_new() ); ?>">		
			<i class="fa fa-plus" aria-hidden="true"></i> <?php echo esc_html( $labels->add_new_item ); ?>
		</a>
	</header>

<?php endif; ?>
