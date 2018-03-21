<?php get_header(); ?>

<?php get_template_part( 'templates/deals-stats' ); ?>

<hr />

<div class="card">
	<div class="card-block">
		<?php get_template_part( 'templates/search_form' ); ?>
	</div>

	<?php if ( have_posts() ) : ?>

		<div class="table-responsive">
			<table class="table table-striped table-condense table-hover">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Company', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Title', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Price', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Status', 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Author', 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ( have_posts() ) :
						the_post();
					?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<?php the_date(); ?>
							</td>
							<td>
								<?php orbis_deal_the_company_name(); ?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php get_template_part( 'templates/table-cell-comments' ); ?>
							</td>
							<td>
								<?php orbis_deal_the_price(); ?>
							</td>
							<td>
								<?php orbis_deal_the_status(); ?>
							</td>
							<td>
								<?php the_author(); ?>
							</td>
							<td>
								<?php get_template_part( 'templates/table-cell-actions' ); ?>
							</td>
						</tr>

					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>

		<?php get_template_part( 'templates/content-none' ); ?>

	<?php endif; ?>
</div>

<?php orbis_content_nav(); ?>

<?php get_footer(); ?>
