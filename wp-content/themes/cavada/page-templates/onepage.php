<?php
/**
 * Template Name: One Page
 *
 **/
get_header(); ?>
	<div class="home-content container" role="main">
 			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
			?>
	</div><!-- #main-content -->
<?php get_footer();
