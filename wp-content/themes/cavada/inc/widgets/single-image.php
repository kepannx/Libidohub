<?php /**
 * Class CAVADA_Widget_Product_Category
 * Create ajax search
 */
class CAVADA_Widget_Single_Image extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'CAVADA_Widget_Single_Image_class',
			'description' => 'Single Image'
		);
		parent::__construct( 'CAVADA_Widget_Single_Image', '(Vi) Single Image', $widget_ops );
	}

	public function form( $instance ) {
		$defaults = array(
			'title'      => '',
			'new_window' => '',
			'image_url'  => '',
			'image_link' => '',
			'desc'       => ''
		);
		@$instance = wp_parse_args( (array) $instance, $defaults );
		$image_link = $instance['image_link'];
		$new_window = $instance['new_window'];
		$desc       = $instance['desc'];
		$title      = $instance['title'];
		$image      = new WidgetImageField( ent2ncr( $this->get_field_name( 'image_url' ) ), '', $instance['image_url'] );
		/*Get Product category*/
		?>
		<p>
			<label><?php echo esc_html__( 'Title', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label><?php echo esc_html__( 'Upload Image', 'cavada' ); ?></label>
		</p>
		<?php echo ent2ncr( $image->get_field() ) ?>
		<p>
			<label><?php echo esc_html__( 'Description', 'cavada' ); ?></label>
			<textarea class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'desc' ) ); ?>"><?php echo esc_html( $desc ); ?></textarea>
		</p>
		<p>
			<label><?php echo esc_html__( 'Link', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'image_link' ) ); ?>" type="text" value="<?php echo esc_attr( $image_link ); ?>" />
		</p>
		<p>
			<label><?php echo esc_html__( 'Open New Window', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'new_window' ) ); ?>" class="widefat">
				<option value="0" <?php selected( $new_window, '0' ) ?>><?php esc_html_e( 'No', 'cavada' ) ?></option>
				<option value="1" <?php selected( $new_window, '1' ) ?>><?php esc_html_e( 'Yes', 'cavada' ) ?></option>
			</select>
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['new_window'] = sanitize_text_field( $new_instance['new_window'] );
		$instance['image_link'] = sanitize_text_field( $new_instance['image_link'] );
		$instance['image_url']  = sanitize_text_field( $new_instance['image_url'] );
		$instance['desc']       = sanitize_text_field( $new_instance['desc'] );

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		echo ent2ncr( $before_widget );
		$image_link = isset( $instance['image_link'] ) ? $instance['image_link'] : '';
		$new_window = isset( $instance['new_window'] ) ? $instance['new_window'] : '1';
		$image_url  = isset( $instance['image_url'] ) ? $instance['image_url'] : '';
		$title      = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$desc       = isset( $instance['desc'] ) ? trim( $instance['desc'] ) : '';
		if ( $title ) {
			echo "<h3 class='widget-title'>{$title}</h3>";
		} ?>

		<div class="vi-single-image">
			<?php
			$before_link = $after_link = $window = '';
			if ( $new_window == '1' ) {
				$window = ' target="_blank"';
			}
			if ( $image_link ) {
				$before_link = '<a href="' . $image_link . '"' . $window . '>';
				$after_link  = '</a>';
			}
			if ( $image_url ) {
				$src       = wp_get_attachment_image_src( $image_url, 'full' );
				$dimension = '';
				if ( isset( $src[1] ) ) {
					$dimension .= ' width="' . $src[1] . '"';
				}
				if ( isset( $src[2] ) ) {
					$dimension .= ' height="' . $src[2] . '"';
				}

				echo ent2ncr( $before_link . '<img class="vi-single-image" src="' . esc_url( $src[0] ) . '" ' . $dimension . ' alt="">' . $after_link );
			}
			if ( $desc ) { ?>

				<div class="vi-single-image-desc">
					<?php echo esc_html( $desc ) ?>
				</div>
			<?php } ?>
		</div>
		<?php echo ent2ncr( $after_widget );
	}
}

register_widget( 'CAVADA_Widget_Single_Image' );