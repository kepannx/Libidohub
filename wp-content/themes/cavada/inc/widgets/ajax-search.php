<?php /**
 * Class CAVADA_Widget_Ajax_Search
 * Create ajax search
 */
class CAVADA_Widget_Ajax_Search extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'CAVADA_Widget_Ajax_Search_class',
			'description' => 'Search all post type by ajax'
		);
		parent::__construct( 'CAVADA_Widget_Ajax_Search', '(Vi) Ajax Search', $widget_ops );
	}

	public function form( $instance ) {
		$defaults = array(
			'title'     => '',
			'limit'     => 6,
			'show_icon' => '1',
		);
		@$instance = wp_parse_args( (array) $instance, $defaults );
		$title     = $instance['title'];
		$limit     = $instance['limit'];
		$show_icon = $instance['show_icon'];
		?>

		<p>
			<label><?php echo esc_html__( 'Title', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label><?php echo esc_html__( 'Limit', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>

		<p>
			<label><?php echo esc_html__( 'Show Only Icon', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'show_icon' ) ); ?>" class="widefat">
				<option value="0" <?php selected( $show_icon, '0' ) ?>><?php esc_html_e( 'No', 'cavada' ) ?></option>
				<option value="1" <?php selected( $show_icon, '1' ) ?>><?php esc_html_e( 'Yes', 'cavada' ) ?></option>
			</select>
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['limit']     = sanitize_text_field( $new_instance['limit'] );
		$instance['show_icon'] = sanitize_text_field( $new_instance['show_icon'] );

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		echo ent2ncr( $before_widget );
		$title     = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$limit     = isset( $instance['limit'] ) ? $instance['limit'] : '6';
		$show_icon = isset( $instance['show_icon'] ) ? $instance['show_icon'] : '';
		if ( $title ) {
			echo "<h3 class='widget-title'>{$title}</h3>";
		} ?>
		<div class="wrapper_vi_search_form<?php if ( $show_icon == '1' ) {
			echo ' vi_search_form_style_1';
		} ?>">
			<?php
			if ( $show_icon == '1' ) {
				echo '<span class="search-link" id="header-search"><i class="fa fa-search"></i></span>';
			} ?>
			<div class="wrapper-header-search-form">
				<div class="search-popup-bg"></div>
				<div class="header-search-form-input">
					<form action="#" method="get" class="vi_search_form">
						<input data-limit="<?php echo esc_attr( $limit ) ?>" value="" name="s" id="s" placeholder="<?php echo esc_html__( 'SEARCH...', 'cavada' ) ?>" class="form-control vi-search-input" autocomplete="off" type="text">
						<button type="submit"><i class="fa fa-search"></i></button>
						<span class="header-search-close"><i class="fa fa-times"></i></span>
					</form>
					<ul class="vi-search-results"></ul>
				</div>
			</div>
		</div>
		<?php echo ent2ncr( $after_widget );
	}
}

register_widget( 'CAVADA_Widget_Ajax_Search' );