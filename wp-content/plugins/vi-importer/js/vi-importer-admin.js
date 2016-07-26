/**
 * File:  Vi Import
 * Description: Action import data demo, demo files to make site as demo site
 * Author: Andy Ha (admin@villatheme.com)
 * Copyright 2015-2016 villatheme.com. All rights reserved.
 */

/**
 * Function import
 * Call ajax to process
 * @constructor
 */
jQuery(document).ready(function ($) {
	$('.tp_process_messase').css('font-size', 'smaller');
	jQuery('.vi-import-action').on('click', function (event) {
		var r = confirm("Your Theme Options will be removed and demo data will be installed. Do you want to continued ?");
		if (r == true) {

		} else {
			return;
		}
		jQuery('.vi-importer-item').slideUp(500);
		jQuery('.vi-process-bar').slideDown(500);

		var demodata = jQuery(this).data('id');
		vi_import_type('download&demodata=' + demodata, 0);
		jQuery(".vi-import-download").show();
		jQuery(".vi-import-download .meter > span").animate({width: '20px'});
		jQuery(".vi-process-bar").slideDown('fast');
	})
})


function vi_import_type(type, method) {
	jQuery.ajax({
		type      : 'POST',
		data      : 'action=vi_install_demo&method=' + method + '&type=' + type,
		url       : ajaxurl,
		'dataType': 'json',
		success   : function (response) {
			var next_step = response.next;
			var step = response.step;
			var msg_style = "";
			if (response.return) {
				msg_style = ' style="color:#4CAF50;" ';
			} else {
				msg_style = ' style="color:#F44336;" ';
			}
			if (next_step == 'error') {
				if (response.message) {
					jQuery(".vi-import-" + step + " .vi-process-messase").append('<div' + msg_style + '>' + response.message + '</div>');
				}
				if (response.logs) {
					jQuery(".vi-import-" + step + " .vi-process-messase").append('<div' + msg_style + '>' + response.logs + '</div>');
				}
				return;
			} else if ((next_step == 'setting') || (next_step == 'menus') || (next_step == 'slider') || (next_step == 'widgets') || (next_step == 'core') || (next_step == 'extract') || (next_step == 'woo_setting') || (next_step == 'done')) {
				if (step != next_step) {
					jQuery(".vi-import-" + next_step).show();
				}
				if (next_step == 'core') {
					jQuery(".vi-import-" + step + " .meter > span").animate({width: '345px'}, 'slow');
					if (parseInt(jQuery('.vi-import-core .meter > span').width()) < 320) {
						jQuery(".vi-import-core .meter > span").animate({width: parseInt(jQuery('.vi-import-core .meter > span').width()) + 50 + 'px'}, 'slow');
						if (step != next_step) {
							if (response.message) {
								jQuery(".vi-import-" + step + " .vi-process-messase").append('<div' + msg_style + '>' + response.message + '</div>');
							}
						} else if (response.message) {
							jQuery(".vi-import-core .vi-process-messase").append('<div' + msg_style + '>' + response.message + '</div>');
						}

						if (step != next_step) {
							if (response.message) {
								jQuery(".vi-import-" + step + " .vi-process-messase").append('<div' + msg_style + '>' + response.logs + '</div>');
							}
						} else if (response.logs) {
							jQuery(".vi-import-core .vi-process-messase").append('<div' + msg_style + '>' + response.logs + '</div>');
						}


					}
				} else if ((next_step == 'setting') || (next_step == 'menus') || (next_step == 'slider') || (next_step == 'widgets') || (next_step == 'extract') || (next_step == 'woo_setting') || (next_step == 'done')) {
					jQuery(".vi-import-" + step + " .meter > span").animate({width: '345px'}, 'slow');
					if (response.message) {
						jQuery(".vi-import-" + step + " .vi-process-messase").append('<div' + msg_style + '>' + response.message + '</div>');
					}
					if (response.logs) {
						jQuery(".vi-import-" + step + " .vi-process-messase").append('<div' + msg_style + '>' + response.logs + '</div>');
					}
					if (next_step == 'done') {
						alert("Import demo data success!");
						if (villatheme_themeoptions_link) {
							window.location.href = villatheme_themeoptions_link;
						} else {
							return;
						}
					}
					jQuery(".vi-import_" + next_step).show();
					jQuery(".vi-import-" + next_step + " .meter > span").animate({width: '20px'});
				} else {
					jQuery(".vi-import-core .meter > span").animate({width: '345px'}, 'slow');
					if (response.message) {
						jQuery(".vi-import-core .vi-process-messase").append('<div' + msg_style + '>' + response.message + '</div>');
					}
					if (response.logs) {
						jQuery(".vi-import-core .vi-process-messase").append('<div' + msg_style + '>' + response.logs + '</div>');
					}
				}
				vi_import_type(next_step, method);
			}
			else if (next_step == 'revolution_error') {
				var msg = 'Import finish without revolution sliders.You can import manual, please view htvi://villatheme.com/knowledge-base/.';
				jQuery('#vi-process-error-messase').append(msg);
				alert(msg);
			}
			else {
				if (response.message) {
					jQuery('#vi-process-error-messase').append(response.message);
					alert(response.message);
				} else {
					jQuery('#vi-process-error-messase').append('Import error. Please go to http://villatheme.com/support to get the best support.');
					alert('Import error. Please go to http://villatheme.com/support to get the best support.');
				}
			}
		},
		error     : function (html) {
			jQuery('#vi-process-error-messase').append('Import error. Please go to http://villatheme.com/forums to get the best support.');
			alert('Import error 02. Please go to http://villatheme.com/forums to get the best support.');
		}
	});
}
