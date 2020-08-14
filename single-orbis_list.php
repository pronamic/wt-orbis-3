<?php

$p2p_type = p2p_type( 'orbis_persons_to_lists' );

if ( 'orbis_list_add' === filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING ) && wp_verify_nonce( filter_input( INPUT_GET, '_wpnonce' ), 'orbis_list_add' ) ) {
	$from   = filter_input( INPUT_GET, 'from', FILTER_SANITIZE_STRING );
	$to     = filter_input( INPUT_GET, 'to', FILTER_SANITIZE_STRING );
	$active = filter_input( INPUT_GET, 'active', FILTER_SANITIZE_STRING );

	$p2p_type->connect( $from, $to, array(
		'active' => $active,
	) );
}

?>

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

				<?php endif; ?>

				<div class="card mb-3">
					<div class="card-header"><?php esc_html_e( 'On the list', 'orbis' ); ?></div>
					<div class="card-body">

						<?php

						$query = new WP_Query( array(
							'connected_type'  => 'orbis_persons_to_lists',
							'connected_items' => get_queried_object(),
							'nopaging'        => true,
						) );

						if ( $query->have_posts() ) :
						?>

							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th scope="col"><?php esc_html_e( 'Name', 'orbis' ); ?></th>
										<th scope="col"><?php esc_html_e( 'Active', 'orbis' ); ?></th>
										<th scope="col"><?php esc_html_e( 'Note', 'orbis' ); ?></th>
									</tr>
								</thead>

								<tbody>

									<?php
									while ( $query->have_posts() ) :
										$query->the_post();
									?>

										<tr>
											<td>
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</td>
											<td>
												<?php

												$active = p2p_get_meta( get_post()->p2p_id, 'active', true );

												switch ( $active ) {
													case 'yes':
														esc_html_e( 'Yes', 'orbis' );
														break;
													case 'no':
														esc_html_e( 'No', 'orbis' );
														break;
													case 'maybe':
														esc_html_e( 'Maybe', 'orbis' );
														break;
												}

												?>
											</td>
											<td>
												<?php echo esc_html( p2p_get_meta( get_post()->p2p_id, 'note', true ) ); ?>
											</td>
										</tr>

									<?php endwhile; ?>

								</tbody>
							</table>

							<?php wp_reset_postdata(); ?>

						<?php endif; ?>
					</div>
				</div>

				<div class="card mb-3">
					<div class="card-header"><?php esc_html_e( 'Not on the list', 'orbis' ); ?></div>
					<div class="card-body">

						<?php

						$link = add_query_arg( array(
							'action' => 'orbis_list_add',
							'from'   => get_the_ID(),
						), get_permalink() );

						$query = $p2p_type->get_connectable( get_the_ID(), array(
							'posts_per_page' => 10,
						) );

						if ( $query->have_posts() ) :

						?>

							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th scope="col"><?php esc_html_e( 'Name', 'orbis' ); ?></th>
										<th scope="col"><?php esc_html_e( 'Action', 'orbis' ); ?></th>
									</tr>
								</thead>

								<tbody>

									<?php
									while ( $query->have_posts() ) :
										$query->the_post();
									?>

										<tr>
											<td>
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</td>
											<td>
												<?php

												$active_options = array(
													'yes' => array(
														'class' => 'success',
														'icon'  => 'check',
														'label' => __( 'Yes', 'orbis' ),
													),
													'no'  => array(
														'class' => 'danger',
														'icon'  => 'times',
														'label' => __( 'No', 'orbis' ),
													),
												);

												foreach ( $active_options as $active => $option ) {
													printf( // WPCS: XSS ok.
														'<a href="%s" class="btn btn-sm btn-outline-%s">%s %s</a>',
														wp_nonce_url( add_query_arg( array(
															'to'     => get_the_ID(),
															'active' => $active,
														), $link ), 'orbis_list_add' ),
														esc_html( $option['class'] ),
														sprintf( '<i class="fa fa-%s" aria-hidden="true"></i>', esc_attr( $option['icon'] ) ),
														esc_html( $option['label'] )
													);

													echo ' ';
												}

												?>
											</td>
										</tr>

									<?php endwhile; ?>

								</tbody>
							</table>

							<?php wp_reset_postdata(); ?>

						<?php else : ?>

						<div class="content">
							<p class="alt">
								<?php esc_html_e( 'Nothing to show here.', 'orbis' ); ?>
							</p>
						</div>

						<?php endif; ?>
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

						<div class="content">
							<dl>
								<dt><?php esc_html_e( 'Posted on', 'orbis' ); ?></dt>
								<dd><?php echo esc_html( get_the_date() ); ?></dd>

								<dt><?php esc_html_e( 'Posted by', 'orbis' ); ?></dt>
								<dd><?php echo esc_html( get_the_author() ); ?></dd>

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
