<div class="card mb-3">
	<div class="card-body">
		<h3 class="card-title"><?php esc_html_e( 'Subscription Product Details', 'orbis' ); ?></h3>

		<div class="content">
			<dl>
				<dt><?php esc_html_e( 'Price', 'orbis' ); ?></dt>
				<dd>
					<?php

					$price = get_post_meta( get_the_ID(), '_orbis_subscription_product_price', true );

					if ( empty( $price ) ) {
						echo '—';
					} else {
						echo esc_html( orbis_price( $price ) );
					}

					?>
				</dd>

				<dt><?php esc_html_e( 'Cost Price', 'orbis' ); ?></dt>
				<dd>
					<?php

					$price = get_post_meta( get_the_ID(), '_orbis_subscription_product_cost_price', true );

					if ( empty( $price ) ) {
						echo '—';
					} else {
						echo esc_html( orbis_price( $price ) );
					}

					?>
				</dd>

				<dt><?php esc_html_e( 'Auto Renew', 'orbis' ); ?></dt>
				<dd>
					<?php

					$auto_renew = get_post_meta( get_the_ID(), '_orbis_subscription_product_auto_renew', true );

					echo esc_html( $auto_renew ? __( 'Yes', 'orbis' ) : __( 'No', 'orbis' ) );

					?>
				</dd>
			</dl>
		</div>
	</div>

</div>
