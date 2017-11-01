<?php

/**
 * Page menu
 */
function orbis_page_menu_args( $args ) {
	$args['show_home'] = true;

	return $args;
}

add_filter( 'wp_page_menu_args', 'orbis_page_menu_args' );

///////////////////////////////////////////////

/**
 * Display navigation to next/previous pages when applicable
 */
function orbis_content_nav() {
	$html = get_the_posts_pagination( array(
		'mid_size' => 2,
		'type'     => 'list',
	) );

	if ( empty( $html ) ) {
		return;
	}

	$document = new DOMDocument();

	libxml_use_internal_errors( true );

	$document->loadHTML( $html );

	libxml_clear_errors();

	$simplexml = simplexml_import_dom( $document );

	if ( false !== $simplexml ) {
		$nav = $simplexml->body->nav;

		$nav->ul['class'] = 'pagination';

		foreach ( $nav->ul->li as $li ) {
			$classes = array(
				'page-item',
			);

			$child = null;

			if ( isset( $li->a ) ) {
				$child = $li->a;
			}

			if ( isset( $li->span ) ) {
				$child = $li->span;
			}

			if ( empty( $child ) ) {
				continue;
			}

			$child_classes = explode( ' ', $child['class'] );

			if ( in_array( 'current', $child_classes, true ) ) {
				$classes[] = 'active';
			}

			if ( in_array( 'dots', $child_classes, true ) ) {
				$classes[] = 'disabled';
			}

			$child['class'] = 'page-link';

			$li['class'] = implode( ' ', $classes );
		}

		$html = $nav->asXML();
	}

	echo '<div class="mt-3">';
	echo $html;
	echo '</div>';
}

///////////////////////////////////////////////

/**
 * Enqueue comment reply script
 */
function orbis_enqueue_comments_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'comment_form_before', 'orbis_enqueue_comments_reply' );

/**
 * Template for comments and pingbacks.
 */
function orbis_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case 'pingback'  :
		case 'trackback' :
			?>
			<li class="post pingback">
				<p><?php esc_html_e( 'Pingback:', 'orbis' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'orbis' ), ' ' ); ?></p>
			<?php
			break;

		default :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="comment-content">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 60 ); ?>
		
					<?php

					printf(
						__( '%s <span class="says">says:</span>', 'orbis' ),
						sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() )
					);

					?>
				</div>

				<?php if ( $comment->comment_approved == '0' ) : ?>

					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'orbis' ); ?></em><br />

				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php

						printf(
							esc_html__( '%1$s at %2$s', 'orbis' ),
							get_comment_date(),
							get_comment_time()
						);

						?>
					</a>

					<?php edit_comment_link( __( '(Edit)', 'orbis' ), ' ' ); ?>
				</div>

				<div class="comment-body">
					<?php comment_text(); ?>
				</div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>

			<?php

			break;
	endswitch;
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function orbis_posted_on() {
	printf(
		__( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'orbis' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url(get_the_author_meta('ID') ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'orbis' ), get_the_author() ) ),
		get_the_author()
	);
}
