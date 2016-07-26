jQuery( function ( $ )
{
	checkboxToggle();
	togglePostFormatMetaBoxes();
 	togglePortfolioSettings();
	togglePortfolioTestimonial();
	toggleMenuOnePage();
	toggleComingSoonPage();
	toggleBlankPage();
	toggleDisplaysetting();
	/**
	 * Show, hide a <div> based on a checkbox
	 *
	 * @return void
	 * @since 1.0
	 */
	function checkboxToggle()
	{
		$( 'body' ).on( 'change', '.checkbox-toggle input', function()
		{
			var $this = $( this ),
				$toggle = $this.closest( '.checkbox-toggle' ),
				action;
			if ( !$toggle.hasClass( 'reverse' ) )
				action = $this.is( ':checked' ) ? 'slideDown' : 'slideUp';
			else
				action = $this.is( ':checked' ) ? 'slideUp' : 'slideDown';

			$toggle.next()[action]();
		} );
		$( '.checkbox-toggle input' ).trigger( 'change' );
	}

	/**
	 * Show, hide post format meta boxes
	 *
	 * @return void
	 * @since 1.0
	 */
	function togglePostFormatMetaBoxes()
	{
		var $input = $( 'input[name=post_format]' ),
			$metaBoxes = $( '[id^="cavada-meta-box-post-format-"]' ).hide();

		// Don't show post format meta boxes for portfolio
		if ( $( '#post_type' ).val() == 'portfolio' )
			return;

		$input.change( function ()
		{
			$metaBoxes.hide();
			$( '#cavada-meta-box-post-format-' + $( this ).val() ).show();
		} );
		$input.filter( ':checked' ).trigger( 'change' );
	}

	/**
	 * Show contact meta box for contact page template only
	 *
	 * @return void
	 * @since 1.0
	 */

	function togglePortfolioSettings()
	{
		$( '#page_template' ).change(function ()
		{
			$( '#cavada-meta-box-template-page-portfolio' )[$( this ).val() == 'page-templates/portfolio.php' ? 'show' : 'hide']();
			$( '#display-settings .hidden-layout-portfolio' )[$( this ).val() == 'page-templates/portfolio.php' ? 'hide' : 'show']();

		} ).trigger( 'change' );
	}

	function toggleMenuOnePage()
	{
		$( '#page_template' ).change(function ()
		{
			$( '#select-menu-one-page' )[$( this ).val() =='page-templates/onepage.php' || $(this).val() == 'page-templates/onepagemobile.php' ? 'show' : 'hide']();
			$( '#select-menu-one-page-hide' )[$( this ).val() == 'page-templates/onepage.php' || $(this).val() == 'page-templates/onepagemobile.php' ?  'show' : 'hide']();
		} ).trigger( 'change' );
	}

	/**
	 * Display type for portfolio
	 *
	 * @return void
	 * @since 1.0
	 */
	function togglePortfolioTestimonial()
	{
		var $display = $( 'input[name=display]' ),
			$testimonial = $( '#portfolio-testimonial' );
		$display.change( function ()
		{
			$testimonial[$( this ).val() == 'simple' ? 'show' : 'hide']();
		} );
		$display.filter( ':checked' ).trigger( 'change' );
	}
	function toggleDisplaysetting() {
		jQuery('#page_template').change(function () {
			jQuery('#display-settings')[jQuery(this).val() == 'default' ? 'show' : 'hide']();
 		}).trigger('change');
	}
	function toggleComingSoonPage() {
		jQuery('#page_template').change(function () {
			jQuery('#coming-soon-settings')[jQuery(this).val() == 'page-templates/comingsoon.php' ? 'show' : 'hide']();
  		}).trigger('change');
	}
	function toggleBlankPage() {
		jQuery('#page_template').change(function () {
			jQuery('#blank-page-settings')[jQuery(this).val() == 'page-templates/blankpage.php' ? 'show' : 'hide']();
  		}).trigger('change');
	}

} );