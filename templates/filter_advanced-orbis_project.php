<?php

$principal      = get_query_var( 'orbis_project_principal' );
$invoice_number = get_query_var( 'orbis_project_invoice_number' );
$is_advanced    = ! empty( $principal ) || ! empty( $invoice_number );

?>

<div id="advanced-search" class="<?php echo $is_advanced ? 'in' : 'collapse'; ?>">
	<fieldset>
		<legend><?php esc_html_e( 'Advanced Search', 'orbis' ); ?></legend>

		<div class="form-group">
			<label for="orbis_project_principal"><?php esc_html_e( 'Client', 'orbis' ); ?></label>
			<input id="orbis_project_principal" class="form-control" name="orbis_project_principal" value="<?php echo esc_attr( $principal ); ?>" type="text" placeholder="<?php esc_html_e( 'Search on Client', 'orbis' ); ?>">
		</div>

		<div class="form-group">
			<label for="orbis_project_invoice_number"><?php esc_html_e( 'Invoice Number', 'orbis' ); ?></label>
			<input id="orbis_project_invoice_number" class="form-control" name="orbis_project_invoice_number" value="<?php echo esc_attr( $invoice_number ); ?>" type="text" placeholder="<?php esc_html_e( 'Search on Invoice Number', 'orbis' ); ?>">
		</div>

		<div class="form-footer">
			<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'orbis' ); ?></button>
			<button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#advanced-search"><?php esc_html_e( 'Cancel', 'orbis' ); ?></button>
		</div>
	</fieldset>
</div>
