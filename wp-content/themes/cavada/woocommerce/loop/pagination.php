<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$wp_query = cavada_get_wp_query();
$cavada_data = cavada_get_data_themeoptions();
if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
if ( ! isset( $cavada_data['ajax_settings_run'] ) ) {
	$cavada_data['ajax_settings_run'] = 0;
}
if ( $cavada_data['ajax_settings_run'] == 'no' || ! $cavada_data['ajax_settings_run'] ) {
	echo '<div class="wrapper-pagination"><div class="next-prev-btn">';
	posts_nav_link( ' ', esc_html__( 'PREVIOUS', 'cavada' ), esc_html__( 'NEXT', 'cavada' ) );
	echo '</div>'
	?>
	<div class="pagination loop-pagination">
		<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'    => '',
			'add_args'  => '',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'prev_next' => false,
			'type'      => 'list',
			'end_size'  => 3,
			'mid_size'  => 3
		) ) );
		?>
	</div>
</div>
<?php } else {
	echo '<div class="next-prev-btn">';
	echo next_posts_link(__( 'NEXT', 'cavada' ));
	echo '</div>';
} ?>


