<?php /**
 * Class CAVADA_Widget_Product_Category
 * Create ajax search
 */


class CAVADA_Widget_Product_Category extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'CAVADA_Widget_Product_Category_class',
			'description' => 'Show products in category '
		);
		parent::__construct( 'CAVADA_Widget_Product_Category', '(Vi) Product Category', $widget_ops );
	}

	public function form( $instance ) {
		$defaults = array(
			'title'          => '',
			'limit'          => 3,
			'show_image'     => '1',
			'image_position' => 'top',
			'view_all'       => '',
			'category'       => '',
			'order'          => '',
			'orderby'        => '',
			'image_url'      => ''
		);
		@$instance = wp_parse_args( (array) $instance, $defaults );
		$title          = $instance['title'];
		$limit          = $instance['limit'];
		$show_image     = $instance['show_image'];
		$image_position = $instance['image_position'];
		$view_all       = $instance['view_all'];
		$category       = $instance['category'];
		$order          = $instance['order'];
		$orderby        = $instance['orderby'];

		$image = new WidgetImageField( ent2ncr( $this->get_field_name( 'image_url' ) ), '', $instance['image_url'] );
		/*Get Product category*/
		$args       = array(
			'pad_counts'         => 1,
			'show_counts'        => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'menu_order'         => false
		);
		$terms      = get_terms( 'product_cat', $args );
		$categories = array();
		foreach ( $terms as $term ) {
			$categories[$term->term_id] = $term->name;
		}
		?>

		<p>
			<label><?php echo esc_html__( 'Title', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label><?php echo esc_html__( 'Product Category', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'category' ) ); ?>" class="widefat">
				<?php if ( count( $categories ) ) {
					foreach ( $categories as $k => $cate ) {
						?>
						<option value="<?php echo esc_attr( $k ) ?>" <?php selected( $category, $k ) ?>><?php echo ent2ncr( $cate ) ?></option>
					<?php }
				} ?>
			</select>
		</p>
		<p>
			<label><?php echo esc_html__( 'Limit', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>
		<p>
			<label><?php echo esc_html__( 'Order', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'order' ) ); ?>" class="widefat">
				<option value="DESC" <?php selected( $order, 'DESC' ) ?>><?php esc_html_e( 'DESC', 'cavada' ) ?></option>
				<option value="ASC" <?php selected( $order, 'ASC' ) ?>><?php esc_html_e( 'ASC', 'cavada' ) ?></option>
			</select>
		</p>

		<p>
			<label><?php echo esc_html__( 'Order by', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'orderby' ) ); ?>" class="widefat">
				<option value="date" <?php selected( $orderby, 'date' ) ?>><?php esc_html_e( 'Date', 'cavada' ) ?></option>
				<option value="title" <?php selected( $orderby, 'title' ) ?>><?php esc_html_e( 'Title', 'cavada' ) ?></option>
			</select>
		</p>
		<p>
			<label><?php echo esc_html__( 'Show Image', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'show_image' ) ); ?>" class="widefat">
				<option value="0" <?php selected( $show_image, '0' ) ?>><?php esc_html_e( 'No', 'cavada' ) ?></option>
				<option value="1" <?php selected( $show_image, '1' ) ?>><?php esc_html_e( 'Yes', 'cavada' ) ?></option>
			</select>
		</p>

		<p>
			<label><?php echo esc_html__( 'Image Position', 'cavada' ); ?></label>
			<select name="<?php echo ent2ncr( $this->get_field_name( 'image_position' ) ); ?>" class="widefat">
				<option value="top" <?php selected( $image_position, 'top' ) ?>><?php esc_html_e( 'Top', 'cavada' ) ?></option>
				<option value="left" <?php selected( $image_position, 'left' ) ?>><?php esc_html_e( 'Left', 'cavada' ) ?></option>
			</select>
		</p>
		<p>
			<label><?php echo esc_html__( 'Image URL', 'cavada' ); ?></label>
		</p>
		<?php echo ent2ncr( $image->get_field() ) ?>
		<p>
			<label><?php echo esc_html__( 'View All Text', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo ent2ncr( $this->get_field_name( 'view_all' ) ); ?>" type="text" value="<?php echo esc_attr( $view_all ); ?>" />
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance['title']          = sanitize_text_field( $new_instance['title'] );
		$instance['limit']          = sanitize_text_field( $new_instance['limit'] );
		$instance['category']       = sanitize_text_field( $new_instance['category'] );
		$instance['order']          = sanitize_text_field( $new_instance['order'] );
		$instance['orderby']        = sanitize_text_field( $new_instance['orderby'] );
		$instance['show_image']     = sanitize_text_field( $new_instance['show_image'] );
		$instance['image_position'] = sanitize_text_field( $new_instance['image_position'] );
		$instance['view_all']       = sanitize_text_field( $new_instance['view_all'] );
		$instance['image_url']      = sanitize_text_field( $new_instance['image_url'] );

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		echo ent2ncr( $before_widget );

		$title          = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$limit          = isset( $instance['limit'] ) ? $instance['limit'] : '3';
		$show_image     = isset( $instance['show_image'] ) ? $instance['show_image'] : '1';
		$image_position = isset( $instance['image_position'] ) ? $instance['image_position'] : 'top';
		$view_all       = isset( $instance['view_all'] ) ? $instance['view_all'] : '';
		$category       = isset( $instance['category'] ) ? $instance['category'] : '';
		$order          = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
		$orderby        = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
		$image_url      = isset( $instance['image_url'] ) ? $instance['image_url'] : '';

		/*Get products*/
		$query_args = array(
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'orderby'        => $orderby,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $category
				)
			)
		);
		$the_query  = new WP_Query( $query_args );
		if ( $title ) {
			echo "<h3 class='widget-title'>{$title}</h3>";
		}
		$col = 12;
		if ( $image_position == 'left' ) {
			$col = 6;
		}
		?>
		<div class="vi-product-category-wrapper row">
			<div class="col-sm-<?php echo esc_attr( $col ) ?>">
				<?php if ( $show_image && $image_url ) {
					$term = get_term( $category );
					$src  = wp_get_attachment_image_url( $image_url, 'medium' );

					?>
					<a href="<?php echo get_term_link( $term, 'product_cat' ) ?>">
						<img alt="<?php echo esc_attr($term->name) ?>" class="vi-product-category-img" style="max-width: 100%" data-default-src="<?php echo esc_url( $src ) ?>" src="<?php echo esc_url( $src ) ?>">
					</a>
				<?php } ?>
			</div>
			<div class="col-sm-<?php echo esc_attr( $col ) ?>">
				<ul class="vi-product-list">
					<?php if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post(); ?>

							<li class="vi-product-img" data-image="<?php echo get_the_post_thumbnail_url( '', 'medium' ) ?>">
								<a href="<?php echo the_permalink() ?>"> <?php the_title() ?> </a>
							</li>
						<?php }
					}
					wp_reset_postdata();
					if ( $view_all && $category ) { ?>
						<li class="view-all">
							<?php if ( $category ) {
								$term = get_term( $category );
								?>
								<a href="<?php echo get_term_link( $term, 'product_cat' ) ?>" class="btn btn-primary"><?php echo esc_html( $view_all ) ?></a>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<?php echo ent2ncr( $after_widget );
	}
}

register_widget( 'CAVADA_Widget_Product_Category' );