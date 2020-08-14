<div class="card-body">

	<?php if ( has_post_thumbnail() ) : ?>

		<div class="thumbnail">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</div>

	<?php endif; ?>

	<?php the_content(); ?>

</div>

<?php

get_template_part( 'templates/post-card-footer' );
