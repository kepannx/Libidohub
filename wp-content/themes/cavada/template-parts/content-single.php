<?php
/**
 * Template part for displaying single posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cavada
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-blog' ); ?>>
	<div class="content-single-inner">
		<div class="entry-content">
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php
				cavada_posted_on();
				cavada_archive_entry_footer();
				?>
			</header>
			<?php do_action( 'cavada_entry_top', 'full' ); ?>
			<!-- .entry-header -->
			<div class="entry-summary">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cavada' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		</div>
		<?php cavada_wooshare(); ?>

		<!-- .entry-footer -->
	</div>
</article><!-- #post-## -->

