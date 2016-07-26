<?php

/**
 * Class Tweets_Widget
 * Create Recent tweet
 */
class VILLATHEME_Tweets_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'tweets', 'description' => 'List Tweets Feed' );
		parent::__construct( 'tweets-widget', '(Vi) Twitter', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$widget_id           = $args['widget_id'];
		$widget_title        = $instance['widget_title'] ? apply_filters( 'widget_title', $instance['widget_title'] ) : '';
		$consumer_key        = $instance['consumer_key'];
		$consumer_secret     = $instance['consumer_secret'];
		$access_token        = $instance['access_token'];
		$access_token_secret = $instance['access_token_secret'];
		$twitter_id          = $instance['twitter_id'];
		$count               = (int) $instance['count'];
		echo ent2ncr( $before_widget );
		if ( $widget_title <> '' ) {
			echo ent2ncr( $before_title . $widget_title . $after_title );
		}
		if ( $twitter_id && $consumer_key && $consumer_secret && $access_token && $access_token_secret && $count ) {
			$transName = 'list_tweets_' . $widget_id;
			$cacheTime = 10;
			if ( false === ( $twitterData = get_transient( $transName ) ) ) {

				$token = get_option( 'cfTwitterToken_' . $widget_id );
				// get a new token anyways
				delete_option( 'cfTwitterToken_' . $widget_id );
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
				?>
				<ul class="tweet">
					<?php foreach ( $twitter as $tweet ):
						$latestTweet = $timeAgo = '';
						//						var_dump(count( $tweet ));
						if ( count( $tweet ) > 1 ) {
							$twitterTime = strtotime( $tweet['created_at'] );
							$timeAgo     = $this->ago( $twitterTime );
							$latestTweet = $tweet['text'];
							$latestTweet = preg_replace( '/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet );
							$latestTweet = preg_replace( '/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet );
						}
						?>
						<li><?php
							echo ent2ncr( $latestTweet );
							echo "<br/>";
							echo '<i>' . $timeAgo . '</i>';
							?></li>
					<?php endforeach; ?>
				</ul>
				<?php
			}
		}

		echo ent2ncr( $after_widget );
	}

	function ago( $time ) {
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

	function update( $new_instance, $old_instance ) {
		$instance                        = $old_instance;
		$instance['widget_title']        = $new_instance['widget_title'];
		$instance['consumer_key']        = $new_instance['consumer_key'];
		$instance['consumer_secret']     = $new_instance['consumer_secret'];
		$instance['access_token']        = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['twitter_id']          = $new_instance['twitter_id'];
		$instance['count']               = $new_instance['count'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'widget_title'        => 'Twitter Feed',
			'twitter_id'          => 'villatheme',
			'count'               => 3,
			'consumer_key'        => 'T8Gv9HlLeq0q7tn67id8gL6bz',
			'consumer_secret'     => 'cH3BZEV98eCtmeh0KlLjOpmwjQO6ik41gEYCVVKfqt1ItoJbtx',
			'access_token'        => '070908393-H4UpbU0hY8WQcx2knPmQRj7eAoHghHRdIQADRZ7',
			'access_token_secret' => 'bodC2TAd0Htil1iI0553y07C6FA2MOPMWgASZ9CA1Hdgt'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<?php $link1 = 'http://dev.twitter.com/apps'; ?>
			<a href="<?php echo esc_url( $link1 ); ?>"><?php echo esc_html_e( 'Find or Create your Twitter App ', 'dukan' ) ?></a>
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'widget_title' ) ); ?>"><?php echo esc_html_e( 'Title: ', 'dukan' ) ?></label>
			<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'widget_title' ) ); ?>" value="<?php echo ent2ncr( $instance['widget_title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'consumer_key' ) ); ?>"><?php echo esc_html_e( 'Consumer Key: ', 'dukan' ) ?></label>
			<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'consumer_key' ) ); ?>" value="<?php echo ent2ncr( $instance['consumer_key'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'consumer_secret' ) ); ?>"><?php echo esc_html_e( 'Consumer Secret: ', 'dukan' ) ?></label>
			<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'consumer_secret' ) ); ?>" value="<?php echo ent2ncr( $instance['consumer_secret'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'access_token' ) ); ?>"><?php echo esc_html_e( 'Access Token: ', 'dukan' ) ?></label>
			<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'access_token' ) ); ?>" value="<?php echo ent2ncr( $instance['access_token'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'access_token_secret' ) ); ?>"><?php echo esc_html_e( 'Access Token Secret: ', 'dukan' ) ?></label>
			<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'access_token_secret' ) ); ?>" value="<?php echo ent2ncr( $instance['access_token_secret'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo ent2ncr( $this->get_field_id( 'twitter_id' ) ); ?>"><?php echo esc_html_e( 'Twitter Name: ', 'dukan' ) ?></label>
			<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'twitter_id' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'twitter_id' ) ); ?>" value="<?php echo ent2ncr( $instance['twitter_id'] ); ?>" />
		</p>

		<label for="<?php echo ent2ncr( $this->get_field_id( 'count' ) ); ?>"><?php echo esc_html_e( 'Number of Tweets: ', 'dukan' ) ?></label>
		<input class="widefat" id="<?php echo ent2ncr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo ent2ncr( $this->get_field_name( 'count' ) ); ?>" value="<?php echo ent2ncr( $instance['count'] ); ?>" />
		</p>

		<?php
	}
}
