<?php

$comments_number = get_comments_number();

if ( empty( $comments_number ) ) {
	return;
}

?>
<div class="comments-number">
	<i class="fa fa-comment" aria-hidden="true"></i>
	<?php comments_number( '0', '1', '%' ); ?>
</div>
