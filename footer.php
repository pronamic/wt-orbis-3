
					<footer id="footer">
						<?php

						printf( // WPCS: XSS ok.
							__( '© %1$s %2$s. WordPress theme by <a href="%3$s">Pronamic</a>.', 'orbis' ),
							esc_html( date( 'Y' ) ),
							esc_html( get_bloginfo( 'site-title' ) ),
							'https://www.pronamic.nl/'
						);

						?>
					</footer>
				</div>
			</div>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>
