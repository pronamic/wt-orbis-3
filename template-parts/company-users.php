<?php

if ( ! \function_exists( 'p2p_register_connection_type' ) ) {
	return;
}

$post = \get_post();

$users = get_users(
	array(
		'connected_type'  => 'orbis_users_to_companies',
		'connected_items' => $post
	)
);

if ( empty( $users ) ) : ?>

	<div class="card-body">
		<p class="text-muted m-0">
			<?php esc_html_e( 'No users connected.', 'orbis' ); ?>
		</p>
	</div>

<?php else : ?>

	<ul class="list-group list-group-flush" style="max-height: 600px; overflow: scroll;">
		<?php foreach ( $users as $user ) : ?>

			<li class="list-group-item">
				<div class="media">
					<span class="mr-3">
						<img src="<?php bloginfo( 'template_directory' ); ?>/placeholders/avatar.png" alt="">
					</span>

					<div class="media-body">
						<?php

						echo \esc_html( $user->display_name ), '<br />';

						printf(
							'<a class="text-secondary" style="font-size: .8em" href="mailto:%s">%s</a><br />',
							esc_html( $user->user_email ),
							esc_html( $user->user_email )
						);

						?>
					</div>
				</div>
			</li>

		<?php endforeach; ?>
	</ul>

<?php endif; ?>
