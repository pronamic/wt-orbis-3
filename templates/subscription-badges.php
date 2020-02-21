<?php

global $post;

$badges = array();

$current_date    = new \DateTime();
$expiration_date = new \DateTime( $post->subscription_expiration_date );

$is_active    = empty( $post->subscription_cancel_date ) || $expiration_date > $current_date;
$is_cancelled = isset( $post->subscription_cancel_date );
$is_expired   = $current_date > $expiration_date;

if ( $is_active ) {
	$badges[] = array(
		'variation' => 'success',
		'content'   => 'Actief',
	);
}

if ( $is_cancelled ) {
	$badges[] = array(
		'variation' => 'warning',
		'content'   => 'Opgezegd',
	);
}

if ( $is_expired ) {
	$badges[] = array(
		'variation' => $is_cancelled ? 'danger' : 'info',
		'content'   => 'Verlopen',
	);
}

foreach ( $badges as $badge ) {
	$classes = array(
		'badge',
		'badge-' . $badge['variation']
	);

	printf(
		'<span class="badge badge-%s">%s</span> ',
		esc_attr( implode( ' ', $classes ) ),
		esc_html( $badge['content'] )
	);
}
