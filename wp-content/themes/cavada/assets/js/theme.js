(function ($) {
	"use strict";
	$.avia_utilities = $.avia_utilities || {};
	$.avia_utilities.supported = {};
	$.avia_utilities.supports = (function () {
		var div = document.createElement('div'),
			vendors = ['Khtml', 'Ms', 'Moz', 'Webkit', 'O'];
		return function (prop, vendor_overwrite) {
			if (div.style.prop !== undefined) {
				return "";
			}
			if (vendor_overwrite !== undefined) {
				vendors = vendor_overwrite;
			}
			prop = prop.replace(/^[a-z]/, function (val) {
				return val.toUpperCase();
			});

			var len = vendors.length;
			while (len--) {
				if (div.style[vendors[len] + prop] !== undefined) {
					return "-" + vendors[len].toLowerCase() + "-";
				}
			}
			return false;
		};
	}());

	/* Smartresize */
	(function ($, sr) {
		var debounce = function (func, threshold, execAsap) {
			var timeout;
			return function debounced() {
				var obj = this, args = arguments;

				function delayed() {
					if (!execAsap)
						func.apply(obj, args);
					timeout = null;
				}

				if (timeout)
					clearTimeout(timeout);
				else if (execAsap)
					func.apply(obj, args);
				timeout = setTimeout(delayed, threshold || 100);
			}
		}
		// smartresize
		jQuery.fn[sr] = function (fn) {
			return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
		};
	})(jQuery, 'smartresize');
})(jQuery);

var custom_js = {

	init: function () {
		/*Filter button on shop page*/
		jQuery('.shop-top-button').unbind();
		jQuery('.shop-top-button').on('click', function (e) {
			jQuery('#shop-top').slideToggle();
			e.preventDefault();
		});
		// image top header
		jQuery('#masthead').imagesLoaded(function () {
			var height_header = jQuery('.wrapper-header_overlay .site-header').outerHeight(true);
			//var height_header_mobile = jQuery('#masthead').outerHeight(true);
			var wpadminbar = jQuery('#wpadminbar').outerHeight(true);
			//jQuery('.wrapper-header_overlay').find('.top-site-no-image,.vi-loginForm').css({"padding-top": (height_header + wpadminbar) + 'px'});
			//jQuery('.wrapper-header_overlay').find('.top-site-no-image-custom').css({"padding-top": (height_header + wpadminbar) + 'px'});
			if (height_header > 0) {
				jQuery('.top_site_main').css({"margin-top": (height_header + wpadminbar) + 'px'});
			}
		});
		// add affix header
		jQuery(window).scroll(function () {
			var $header = jQuery('#masthead.sticky-header');
			var $height_banner_top = 2;
			var $topbar_header = jQuery('.topbar-header').outerHeight(true);
			var $height_banner_top = jQuery('.header_v1').outerHeight(true);
			if (jQuery(this).scrollTop() > ($height_banner_top + $topbar_header)) {
				$header.addClass('affix');
				$header.removeClass('affix-top');
			} else {
				$header.removeClass('affix');
				$header.addClass('affix-top');
			}
		});
		// perload
		jQuery(window).load(function () {
			jQuery('#preload').delay(100).fadeOut(500, function () {
				jQuery(this).remove();
			});
		});
		// button mobile menu
		jQuery(".button-collapse").sideNav();
		/*Init Tabs*/
		jQuery('.nav-tabs a').unbind();
		jQuery('.nav-tabs a').click(function (e) {
			e.preventDefault();
			jQuery(this).tab('show')
		});

		// menu scroll
		var adminbar_height = jQuery('#wpadminbar').outerHeight();
		jQuery('.navbar-nav li a,.arrow-scroll > a,a[href^="#"]').click(function (e) {
			if (parseInt(jQuery(window).scrollTop(), 10) < 2) {
				var height = 74;
			} else height = 0;
			var sticky_height = jQuery('#masthead').outerHeight();
			var menu_anchor = jQuery(this).attr('href');
			if (menu_anchor && menu_anchor.indexOf("#") == 0 && menu_anchor.length > 1) {
				e.preventDefault();
				jQuery('html,body').animate({
					scrollTop: jQuery(menu_anchor).offset().top - adminbar_height - sticky_height + height
				}, 850);
			}
			//jQuery('.wrapper-container').removeClass('mobile-menu-open');
		});

		/*Unveil load*/
		jQuery("img.vi-load").unveil(100, function () {
			jQuery(this).load(function () {
				jQuery(this).closest('.product-top').find('.vi-placeholder').hide();
			});
		});
		jQuery('body').bind("added_to_cart", function (event, fragments, cart_hash, $thisbutton) {

			var is_single_product = $thisbutton.hasClass('single_add_to_cart_button');

			var productThumb;
			var productWrap;
			var productImage;

			if (!is_single_product) {
				productWrap = jQuery($thisbutton).parent().parent().parent().parent();
			} else {
				var product_id = parseInt($thisbutton.data('product_id'), 10);
				if (!isNaN(product_id)) {
					productWrap = jQuery('#product-' + product_id);
				}
			}

			if (!is_single_product) {
				setTimeout(function () {
					productWrap.addClass('added').removeClass('active');
				}, 300);
			}

			if (is_single_product) {
				productThumb = jQuery($('.woocommerce-main-image', productWrap)[0]);
				productImage = jQuery('img', productThumb);
			} else {
				if (productWrap.length == 0) {
					return;
				}

				productThumb = jQuery('.product-top', productWrap);

				productImage = jQuery('.product-image > img.primary-image', productWrap);
				if (productImage.length == 0) {
					productImage = jQuery('.product-image > img', productWrap);
				}
			}

			if (productThumb.length == 0) {
				return;
			}

			var position = productThumb.offset();

			jQuery("body").append('<div class="floating-cart"></div>');
			var cart = jQuery('div.floating-cart');
			productImage.clone().appendTo(cart);


			var mini_cart = jQuery('#header-mini-cart');

			if (mini_cart.length == 0) {
				return;
			}

			jQuery(cart).css({
				'top'   : position.top + 'px',
				'left'  : position.left + 'px',
				'width' : productThumb.width() + 'px',
				'height': productThumb.height() + 'px'
			}).fadeIn("slow");


			jQuery(cart).animate({
				'width' : (productThumb.width() / 2) + 'px',
				'height': (productThumb.height() / 2) + 'px',
				top     : '+=' + (productThumb.height() / 4) + 'px',
				left    : '+=' + (productThumb.width() / 4) + 'px'
			}, 400, 'swing', function () {
				jQuery(cart).animate({
					top   : mini_cart.offset().top + 'px',
					left  : mini_cart.offset().left + 'px',
					height: '18px',
					width : '25px'
				}, 800, "swing", function () {
					jQuery('div.floating-cart').fadeIn('fast', function () {
						jQuery('div.floating-cart').remove();
					});

					mini_cart.addClass('animated').addClass('tada');
					setTimeout(function () {
						mini_cart.removeClass('animated').removeClass('tada');
					}, 4000);
				});
			});

		});

	},

	totop: function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#topcontrol').css({bottom: "15px"});
			} else {
				jQuery('#topcontrol').css({bottom: "-100px"});
			}
		});
		jQuery('#topcontrol').click(function () {
			jQuery('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
	},

	sticky_header: function () {
		var $header = jQuery('#masthead.sticky-header.header_default');
		var $content_pusher = jQuery('#wrapper-container .content-pusher');
		//$header.imagesLoaded(function () {
		var height_sticky_header = $header.outerHeight(true);
		$content_pusher.css({"padding-top": height_sticky_header + 'px'});
		jQuery(window).resize(function () {
			var height_sticky_header = $header.outerHeight(true);
			$content_pusher.css({"padding-top": height_sticky_header + 'px'})
		});
	},

	menu: function () {
		jQuery('.navbar-nav li.menu-item-has-children >a,.navbar-nav li.menu-item-has-children >span,.navbar-nav li.widget_area >a,.navbar-nav li.widget_area >span').after('<span class="icon-toggle"><i class="fa fa-sort-desc"></i></span>');
		if (jQuery(window).width() < 768) {
			//jQuery('.navbar-nav >li,.navbar-nav li.standard,.navbar-nav li.standard ul li').hover(
			//	function () {
			//		jQuery(this).children('.sub-menu').stop(true, false).slideDown(250);
			//	},
			//	function () {
			//		jQuery(this).children('.sub-menu').stop(true, false).slideUp(250);
			//	}
			//);
			jQuery('.navbar-nav>li.menu-item-has-children .icon-toggle,.navbar-nav>li.widget_area .icon-toggle').click(function () {
				//alert('test');
				if (jQuery(this).next('ul.sub-menu,div.sub-menu').is(':hidden')) {
					jQuery(this).next('ul.sub-menu,div.sub-menu').slideDown(500, 'linear');
					jQuery(this).html('<i class="fa fa-angle-up"></i>');
				}
				else {
					jQuery(this).next('ul.sub-menu,div.sub-menu').slideUp(500, 'linear');
					jQuery(this).html('<i class="fa fa-angle-down"></i>');
				}
			});
		}
		//else {
		//	jQuery('.navbar-nav>li.menu-item-has-children .icon-toggle,.navbar-nav>li.widget_area .icon-toggle').click(function () {
		//		//alert('test');
		//		if (jQuery(this).next('ul.sub-menu,div.sub-menu').is(':hidden')) {
		//			jQuery(this).next('ul.sub-menu,div.sub-menu').slideDown(500, 'linear');
		//			jQuery(this).html('<i class="fa fa-angle-up"></i>');
		//		}
		//		else {
		//			jQuery(this).next('ul.sub-menu,div.sub-menu').slideUp(500, 'linear');
		//			jQuery(this).html('<i class="fa fa-angle-down"></i>');
		//		}
		//	});
		//}
	},

	menu_one_page: function () {
		var scrollTimer = false, scrollHandler = function () {
			var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
			jQuery('.navbar-nav li a[href^="#"]').each(function () {
				var thisHref = jQuery(this).attr('href');
				if (jQuery(thisHref).length) {
					var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10);
					if (jQuery("#wpadminbar").length) {
						var admin_height = jQuery("#wpadminbar").height();
					} else admin_height = 0;
					var thisPosition = thisTruePosition - (jQuery("#masthead").outerHeight() + admin_height);
					if (scrollPosition <= parseInt(jQuery(jQuery('.navbar-nav li a[href^="#"]').first().attr('href')).height(), 10)) {
						if (scrollPosition >= thisPosition) {
							jQuery('.navbar-nav li a[href^="#"]').removeClass('nav-active');
							jQuery('.navbar-nav li a[href="' + thisHref + '"]').addClass('nav-active');
						}
					} else {
						if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
							jQuery('.navbar-nav li a[href^="#"]').removeClass('nav-active');
							jQuery('.navbar-nav li a[href="' + thisHref + '"]').addClass('nav-active');
						}
					}
				}
			});
		}
		window.clearTimeout(scrollTimer);
		scrollHandler();
		jQuery(window).scroll(function () {
			window.clearTimeout(scrollTimer);
			scrollTimer = window.setTimeout(function () {
				scrollHandler();
			}, 20);
		});
	},

	owl_Carousel: function () {
		if (jQuery().owlCarousel) {
			window.onload = function () {
				var item_teams = jQuery(".vi-video-slider,.related-our-teams .our-teams,.vi-teams-slider .our-teams").data("item");
				jQuery(".vi-video-slider,.related-our-teams .our-teams,.vi-teams-slider .our-teams").owlCarousel({
					items            : item_teams,
					itemsDesktopSmall: [900, 2], // betweem 900px and 601px
					itemsTablet      : [600, 2], //2 items between 600 and 0
					itemsMobile      : [479, 1]
				});
				// Custom Navigation Events
				jQuery(".vi-teams-slider .next").click(function () {
					owl.trigger('owl.next');
				})
				jQuery(".vi-teams-slider .prev").click(function () {
					owl.trigger('owl.prev');
				})
				jQuery(".vi-product-slider").each(function () {
					var $this = jQuery(this);
					var owl = $this.find('.product-slider');
					var $item = owl.data("item");
					var $pagination = owl.data("pagination");

					if ($this.hasClass('fix-responsive')) {
						owl.owlCarousel({
							items            : $item,
							itemsDesktop     : [1199, 2],
							itemsDesktopSmall: [979, 2],
							itemsTablet      : [767, 3],
							itemsTabletSmall : [600, 2],
							itemsMobile      : [479, 1],
							responsive       : true,
							navigation       : false,
							autoPlay         : false,
							pagination       : false,
							baseClass        : 'vi-carousel',
							afterAction      : function () {
								jQuery("img.vi-load").unbind();
								jQuery("img.vi-load").unveil(0, function () {
									jQuery(this).load(function () {
										jQuery(this).closest('.product-top').find('.vi-placeholder').hide();
									});
								});
							}
						});
					} else {
						owl.owlCarousel({
							items            : $item,
							itemsDesktopSmall: [979, 3],
							itemsTablet      : [767, 3],
							itemsTabletSmall : [600, 2],
							itemsMobile      : [479, 1],
							responsive       : true,
							navigation       : false,
							autoPlay         : false,
							pagination       : $pagination,
							baseClass        : 'vi-carousel',
							afterAction      : function () {
								jQuery("img.vi-load").unbind();
								jQuery("img.vi-load").unveil(0, function () {
									jQuery(this).load(function () {
										jQuery(this).closest('.product-top').find('.vi-placeholder').hide();
									});
								});
							}
						});
					}

					owl.owlCarousel({
						items            : $item,
						itemsDesktopSmall: [979, 3],
						itemsTablet      : [767, 2],
						itemsMobile      : [479, 1],
						responsive       : true,
						navigation       : false,
						autoPlay         : false,
						pagination       : false,
						baseClass        : 'vi-carousel',
						afterAction      : function () {
							jQuery("img.vi-load").unbind();
							jQuery("img.vi-load").unveil(0, function () {
								jQuery(this).load(function () {
									jQuery(this).closest('.product-top').find('.vi-placeholder').hide();
								});
							});
						}
					});
					owl.on('changed.owl.carousel', function (e) {
						alert("changed");
					});
					$this.find('.next').click(function () {
						owl.trigger('owl.next')
					});
					$this.find('.prev').click(function () {
						owl.trigger('owl.prev')
					});
				});

				jQuery(".vi-testimonials").each(function () {
					var $this = jQuery(this);
					var owl = $this.find('.vi-inner-testimonials');
					owl.owlCarousel({
						autoPlay  : false,
						singleItem: true,
						responsive: true,
						navigation: false,
						pagination: true
					});
				});

				jQuery(".twitter-feed").each(function () {
					var $this = jQuery(this);
					$this.owlCarousel({
						autoPlay  : true,
						singleItem: true,
						responsive: true,
						navigation: false,
						pagination: false
					});
				});
			}
		}
	}

};

//blog
var blog = {
	post_gallery: function () {
		jQuery('.flexslider').flexslider({
			slideshow     : true,
			animation     : 'fade',
			pauseOnHover  : true,
			animationSpeed: 400,
			smoothHeight  : true,
			directionNav  : false,
			controlNav    : true
		});
	}
};

// jquery product
var product = {
	single_product : function () {
		if (jQuery().flexslider && jQuery(".woocommerce #carousel").length >= 1) {
			var e = 100;
			if (typeof jQuery(".woocommerce #carousel").data("flexslider") != "undefined") {
				jQuery(".woocommerce #carousel").flexslider("destroy");
				jQuery(".woocommerce #slider").flexslider("destroy")
			}
			jQuery(".woocommerce #carousel").flexslider({
				animation    : "slide",
				controlNav   : !1,
				directionNav : !0,
				animationLoop: !1,
				slideshow    : !1,
				itemWidth    : 120,
				maxItems     : 4,
				itemMargin   : 20,
				touch        : !1,
				useCSS       : !1,
				asNavFor     : ".woocommerce #slider",
				smoothHeight : !1
			});
			jQuery(".woocommerce #slider").flexslider({
				animation    : "slide",
				controlNav   : !1,
				directionNav : !1,
				animationLoop: !1,
				slideshow    : !1,
				smoothHeight : !1,
				touch        : !0,
				useCSS       : !1,
				sync         : ".woocommerce #carousel"
			});
		}
	},
	quick_view     : function () {
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
	mini_cart      : function () {
		jQuery(document).on('click', '.minicart_hover', function () {
			jQuery(this).next('.widget_shopping_cart_content').slideDown();
		}).on('mouseleave', '.minicart_hover', function () {
			jQuery(this).next('.widget_shopping_cart_content').delay(100).stop(true, false).slideUp();
		});
		jQuery(document).on('mouseenter', '.widget_shopping_cart_content', function () {
			jQuery(this).stop(true, false).show()
		}).on('mouseleave', '.widget_shopping_cart_content', function () {
			jQuery(this).delay(100).stop(true, false).slideUp()
		});
	},
	check_list_grid: function () {
		/* Product Grid, List Switch */
		var listSwitcher = function () {
			var activeClass = 'switcher-active';
			var gridClass = 'product-grid';
			var listClass = 'product-list';
			jQuery('.switchToList').click(function () {
				if (!jQuery.cookie('products_page') || jQuery.cookie('products_page') == 'grid') {
					switchToList();
				}
			});
			jQuery('.switchToGrid').click(function () {
				if (!jQuery.cookie('products_page') || jQuery.cookie('products_page') == 'list') {
					switchToGrid();
				}
			});

			function switchToList() {
				jQuery('.switchToList').addClass(activeClass);
				jQuery('.switchToGrid').removeClass(activeClass);
				jQuery('.archive_switch').fadeOut(300, function () {
					jQuery(this).removeClass(gridClass).addClass(listClass).fadeIn(300);
					jQuery.cookie('products_page', 'list', {expires: 3, path: '/'});
				});
			}

			function switchToGrid() {
				jQuery('.switchToGrid').addClass(activeClass);
				jQuery('.switchToList').removeClass(activeClass);
				jQuery('.archive_switch').fadeOut(300, function () {
					jQuery(this).removeClass(listClass).addClass(gridClass).fadeIn(300);
					jQuery.cookie('products_page', 'grid', {expires: 3, path: '/'});
				});
			}
		}

		var check_view_mod = function () {
			var activeClass = 'switcher-active';
			if (jQuery.cookie('products_page') == 'grid') {
				jQuery('.archive_switch').removeClass('product-list').addClass('product-grid');
				jQuery('.switchToGrid').addClass(activeClass);
			} else if (jQuery.cookie('products_page') == 'list') {
				jQuery('.archive_switch').removeClass('product-grid').addClass('product-list');
				jQuery('.switchToList').addClass(activeClass);
			}
			else {
				jQuery('.switchToGrid').addClass(activeClass);
				jQuery('.archive_switch').removeClass('product-list').addClass('product-grid');
			}
		}
		if (jQuery("body.woocommerce").length) {
			check_view_mod();
			listSwitcher();
		}
	}
};

// jquery shortcode
var short_code_js = {
	bg_video      : function () {
		jQuery(document).delegate('.bg-video-play', "click", function () {
			if (jQuery(".full-screen-video").get(0).paused) {
				jQuery('.full-screen-video').get(0).play();
				jQuery(this).addClass('bg-pause');
			} else {
				jQuery('.full-screen-video').get(0).pause();
				jQuery(this).removeClass('bg-pause');
			}
		});
	},
	/*Vi Product Category*/
	vi_product_cat: function () {
		jQuery('.vi-product-img').unbind();
		jQuery('.vi-product-img').hover(function () {
				var img_src = jQuery(this).data('image');
				if (img_src) {
					jQuery(this).closest('.vi-product-category-wrapper').find('.vi-product-category-img').attr('src', img_src);
				}
			}, function () {
				var or_img = jQuery(this).closest('.vi-product-category-wrapper').find('.vi-product-category-img').data('default-src');
				if (or_img) {
					jQuery(this).closest('.vi-product-category-wrapper').find('.vi-product-category-img').attr('src', or_img);
				}
			}
		);
	},

	/*Deal of day*/
	deal_of_day: function () {
		if (jQuery().mbComingsoon) {
			jQuery('.dealofday-timer').each(function () {
				var data = jQuery(this).data();
				//console.log(data);
				var date_text = data.text;
				date_text = date_text.split(',');
				jQuery(this).mbComingsoon({
					expiryDate  : new Date(data.year, (data.month - 1), data.date, data.hour, data.min, data.sec),
					speed       : 500,
					gmt         : data.gmt,
					showText    : 1,
					localization: {
						days   : date_text[0],
						hours  : date_text[1],
						minutes: date_text[2],
						seconds: date_text[3]
					}
				});
			});
		}
		if (jQuery().magnify) {
			jQuery('.woocommerce-main-image.zoom img').each(function () {
				jQuery(this).magnify();
			});
		}
	}
};

var search = {
	button_search: function () {
		jQuery("#header-search").on('click', function (e) {
			e.preventDefault();
			jQuery('.wrapper-header-search-form').addClass('open');
			jQuery('.header-search-form-input #s').focus();
		});

		jQuery('.search-popup-bg').bind('touchstart click', function () {
			jQuery('.wrapper-header-search-form').removeClass("open");
		});
		jQuery('.vi_search_form').on('keyup', function (event) {
			if (event.which == 27) {
				jQuery('.wrapper-header-search-form').removeClass("open");
				jQuery(this).val('');
				jQuery(this).stop();
				jQuery('.vi-search-results').html('');
			}
		});
	},
	search_result: function () {
		function search(waitKey) {
			var keyword = jQuery('.vi-search-input').val();
			var limit = jQuery('.vi-search-input').data('limit');
			if (keyword) {
				if (!waitKey && keyword.length < 3) {
					return;
				}
				//jQuery('.vi_search_form').html('<i class="fa fa-spinner fa-spin"></i>');
				jQuery('.vi_search_form').addClass('search-loading');
				jQuery.ajax({
					type   : 'POST',
					data   : 'action=vi_ajax_search&keyword=' + keyword + '&limit=' + limit,
					url    : ajaxurl,
					success: function (html) {
						var data_li = '';
						var items = jQuery.parseJSON(html);
						jQuery.each(items, function (index) {
							if (index == 0 && parseInt(this['id']) != 0) {
								data_li += '<li class="ui-menu-item' + this['id'] + ' selected"><a id="ui-id-' + this['id'] + '" class="ui-corner-all" href="' + this['guid'] + '"><span class="search-title">' + this['title'] + '</span><span class="search-date">' + this['date'] + '</span></a></li>';
							}
							else if (parseInt(this['id']) != 0) {
								data_li += '<li class="ui-menu-item' + this['id'] + '"><a id="ui-id-' + this['id'] + '" class="ui-corner-all" href="' + this['guid'] + '"><span class="search-title">' + this['title'] + '</span><span class="search-date">' + this['date'] + '</span></a></li>';
							}
							else {
								data_li += '<li class="ui-menu-item' + this['id'] + '"><a id="ui-id-' + this['id'] + '" class="ui-corner-all" href="' + this['guid'] + '"><span class="search-title">' + this['title'] + '</span></a></li>';
							}

						});
						jQuery('.vi-search-results').html('').append(data_li);
						jQuery('.vi_search_form').removeClass('search-loading');
					},
					error  : function (html) {
					}
				});
			}
		};
		jQuery('.vi-search-input').on('keyup', function (event) {
			clearTimeout(jQuery.data(this, 'timer'));
			if (event.which == 13) {
				event.preventDefault();
				jQuery(this).stop();
			} else if (event.which == 38) {
				if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
					var selected = jQuery(".selected");
					jQuery(".vi-search-results li").removeClass("selected");

					// if there is no element before the selected one, we select the last one
					if (selected.prev().length == 0) {
						selected.siblings().last().addClass("selected");
					} else { // otherwise we just select the next one
						selected.prev().addClass("selected");
					}
				}
			} else if (event.which == 40) {
				if (navigator.userAgent.indexOf('Chrome') != -1 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15) {
					var selected = jQuery(".selected");
					jQuery(".vi-search-results li").removeClass("selected");

					// if there is no element before the selected one, we select the last one
					if (selected.next().length == 0) {
						selected.siblings().first().addClass("selected");
					} else { // otherwise we just select the next one
						selected.next().addClass("selected");
					}
				}
			} else if (event.which == 27) {
				jQuery('.main-header-search-form-input').hide();
				jQuery('.header .sm-logo,.header nav').css({'opacity': 1});
				jQuery('.header-search-close').html('<i class="fa fa-times"></i>');
				jQuery('.vi-search-results').html('');
				jQuery(this).val('');
				jQuery(this).stop();
			} else {
				jQuery(this).data('timer', setTimeout(search, 1000));
			}
		});
		jQuery('.vi-search-input').on('keypress', function (event) {
			if (event.keyCode == 13) {
				var selected = jQuery(".selected");
				if (selected.length > 0) {
					var ob_href = selected.find('a').first().attr('href');
					window.location.href = ob_href;
				}
				event.preventDefault();
			}
			if (event.keyCode == 27) {
				jQuery('.main-header-search-form-input').hide();
				jQuery('.header .sm-logo,.header nav').css({'opacity': 1});
			}
			if (event.keyCode == 38) {
				var selected = jQuery(".selected");
				jQuery(".vi-search-results li").removeClass("selected");

				// if there is no element before the selected one, we select the last one
				if (selected.prev().length == 0) {
					selected.siblings().last().addClass("selected");
				} else { // otherwise we just select the next one
					selected.prev().addClass("selected");
				}
			}
			if (event.keyCode == 40) {
				var selected = jQuery(".selected");
				jQuery(".vi-search-results li").removeClass("selected");

				// if there is no element before the selected one, we select the last one
				if (selected.next().length == 0) {
					selected.siblings().first().addClass("selected");
				} else { // otherwise we just select the next one
					selected.next().addClass("selected");
				}
			}
		});
	},
}

function SmoothTransition() {
	jQuery(window).focus(function () {
		jQuery('.wrapper-container').fadeIn(0);
	});
	jQuery('a').not('.yith_magnifier_thumbnail').click(function (e) {
		var a = jQuery(this);
		var attr = jQuery(this).attr('href');

		// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
		if (typeof attr !== typeof undefined && attr !== false) {
			if (
				e.which == 1 && // check if the left mouse button has been pressed
				(typeof a.data('rel') === 'undefined') && //Not pretty photo link
				(typeof a.attr('rel') === 'undefined') && //Not VC pretty photo link
				!a.hasClass('eltd-like') && //Not like link
				a.attr('href').indexOf(window.location.host) >= 0 && // check if the link is to the same domain
				(typeof a.attr('target') === 'undefined' || a.attr('target') === '_self') // check if the link opens in the same window
			) {
				e.preventDefault();
				if (a.parents('.shop-top').length > 0) {

				} else if (a.attr('href').match(/^#/gi)) {

				} else {
					jQuery('.wrapper-container').fadeOut(1000, function () {
						window.location = a.attr('href');
					});
				}
			}
		} else {
			return false;
		}
	});

}


jQuery(document).ready(function ($) {
	custom_js.init();
	custom_js.totop();
	custom_js.sticky_header();
	custom_js.menu();
	custom_js.menu_one_page();
	custom_js.owl_Carousel();

	// jquery blog
	blog.post_gallery();
	//blog.blog_masonry();

	// jquery product
	product.mini_cart();
	product.quick_view();
	product.single_product();
	//product.check_list_grid();

	// jquery shortcode
	short_code_js.bg_video();
	short_code_js.deal_of_day();
	short_code_js.vi_product_cat();

	// search
	search.button_search();
	search.search_result();

	SmoothTransition();
});