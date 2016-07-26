"use strict";
jQuery(document).ready(function () {
	jQuery('.vi-woo-cate-tabs.vi-ajax a').on('click', function () {
		jQuery('#preload-ajax').show();
		var data = jQuery(this).data();
		var el_parent = jQuery(this).closest('.vi-woocommerce-product-category-tabs');
		jQuery.ajax({
			type   : 'POST',
			data   : 'data=' + data.id + '&limit=' + data.limit + '&action=vi_get_category',
			url    : vi_ajax_url,
			success: function (data) {
				var obj = jQuery.parseJSON(data);
				if (obj.check == 'done') {
					var products = obj.msg;
					var slides = '';
					if (products.length > 0) {
						var first = products[0];
						el_parent.find('.product-content h2').html(first.title);
						el_parent.find('.price-box').html(first.price);
						el_parent.find('.product-description').html(first.content);
						el_parent.find('.product-rating').html(first.rate);
						el_parent.find('.tab-thumb-image').html(first.image);
						el_parent.find('.controls-list').html(first.add_to_cart);
						for (var i = 0; i < products.length; i++) {
							slides += '<div data-id="' + products[i].id + '" class="item item-product post-' + products[i].id + '">' + products[i].thumb + '</div>';
						}
						el_parent.find('.related-products-slider').html(slides);
						el_parent.find('.related-products-slider').owlCarousel().data('owlCarousel').reinit({
							items: 4
						});
						init_product_ajax();
					}
				} else {
					console.log(obj);
				}
				jQuery('#preload-ajax').hide();
			},
			error  : function (data) {
			}
		});
	});
	/*Init slider*/
	function init_relate_products_slider(check) {
		if (check) {
			var owl = jQuery('.related-products-slider');
			owl.owlCarousel({
				items     : 4,
				pagination: false,
				rewindNav : false
			});
			// Custom Navigation Events
			jQuery(".next").on('click', function () {
				owl.trigger('owl.next');
			})
			jQuery(".prev").on('click', function () {
				owl.trigger('owl.prev');
			})
		} else {
			jQuery('.related-products-slider').owlCarousel().data('owlCarousel').reinit({
				items: 4
			});
		}
	}

	/**
	 * Init product ajax
	 */
	function init_product_ajax() {
		jQuery(document).ready(function () {
			jQuery('.related-products-slider .item-product').on('click', function () {
				jQuery('#preload-ajax').show();
				var data = jQuery(this).data('id');
				var el_parent = jQuery(this).closest('.vi-woocommerce-product-category-tabs');

				jQuery.ajax({
					type   : 'POST',
					data   : 'data=' + data + '&action=vi_get_product',
					url    : vi_ajax_url,
					success: function (data) {
						var obj = jQuery.parseJSON(data);

						if (obj.check == 'done') {
							var product = obj.msg;
							//console.log(product[0].title);
							el_parent.find('.product-content h2').html(product.title);
							el_parent.find('.price-box').html(product.price);
							el_parent.find('.product-description').html(product.content);
							el_parent.find('.product-rating').html(product.rate);
							el_parent.find('.tab-thumb-image').html(product.image);
							el_parent.find('.controls-list').html(product.add_to_cart);
						} else {
							console.log(obj);
						}

						jQuery('#preload-ajax').hide();
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
							e.preventDefault();
						});
					},
					error  : function (data) {
					}
				});
			});
		});
	}

	function init(check) {
		init_relate_products_slider(check);
		init_product_ajax();
	}

	init(1);
});