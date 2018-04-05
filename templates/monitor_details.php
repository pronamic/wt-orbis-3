<div class="card mb-3">
	<div class="card-header"><?php esc_html_e( 'Monitor Details', 'orbis' ); ?></div>
	<div class="card-body">

		<div class="content">
			<dl>
				<dt><?php esc_html_e( 'URL', 'orbis' ); ?></dt>
				<dd>
					<?php

					$url = get_post_meta( get_the_ID(), '_orbis_monitor_url', true );

					echo empty( $url ) ? '—' : esc_html( $url );

					?>
				</dd>

				<dt><?php esc_html_e( 'Required Response Code', 'orbis' ); ?></dt>
				<dd>
					<?php

					$code = get_post_meta( get_the_ID(), '_orbis_monitor_required_response_code', true );

					echo empty( $code ) ? '—' : esc_html( $code );

					?>
				</dd>

				<dt><?php esc_html_e( 'Required location', 'orbis' ); ?></dt>
				<dd>
					<?php

					$location = get_post_meta( get_the_ID(), '_orbis_monitor_required_location', true );

					echo empty( $location ) ? '—' : esc_html( $location );

					?>
				</dd>
			</dl>
		</div>
	</div>

</div>
