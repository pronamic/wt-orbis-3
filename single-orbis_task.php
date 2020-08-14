<?php get_header(); ?>

<?php
while ( have_posts() ) :
	the_post();
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="row">
			<div class="col-md-8">
				<?php do_action( 'orbis_before_main_content' ); ?>

				<div class="card mb-3">
					<div class="card-header"><?php esc_html_e( 'Description', 'orbis' ); ?></div>
					<div class="card-body">

						<div class="card-text clearfix">
							<?php if ( has_post_thumbnail() ) : ?>

								<div class="thumbnail">
									<?php the_post_thumbnail( 'thumbnail' ); ?>
								</div>

							<?php endif; ?>

							<?php the_content(); ?>
						</div>	
					</div>
				</div>

				<?php do_action( 'orbis_after_main_content' ); ?>

				<?php comments_template( '', true ); ?>
			</div>

			<div class="col-md-4">
				<?php do_action( 'orbis_before_side_content' ); ?>

				<div class="card">
					<div class="card-header"><?php esc_html_e( 'Additional Information', 'orbis' ); ?></div>
					<div class="card-body">

						<div class="card-text">
							<dl>
								<dt><?php esc_html_e( 'Posted on', 'orbis' ); ?></dt>
								<dd><?php echo esc_html( get_the_date() ); ?></dd>

								<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
								<dd><?php echo esc_html( get_the_author() ); ?></dd>

								<dt><?php esc_html_e( 'Project', 'orbis' ); ?></dt>
								<dd><?php orbis_task_project(); ?></dd>

								<dt><?php esc_html_e( 'Assignee', 'orbis' ); ?></dt>
								<dd><?php orbis_task_assignee(); ?></dd>

								<dt><?php esc_html_e( 'Deadline', 'orbis' ); ?></dt>
								<dd><?php orbis_task_due_at(); ?></dd>

								<?php if ( null !== get_edit_post_link() ) : ?>

									<dt><?php esc_html_e( 'Actions', 'orbis' ); ?></dt>
									<dd><?php edit_post_link( __( 'Edit', 'orbis' ) ); ?></dd>

								<?php endif; ?>
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
