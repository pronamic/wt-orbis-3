<?php if ( comments_open() ) : ?>

	<div class="card-footer">

		<?php

		printf(
			'<i class="fa fa-comment text-muted" aria-hidden="true"></i> <a href="%s">%s</a>',
			esc_url( get_permalink() . '#respond' ),
			esc_html__( 'Respond', 'orbis' )
		);

		?>

	</div>

<?php endif; ?>
