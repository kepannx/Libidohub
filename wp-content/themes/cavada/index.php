<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package cavada
 */

get_header();

get_template_part( 'inc/templates/heading', 'top' );

do_action( 'cavada_wrapper_loop_start' );

if ( have_posts() ) :
	?>
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
