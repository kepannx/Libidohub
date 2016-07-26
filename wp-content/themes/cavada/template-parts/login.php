<?php
/**
 * Template Name: Login Page
 */
?>

<?php get_header(); ?>
<?php
$cavada_data = cavada_get_data_themeoptions();
while ( have_posts() ) : the_post();
	$style_css = $style = '';
	if ( has_post_thumbnail() ):
		$image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
		$style_css .= ( $image != '' ) ? 'background-image: url(' . $image . ');background-size: cover;' : '';
	endif;
	if ( $style_css ) {
	echo '
	<style>
	body{' . $style_css . '};
</style>';

	}
endwhile;
?>
	<!-- section -->
	<section class="vi-loginForm main">
		<div class="container">
		<div class="page_login">
		<?php $user_login = get_current_user();

		if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) {
			?>
			<div class="aa_error">
				<p><?php esc_html_e('FAILED: Try again!','cavada')?></p>
			</div>
			<?php
		}
		if ( is_user_logged_in() ) {
			echo '<div class="aa_logout"> '.__('Hello','cavada').', <div class="aa_logout_user">', $user_login, '. '.__('You are already logged in.','cavada').'</div><a id="wp-submit" href="', wp_logout_url(), ' " title="Logout">'.__('Logout','cavada').'</a></div>';
		} else {
		echo '
			<div class="vi-heading">
 				<h2 class="sub-title" style="color: #fff">'.__('Login to continue','cavada').'</h2>
				<span class="separator-heading"><i class="icon-separator"></i></span>
			</div>
			';
			$args = array(
				'echo'           => true,
				'redirect'       => esc_url(home_url( '/wp-admin/' )),
				'form_id'        => 'loginform',
				'label_username' => esc_html__( 'Username','cavada' ),
				'label_password' => esc_html__( 'Password','cavada' ),
				'label_remember' => esc_html__( 'Remember Me','cavada' ),
				'label_log_in'   => esc_html__( 'Log In','cavada' ),
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'remember'       => true,
				'value_username' => null,
				'value_remember' => true
			);
			wp_login_form( $args ) ;
			if(get_option('users_can_register',0)){?>
		<a class="btn register-link btn-default" href="<?php echo esc_url( wp_registration_url() )  ?>"><?php echo esc_html__('Register','cavada') ?></a>
		<?php }

		}
		 ?>
		</div>
		</div>
	</section>
	<!-- /section -->
</div></div><!-- .wrapper-container -->
<!-- .box-area -->
<?php
	if ( isset( $cavada_data['footer_text'] ) ) {
		echo ' <div id="powered-login">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 footer_login">
								<p class="text-copyright">'. $cavada_data['footer_text'].'</p>
							</div>
						</div>
					</div>
				</div>
			 ';
	}
	?>
<?php wp_footer(); ?>
</body>
</html>