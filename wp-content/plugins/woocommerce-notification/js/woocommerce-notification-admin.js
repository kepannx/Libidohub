'use strict';
jQuery(document).ready(function () {
	jQuery('.vi-ui.tabular.menu .item').tab();
	jQuery('.vi-ui.checkbox').checkbox();
	jQuery('select.vi-ui.dropdown').dropdown();

	/*Add field depend*/
	/*Products*/
	jQuery('.get_from_billing').dependsOn({
		'select[name="wnotification_params[archive_page]"]': {
			values: ['0']
		}
	});
	jQuery('.select_product').dependsOn({
		'select[name="wnotification_params[archive_page]"]': {
			values: ['1']
		}
	});
	jQuery('.virtual_address').dependsOn({
		'select[name="wnotification_params[country]"]': {
			values: ['1']
		}
	});
	jQuery('.detect_address').dependsOn({
		'select[name="wnotification_params[country]"]'        : {
			values: ['0']
		}, 'select[name="wnotification_params[archive_page]"]': {
			values: ['1']
		}
	});
	jQuery('select[name="wnotification_params[archive_page]"]').on('change', function () {
		var data = jQuery(this).val();
		console.log(data);
		if (data == 0) {
			jQuery('.virtual_address').hide();
		} else {
			var data1 = jQuery('select[name="wnotification_params[country]"]').val();
			if (data1 > 0) {
				jQuery('.virtual_address').show();
			}
		}
	});
	/*Time*/
	jQuery('.time_loop').dependsOn({
		'input[name="wnotification_params[loop]"]': {
			checked: true
		}
	});
	/*Logs*/
	jQuery('.save_logs').dependsOn({
		'input[name="wnotification_params[save_logs]"]': {
			checked: true
		}
	});
// Color picker
	jQuery('.color-picker').iris({
		change: function (event, ui) {
			jQuery(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
			var ele = jQuery(this).data('ele');
			if (ele == 'highlight') {
				jQuery('#message-purchased').find('a').css({'color': ui.color.toString()});
			} else if (ele == 'textcolor') {
				jQuery('#message-purchased').css({'color': ui.color.toString()});
			} else {
				jQuery('#message-purchased').css({backgroundColor: ui.color.toString()});
			}
		},
		hide  : true,
		border: true
	}).click(function () {
		jQuery('.iris-picker').hide();
		jQuery(this).closest('td').find('.iris-picker').show();
	});

	jQuery('body').click(function () {
		jQuery('.iris-picker').hide();
	});
	jQuery('.color-picker').click(function (event) {
		event.stopPropagation();
	});
	jQuery('input[name="wnotification_params[position]"]').on('change', function () {
		var data = jQuery(this).val();
		if (data == 1) {
			jQuery('#message-purchased').removeClass('top_left top_right').addClass('bottom_right');
		} else if (data == 2) {
			jQuery('#message-purchased').removeClass('bottom_right top_right').addClass('top_left');
		} else if (data == 3) {
			jQuery('#message-purchased').removeClass('bottom_right top_left').addClass('top_right');
		} else {
			jQuery('#message-purchased').removeClass('bottom_right top_left top_right');
		}
	});
	jQuery('select[name="wnotification_params[image_position]"]').on('change', function () {
		var data = jQuery(this).val();
		if (data == 1) {
			jQuery('#message-purchased').addClass('img-right');
		} else {
			jQuery('#message-purchased').removeClass('img-right');
		}
	})
});