<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo esc_attr( orbis_get_url_post_new() ); ?>">
		<span class="glyphicon glyphicon-plus"></span> <?php esc_html_e( 'Add subscription product', 'orbis' ); ?>
	</a>
</header>

<div class="card">
	<div class="card-block">
		<?php get_template_part( 'templates/search_form' ); ?>
	</div>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Title', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Costs', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Revenue', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Profit', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php if ( get_comments_number() !== 0 ) : ?>

									<div class="comments-number">
										<span class="glyphicon glyphicon-comment"></span>
										<?php comments_number( '0', '1', '%' ); ?>
									</div>

								<?php endif; ?>
							</td>
							<td>
								<?php

								$price   = get_post_meta( get_the_ID(), '_orbis_subscription_purchase_price', true );
								$revenue = get_post_meta( get_the_ID(), '_orbis_subscription_purchase_revenue', true );
								$profit  = $revenue - $price;

								if ( empty( $price ) ) {
									echo '—';
								} else {
									echo esc_html( orbis_price( $price ) );
								}

								?>
							</td>
							<td>
								<?php

								if ( empty( $revenue ) ) {
									echo '—';
								} else {
									echo esc_html( orbis_price( $revenue ) );
								}

								?>
							</td>
							<td>
								<?php

								if ( empty( $profit ) ) {
									echo '—';
								} else {
									echo esc_html( orbis_price( $profit ) );
								}

								?>
							</td>
							<td>
								<div class="actions">
									<div class="nubbin">
										<?php orbis_edit_post_link(); ?>
									</div>
								</div>
							</td>
						</tr>

					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php esc_html_e( 'No results found.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
