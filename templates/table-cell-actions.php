<?php

$text = '';

$text .= '<i class="fas fa-edit" aria-hidden="true"></i>';
$text .= sprintf(
	'<span class="sr-only sr-only-focusable">%s</span>',
	__( 'Edit', 'orbis' )
);

edit_post_link( $text );
