<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="row">
			<div class="col-md-8">
				<?php do_action( 'orbis_before_main_content' ); ?>

				<div class="card mb-3">
					<div class="card-body">
						<h3 class="card-title"><?php esc_html_e( 'Description', 'orbis' ); ?></h3>

						<div class="content clearfix">
							<?php if ( has_post_thumbnail() ) : ?>
					
								<div class="thumbnail">
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</div>

							<?php endif; ?>

							<?php the_content(); ?>
						</div>
					</div>
					

					<?php get_template_part( 'templates/post-card-footer' ); ?>
				</div>

				<?php do_action( 'orbis_after_main_content' ); ?>

				<?php comments_template( '', true ); ?>
			</div>

			<div class="col-md-4">
				<?php do_action( 'orbis_before_side_content' ); ?>

				<div class="card">
					<div class="card-body">
						<h3 class="card-title"><?php esc_html_e( 'Additional Information', 'orbis' ); ?></h3>

						<div class="content">
							<dl>
								<dt><?php esc_html_e( 'Posted on', 'orbis' ); ?></dt>
								<dd><?php echo esc_html( get_the_date() ); ?></dd>

								<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
								<dd><?php echo esc_html( get_the_author() ); ?></dd>

								<dt><?php esc_html_e( 'Actions', 'orbis' ); ?></dt>
								<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>
							</dl>
						</div>
					</div>
					
				</div>

				<?php do_action( 'orbis_after_side_content' ); ?>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
