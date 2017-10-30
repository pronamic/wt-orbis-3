<div class="form-inline">
	<span><select name="orbis_deal_status" class="form-control">
		<?php

		$statuses = orbis_deal_get_statuses();

		array_unshift( $statuses, __( '— Select Status —', 'orbis' ) );

		$status = filter_input( INPUT_GET, 'orbis_deal_status', FILTER_SANITIZE_STRING );

		foreach ( $statuses as $key => $label ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $key ),
				selected( $key, $status, false ),
				esc_html( $label )
			);
		}

		?>
	</select> <button class="btn btn-secondary" type="submit"><?php esc_html_e( 'Filter', 'orbis' ); ?></button></span>
</div>
