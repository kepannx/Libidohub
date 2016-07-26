<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save"><?php esc_html_e( 'Options Updated', 'cavada' ) ?></div>
	</div>

	<div id="of-popup-generate-less" class="of-generate-less-popup">
		<div class="of-generate-less"><?php esc_html_e( 'CSS Generated', 'cavada' ) ?></div>
	</div>

	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset"><?php esc_html_e( 'Options Reset', 'cavada' ) ?></div>
	</div>

	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-save-fail"><?php esc_html_e( 'Error', 'cavada' ) ?>!</div>
	</div>

	<span style="display: none;" id="hooks"><?php echo json_encode( of_get_header_classes_array() ); ?></span>
	<input type="hidden" id="reset" value="<?php
	if ( isset( $_REQUEST['reset'] ) ) {
		echo ent2ncr( $_REQUEST['reset'] );
	}
	?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce( 'of_ajax_nonce' ); ?>" />
	<input type="hidden" id="generatelesscss" value="<?php
	if ( isset( $_REQUEST['generatelesscss'] ) ) {
		echo ent2ncr( $_REQUEST['generatelesscss'] );
	}
	?>" />

	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data">
		<h2>
			<?php echo CAVADA_THEMENAME; ?>
			<small>
				<small><?php echo( 'v' . CAVADA_THEMEVERSION ); ?></small>
			</small>
		</h2>

		<div id="js-warning"><?php esc_html_e( 'Warning- This options panel will not work properly without javascript!', 'cavada' ) ?></div>
		<div class="icon-option"></div>
		<div class="clear"></div>
		<div id="info_bar">
			<div class="info_bar_links">
				<?php $link_doc = 'http://docs.villatheme.com/cavada';
				$link_support   = 'http://villatheme.com/supports/';
				$link_update    = 'http://villatheme.com/knowledge-base/envato-wordpress-toolkit-guide-for-automatic-theme-updates-from-themeforest/';
				?>
				<a href="<?php echo esc_url( $link_doc ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'cavada' ); ?></a>&nbsp;|&nbsp;
				<a href="<?php echo esc_url( $link_support ); ?>" target="_blank"><?php esc_html_e( 'Support', 'cavada' ); ?></a>&nbsp;|&nbsp;
				<a href="<?php echo esc_url( $link_update ); ?>" target="_blank"><?php esc_html_e( 'Update', 'cavada' ); ?></a>
			</div>
			<div class="info_bar_buttons">
				<img style="display:none" src="<?php echo CAVADA_ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php esc_html_e( 'Working...', 'cavada' ) ?>" />
				<button id="of_save" type="button" class="button-primary">
					<?php esc_html_e( 'Save All Changes', 'cavada' ); ?>
				</button>
			</div>
		</div>
		<!--.info_bar-->

		<div id="main">

			<div id="of-nav">
				<ul>
					<?php echo ent2ncr( $options_machine->Menu ) ?>
				</ul>
			</div>

			<div id="content">
				<?php echo ent2ncr( $options_machine->Inputs ) /* Settings */ ?>
			</div>

			<div class="clear"></div>

		</div>

		<div class="save_bar">
			<div class="info_bar_links">
				<button id="of_reset" type="button" class="button submit-button reset-button"><?php esc_html_e( 'Options Reset', 'cavada' ); ?></button>
				<img style="display:none" src="<?php echo CAVADA_ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="Working..." />
			</div>
			<div class="info_bar_buttons">
				<img style="display:none" src="<?php echo CAVADA_ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
				<button id="of_save" type="button" class="button-primary"><?php esc_html_e( 'Save All Changes', 'cavada' ); ?></button>
			</div>
		</div>
		<!--.save_bar-->

	</form>

	<div style="clear:both;"></div>

</div><!--wrap-->