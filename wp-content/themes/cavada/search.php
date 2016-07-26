<?php
/**
 * The template for displaying search results pages.
 *
 * @package cavada
 */

get_header();

?>

<?php do_action( 'cavada_wrapper_loop_start' ); ?>

<?php
if ( have_posts() ) :
	?>
	<header class="page-header">
		<h1 class="page-title"><?php printf( wp_kses( 'Search Results for: %s', 'cavada' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	</header><!-- .page-header -->
	<div class="archive-blog">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			/*
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );
			?>
		<?php endwhile; ?>
	</div>
	<?php
	echo '<div class="clear"></div>';
	cavada_paging_nav();
	?>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>
<!--end item-->

<?php do_action( 'cavada_wrapper_loop_end' ); ?>

<?php get_footer(); ?>
