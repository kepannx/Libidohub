<?php $cavada_data = cavada_get_data_themeoptions();
if ( isset( $cavada_data['menu_layout'] ) && $cavada_data['menu_layout'] == '1' ) {
	$menu_fullwidth = '-fluid';
}
$flag = 0;
if ( isset( $cavada_data['choose_header'] ) && $cavada_data['choose_header'] == 'header_v1_02' ) {
	$flag = 1;
}
if ( isset( $cavada_data['choose_header'] ) && ( $cavada_data['choose_header'] != 'header_v1_04' ) ) {
	?>
	<div class="wrapper-logo">
		<?php
		$menu_fullwidth = '';
		$class          = " col-sm-8";
		$logo_center    = ' text-left';
		if ( isset( $cavada_data['menu_layout'] ) && $cavada_data['menu_layout'] == '1' ) {
			$menu_fullwidth = '-fluid';
		}
		echo '<div class="container' . $menu_fullwidth . '"><div class="row"><div class="header-table">';
		// header left
		if ( isset( $cavada_data['choose_header'] ) && ( $cavada_data['choose_header'] == 'header_v1_02' || $cavada_data['choose_header'] == 'header_v1_01' ) ) {
			if ( is_active_sidebar( 'header_left' ) ) {
				echo '<div class="col-sm-4 text-left">';
				dynamic_sidebar( 'header_left' );
				echo '</div>';
				$class       = " col-sm-4";
				$logo_center = " text_center";
			}
		}
		//logo
		echo '<div class="col-sm-4' . $logo_center . '">';
		do_action( 'cavada_logo' );
		echo '</div>';

		// header right
		if ( is_active_sidebar( 'header_right' ) ) {
			echo '<div class="text-right' . $class . '">';
			dynamic_sidebar( 'header_right' );
			echo '</div>';
		}
		echo '</div></div></div>';
		?>
	</div>
	<?php
	if ( $flag == '1' ) {
		echo '<div class="container ' . esc_attr( $menu_fullwidth ) . '"><div class="row">';
	}
	?>
	<div class="navigation <?php if ( isset( $cavada_data['choose_header'] ) ) {
		echo esc_attr( $cavada_data['choose_header'] );
	} ?>">
		<?php
		if ( $flag != '1' ) {
			echo '<div class="container ' . esc_attr( $menu_fullwidth ) . '"><div class="row">';
		}
		?>
		<?php
		if ( isset( $cavada_data['choose_header'] ) && $cavada_data['choose_header'] == 'header_v1_02' ) {
			echo '<span class="icon-arrow"></span><span class="border-menu"></span>';
		}
		?>
		<div class="tm-table">
			<div class="menu-mobile-effect navbar-toggle button-collapse" data-activates="mobile-demo">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</div>
			<div class="width-logo table-cell sm-logo">
				<?php
				do_action( 'cavada_sticky_logo' );
				?>
			</div>
			<nav class="width-navigation table-cell" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php get_template_part( 'inc/header/main-menu' ); ?>
			</nav>
			<?php
			if ( $flag != '1' ) {
				echo '</div></div>';
			}
			?>
			<!--end .row-->
		</div>
	</div>
	<?php
	if ( $flag == '1' ) {
		echo '</div></div>';
	}
	?>
<?php } else { ?>

	<div class="container<?php echo esc_attr( $menu_fullwidth ); ?>">
		<div class="row">
			<div class="navigation <?php if ( isset( $cavada_data['choose_header'] ) ) {
				echo esc_attr( $cavada_data['choose_header'] );
			} ?>">
				<?php
				if ( isset( $cavada_data['choose_header'] ) && $cavada_data['choose_header'] == 'header_v1_02' ) {
					echo '<span class="icon-arrow"></span><span class="border-menu"></span>';
				}
				?>
				<div class="tm-table">
					<div class="menu-mobile-effect navbar-toggle button-collapse" data-activates="mobile-demo">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</div>
					<nav class="width-navigation table-cell" itemscope itemtype="http://schema.org/SiteNavigationElement">
						<?php get_template_part( 'inc/header/main-menu' ); ?>
					</nav>

					<div class="width-logo table-cell">
						<?php
						do_action( 'cavada_logo' );
						do_action( 'cavada_sticky_logo' );
						?>
					</div>
					<?php
					if ( is_active_sidebar( 'header_right' ) ) {
						echo '<div class="header-right">';
						dynamic_sidebar( 'header_right' );
						echo '</div>';
					} ?>
				</div>
			</div>
		</div>
		<!--end .row-->
	</div>

<?php } ?>
