<?php

/**
 * Class VI_WNOTIFICATION_Frontend_Notify
 */
class VI_WNOTIFICATION_Frontend_Notify {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'init_scripts' ) );

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

		add_action( 'wp_ajax_nopriv_woonotification_get_product', array( $this, 'product_html' ) );
		add_action( 'wp_ajax_woonotification_get_product', array( $this, 'product_html' ) );

		add_action( 'woocommerce_order_status_completed', array( $this, 'woocommerce_order_status_completed' ) );
		add_action( 'woocommerce_order_status_pending', array( $this, 'woocommerce_order_status_completed' ) );
		/*WordPress lower 4.5*/
		if ( woocommerce_notification_wpversion() ) {
			add_action( 'wp_print_scripts', array( $this, 'custom_script' ) );
		}
	}

	public function woocommerce_order_status_completed( $order_id ) {
		$params       = new VI_WNOTIFICATION_Admin_Settings();
		$archive_page = $params->get_field( 'archive_page' );
		if ( ! $archive_page ) {
			update_option( '_woocommerce_notification_prefix', substr( md5( date( "YmdHis" ) ), 0, 10 ) );
		}
	}

	/**
	 * Script in Wp 4.2
	 */
	public function custom_script() {
		$script = 'var wnotification_ajax_url = "' . admin_url( 'admin-ajax.php' ) . '"'; ?>
		<script type="text/javascript">
			<?php echo $script; ?>
		</script>
	<?php }

	/**
	 * Show HTML on front end
	 */
	public function product_html() {
		$params        = new VI_WNOTIFICATION_Admin_Settings();
		$enable        = $params->get_field( 'enable' );
		$logic_value   = $params->get_field( 'conditional_tags' );
		$enable_mobile = $params->get_field( 'enable_mobile' );
		// Include and instantiate the class.
		$detect = new Mobile_Detect;

		// Any mobile device (phones or tablets).
		if ( $detect->isMobile() ) {
			if ( ! $enable_mobile ) {
				return false;
			}
		}
		if ( $logic_value ) {
			if ( stristr( $logic_value, "return" ) === false ) {
				$logic_value = "return (" . $logic_value . ");";
			}
			if ( ! eval( $logic_value ) ) {
				return;
			}
		}
		if ( $enable ) {
			echo $this->show_product();
		}

		die;
	}

	/**
	 * Detect IP
	 */
	public function init() {
		$params         = new VI_WNOTIFICATION_Admin_Settings();
		$detect_country = $params->get_field( 'country' );
		$detect         = isset( $_COOKIE['ip'] ) ? 1 : 0;
		if ( ! $detect_country && ! $detect ) {
			$data            = $this->geoCheckIP( $this->getIP() );
			$data['country'] = $_SESSION['country'] = isset( $data['country'] ) ? $data['country'] : 'United States';
			$data['city']    = $_SESSION['city'] = isset( $data['city'] ) ? $data['city'] : 'New York City';
			$_SESSION['ip']  = 1;
			setcookie( 'ip', 1, time() + 7 * 60 * 60 * 24, '/' );
			setcookie( 'country', $data['country'], time() + 7 * 60 * 60 * 24, '/' );
			setcookie( 'city', $data['city'], time() + 7 * 60 * 60 * 24, '/' );
		}
		/*Make cache folder*/
		if ( ! is_dir( VI_WNOTIFICATION_CACHE ) ) {
			mkdir( VI_WNOTIFICATION_CACHE, '0755', true );
			chmod( VI_WNOTIFICATION_CACHE, 0755 );
			file_put_contents(
				VI_WNOTIFICATION_CACHE . '.htaccess', '<IfModule !mod_authz_core.c>
Order deny,allow
Deny from all
</IfModule>
<IfModule mod_authz_core.c>
  <RequireAll>
    Require all denied
  </RequireAll>
</IfModule>
'
			);
		}

	}


	/**
	 * Show HTML code
	 */
	public function wp_footer() {
		$params        = new VI_WNOTIFICATION_Admin_Settings();
		$enable        = $params->get_field( 'enable' );
		$logic_value   = $params->get_field( 'conditional_tags' );
		$sound_enable  = $params->get_field( 'sound_enable' );
		$sound         = $params->get_field( 'sound' );
		$enable_mobile = $params->get_field( 'enable_mobile' );
		// Include and instantiate the class.
		$detect = new Mobile_Detect;

		// Any mobile device (phones or tablets).
		if ( $detect->isMobile() ) {
			if ( ! $enable_mobile ) {
				return false;
			}
		}
		if ( $logic_value ) {
			if ( stristr( $logic_value, "return" ) === false ) {
				$logic_value = "return (" . $logic_value . ");";
			}
			if ( ! eval( $logic_value ) ) {
				return;
			}
		}
		if ( $enable ) {
			echo $this->show_product();
		}

		if ( $sound_enable ) { ?>
			<audio id="woocommerce-notification-audio">
				<source src="<?php echo esc_url( VI_WNOTIFICATION_SOUNDS_URL . $sound ) ?>"></source>
			</audio>
		<?php }
	}

	/**
	 * Add Script and Style
	 */
	function init_scripts() {
		$params = new VI_WNOTIFICATION_Admin_Settings();

		/*Conditional tags*/
		$logic_value = $params->get_field( 'conditional_tags' );

		if ( $logic_value ) {
			if ( stristr( $logic_value, "return" ) === false ) {
				$logic_value = "return (" . $logic_value . ");";
			}
			if ( ! eval( $logic_value ) ) {
				return;
			}
		}

		wp_enqueue_style( 'woocommerce-notification', VI_WNOTIFICATION_CSS . 'woocommerce-notification.css', array(), VI_WNOTIFICATION_VERSION );

		wp_enqueue_script( 'woocommerce-notification', VI_WNOTIFICATION_JS . 'woocommerce-notification.js', array( 'jquery' ), VI_WNOTIFICATION_VERSION );

		/*Custom*/

		$highlight_color  = $params->get_field( 'highlight_color' );
		$text_color       = $params->get_field( 'text_color' );
		$background_color = $params->get_field( 'background_color' );
		$custom_css       = "
                #message-purchased{
                        background-color: {$background_color} !important;
                        color:{$text_color} !important;
                }
                 #message-purchased a{
                        color:{$highlight_color} !important;
                }
                ";

		wp_add_inline_style( 'woocommerce-notification', $custom_css );

		/*Add ajax url*/
		/*Custom*/
		if ( woocommerce_notification_wpversion() ) {
			return;
		}
		$script = 'var wnotification_ajax_url = "' . admin_url( 'admin-ajax.php' ) . '"';
		wp_add_inline_script( 'woocommerce-notification', $script );
	}

	/**
	 * Show product
	 *
	 * @param $product_id Product ID
	 *
	 */
	protected function show_product() {
		$params                = new VI_WNOTIFICATION_Admin_Settings();
		$image_position        = $params->get_field( 'image_position' );
		$position              = $params->get_field( 'position' );
		$loop                  = $params->get_field( 'loop' );
		$initial_delay         = $params->get_field( 'initial_delay' );
		$notification_per_page = $params->get_field( 'notification_per_page' );
		$display_time          = $params->get_field( 'display_time' );
		$next_time             = $params->get_field( 'next_time' );
		$class                 = array();
		$class[]               = $image_position ? 'img-right' : '';
		switch ( $position ) {
			case  1:
				$class[] = 'bottom_right';
				break;
			case  2:
				$class[] = 'top_left';
				break;
			case  3:
				$class[] = 'top_right';
				break;
		}
		ob_start();
		?>
		<div id="message-purchased" class="customized <?php echo implode( ' ', $class ) ?>" style="display: none;"
			 data-loop="<?php echo esc_attr( $loop ) ?>"
			 data-initial_delay="<?php echo esc_attr( $initial_delay ) ?>"
			 data-notification_per_page="<?php echo esc_attr( $notification_per_page ) ?>"
			 data-display_time="<?php echo esc_attr( $display_time ) ?>"
			 data-next_time="<?php echo esc_attr( $next_time ) ?>">

			<?php echo $this->message_purchased() ?>

		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Message purchased
	 *
	 * @param $product_id
	 */
	protected function message_purchased() {
		$params            = new VI_WNOTIFICATION_Admin_Settings();
		$message_purchased = $params->get_field( 'message_purchased' );
		$show_close_icon   = $params->get_field( 'show_close_icon' );
		$archive_page      = $params->get_field( 'archive_page' );

		$messsage = '';
		$keys     = array(
			'{first_name}',
			'{city}',
			'{country}',
			'{product}',
			'{product_with_link}',
			'{time_ago}'
		);


		$product = $this->get_product();

		if ( $product ) {
			$product_id = $product['id'];
		} else {
			return false;
		}

		$first_name = trim( $product['first_name'] );
		$city       = trim( $product['city'] );
		$country    = trim( $product['country'] );
		$time       = trim( $product['time'] );
		if ( ! $archive_page ) {
			$time = $this->time_substract( $time );
		}
		$product = esc_html( get_the_title( $product_id ) );
		$link    = get_permalink( $product_id );
		$link    = wp_nonce_url( $link, 'wocommerce_notification_click', 'link' );
		ob_start(); ?>
		<a href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( get_the_title( $product_id ) ) ?></a>
		<?php $product_with_link = ob_get_clean();
		ob_start(); ?>
		<small><?php echo esc_html__( 'About', 'woocommerce-notification' ) . ' ' . esc_html( $time ) . ' ' . esc_html__( 'ago', 'woocommerce-notification' ) ?></small>
		<?php $time_ago = ob_get_clean();

		if ( has_post_thumbnail( $product_id ) ) {
			$messsage .= get_the_post_thumbnail( $product_id );
		}
		$replaced = array(
			$first_name,
			$city,
			$country,
			$product,
			$product_with_link,
			$time_ago
		);
		$messsage .= str_replace( $keys, $replaced, '<p>' . strip_tags( $message_purchased ) . '</p>' );
		ob_start();
		if ( $show_close_icon ) {
			?>
			<span id="notify-close"></span>
			<?php
		}
		$messsage .= ob_get_clean();

		return $messsage;
	}

	/**
	 * Process product
	 * @return bool
	 */
	protected function get_product() {
		$params       = new VI_WNOTIFICATION_Admin_Settings();
		$archive_page = $params->get_field( 'archive_page' );
		$prefix       = woocommerce_notification_prefix();
		/*Process section*/
		$sec_datas = isset( $_SESSION[$prefix] ) ? $_SESSION[$prefix] : array();

		if ( count( $sec_datas ) ) {
			/*Process data with product up sell*/

			$data = $sec_datas[0];
			unset( $sec_datas[0] );
			$sec_datas         = array_values( $sec_datas );
			$sec_datas[]       = $data;
			$_SESSION[$prefix] = $sec_datas;

			return $data;

		}

		/*Check with Product get from Billing*/
		if ( ! $archive_page ) {
			/*Parram*/
			$order_threshold_num  = $params->get_field( 'order_threshold_num' );
			$order_threshold_time = $params->get_field( 'order_threshold_time' );
			$current_time         = '';
			if ( $order_threshold_num ) {
				switch ( $order_threshold_time ) {
					case 1:
						$time_type = 'days';
						break;
					default:
						$time_type = 'hours';
				}
				$current_time = strtotime( "+" . $order_threshold_num . " " . $time_type );
			}
			$args = array(
				'post_type'      => 'shop_order',
				'post_status'    => array( 'wc-processing', 'wc-completed' ),
				'posts_per_page' => '30',
				'orderby'        => 'date',
				'order'          => 'DESC'
			);
			if ( $current_time ) {
				$args['date_query'] = array(
					array(
						'before'    => array(               //(string/array) - Date to retrieve posts after. Accepts strtotime()-compatible string, or array of 'year', 'month', 'day'
							'year'  => date( "Y", $current_time ),                  //(string) Accepts any four-digit year. Default is empty.
							'month' => date( "m", $current_time ),                     //(string) The month of the year. Accepts numbers 1-12. Default: 12.
							'day'   => date( "d", $current_time ),                    //(string) The day of the month. Accepts numbers 1-31. Default: last day of month.
						),
						'inclusive' => true,                //(boolean) - For after/before, whether exact value should be matched or not'.
						'compare'   => '<=',                  //(string) - Possible values are '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS' (only in WP >= 3.5), and 'NOT EXISTS' (also only in WP >= 3.5). Default value is '='
						'column'    => 'post_date',            //(string) - Column to query against. Default: 'post_date'.
						'relation'  => 'AND',                //(string) - OR or AND, how the sub-arrays should be compared. Default: AND.
					),
				);
			}
			$my_query = new WP_Query( $args );
			$products = array();
			if ( $my_query->have_posts() ) {
				while ( $my_query->have_posts() ) {
					$my_query->the_post();
					$order = new WC_Order( get_the_ID() );
					$items = $order->get_items();
					foreach ( $items as $item ) {
						$product['id']         = isset( $item['product_id'] ) ? $item['product_id'] : '';
						$product['time']       = get_the_date( "Y-m-d H:i:s" );
						$product['first_name'] = get_post_meta( get_the_ID(), '_billing_first_name', true );
						$product['city']       = get_post_meta( get_the_ID(), '_billing_city', true );
						$product['country']    = get_post_meta( get_the_ID(), '_billing_country', true );
						$products[]            = $product;
					}
					$products = array_map( "unserialize", array_unique( array_map( "serialize", $products ) ) );
					if ( count( $products ) >= 50 ) {
						break;
					}
				}
			}
			if ( count( $products ) ) {
				$data = $products[0];
				unset( $products[0] );
				$products          = array_values( $products );
				$products[]        = $data;
				$_SESSION[$prefix] = $products;
			} else {
				return false;
			}

		} else {

			/*Params from Settings*/
			$archive_products = $params->get_field( 'archive_products' );
			$virtual_name     = $params->get_field( 'virtual_name' );
			$virtual_time     = $params->get_field( 'virtual_time' );
			$detect_country   = $params->get_field( 'country' );

			if ( $virtual_name ) {
				$virtual_name = explode( "\n", $virtual_name );
				$virtual_name = array_filter( $virtual_name );
			}

			if ( ! $detect_country ) {
				$detect_data = $this->detect_country();

				$country = isset( $detect_data['country'] ) ? $detect_data['country'] : '';
				$city    = isset( $detect_data['city'] ) ? $detect_data['city'] : '';
			} else {
				$country = $params->get_field( 'virtual_country' );
				$city    = $params->get_field( 'virtual_city' );
				if ( $city ) {
					$city = explode( "\n", $city );
					$city = array_filter( $city );
				}
			}
			$archive_products = is_array( $archive_products ) ? $archive_products : array();

			if ( count( array_filter( $archive_products ) ) < 1 ) {
				$args      = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => '50',
					'orderby'        => 'date',
					'order'          => 'DESC'
				);
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					$archive_products = array();
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$archive_products[] = get_the_ID();
					}
				}
			}
			$products = array();
			foreach ( $archive_products as $archive_product ) {

				if ( is_array( $city ) ) {
					$index     = array_rand( $city );
					$city_text = $city[$index];
				} else {
					$city_text = $city;
				}

				if ( is_array( $virtual_name ) ) {
					$index             = array_rand( $virtual_name );
					$virtual_name_text = $virtual_name[$index];
				} else {
					$virtual_name_text = $virtual_name;
				}


				$product['id']         = $archive_product;
				$product['time']       = $this->time_substract( current_time( 'timestamp' ) - rand( 10, $virtual_time * 3600 ), true );
				$product['first_name'] = $virtual_name_text;
				$product['city']       = $city_text;
				$product['country']    = $country;
				$products[]            = $product;
			}

			if ( count( $products ) ) {
				$data = $products[0];
				unset( $products[0] );
				$products          = array_values( $products );
				$products[]        = $data;
				$_SESSION[$prefix] = $products;
			} else {
				return false;
			}

		}

		return $data;

	}

	/**
	 * Detect country and city
	 *
	 * @return array
	 */
	protected function detect_country() {
		$ip = isset( $_COOKIE['ip'] ) ? $_COOKIE['ip'] : '';
		if ( $ip || isset( $_SESSION['ip'] ) ) {
			$data['city'] = isset( $_COOKIE['city'] ) ? $_COOKIE['city'] : '';
			if ( ! $data['city'] && isset( $_SESSION['city'] ) ) {
				$data['city'] = $_SESSION['city'];
			}
			$data['country'] = isset( $_COOKIE['country'] ) ? $_COOKIE['country'] : '';
			if ( ! $data['country'] && isset( $_SESSION['country'] ) ) {
				$data['country'] = $_SESSION['country'];
			}
		} else {
			$data = $this->geoCheckIP( $this->getIP() );
		}

		return $data;
	}

	/**
	 * Get ip of client
	 *
	 * @return mixed ip of client
	 */
	protected function getIP() {
		$ip = new WC_Geolocation();

		return $ip->get_ip_address();
	}

	/**
	 * Get time
	 *
	 * @param      $time
	 * @param bool $number
	 * @param bool $calculate
	 *
	 * @return bool|string
	 */
	protected function time_substract( $time, $number = false, $calculate = false ) {
		if ( ! $number ) {
			if ( $time ) {
				$time = strtotime( $time );
			} else {
				return false;
			}
		}
		if ( ! $calculate ) {
			$current_time   = current_time( 'timestamp' );
			$time_substract = $current_time - $time;
		} else {
			$time_substract = $time;
		}
		if ( $time_substract > 0 ) {

			/*Check day*/
			$day = $time_substract / ( 24 * 3600 );
			$day = intval( $day );
			if ( $day > 1 ) {
				return $day . ' ' . esc_html__( 'days', 'woocommerce-notification' );
			} elseif ( $day > 0 ) {
				return $day . ' ' . esc_html__( 'day', 'woocommerce-notification' );
			}

			/*Check hour*/
			$hour = $time_substract / ( 3600 );
			$hour = intval( $hour );
			if ( $hour > 1 ) {
				return $hour . ' ' . esc_html__( 'hours', 'woocommerce-notification' );
			} elseif ( $hour > 0 ) {
				return $hour . ' ' . esc_html__( 'hour', 'woocommerce-notification' );
			}

			/*Check min*/
			$min = $time_substract / ( 60 );
			$min = intval( $min );
			if ( $min > 1 ) {
				return $min . ' ' . esc_html__( 'minutes', 'woocommerce-notification' );
			} elseif ( $min > 0 ) {
				return $min . ' ' . esc_html__( 'minute', 'woocommerce-notification' );
			}

			return intval( $time_substract ) . ' ' . esc_html__( 'seconds', 'woocommerce-notification' );

		} else {
			return false;
		}


	}

	/**
	 * Get an array with geoip-infodata
	 *
	 * @param $ip
	 *
	 * @return bool
	 */
	protected function geoCheckIP( $ip ) {
		$params   = new VI_WNOTIFICATION_Admin_Settings();
		$auth_key = $params->get_field( 'ipfind_auth_key' );
		if ( ! $auth_key ) {
			return false;
		}
		//check, if the provided ip is valid
		if ( ! filter_var( $ip, FILTER_VALIDATE_IP ) ) {
			throw new InvalidArgumentException( "IP is not valid" );
		}

		//contact ip-server
		$response = @file_get_contents( 'https://ipfind.co?ip=' . $ip . '&auth=' . trim( $auth_key ) );
		file_put_contents( VI_WNOTIFICATION_CACHE . 'ip.txt', "\n" . date( "H:i:s" ), FILE_APPEND );
		if ( empty( $response ) ) {
			return false;
			throw new InvalidArgumentException( "Error contacting Geo-IP-Server" );

		} else {
			$response = json_decode( $response );
		}

		$ipInfo["city"]    = $response->city;
		$ipInfo["country"] = $response->country;

		return $ipInfo;
	}

}