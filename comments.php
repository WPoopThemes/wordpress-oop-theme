<?php
  if ( post_password_required() ) {
    return;
  }
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2>
			<?php
			$comment_count = get_comments_number();
			if ( $comment_count === '1') {
				printf(
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'starter-theme' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( 

					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'starter-theme' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ul>
			<?php
			wp_list_comments( array(
				'style'      => 'ul',
				'short_ping' => true,
			) );
			?>
		</ul>

		<?php
    the_comments_navigation();
    
		if ( ! comments_open() ) :
			?>
			<p><?php esc_html_e( 'Comments are closed.', 'starter-theme' ); ?></p>
			<?php
		endif;

	endif; 

	comment_form();
	?>