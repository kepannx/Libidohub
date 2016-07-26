<?php $cavada_data = cavada_get_data_themeoptions(); ?>
<div class="navigation">
	<?php
	$menu_fullwidth = '';
	if ( isset( $cavada_data['menu_layout'] ) && $cavada_data['menu_layout'] == '1' ) {
		$menu_fullwidth = '-fluid';
	} ?>
	<div class="container<?php echo esc_attr($menu_fullwidth);?>">
		<div class="tm-table">
			<div class="menu-mobile-effect navbar-toggle button-collapse" data-activates="mobile-demo">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</div>
			<div class="width-logo table-cell sm-logo">
				<?php
				do_action( 'cavada_logo' );
				do_action( 'cavada_sticky_logo' );
				?>
			</div>
			<nav class="width-navigation table-cell" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php get_template_part( 'inc/header/main-menu' ); ?>
			</nav>
		</div>
	</div><!--end .row-->
</div>