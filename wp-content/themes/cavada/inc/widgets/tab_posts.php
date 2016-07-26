<?php

/**
 * Class VI_VC_ADDON_Widget_Tab_Posts
 */

register_widget( 'VI_Widget_Tab_Posts' );

class VI_Widget_Tab_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname'   => 'VI_Widget_Tab_Posts_class',
			'description' => 'Show popular posts and comments'
		);
		parent::__construct( 'VI_Widget_Tab_Posts', '(Vi) Tab Posts', $widget_ops );
	}

	function form( $instance ) {

		$defaults = array(
			'limit'   => 3,
			'order'   => 'DESC',
			'orderby' => 'post_date',
			'col'     => 3
		);
		@$instance = wp_parse_args( (array) $instance, $defaults );
		$limit   = $instance['limit'];
		$order   = $instance['order'];
		$orderby = $instance['orderby'];
		?>


		<p>
			<label><?php echo esc_html__( 'Limit', 'cavada' ); ?></label>
			<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'limit' )); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>

		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['limit'] = sanitize_text_field( $new_instance['limit'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		echo ent2ncr( $before_widget );
		$limit = isset( $instance['limit'] ) ? $instance['limit'] : 3;
		$args  = array(
			'post_status'    => 'publish',
			'post_type'      => 'post',
			'posts_per_page' => $limit
		);

		$the_query = new WP_Query( $args );
		// The Loop
		if ( $the_query->have_posts() ) {
			?>
			<div class="vi-widget-tab-posts">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#vi-posts-popular"><?php echo esc_html__( 'Popuplar', 'cavada' ) ?></a>
					</li>

					<li role="presentation">
						<a href="#vi-posts-comments"><?php echo esc_html__( 'Comments', 'cavada' ) ?></a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="vi-posts-popular" role="tabpanel" class="tab-pane fade in active">
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
										<?php
										echo '<div class="widget-meta">';
										echo '<span class="article-date"><i class="fa fa-clock-o"></i> <span class="day">' . get_the_date( get_option( 'date_format' ) ) . '</span></span>';
										echo '<span class="view"><i class="fa fa-eye"></i>' . get_blog_visitor() . ' (' . esc_html__( 'Views', 'cavada' ) . ')</span>';
										echo '</div>';
										?>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>

					<div id="vi-posts-comments" role="tabpanel" class="tab-pane fade">
						<?php
						$args     = array(
							'number' => $limit
						);
						$comments = get_comments( $args );
						?>
						<ul class="list-unstyled">
							<?php if ( count( $comments ) ) {
								foreach ( $comments as $comment ) {
									?>
									<li>
										<h6>
											<?php echo '<span>' . $comment->comment_author . '</span> ' . esc_html__( 'commented on ', 'cavada' ) . '<span>' . $comment->post_title . '</span>' ?>
										</h6>
										<?php
										$text  = $comment->comment_content;
										$count = 10;
										$text  = strip_shortcodes( $text );
										$text  = apply_filters( 'the_content', $text );
										$text  = str_replace( ']]>', ']]>', $text );
										$text  = strip_tags( $text );
										$text  = nl2br( $text );
										$words = explode( ' ', $text, $count + 1 );
										if ( count( $words ) > $count ) {
											array_pop( $words );
											array_push( $words, '' );
											$text = implode( ' ', $words );
										}
										echo ent2ncr($text);
										?>
									</li>
								<?php }
							} ?>
						</ul>
					</div>
				</div>
			</div>

		<?php }
		wp_reset_postdata();
		echo ent2ncr( $after_widget );
	}
}