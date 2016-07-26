"use strict";
function vi_ajax(link, selector, s_replace) {
	jQuery.ajax({
		type   : 'POST',
		url    : link,
		success: function (html) {
			var content = jQuery(html).find(selector).children().unwrap();
			jQuery(s_replace).html(content);
			load_ajax_page_init(1);
			filter_price();
			SmoothTransition();
		},
		error  : function (data) {
		}
	});
}
function load_ajax_page_init(check) {

	if (check) {
		jQuery('.category-product-list').unbind('.jscroll')
			.removeData('jscroll')
			.find('.jscroll-inner').children().unwrap()
			.filter('.jscroll-added').children().unwrap();
		jQuery(window).unbind('scroll');
		jQuery('select.orderby-ajax').unbind();
		jQuery('.shop-top-button').unbind();
		jQuery('#shop-top').show();
		jQuery('.shop-top-button').on('click', function (e) {
			jQuery('#shop-top').slideToggle();
			e.preventDefault();
		});
		jQuery('.quick-view').unbind();
		jQuery('.quick-view').click(function (e) {
			/* add loader  */
			jQuery('.quick-view a').css('display', 'none');
			jQuery(this).append('<a href="javascript:;" class="loading dark"></a>');
			var product_id = jQuery(this).attr('data-prod');
			var data = {action: 'jck_quickview', product: product_id};
			jQuery.post(ajaxurl, data, function (response) {
				jQuery.magnificPopup.open({
					mainClass: 'my-mfp-zoom-in',
					items    : {
						src : '<div class="mfp-iframe-scaler">' + response + '</div>',
						type: 'inline'
					}
				});
				jQuery('.quick-view a').css('display', 'inline-block');
				jQuery('.loading').remove();
				jQuery('.product-card .wrapper').removeClass('animate');
				setTimeout(function () {
					jQuery('.product-lightbox form').wc_variation_form();
				}, 600);
			});
		})
		jQuery('.orderby-ajax a, .widget.widget_layered_nav ul>li> a,.widget.widget_product_tag_cloud .tagcloud > a,.widget.widget_layered_nav_filters ul>li>a,.widget.widget_price_filter form,.widget.widget_product_search form').unbind();


	} else {
		jQuery('.shop-top-button').unbind();
		jQuery('.shop-top-button').on('click', function (e) {
			jQuery('#shop-top').slideToggle('400');
			e.preventDefault();
		});
	}
	jQuery('.category-product-list').jscroll({
		loadingHtml    : '<div id="preload-ajax"> <div class="preload-inner"> <div class="loading-inner"> <span class="loading-1"></span> <span class="loading-2"></span> <span class="loading-3"></span> </div> </div> </div>',
		nextSelector   : '.next-prev-btn a',
		contentSelector: '.category-product-list li.item-product,.next-prev-btn',
		callback       : function () {
			SmoothTransition();
			jQuery("img.vi-load").unbind();
			jQuery("img.vi-load").unveil(100, function () {
				jQuery(this).load(function () {
					jQuery(this).closest('.product-top').find('.vi-placeholder').hide();
				});
			});
			jQuery('.quick-view').unbind();
			jQuery('.quick-view').click(function (e) {

				jQuery('.quick-view a').css('display', 'none');
				jQuery(this).append('<a href="javascript:;" class="loading dark"></a>');
				var product_id = jQuery(this).attr('data-prod');
				var data = {action: 'jck_quickview', product: product_id};
				jQuery.post(ajaxurl, data, function (response) {
					jQuery.magnificPopup.open({
						mainClass: 'my-mfp-zoom-in',
						items    : {
							src : '<div class="mfp-iframe-scaler">' + response + '</div>',
							type: 'inline'
						}
					});
					jQuery('.quick-view a').css('display', 'inline-block');
					jQuery('.loading').remove();
					jQuery('.product-card .wrapper').removeClass('animate');
					setTimeout(function () {
						jQuery('.product-lightbox form').wc_variation_form();
					}, 600);
				});
				e.preventDefault();
			});
		}

	});

	jQuery('.orderby-ajax a, .widget.widget_layered_nav ul>li> a,.widget.widget_product_tag_cloud .tagcloud > a,.widget.widget_layered_nav_filters ul>li>a').click(function (event) {
		event.preventDefault();
		var link = jQuery(this).attr('href');
		window.history.pushState('', '', link);
		vi_ajax(link, '.site-content', '.site-content');
	});
	jQuery('.widget.widget_price_filter form,.widget.widget_product_search form').submit(function (event) {
		event.preventDefault();
		var link = jQuery(this).attr('action');
		var attr = '';
		jQuery(this).find('input').not(':input[type=button], :input[type=submit], :input[type=reset]').each(function () {
			var name = jQuery(this).attr('name');
			var val = jQuery(this).val();

			if (attr.length < 1) {
				attr = '?' + name + '=' + val;
			} else {
				attr += '&' + name + '=' + val;
			}
		});
		link += attr;
		window.history.pushState('', '', link);
		vi_ajax(link, '.site-content', '.site-content');
	});

}
function filter_price() {
	/* global woocommerce_price_slider_params */
	jQuery(function (jQuery) {

		// woocommerce_price_slider_params is required to continue, ensure the object exists
		if (typeof woocommerce_price_slider_params === 'undefined') {
			return false;
		}

		// Get markup ready for slider
		jQuery('input#min_price, input#max_price').hide();
		jQuery('.price_slider, .price_label').show();

		// Price slider uses jquery ui
		var min_price = jQuery('.price_slider_amount #min_price').data('min'),
			max_price = jQuery('.price_slider_amount #max_price').data('max'),
			current_min_price = parseInt(min_price, 10),
			current_max_price = parseInt(max_price, 10);

		if (woocommerce_price_slider_params.min_price) {
			current_min_price = parseInt(woocommerce_price_slider_params.min_price, 10);
		}
		if (woocommerce_price_slider_params.max_price) {
			current_max_price = parseInt(woocommerce_price_slider_params.max_price, 10);
		}

		jQuery(document.body).bind('price_slider_create price_slider_slide', function (event, min, max) {
			if (woocommerce_price_slider_params.currency_pos === 'left') {

				jQuery('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + min);
				jQuery('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + max);

			} else if (woocommerce_price_slider_params.currency_pos === 'left_space') {

				jQuery('.price_slider_amount span.from').html(woocommerce_price_slider_params.currency_symbol + ' ' + min);
				jQuery('.price_slider_amount span.to').html(woocommerce_price_slider_params.currency_symbol + ' ' + max);

			} else if (woocommerce_price_slider_params.currency_pos === 'right') {

				jQuery('.price_slider_amount span.from').html(min + woocommerce_price_slider_params.currency_symbol);
				jQuery('.price_slider_amount span.to').html(max + woocommerce_price_slider_params.currency_symbol);

			} else if (woocommerce_price_slider_params.currency_pos === 'right_space') {

				jQuery('.price_slider_amount span.from').html(min + ' ' + woocommerce_price_slider_params.currency_symbol);
				jQuery('.price_slider_amount span.to').html(max + ' ' + woocommerce_price_slider_params.currency_symbol);

			}

			jQuery(document.body).trigger('price_slider_updated', [min, max]);
		});

		jQuery('.price_slider').slider({
			range  : true,
			animate: true,
			min    : min_price,
			max    : max_price,
			values : [current_min_price, current_max_price],
			create : function () {

				jQuery('.price_slider_amount #min_price').val(current_min_price);
				jQuery('.price_slider_amount #max_price').val(current_max_price);

				jQuery(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
			},
			slide  : function (event, ui) {

				jQuery('input#min_price').val(ui.values[0]);
				jQuery('input#max_price').val(ui.values[1]);

				jQuery(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
			},
			change : function (event, ui) {

				jQuery(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
			}
		});

	});

}

jQuery(document).ready(function () {
	load_ajax_page_init(0);
	jQuery('.archive-blog').jscroll({
		loadingHtml    : '<div id="preload-ajax"> <div class="preload-inner"> <div class="loading-inner"> <span class="loading-1"></span> <span class="loading-2"></span> <span class="loading-3"></span> </div> </div> </div>',
		nextSelector   : '.next-prev-btn a',
		contentSelector: '.archive-blog article,.next-prev-btn',
		callback       : function () {
			SmoothTransition();
		}
	});

});