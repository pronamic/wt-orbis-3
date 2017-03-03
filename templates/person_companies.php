<?php

if ( ! function_exists( 'p2p_connection_exists' ) ) {
	return;
}

if ( ! p2p_connection_exists( 'orbis_persons_to_companies' ) ) {
	return;
}

$query = new WP_Query( array(
	'connected_type'  => 'orbis_persons_to_companies',
	'connected_items' => get_queried_object(),
	'nopaging'        => true,
) );

?>
<div class="panel">
	<header>
		<h3><?php esc_html_e( 'Connected Companies', 'orbis' ); ?></h3>
	</header>

	<?php if ( $query->have_posts() ) : ?>

		<ul class="list">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<li>
					<?php

					$favicon_url = orbis_get_favicon_url( get_post_meta( get_the_ID(), '_orbis_company_website', true ) );

					?>
					<a href="<?php the_permalink(); ?>">
						<?php if ( ! empty( $favicon_url ) ) : ?>

							<img src="<?php echo esc_attr( $favicon_url ); ?>" alt="" />

						<?php endif; ?>

						<?php the_title(); ?>
					</a>
				</li>

			<?php endwhile; ?>
		</ul>

		<?php wp_reset_postdata(); ?>

	<?php else : ?>

		<div class="content">
			<p class="alt">
				<?php esc_html_e( 'No companies connected.', 'orbis' ); ?>
			</p>
		</div>

	<?php endif; ?>
</div>
