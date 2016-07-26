<?php
/**
 * Class cavada_social_links
 * Create social links
 */

require_once( get_template_directory() . '/inc/widgets/widget-image-field/widget-image-field.php' );

class cavada_social_links extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'cavada_social_links', 'description' => 'Social Links' );
		parent::__construct( 'widget_cavada_social_links', '(Vi) Social Links', $widget_ops );
	}

	public function form( $instance ) {
		$defaults = array(
			'style'          => 'circle',
			'desc'           => '',
			'image_url'      => '',
			'icon_color'     => '',
			'link_face'      => '',
			'link_twitter'   => '',
			'link_google'    => '',
			'link_dribble'   => '',
			'link_linkedin'  => '',
			'link_instagram' => '',
			'link_youtube'   => '',
			'link_behance'   => ''
		);
		@$instance = wp_parse_args( (array) $instance, $defaults );
		$style          = strip_tags( $instance['style'] );
		$desc           = strip_tags( $instance['desc'] );
		$link_face      = strip_tags( $instance['link_face'] );
		$link_twitter   = strip_tags( $instance['link_twitter'] );
		$link_google    = strip_tags( $instance['link_google'] );
		$link_dribble   = strip_tags( $instance['link_dribble'] );
		$link_linkedin  = strip_tags( $instance['link_linkedin'] );
		$link_instagram = strip_tags( $instance['link_instagram'] );
		$link_youtube   = strip_tags( $instance['link_youtube'] );
		$link_behance   = strip_tags( $instance['link_behance'] );
		$icon_color     = strip_tags( $instance['icon_color'] );
		$image          = new WidgetImageField( ent2ncr( $this->get_field_name( 'image_url' ) ), '', $instance['image_url'] );

		?>
		<p>
			<label><?php echo esc_html__( 'Select Style', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'style' ) ); ?>" class="widefat">
				<option <?php selected( $style, 'circle' ) ?> value="circle"><?php echo esc_html__( 'Circle', 'cavada' ); ?></option>
				<option <?php selected( $style, 'circle_border' ) ?> value="circle_border"><?php echo esc_html__( 'Circle Border', 'cavada' ); ?></option>
				<option <?php selected( $style, 'basic' ) ?> value="basic"><?php echo esc_html__( 'Bsic', 'cavada' ); ?></option>
			</select>
		</p>
		<p>
			<label><?php echo esc_html__( 'Upload Image', 'cavada' ); ?></label>
		</p>
		<?php echo ent2ncr( $image->get_field() ) ?>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'icon_color' ) ); ?>"><?php echo esc_html_e( 'Icon Color: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'icon_color' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'icon_color' ) ); ?>" value="<?php echo esc_attr( $icon_color ); ?>">
			<span class="description"><?php esc_attr_e( 'If empty, Color will get from Primary color of Theme Options.', 'cavada' ) ?></span>
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'desc' ) ); ?>"><?php echo esc_html_e( 'Description: ', 'cavada' ) ?> </label>
			<textarea class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'desc' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'desc' ) ); ?>"><?php echo esc_attr( $desc ); ?></textarea>

		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_face' ) ); ?>"><?php echo esc_html_e( 'Facebook Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_face' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_face' ) ); ?>" value="<?php echo esc_attr( $link_face ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_twitter' ) ); ?>"><?php echo esc_html_e( 'Twitter Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_twitter' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_twitter' ) ); ?>" value="<?php echo esc_attr( $link_twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_google' ) ); ?>"><?php echo esc_html_e( 'Google Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_google' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_google' ) ); ?>" value="<?php echo esc_attr( $link_google ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_dribble' ) ); ?>"><?php echo esc_html_e( 'Dribble Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_dribble' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_dribble' ) ); ?>" value="<?php echo esc_attr( $link_dribble ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_linkedin' ) ); ?>"><?php echo esc_html_e( 'Linkedin Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_linkedin' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_linkedin' ) ); ?>" value="<?php echo esc_attr( $link_linkedin ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_instagram' ) ); ?>"><?php echo esc_html_e( 'Instagram Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_instagram' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_instagram' ) ); ?>" value="<?php echo esc_attr( $link_instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_youtube' ) ); ?>"><?php echo esc_html_e( 'Youtube Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_youtube' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_youtube' ) ); ?>" value="<?php echo esc_attr( $link_youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'link_behance' ) ); ?>"><?php echo esc_html_e( 'Behance Url: ', 'cavada' ) ?> </label>
			<input type="text" class="widefat" size="3" id="<?php echo ent2ncr( $this->get_field_id( 'link_behance' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'link_behance' ) ); ?>" value="<?php echo esc_attr( $link_behance ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance['style']          = strip_tags( $new_instance['style'] );
		$instance['desc']           = strip_tags( $new_instance['desc'] );
		$instance['image_url']      = strip_tags( $new_instance['image_url'] );
		$instance['link_face']      = strip_tags( $new_instance['link_face'] );
		$instance['link_twitter']   = strip_tags( $new_instance['link_twitter'] );
		$instance['link_google']    = strip_tags( $new_instance['link_google'] );
		$instance['link_dribble']   = strip_tags( $new_instance['link_dribble'] );
		$instance['link_linkedin']  = strip_tags( $new_instance['link_linkedin'] );
		$instance['link_instagram'] = strip_tags( $new_instance['link_instagram'] );
		$instance['link_youtube']   = strip_tags( $new_instance['link_youtube'] );
		$instance['link_behance']   = strip_tags( $new_instance['link_behance'] );
		$instance['icon_color']     = strip_tags( $new_instance['icon_color'] );

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$desc           = empty( $instance['desc'] ) ? '' : apply_filters( 'cavada_social_links_widget_desc', $instance['desc'] );
		$style          = empty( $instance['style'] ) ? 'circle' : apply_filters( 'cavada_social_links_widget_style', $instance['style'] );
		$image_url      = empty( $instance['image_url'] ) ? '' : apply_filters( 'cavada_social_links_widget_image_url', $instance['image_url'] );
		$link_face      = empty( $instance['link_face'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_face', $instance['link_face'] );
		$link_twitter   = empty( $instance['link_twitter'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_twitter', $instance['link_twitter'] );
		$link_google    = empty( $instance['link_google'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_google', $instance['link_google'] );
		$link_dribble   = empty( $instance['link_dribble'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_dribble', $instance['link_dribble'] );
		$link_linkedin  = empty( $instance['link_linkedin'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_linkedin', $instance['link_linkedin'] );
		$link_instagram = empty( $instance['link_instagram'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_instagram', $instance['link_instagram'] );
		$link_youtube   = empty( $instance['link_youtube'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_youtube', $instance['link_youtube'] );
		$link_behance   = empty( $instance['link_behance'] ) ? '' : apply_filters( 'cavada_social_links_widget_link_behance', $instance['link_behance'] );
		$icon_color     = empty( $instance['icon_color'] ) ? '' : apply_filters( 'cavada_social_links_widget_icon_color', $instance['icon_color'] );
		echo ent2ncr( $before_widget );

		if ( $image_url ) {
			$src = wp_get_attachment_image_src( $image_url, 'full' );
			echo '<img  src="' . esc_url( $src[0] ) . '" alt="">';
		}
		if ( $desc ) {
			echo '<p>' . $desc . '</p>';
		}
		$icon_style = '';
		if ( $icon_color ) {
			$icon_style = 'style="color:' . $icon_color . ';"';
		}
		?>

		<ul class="cavada_social_link <?php echo esc_attr( $style ) ?>">
			<?php
			if ( $link_face != '' ) {
				echo '<li><a class="face hasTooltip" href="' . esc_url( $link_face ) . '" ><i '.$icon_style.' class="fa fa-facebook"></i></a></li>';
			}
			if ( $link_twitter != '' ) {
				echo '<li><a class="twitter hasTooltip" href="' . esc_url( $link_twitter ) . '"  ><i '.$icon_style.' class="fa fa-twitter"></i></a></li>';
			}
			if ( $link_google != '' ) {
				echo '<li><a class="google hasTooltip" href="' . esc_url( $link_google ) . '"  ><i  '.$icon_style.' class="fa fa-google-plus"></i></a></li>';
			}
			if ( $link_dribble != '' ) {
				echo '<li><a class="dribble hasTooltip" href="' . esc_url( $link_dribble ) . '"  ><i '.$icon_style.' class="fa fa-dribbble"></i></a></li>';
			}
			if ( $link_linkedin != '' ) {
				echo '<li><a class="linkedin hasTooltip" href="' . esc_url( $link_linkedin ) . '"  ><i '.$icon_style.' class="fa fa-linkedin"></i></a></li>';
			}

			if ( $link_instagram != '' ) {
				echo '<li><a class="instagram hasTooltip" href="' . esc_url( $link_instagram ) . '"  ><i '.$icon_style.' class="fa fa-instagram"></i></a></li>';
			}
			if ( $link_youtube != '' ) {
				echo '<li><a class="youtube hasTooltip" href="' . esc_url( $link_youtube ) . '"  ><i '.$icon_style.' class="fa fa-youtube"></i></a></li>';
			}
			if ( $link_behance != '' ) {
				echo '<li><a class="behance hasTooltip" href="' . esc_url( $link_behance ) . '"  ><i '.$icon_style.' class="fa fa-behance"></i></a></li>';
			}
			?>
		</ul>
		<?php
		echo ent2ncr( $after_widget );
	}
}

register_widget( 'cavada_social_links' );


/**
 * Class CAVADA_Widget_Posts
 * List recent posts
 */
class CAVADA_Widget_Posts extends WP_Widget {
	public function __construct() {
		$widget_ops = array( 'classname' => 'CAVADA_Widget_Posts_class', 'description' => 'Show list posts' );
		parent::__construct( 'CAVADA_Widget_Posts', '(Vi) Posts', $widget_ops );
	}

	public function form( $instance ) {
		$defaults = array(
			'title'   => '',
			'limit'   => 3,
			'order'   => 'DESC',
			'orderby' => 'post_date',
			'col'     => 3
		);
		@$instance = wp_parse_args( (array) $instance, $defaults );
		$title   = $instance['title'];
		$limit   = $instance['limit'];
		$order   = $instance['order'];
		$orderby = $instance['orderby'];
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
			<label><?php echo esc_html__( 'Order', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'order' ) ); ?>">
				<option value="DESC" <?php selected( $order, 'DESC' ) ?>><?php esc_html_e( 'DESC', 'cavada' ) ?></option>
				<option value="ASC" <?php selected( $order, 'ASC' ) ?>><?php esc_html_e( 'ASC', 'cavada' ) ?></option>
			</select>
		</p>
		<p>
			<label><?php echo esc_html__( 'Display', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'orderby' ) ); ?>">
				<option value="rand" <?php selected( $orderby, 'rand' ) ?>><?php esc_html_e( 'Random', 'cavada' ) ?></option>
				<option value="comment_count" <?php selected( $orderby, 'comment_count' ) ?>><?php esc_html_e( 'Popular', 'cavada' ) ?></option>
				<option value="post_date" <?php selected( $orderby, 'post_date' ) ?>><?php esc_html_e( 'Date', 'cavada' ) ?></option>
			</select>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['title']   = sanitize_text_field( $new_instance['title'] );
		$instance['limit']   = sanitize_text_field( $new_instance['limit'] );
		$instance['order']   = sanitize_text_field( $new_instance['order'] );
		$instance['orderby'] = sanitize_text_field( $new_instance['orderby'] );

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		echo ent2ncr( $before_widget );
		$title   = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$limit   = isset( $instance['limit'] ) ? $instance['limit'] : 3;
		$order   = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'post_date';
		if ( $title ) {
			echo ent2ncr( $before_title . $title . $after_title );
		}
		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'posts_per_page' => $limit,
			'order'          => $order,
			'orderby'        => $orderby
		);

		$the_query = new WP_Query( $args );
		// The Loop
		if ( $the_query->have_posts() ) {
			?>
			<div class="vi-widget-posts">
				<ul class="list-unstyled">
					<?php while ( $the_query->have_posts() ) {
						$the_query->the_post();
						?>
						<li>
							<?php if ( has_post_thumbnail() ) { ?>
								<a href="<?php echo get_permalink( get_the_ID() ) ?>" class="post-thumbnail">
									<?php echo get_the_post_thumbnail( get_the_ID(), 'thumbnail' ) ?>
								</a>
							<?php } ?>
							<div class="post-description">
								<h6>
									<a href="<?php echo get_permalink( get_the_ID() ) ?>" class="post-link"><?php the_title() ?></a>
								</h6>
								<div class="post-excerpt">
									<i class="fa fa-clock-o fa-fw"></i>
									<?php
									$date_format = get_option( 'date_format', 'F j, Y' );
									echo get_the_date( $date_format );
									//echo '<p>' . excerpt( 6 ) . '</p>' ?>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>

		<?php }
		wp_reset_postdata();
		echo ent2ncr( $after_widget );
	}
}

register_widget( 'CAVADA_Widget_Posts' );


/**
 * Class cavada_Widget_Attributes
 * Add more field in widget
 */
add_action( 'widgets_init', array( 'CAVADA_Widget_Attributes', 'setup' ) );

class CAVADA_Widget_Attributes {
	const VERSION = '0.2.2';

	/**
	 * Initialize plugin
	 */
	public static function setup() {
		if ( is_admin() ) {
			// Add necessary input on widget configuration form
			add_action( 'in_widget_form', array( __CLASS__, '_input_fields' ), 10, 3 );
			// Save widget attributes
			add_filter( 'widget_update_callback', array( __CLASS__, '_save_attributes' ), 10, 4 );
		} else {
			// Insert attributes into widget markup
			add_filter( 'dynamic_sidebar_params', array( __CLASS__, '_insert_attributes' ) );
		}
	}


	/**
	 * Inject input fields into widget configuration form
	 *
	 * @since   0.1
	 * @wp_hook action in_widget_form
	 *
	 * @param object $widget Widget object
	 *
	 * @return NULL
	 */
	public static function _input_fields( $widget, $return, $instance ) {
		$instance = self::_get_attributes( $instance );
		?>
		<p>
			<?php printf(
				'<label for="%s">%s</label>',
				esc_attr( $widget->get_field_id( 'widget-class' ) ),
				esc_html__( 'Extra Class', 'cavada' )
			) ?>
			<?php
			printf(
				'<input type="text" class="widefat" id="%s" name="%s" value="%s" />',
				esc_attr( $widget->get_field_id( 'widget-class' ) ),
				esc_attr( $widget->get_field_name( 'widget-class' ) ),
				esc_attr( $instance['widget-class'] )
			);
			?>
		</p>
		<?php
		return null;
	}


	/**
	 * Get default attributes
	 *
	 * @since 0.1
	 *
	 * @param array $instance Widget instance configuration
	 *
	 * @return array
	 */
	private static function _get_attributes( $instance ) {
		$instance = wp_parse_args(
			$instance,
			array(
				'widget-class' => '',
			)
		);

		return $instance;
	}


	/**
	 * Save attributes upon widget saving
	 *
	 * @since   0.1
	 * @wp_hook filter widget_update_callback
	 *
	 * @param array  $instance     Current widget instance configuration
	 * @param array  $new_instance New widget instance configuration
	 * @param array  $old_instance Old Widget instance configuration
	 * @param object $widget       Widget object
	 *
	 * @return array
	 */
	public static function _save_attributes( $instance, $new_instance, $old_instance, $widget ) {
		$instance['widget-class'] = '';

		// Classes
		if ( ! empty( $new_instance['widget-class'] ) ) {
			$instance['widget-class'] = apply_filters(
				'widget_attribute_classes',
				implode(
					' ',
					array_map(
						'sanitize_html_class',
						explode( ' ', $new_instance['widget-class'] )
					)
				)
			);
		} else {
			$instance['widget-class'] = '';
		}

		return $instance;
	}


	/**
	 * Insert attributes into widget markup
	 *
	 * @since  0.1
	 * @filter dynamic_sidebar_params
	 *
	 * @param array $params Widget parameters
	 *
	 * @return Array
	 */
	public static function _insert_attributes( $params ) {
		global $wp_registered_widgets;

		$widget_id  = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[$widget_id];

		if (
			! isset( $widget_obj['callback'][0] )
			|| ! is_object( $widget_obj['callback'][0] )
		) {
			return $params;
		}

		$widget_options = get_option( $widget_obj['callback'][0]->option_name );
		if ( empty( $widget_options ) ) {
			return $params;
		}

		$widget_num = $widget_obj['params'][0]['number'];
		if ( empty( $widget_options[$widget_num] ) ) {
			return $params;
		}

		$instance = $widget_options[$widget_num];

		// Classes
		if ( ! empty( $instance['widget-class'] ) ) {
			$params[0]['before_widget'] = preg_replace(
				'/class="/',
				sprintf( 'class="%s ', $instance['widget-class'] ),
				$params[0]['before_widget'],
				1
			);
		}

		return $params;
	}
}

require_once( get_template_directory() . '/inc/widgets/ajax-search.php' );
require_once( get_template_directory() . '/inc/widgets/product-category.php' );
require_once( get_template_directory() . '/inc/widgets/single-image.php' );
require_once( get_template_directory() . '/inc/widgets/class-wc-widget-layered-nav.php' );


