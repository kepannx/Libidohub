<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package cavada
 */
get_header();

//get_template_part( 'inc/templates/heading', 'top' );

//do_action( 'cavada_wrapper_loop_start' ); ?>
	<div class="site-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="error-404">
						<h1><?php echo esc_html_e( '404', 'cavada' ); ?></h1>
						<h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'cavada' ); ?></h3>
						<p><?php esc_html_e( 'It\'s nothing was found at this location. Try to search now!', 'cavada' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php //do_action( 'cavada_wrapper_loop_end' ); ?>

<?php get_footer(); ?>