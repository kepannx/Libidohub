<?php

/*
Class Name: WP_SM_Admin_Settings
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2016 villatheme.com. All rights reserved.
*/

class VI_WNOTIFICATION_Admin_Settings {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'save_meta_boxes' ) );

	}

	/**
	 * Get files in directory
	 *
	 * @param $dir
	 *
	 * @return array|bool
	 */
	static private function scan_dir( $dir ) {
		$ignored = array( '.', '..', '.svn', '.htaccess', 'test-log.log' );

		$files = array();
		foreach ( scandir( $dir ) as $file ) {
			if ( in_array( $file, $ignored ) ) {
				continue;
			}
			$files[$file] = filemtime( $dir . '/' . $file );
		}
		arsort( $files );
		$files = array_keys( $files );

		return ( $files ) ? $files : false;
	}

	private function stripslashes_deep( $value ) {
		$value = is_array( $value ) ?
			array_map( 'stripslashes_deep', $value ) :
			stripslashes( $value );

		return $value;
	}

	/**
	 * Save post meta
	 *
	 * @param $post
	 *
	 * @return bool
	 */
	public function save_meta_boxes() {
		if ( ! isset( $_POST['_wnotification_nonce'] ) || ! isset( $_POST['wnotification_params'] ) ) {
			return false;
		}
		if ( ! wp_verify_nonce( $_POST['_wnotification_nonce'], 'wnotification_save_email_settings' ) ) {
			return false;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}
		$_POST['wnotification_params']['conditional_tags'] = $this->stripslashes_deep( $_POST['wnotification_params']['conditional_tags'] );
		update_option( '_woocommerce_notification_prefix', substr( md5( date( "YmdHis" ) ), 0, 10 ) );
		update_option( 'wnotification_params', $_POST['wnotification_params'] );
	}

	/**
	 * Set Nonce
	 * @return string
	 */
	protected static function set_nonce() {
		return wp_nonce_field( 'wnotification_save_email_settings', '_wnotification_nonce' );
	}

	/**
	 * Set field in meta box
	 *
	 * @param      $field
	 * @param bool $multi
	 *
	 * @return string
	 */
	protected static function set_field( $field, $multi = false ) {
		if ( $field ) {
			if ( $multi ) {
				return 'wnotification_params[' . $field . '][]';
			} else {
				return 'wnotification_params[' . $field . ']';
			}
		} else {
			return '';
		}
	}

	/**
	 * Get Post Meta
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	public static function get_field( $field, $default = '' ) {
		$params = get_option( 'wnotification_params', array() );
		if ( isset( $params[$field] ) && $field ) {
			return $params[$field];
		} else {
			return $default;
		}
	}

	/**
	 * Get list shortcode
	 * @return array
	 */
	public static function page_callback() { ?>
		<div class="wrap woocommerce-notification">
			<h2><?php esc_attr_e( 'WooCommerce Notification Settings', 'wp-send-end' ) ?></h2>
			<form method="post" action="" class="vi-ui form">
				<?php echo ent2ncr( self::set_nonce() ) ?>

				<div class="vi-ui attached tabular menu">
					<div class="item active" data-tab="general"><?php esc_html_e( 'General', 'woocommerce-notification' ) ?></div>
					<div class="item" data-tab="design"><?php esc_html_e( 'Design', 'woocommerce-notification' ) ?></div>
					<div class="item" data-tab="products"><?php esc_html_e( 'Products', 'woocommerce-notification' ) ?></div>
					<div class="item" data-tab="time"><?php esc_html_e( 'Time', 'woocommerce-notification' ) ?></div>
					<div class="item" data-tab="sound"><?php esc_html_e( 'Sound', 'woocommerce-notification' ) ?></div>
					<div class="item" data-tab="logs"><?php esc_html_e( 'Report', 'woocommerce-notification' ) ?></div>
				</div>
				<div class="vi-ui bottom attached tab segment active" data-tab="general">
					<!-- Tab Content !-->
					<table class="optiontable form-table">
						<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="<?php echo self::set_field( 'enable' ) ?>">
									<?php esc_html_e( 'Enable', 'woocommerce-notification' ) ?>
								</label>
							</th>
							<td>
								<div class="vi-ui toggle checkbox">
									<input id="<?php echo self::set_field( 'enable' ) ?>" type="checkbox" <?php checked( self::get_field( 'enable' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'enable' ) ?>" />
									<label></label>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="<?php echo self::set_field( 'enable_mobile' ) ?>">
									<?php esc_html_e( 'Mobile', 'woocommerce-notification' ) ?>
								</label>
							</th>
							<td>
								<div class="vi-ui toggle checkbox">
									<input id="<?php echo self::set_field( 'enable_mobile' ) ?>" type="checkbox" <?php checked( self::get_field( 'enable_mobile' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'enable_mobile' ) ?>" />
									<label></label>
								</div>
								<p class="description"><?php esc_html_e( 'Notification will show on mobile and responsive.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php esc_html_e( 'Conditional Tags', 'woocommerce-notification' ) ?>
							</th>
							<td>
								<input type="text" value="<?php echo htmlentities( self::get_field( 'conditional_tags' ) ) ?>" name="<?php echo self::set_field( 'conditional_tags' ) ?>" />
								<p class="description"><?php esc_html_e( 'Lets you control on which pages appear using WP\'s conditional tags.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<!--Products-->
				<div class="vi-ui bottom attached tab segment" data-tab="products">
					<!-- Tab Content !-->
					<table class="optiontable form-table">
						<tbody>

						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Show Products', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<select name="<?php echo self::set_field( 'archive_page' ) ?>" class="vi-ui fluid dropdown">
									<option <?php selected( self::get_field( 'archive_page' ), 0 ) ?> value="0"><?php esc_attr_e( 'Get from Billing', 'woocommerce-notification' ) ?></option>
									<option <?php selected( self::get_field( 'archive_page' ), 1 ) ?> value="1"><?php esc_attr_e( 'Select Products', 'woocommerce-notification' ) ?></option>
								</select>
								<p class="description"><?php esc_html_e( 'You can use real products in order or special product what you want up sells.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="get_from_billing hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Order Time', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="fields">
									<div class="twelve wide field">
										<input type="number" value="<?php echo self::get_field( 'order_threshold_num', 30 ) ?>" name="<?php echo self::set_field( 'order_threshold_num' ) ?>" />
									</div>
									<div class="two wide field">
										<select name="<?php echo self::set_field( 'order_threshold_time' ) ?>" class="vi-ui fluid dropdown">
											<option <?php selected( self::get_field( 'order_threshold_time' ), 0 ) ?> value="0"><?php esc_attr_e( 'Hours', 'woocommerce-notification' ) ?></option>
											<option <?php selected( self::get_field( 'order_threshold_time' ), 1 ) ?> value="1"><?php esc_attr_e( 'Days', 'woocommerce-notification' ) ?></option>
										</select>
									</div>
								</div>
								<p class="description"><?php esc_html_e( 'Products in this recently time will get from order.  ', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="select_product hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Select Products', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<?php
								$args     = array(
									'post_type'      => 'product',
									'post_status'    => 'publish',
									'posts_per_page' => - 1,
									'order'          => 'ASC',
									'orderby'        => 'title'
								);
								$products = new WP_Query( $args );

								?>
								<select multiple="multiple" name="<?php echo self::set_field( 'archive_products', true ) ?>" class="vi-ui fluid dropdown" placeholder="<?php esc_attr_e( 'Please select products', 'woocommerce-notification' ) ?>">
									<?php while ( $products->have_posts() ) {
										$products->the_post();
										$arg_products = self::get_field( 'archive_products', array() );
										$selected     = '';
										if ( in_array( get_the_ID(), $arg_products ) ) {
											$selected = 'selected="selected"';
										}
										?>
										<option <?php echo $selected; ?> value="<?php echo get_the_ID() ?>"><?php echo esc_html( get_the_title() ) ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr valign="top" class="select_product hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Virtual First Name', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<textarea name="<?php echo self::set_field( 'virtual_name' ) ?>"><?php echo self::get_field( 'virtual_name' ) ?></textarea>
								<p class="description"><?php esc_html_e( 'Virtual first name what will show on notification. Each first name on a line.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="select_product hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Virtual Time', 'woocommerce-notification' ) ?></label></th>
							<td>
								<div class="vi-ui form">
									<div class="inline fields">
										<input type="number" name="<?php echo self::set_field( 'virtual_time' ) ?>" value="<?php echo self::get_field( 'virtual_time', '10' ) ?>" />
										<label><?php esc_html_e( 'hours', 'woocommerce-notification' ) ?></label>
									</div>
								</div>
								<p class="description"><?php esc_html_e( 'Time will auto get random in this time threshold ago.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="select_product hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Address', 'woocommerce-notification' ) ?></label></th>
							<td>
								<select name="<?php echo self::set_field( 'country' ) ?>" class="vi-ui fluid dropdown">
									<option <?php selected( self::get_field( 'country' ), 0 ) ?> value="0"><?php esc_attr_e( 'Auto Detect', 'woocommerce-notification' ) ?></option>
									<option <?php selected( self::get_field( 'country' ), 1 ) ?> value="1"><?php esc_attr_e( 'Virtual', 'woocommerce-notification' ) ?></option>
								</select>
								<p class="description"><?php esc_html_e( 'You can use auto detect address or make virtual address of customer.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="virtual_address hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Virtual City', 'woocommerce-notification' ) ?></label></th>
							<td>
								<textarea name="<?php echo self::set_field( 'virtual_city' ) ?>"><?php echo self::get_field( 'virtual_city' ) ?></textarea>
								<p class="description"><?php esc_html_e( 'Virtual city name what will show on notification. Each city name on a line.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="virtual_address hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Virtual Country', 'woocommerce-notification' ) ?></label></th>
							<td>
								<input type="text" name="<?php echo self::set_field( 'virtual_country' ) ?>" value="<?php echo self::get_field( 'virtual_country' ) ?>" />
								<p class="description"><?php esc_html_e( 'Virtual country name what will show on notification.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="detect_address hidden">
							<th scope="row">
								<label><?php esc_html_e( 'Ipfind Auth Key', 'woocommerce-notification' ) ?></label></th>
							<td>
								<input type="text" name="<?php echo self::set_field( 'ipfind_auth_key' ) ?>" value="<?php echo self::get_field( 'ipfind_auth_key', '2644131a-a1e7-4681-a923-8069a9c9ff2b' ) ?>" />
								<p class="description"><?php esc_html_e( 'When you use detect IP, please enter your auth key. You can get at https://ipfind.co', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>

						</tbody>
					</table>
				</div>
				<!-- Design !-->
				<div class="vi-ui bottom attached tab segment" data-tab="design">
					<!-- Tab Content !-->
					<table class="optiontable form-table">
						<tbody>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Message purchased', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<textarea name="<?php echo self::set_field( 'message_purchased' ) ?>"><?php echo strip_tags( self::get_field( 'message_purchased', 'Someone in {city}, {country} purchased a {product_with_link} {time_ago}' ) ) ?></textarea>
								<ul class="description" style="list-style: none">
									<li>
										<span>{first_name}</span> - <?php esc_html_e( 'Customer first name', 'woocommerce-notification' ) ?>
									</li>
									<li>
										<span>{city}</span> - <?php esc_html_e( 'Customer city', 'woocommerce-notification' ) ?>
									</li>
									<li>
										<span>{country}</span> - <?php esc_html_e( 'Customer country', 'woocommerce-notification' ) ?>
									</li>
									<li>
										<span>{product}</span> - <?php esc_html_e( 'Product title', 'woocommerce-notification' ) ?>
									</li>
									<li>
										<span>{product_with_link}</span> - <?php esc_html_e( 'Product title with link', 'woocommerce-notification' ) ?>
									</li>
									<li>
										<span>{time_ago}</span> - <?php esc_html_e( 'Time after purchase', 'woocommerce-notification' ) ?>
									</li>
								</ul>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Message checkout', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<textarea name="<?php echo self::set_field( 'message_checkout' ) ?>"><?php echo self::get_field( 'message_checkout' ) ?></textarea>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Highlight color', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<input data-ele="highlight" type="text" class="color-picker" name="<?php echo self::set_field( 'highlight_color' ) ?>" value="<?php echo self::get_field( 'highlight_color', '#000000' ) ?>" style="background-color: <?php echo esc_attr( self::get_field( 'highlight_color', '#000000' ) ) ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Text color', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<input data-ele="textcolor" style="background-color: <?php echo esc_attr( self::get_field( 'text_color', '#000000' ) ) ?>" type="text" class="color-picker" name="<?php echo self::set_field( 'text_color' ) ?>" value="<?php echo self::get_field( 'text_color', '#000000' ) ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Background color', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<input style="background-color: <?php echo esc_attr( self::get_field( 'background_color', '#ffffff' ) ) ?>" data-ele="backgroundcolor" type="text" class="color-picker" name="<?php echo self::set_field( 'background_color' ) ?>" value="<?php echo self::get_field( 'background_color', '#ffffff' ) ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Image Position', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<select name="<?php echo self::set_field( 'image_position' ) ?>" class="vi-ui fluid dropdown">
									<option <?php selected( self::get_field( 'image_position' ), 0 ) ?> value="0"><?php esc_attr_e( 'Left', 'woocommerce-notification' ) ?></option>
									<option <?php selected( self::get_field( 'image_position' ), 1 ) ?> value="1"><?php esc_attr_e( 'Right', 'woocommerce-notification' ) ?></option>
								</select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Position', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui form">
									<div class="fields">
										<div class="four wide field">
											<img src="<?php echo VI_WNOTIFICATION_IMAGES . 'position_1.jpg' ?>" class="vi-ui centered medium image middle aligned " />
											<div class="vi-ui toggle checkbox center aligned segment">
												<input id="<?php echo self::set_field( 'position' ) ?>" type="radio" <?php checked( self::get_field( 'position', 0 ), 0 ) ?> tabindex="0" class="hidden" value="0" name="<?php echo self::set_field( 'position' ) ?>" />
												<label><?php esc_attr_e( 'Bottom left', 'woocommerce-notification' ) ?></label>
											</div>

										</div>
										<div class="four wide field">
											<img src="<?php echo VI_WNOTIFICATION_IMAGES . 'position_2.jpg' ?>" class="vi-ui centered medium image middle aligned " />
											<div class="vi-ui toggle checkbox center aligned segment">
												<input id="<?php echo self::set_field( 'position' ) ?>" type="radio" <?php checked( self::get_field( 'position' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'position' ) ?>" />
												<label><?php esc_attr_e( 'Bottom right', 'woocommerce-notification' ) ?></label>
											</div>
										</div>
										<div class="four wide field">
											<img src="<?php echo VI_WNOTIFICATION_IMAGES . 'position_4.jpg' ?>" class="vi-ui centered medium image middle aligned " />
											<div class="vi-ui toggle checkbox center aligned segment">
												<input id="<?php echo self::set_field( 'position' ) ?>" type="radio" <?php checked( self::get_field( 'position' ), 2 ) ?> tabindex="0" class="hidden" value="2" name="<?php echo self::set_field( 'position' ) ?>" />
												<label><?php esc_attr_e( 'Top left', 'woocommerce-notification' ) ?></label>
											</div>
										</div>
										<div class="four wide field">
											<img src="<?php echo VI_WNOTIFICATION_IMAGES . 'position_3.jpg' ?>" class="vi-ui centered medium image middle aligned " />
											<div class="vi-ui toggle checkbox center aligned segment">
												<input id="<?php echo self::set_field( 'position' ) ?>" type="radio" <?php checked( self::get_field( 'position' ), 3 ) ?> tabindex="0" class="hidden" value="3" name="<?php echo self::set_field( 'position' ) ?>" />
												<label><?php esc_attr_e( 'Top right', 'woocommerce-notification' ) ?></label>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="<?php echo self::set_field( 'show_close_icon' ) ?>">
									<?php esc_html_e( 'Show Close Icon', 'woocommerce-notification' ) ?>
								</label>
							</th>
							<td>
								<div class="vi-ui toggle checkbox">
									<input id="<?php echo self::set_field( 'show_close_icon' ) ?>" type="checkbox" <?php checked( self::get_field( 'show_close_icon' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'show_close_icon' ) ?>" />
									<label></label>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
					<?php
					$class = array();
					switch ( self::get_field( 'position' ) ) {
						case 1:
							$class[] = 'bottom_right';
							break;
						case 2:
							$class[] = 'top_left';
							break;
						case 3:
							$class[] = 'top_right';
							break;
						default:
							$class[] = '';
					}
					$class[] = self::get_field( 'image_position' ) ? 'img-right' : '';
					?>
					<div style="display: block;" class="customized  <?php echo esc_attr( implode( ' ', $class ) ) ?>" id="message-purchased">
						<img src="<?php echo esc_url( VI_WNOTIFICATION_IMAGES . 'demo-image.jpg' ) ?>">

						<p>Joe Doe in London, England purchased a
							<a href="#">Ninja Silhouette</a>
							<small>About 9 hours ago</small>
						</p>
						<span id="notify-close"></span>

					</div>
				</div>
				<!-- Time !-->
				<div class="vi-ui bottom attached tab segment" data-tab="time">
					<!-- Tab Content !-->
					<table class="optiontable form-table">
						<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="<?php echo self::set_field( 'loop' ) ?>"><?php esc_html_e( 'Loop', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui toggle checkbox">
									<input id="<?php echo self::set_field( 'loop' ) ?>" type="checkbox" <?php checked( self::get_field( 'loop' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'loop' ) ?>" />
									<label></label>
								</div>
							</td>
						</tr>
						<tr valign="top" class="hidden time_loop">
							<th scope="row">
								<label><?php esc_html_e( 'Next time display', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui form">
									<div class="inline fields">
										<input type="number" name="<?php echo self::set_field( 'next_time' ) ?>" value="<?php echo self::get_field( 'next_time', 60 ) ?>" />
										<label><?php esc_html_e( 'seconds', 'woocommerce-notification' ) ?></label>
									</div>
								</div>
								<p class="description"><?php esc_html_e( 'Time to show your notification next time.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top" class="hidden time_loop">
							<th scope="row">
								<label><?php esc_html_e( 'Notification per page', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<input type="number" name="<?php echo self::set_field( 'notification_per_page' ) ?>" value="<?php echo self::get_field( 'notification_per_page', 30 ) ?>" />
								<p class="description"><?php esc_html_e( 'Quantity notifications on a page.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Initial delay', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui form">
									<div class="inline fields">
										<input type="number" name="<?php echo self::set_field( 'initial_delay' ) ?>" value="<?php echo self::get_field( 'initial_delay', 0 ) ?>" />
										<label><?php esc_html_e( 'seconds', 'woocommerce-notification' ) ?></label>
									</div>
								</div>
								<p class="description"><?php esc_html_e( 'When your site load, notification will wait for this time to show.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Display time', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui form">
									<div class="inline fields">
										<input type="number" name="<?php echo self::set_field( 'display_time' ) ?>" value="<?php echo self::get_field( 'display_time', 5 ) ?>" />
										<label><?php esc_html_e( 'seconds', 'woocommerce-notification' ) ?></label>
									</div>
								</div>
								<p class="description"><?php esc_html_e( 'Time your notification display.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<!-- Sound !-->
				<div class="vi-ui bottom attached tab segment" data-tab="sound">
					<!-- Tab Content !-->
					<table class="optiontable form-table">
						<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="<?php echo self::set_field( 'sound_enable' ) ?>"><?php esc_html_e( 'Enable', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui toggle checkbox">
									<input id="<?php echo self::set_field( 'sound_enable' ) ?>" type="checkbox" <?php checked( self::get_field( 'sound_enable' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'sound_enable' ) ?>" />
									<label></label>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label><?php esc_html_e( 'Sound', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<?php
								$sounds = self::scan_dir( VI_WNOTIFICATION_SOUNDS );
								?>
								<select name="<?php echo self::set_field( 'sound' ) ?>" class="vi-ui fluid dropdown">
									<?php foreach ( $sounds as $sound ) { ?>
										<option <?php selected( self::get_field( 'sound', 'cool' ), $sound ) ?> value="<?php echo esc_attr( $sound ) ?>"><?php echo esc_html( $sound ) ?></option>
									<?php } ?>
								</select>
								<p class="description"><?php echo esc_html__( 'Please select sound. Notification rings when show.', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<!-- Logs !-->
				<div class="vi-ui bottom attached tab segment" data-tab="logs">
					<!-- Tab Content !-->
					<table class="optiontable form-table">
						<tbody>
						<tr valign="top">
							<th scope="row">
								<label for="<?php echo self::set_field( 'save_logs' ) ?>"><?php esc_html_e( 'Save Logs', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui toggle checkbox">
									<input id="<?php echo self::set_field( 'save_logs' ) ?>" type="checkbox" <?php checked( self::get_field( 'save_logs' ), 1 ) ?> tabindex="0" class="hidden" value="1" name="<?php echo self::set_field( 'save_logs' ) ?>" />
									<label></label>
								</div>
							</td>
						</tr>
						<tr valign="top" class="hidden save_logs">
							<th scope="row">
								<label><?php esc_html_e( 'History time', 'woocommerce-notification' ) ?></label>
							</th>
							<td>
								<div class="vi-ui form">
									<div class="inline fields">
										<input type="text" name="<?php echo self::set_field( 'history_time' ) ?>" value="<?php echo self::get_field( 'history_time', 30 ) ?>" />
										<label><?php esc_html_e( 'days', 'woocommerce-notification' ) ?></label>
									</div>
								</div>
								<p class="description"><?php echo esc_html__( 'Logs will be saved at ', 'woocommerce-notification' ) . VI_WNOTIFICATION_CACHE . esc_html__( ' in time', 'woocommerce-notification' ) ?></p>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<p>
					<input type="submit" class="button button-primary" value=" <?php esc_html_e( 'Save', 'wp-send-admin' ) ?> " />
				</p>
			</form>
		</div>
	<?php }
} ?>