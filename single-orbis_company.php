<?php get_header(); ?>

<?php
while ( have_posts() ) :
	the_post();
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="row">
			<div class="col-md-8">
				<?php do_action( 'orbis_before_main_content' ); ?>

				<?php if ( ! empty( get_the_content() ) ) : ?>

				<div class="card mb-3">
					<div class="card-header"><?php esc_html_e( 'Description', 'orbis' ); ?></div>

					<div class="card-body">
						<?php the_content(); ?>
					</div>
				</div>

				<?php endif; ?>

				<?php get_template_part( 'templates/company_sections' ); ?>

				<?php do_action( 'orbis_after_main_content' ); ?>

				<?php comments_template( '', true ); ?>
			</div>

			<div class="col-md-4">
				<?php do_action( 'orbis_before_side_content' ); ?>

				<?php get_template_part( 'templates/company_persons' ); ?>

				<?php get_template_part( 'templates/company_twitter' ); ?>

				<div class="card">
					<div class="card-header"><?php esc_html_e( 'Additional Information', 'orbis' ); ?></div>

					<div class="card-body">
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

				<?php do_action( 'orbis_after_side_content' ); ?>
			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php get_footer(); ?>
