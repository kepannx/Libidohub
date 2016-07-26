<?php
if ( function_exists( 'vc_map' ) ) {
	vc_map(
		array(
			"name"        => esc_html__( "Twitter feed", 'dukan' ),
			"icon"        => "icon-ui-splitter-horizontal",
			"base"        => "twitter_feed",
			"description" => "Twitter",
			"category"    => esc_html__( "Villatheme", 'dukan' ),
			"params"      => array(

				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Twitter Name:', 'dukan' ),
					'param_name' => 'twitter_id',
					'value'      => 'villatheme',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Consumer Key:', 'dukan' ),
					'param_name' => 'consumer_key',
					'value'      => 'T8Gv9HlLeq0q7tn67id8gL6bz',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Consumer Secret:', 'dukan' ),
					'param_name' => 'consumer_secret',
					'value'      => 'cH3BZEV98eCtmeh0KlLjOpmwjQO6ik41gEYCVVKfqt1ItoJbtx',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Access Token:', 'dukan' ),
					'param_name' => 'access_token',
					'value'      => '070908393-H4UpbU0hY8WQcx2knPmQRj7eAoHghHRdIQADRZ7',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Access Token Secret:', 'dukan' ),
					'param_name' => 'access_token_secret',
					'value'      => 'bodC2TAd0Htil1iI0553y07C6FA2MOPMWgASZ9CA1Hdgt',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Number of Tweets:', 'dukan' ),
					'param_name' => 'count',
					'value'      => '3',
				),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__( "Extra class name", "dukan" ),
					"param_name"  => "el_class",
					"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "dukan" ),
				),
				function_exists( 'villatheme_vc_map_add_css_animation' ) ? villatheme_vc_map_add_css_animation( true ) : ''
			)
		)
	);
}
function twitter_ago( $time ) {
	$periods    = array( "second", "minute", "hour", "day", "week", "month", "year", "decade" );
	$lengths    = array( "60", "60", "24", "7", "4.35", "12", "10" );
	$now        = time();
	$difference = $now - $time;
	//$tense      = "ago";
	for ( $j = 0; $difference >= $lengths[$j] && $j < count( $lengths ) - 1; $j ++ ) {
		$difference /= $lengths[$j];
	}
	$difference = round( $difference );
	if ( $difference != 1 ) {
		$periods[$j] .= "s";
	}

	return "$difference $periods[$j] ago ";
}

function villatheme_shortcode_twitter_feed( $atts, $content = null ) {
	$twitter_id = $villatheme_animation = $css_animation = $el_class = $consumer_key = $consumer_secret = $access_token = $access_token_secret =
	$count = $widget_id = '';
	extract(
		shortcode_atts(
			array(
				'twitter_id'          => 'villatheme',
				'consumer_key'        => 'T8Gv9HlLeq0q7tn67id8gL6bz',
				'consumer_secret'     => 'cH3BZEV98eCtmeh0KlLjOpmwjQO6ik41gEYCVVKfqt1ItoJbtx',
				'access_token'        => '070908393-H4UpbU0hY8WQcx2knPmQRj7eAoHghHRdIQADRZ7',
				'access_token_secret' => 'bodC2TAd0Htil1iI0553y07C6FA2MOPMWgASZ9CA1Hdgt',
				'count'               => '3',
				'el_class'            => '',
				'css_animation'       => '',
			), $atts
		)
	);
	if ( $el_class ) {
		$villatheme_animation .= ' ' . $el_class;
	}

	$villatheme_animation .= villatheme_getCSSAnimation( $css_animation );


	if ( $twitter_id && $consumer_key && $consumer_secret && $access_token && $access_token_secret && $count ) {
		$transName = 'list_tweets';
		$cacheTime = 10;
		if ( false === ( $twitterData = get_transient( $transName ) ) ) {

			$token = get_option( 'cfTwitterToken' );
			// get a new token anyways
			delete_option( 'cfTwitterToken' );
			// getting new auth bearer only if we don't have one
			if ( ! $token ) {
				// preparing credentials
				$credentials = $consumer_key . ':' . $consumer_secret;
				$toSend      = base64_encode( $credentials );
				// http post arguments
				$args = array(
					'method'      => 'POST',
					'httpversion' => '1.1',
					'blocking'    => true,
					'headers'     => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body'        => array( 'grant_type' => 'client_credentials' )
				);

				add_filter( 'https_ssl_verify', '__return_false' );
				$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );

				$keys = json_decode( wp_remote_retrieve_body( $response ) );

				if ( $keys ) {
					// saving token to wp_options table
					update_option( 'cfTwitterToken_' . $widget_id, $keys->access_token );
					$token = $keys->access_token;
				}
			}
			// we have bearer token wether we obtained it from API or from options
			$args = array(
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => array(
					'Authorization' => "Bearer $token"
				)
			);

			add_filter( 'https_ssl_verify', '__return_false' );
			$api_url  = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $twitter_id . '&count=' . $count;
			$response = wp_remote_get( $api_url, $args );
			set_transient( $transName, wp_remote_retrieve_body( $response ), 60 * $cacheTime );
		}
		@$twitter = json_decode( get_transient( $transName ), true );

		if ( $twitter && is_array( $twitter ) ) {

			$html = '<div class="twitter-feed' . esc_attr( $villatheme_animation ) . '">';
			foreach ( $twitter as $tweet ):
				$twitterTime = strtotime( $tweet['created_at'] );
				$timeAgo     = twitter_ago( $twitterTime );
				$html .= '<div class="item-feed">';
				$latestTweet = $tweet['text'];
				$latestTweet = preg_replace( '/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet );
				$latestTweet = preg_replace( '/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet );
				$html .= '<i class="fa fa-twitter"></i>';
				$html .= ent2ncr( '<p>' . $latestTweet . '</p>' );
				$html .= ent2ncr( '<div class="date">' . $timeAgo . '</div>' );
				$html .= '</div>';
			endforeach;
			$html .= '</div>';
		}
	}

	return $html;
}

?>