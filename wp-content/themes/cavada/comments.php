<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package cavada
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

if (
	have_comments() &&
	!( !comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) )
) {
	$class_has_comments = " has-comments";
} else {
	$class_has_comments = "";
}
?>

<div id="comments" class="comments-area<?php echo esc_attr( $class_has_comments ); ?>">
	<?php if ( have_comments() ) : ?>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html__( 'Comment navigation', 'cavada' ); ?></h1>

				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'cavada' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'cavada' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<div class="comment-list-inner">
			<h4 class="comments-title">
				<?php
				printf( 'Comment (%2$s)', 'Comments (%2$)', get_comments_number(), number_format_i18n( get_comments_number() ) );
				?>
			</h4>
			<ol class="comment-list">
				<?php wp_list_comments( 'style=li&&type=comment&avatar_size=90&callback=cavada_comment' ); ?>
			</ol>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html__( 'Comment navigation', 'cavada' ); ?></h1>

				<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'cavada' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'cavada' ) ); ?></div>
			</nav>
		<?php endif; ?>
	<?php endif; ?>
	<?php
	if ( !comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>

		<?php esc_attr_e( 'Comments are closed.', 'cavada' ); ?>
	<?php endif; ?>

	<?php
	$comments_args = array(
		// change the title of send button
		'label_submit'         => esc_html__( 'submit', 'cavada' ),
		'id_submit'            => 'submit',
		// change the title of the reply section
		'title_reply'          => esc_html__( 'Leave a Comment', 'cavada' ),
		// remove "Text or HTML to be displayed after the set of comment fields"
		'comment_notes_after'  => '',
		'comment_notes_before' => '<p class="comment-notes">' .
			__( 'Your email address will not be published.', 'cavada' ) /* . ( $req ? $required_text : '' ) */ .
			'</p>',
		'fields'               => apply_filters( 'comment_form_field_comment', array(
				'author' =>
					'<div class="row"><div class="col-sm-6"><label>' . esc_html__( "Your name", "cavada" ) . ' <span>*</span></label><input id="author" name="author" type="text" class="txt" value="" size="30"/></div>',
				'email'  =>
					'<div class="col-sm-6"><label>' . esc_html__( "Your email", "cavada" ) . ' <span>*</span></label><input id="email" name="email" type="text" class="txt" value="" size="30"/></div></div>',
				'url'    =>
					'<div class="row"><div class="col-sm-12"><label>' . esc_html__( "Your website", "cavada" ) . '</label><input id="url" name="url" type="text" class="txt" value="" size="30" /></div></div>'
			)
		),
		'comment_field'        => '<div class="row"><div class="col-sm-12"><label>' . esc_html__( "Your comment", "cavada" ) . '<span>*</span></label><textarea id="comment" class="text_area" name="comment" aria-required="true"></textarea></div></div>',

	);
	?>

	<div class="comment-respond-area">
		<?php comment_form( $comments_args ); ?>
	</div>
	<div class="clear"></div>
</div><!-- #comments -->