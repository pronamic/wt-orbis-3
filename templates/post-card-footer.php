<div class="card-footer">
	<?php

	if ( comments_open() ) {
		printf(
			'<a href="%s"><i class="fa fa-commenting" aria-hidden="true"></i> %s</a>',
			esc_url( get_permalink() . '#respond' ),
			esc_html__( 'Respond', 'orbis' )
		);
	}

	?>
</div>
