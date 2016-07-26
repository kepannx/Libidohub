<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cavada
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-inner">
		<div class="entry-content">
			<?php
			if ( has_post_format( 'link' ) && cavada_meta( 'url' ) && cavada_meta( 'text' ) ) {
				$url  = cavada_meta( 'url' );
				$text = cavada_meta( 'text' );
				if ( $url && $text ) { ?>
					<header class="entry-header">
						<h2 class="blog_title">
							<a class="link" href="<?php echo esc_url( $url ); ?>"><?php echo cavada_meta( 'text' ); ?></a>
						</h2>
						<?php
						cavada_posted_on();
						?>
					</header>
					<?php do_action( 'cavada_entry_top', 'full' ); ?>
					<?php
				}
				?>
				<div class="entry-summary">
					<?php
					the_excerpt();
					?>

				</div>
			<?php } elseif ( has_post_format( 'audio' ) || has_post_format( 'video' ) ) {
				do_action( 'cavada_entry_top', 'full' );
			} else {
				?>
				<header class="entry-header">
					<?php
					the_title( sprintf( '<h2 class="blog_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
					cavada_posted_on();
					?>
				</header>

				<?php do_action( 'cavada_entry_top', 'full' ); ?>

				<!-- .entry-header -->
				<div class="entry-summary">
					<?php
					the_excerpt();
					?>
					<div class="entry-footer">
						<?php cavada_archive_entry_footer(); ?>
						<a class="read-more" href="<?php echo esc_url( get_permalink() ) ?>"><?php echo esc_html__( 'Read more', 'cavada' ) ?></a>
					</div>
				</div><!-- .entry-summary -->
			<?php }; ?>

			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cavada' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</div>
</article><!-- #post-## -->
