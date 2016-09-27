<?php get_header(); ?>

<header class="section-header clearfix">
	<a class="btn btn-primary pull-right" href="<?php echo esc_url( orbis_get_url_post_new() ); ?>">
		<span class="glyphicon glyphicon-plus"></span> <?php esc_html_e( 'Add deal', 'orbis' ); ?>
	</a>
</header>

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
						<th><?php esc_html_e( 'Title'  , 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Price'  , 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Status' , 'orbis' ); ?></th>
						<th><?php esc_html_e( 'Author' , 'orbis' ); ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while ( have_posts() ) : the_post(); ?>

						<tr id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<td>
								<?php the_date(); ?>
							</td>
							<td>
								<?php orbis_deal_the_company_name(); ?>
							</td>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

								<?php if ( get_comments_number() !== 0  ) : ?>

									<div class="comments-number">
										<span class="glyphicon glyphicon-comment"></span>
										<?php comments_number( '0', '1', '%' ); ?>
									</div>

								<?php endif; ?>
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
