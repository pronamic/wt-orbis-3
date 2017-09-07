<?php

global $post;

$kvk_number = get_post_meta( $post->ID, '_orbis_company_kvk_number', true );
$vat_number = get_post_meta( $post->ID, '_orbis_company_vat_number', true );

$email      = get_post_meta( $post->ID, '_orbis_company_email', true );
$website    = get_post_meta( $post->ID, '_orbis_company_website', true );

$address    = get_post_meta( $post->ID, '_orbis_company_address', true );
$postcode   = get_post_meta( $post->ID, '_orbis_company_postcode', true );
$city       = get_post_meta( $post->ID, '_orbis_company_city', true );
$country    = get_post_meta( $post->ID, '_orbis_company_country', true );

$invoice_email = get_post_meta( $post->ID, '_orbis_invoice_email', true );

?>
<div class="panel">
	<header>
		<h3><?php esc_html_e( 'Contact Details', 'orbis' ); ?></h3>
	</header>

	<div class="content">
		<dl>
			<?php if ( ! empty( $address ) || ! empty( $postcode ) || ! empty( $country ) ) : ?>

				<dt><?php esc_html_e( 'Address', 'orbis' ); ?></dt>
				<dd>
					<?php echo esc_html( $address ); ?><br />
					<?php echo esc_html( $postcode . ' ' . $city ); ?><br />
					<?php echo esc_html( $country ); ?>
				</dd>

			<?php endif; ?>

			<?php if ( ! empty( $website ) ) : ?>

				<dt><?php esc_html_e( 'Website', 'orbis' ); ?></dt>
				<dd>
					<a href="<?php echo esc_attr( $website ); ?>" target="_blank"><?php echo esc_html( $website ); ?></a>
				</dd>

			<?php endif; ?>

			<?php if ( ! empty( $email ) ) : ?>

				<dt><?php esc_html_e( 'E-Mail', 'orbis' ); ?></dt>
				<dd>
					<a href="mailto:<?php echo esc_attr( $email ); ?>" target="_blank"><?php echo esc_html( $email ); ?></a>
				</dd>

			<?php endif; ?>

			<?php if ( ! empty( $invoice_email ) ) : ?>

				<dt><?php esc_html_e( 'Invoice E-Mail', 'orbis' ); ?></dt>
				<dd>
					<a href="mailto:<?php echo esc_attr( $invoice_email ); ?>" target="_blank"><?php echo esc_html( $invoice_email ); ?></a>
				</dd>

			<?php endif; ?>

			<?php if ( ! empty( $kvk_number ) ) : ?>

				<dt><?php esc_html_e( 'KvK Number', 'orbis' ); ?></dt>
				<dd>
					<?php echo esc_html( $kvk_number ); ?>

					<?php

					$url_open_kvk = sprintf( 'https://openkvk.nl/kvk/%s/', $kvk_number );
					$url_kvk      = add_query_arg( 'q', $kvk_number, 'http://zoeken.kvk.nl/search.ashx' );

					?>
					<a class="tag tag-info" href="<?php echo esc_attr( $url_open_kvk ); ?>" target="_blank">openkvk.nl</a>
					<a class="tag tag-info" href="<?php echo esc_attr( $url_kvk ); ?>" target="_blank">kvk.nl</a>
				</dd>

			<?php endif; ?>

			<?php if ( ! empty( $vat_number ) ) : ?>

				<dt><?php esc_html_e( 'VAT Number', 'orbis' ); ?></dt>
				<dd><?php echo esc_html( $vat_number ); ?></dd>

			<?php endif; ?>

			<?php if ( has_term( null, 'orbis_payment_method' ) ) : ?>

				<dt><?php esc_html_e( 'Payment Method', 'orbis' ); ?></dt>
				<dd><?php the_terms( null, 'orbis_payment_method' ); ?></dd>

			<?php endif; ?>

			<?php if ( has_term( null, 'orbis_invoice_shipping_method' ) ) : ?>

				<dt><?php esc_html_e( 'Invoice Shipping Method', 'orbis' ); ?></dt>
				<dd><?php the_terms( null, 'orbis_invoice_shipping_method' ); ?></dd>

			<?php endif; ?>

			<dt><?php esc_html_e( 'vCard', 'orbis' ); ?></dt>
			<dd>
				<?php

				printf(
					'<a href="%s">%s</a>',
					esc_attr( get_permalink() . 'vcard/' ),
					esc_html__( 'Download vCard', 'orbis' )
				);

				?>
			</dd>
		</dl>
	</div>
</div>
