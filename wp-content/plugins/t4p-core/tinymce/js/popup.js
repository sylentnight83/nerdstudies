// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    window.t4p_tb_height = (92 / 100) * jQuery(window).height();
    window.t4p_shortcodes_height = (71 / 100) * jQuery(window).height();
    if(window.t4p_shortcodes_height > 550) {
        window.t4p_shortcodes_height = (74 / 100) * jQuery(window).height();
    }

    jQuery(window).resize(function() {
        window.t4p_tb_height = (92 / 100) * jQuery(window).height();
        window.t4p_shortcodes_height = (71 / 100) * jQuery(window).height();

        if(window.t4p_shortcodes_height > 550) {
            window.t4p_shortcodes_height = (74 / 100) * jQuery(window).height();
        }
    });

    theme4press_shortcodes = {
    	loadVals: function()
    	{
    		var shortcode = $('#_t4p_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.t4p-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('t4p_', ''),		// gets rid of the t4p_ prefix
    				re = new RegExp("{{"+id+"}}","g");
                    var value = input.val();
                    if(value == null) {
                      value = '';
                    }
    			uShortcode = uShortcode.replace(re, value);
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_t4p_ushortcode').remove();
    		$('#t4p-sc-form-table').prepend('<div id="_t4p_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_t4p_cshortcode').text(),
    			pShortcode = '';

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = '<br />';
    			} else {
    				shortcodes = '';
    			}

    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
                if($(this).find('#t4p_slider_type').length >= 1) {
                    if($(this).find('#t4p_slider_type').val() == 'image') {
                        rShortcode = '[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]';
                    } else if($(this).find('#t4p_slider_type').val() == 'video') {
                        rShortcode = '[slide type="{{slider_type}}"]{{video_content}}[/slide]';
                    }
                }
    			$('.t4p-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('t4p_', '')		// gets rid of the t4p_ prefix
    					re = new RegExp("{{"+id+"}}","g");
                        var value = input.val();
                        if(value == null) {
                          value = '';
                        }
    				rShortcode = rShortcode.replace(re, input.val());
    			});

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = shortcodes + rShortcode + '<br />';
    			} else {
    				shortcodes = shortcodes + rShortcode;
    			}
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_t4p_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_t4p_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_t4p_ushortcode').html().replace('{{child_shortcode}}', shortcodes);
            
    		// add updated parent shortcode
    		$('#_t4p_ushortcode').remove();
    		$('#t4p-sc-form-table').prepend('<div id="_t4p_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false,
                onAdd: function(row) {
                    // Get Upload ID
                    var prev_upload_id = jQuery(row).prev().find('.t4p-upload-button').data('upid');
                    var new_upload_id = prev_upload_id + 1;
                    jQuery(row).find('.t4p-upload-button').attr('data-upid', new_upload_id);

                    // activate chosen
                    jQuery('.t4p-form-multiple-select').chosen({
                        width: '100%',
                        placeholder_text_multiple: 'Select Options or Leave Blank for All'
                    });

                    // activate color picker
                    jQuery('.wp-color-picker-field').wpColorPicker({
                        change: function(event, ui) {
                            theme4press_shortcodes.loadVals();
                            theme4press_shortcodes.cLoadVals();
                        }
                    });

                    // changing slide type
                    var type = $(row).find('#t4p_slider_type').val();

                    if(type == 'video') {
                        $(row).find('#t4p_image_content, #t4p_image_url, #t4p_image_target, #t4p_image_lightbox').closest('li').hide();
                        $(row).find('#t4p_video_content').closest('li').show();

                        $(row).find('#_t4p_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
                    }

                    if(type == 'image') {
                        $(row).find('#t4p_image_content, #t4p_image_url, #t4p_image_target, #t4p_image_lightbox').closest('li').show();
                        $(row).find('#t4p_video_content').closest('li').hide();

                        $(row).find('#_t4p_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');   
                    }

                    theme4press_shortcodes.loadVals();
                    theme4press_shortcodes.cLoadVals();
                }
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row',
                cancel: 'div.iconpicker, input, select, textarea, a'
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				t4pPopup = $('#t4p-popup');

            tbWindow.css({
                height: window.t4p_tb_height,
                width: t4pPopup.outerWidth(),
                marginLeft: -(t4pPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: window.t4p_tb_height,
				overflow: 'auto', // IMPORTANT
				width: t4pPopup.outerWidth()
			});

            tbWindow.show();

			$('#t4p-popup').addClass('no_preview');
            $('#t4p-sc-form-wrap #t4p-sc-form').height(window.t4p_shortcodes_height);
    	},
    	load: function()
    	{
    		var	t4p = this,
    			popup = $('#t4p-popup'),
    			form = $('#t4p-sc-form', popup),
    			shortcode = $('#_t4p_shortcode', form).text(),
    			popupType = $('#_t4p_popup', form).text(),
    			uShortcode = '';
    		
            // if its the shortcode selection popup
            if($('#_t4p_popup').text() == 'shortcode-generator') {
                $('.t4p-sc-form-button').hide();
            }

    		// resize TB
    		theme4press_shortcodes.resizeTB();
    		$(window).resize(function() { theme4press_shortcodes.resizeTB() });
    		
    		// initialise
            theme4press_shortcodes.loadVals();
    		theme4press_shortcodes.children();
    		theme4press_shortcodes.cLoadVals();
    		
    		// update on children value change
    		$('.t4p-cinput', form).live('change', function() {
    			theme4press_shortcodes.cLoadVals();
    		});
    		
    		// update on value change
    		$('.t4p-input', form).live('change', function() {
    			theme4press_shortcodes.loadVals();
    		});

            // change shortcode when a user selects a shortcode from choose a dropdown field
            $('#t4p_select_shortcode').change(function() {
                var name = $(this).val();
                var label = $(this).text();
                
                if(name != 'select') {
                    tinyMCE.activeEditor.execCommand("t4pPopup", false, {
                        title: label,
                        identifier: name
                    });

                    $('#TB_window').hide();
                }
            });

            // activate chosen
            $('.t4p-form-multiple-select').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Options'
            });

            // update upload button ID
            jQuery('.t4p-upload-button:not(:first)').each(function() {
                var prev_upload_id = jQuery(this).data('upid');
                var new_upload_id = prev_upload_id + 1;
                jQuery(this).attr('data-upid', new_upload_id);
            });
    	}
	}
    
    // run
    $('#t4p-popup').livequery(function() {
        theme4press_shortcodes.load();

        $('#t4p-popup').closest('#TB_window').addClass('t4p-shortcodes-popup');

        $('#t4p_video_content').closest('li').hide();

            // activate color picker
            $('.wp-color-picker-field').wpColorPicker({
                change: function(event, ui) {
                    setTimeout(function() {
                        theme4press_shortcodes.loadVals();
                        theme4press_shortcodes.cLoadVals();
                    },
                    1);
                }
            });
    });

    // when insert is clicked
    $('.t4p-insert').live('click', function() {                        
        if(window.tinyMCE)
        {
            window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, $('#_t4p_ushortcode').html());
            tb_remove();
        }
    });

    //tinymce.init(tinyMCEPreInit.mceInit['t4p_content']);
    //tinymce.execCommand('mceAddControl', true, 't4p_content');
    //quicktags({id: 't4p_content'});

    // activate upload button
    $('.t4p-upload-button').live('click', function(e) {
	    e.preventDefault();

        upid = $(this).attr('data-upid');

        if($(this).hasClass('remove-image')) {
            $('.t4p-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', '').hide();
            $('.t4p-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', '');
            $('.t4p-upload-button[data-upid="' + upid + '"]').text('Upload').removeClass('remove-image');

            return;
        }

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select Image',
            },
	        frame: 'post',
            multiple: false  // Set to true to allow multiple files to be selected
        });

	    file_frame.open();
      
        $('.media-menu a:contains(Insert from URL)').remove();      

        file_frame.on( 'select', function() {
            var selection = file_frame.state().get('selection');
                selection.map( function( attachment ) {
                attachment = attachment.toJSON();

                $('.t4p-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
                $('.t4p-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

                theme4press_shortcodes.loadVals();
                theme4press_shortcodes.cLoadVals();
            });

            $('.t4p-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
            $('.media-modal-close').trigger('click');
        });

	    file_frame.on( 'insert', function() {
		    var selection = file_frame.state().get('selection');
		    var size = jQuery('.attachment-display-settings .size').val();

		    selection.map( function( attachment ) {
			    attachment = attachment.toJSON();

			    if(!size) {
				    attachment.url = attachment.url;
			    } else {
				    attachment.url = attachment.sizes[size].url;
			    }

			    $('.t4p-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
			    $('.t4p-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

			    theme4press_shortcodes.loadVals();
			    theme4press_shortcodes.cLoadVals();
		    });

		    $('.t4p-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
		    $('.media-modal-close').trigger('click');
	    });
    });

    // activate iconpicker
    $('.iconpicker i').live('click', function(e) {
        e.preventDefault();

        var iconWithPrefix = $(this).attr('class');
        var fontName = $(this).attr('data-name');

        if($(this).hasClass('active')) {
            $(this).parent().find('.active').removeClass('active');

            $(this).parent().parent().find('input').attr('value', '');
        } else {
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().find('input').attr('value', fontName);
        }

        theme4press_shortcodes.loadVals();
        theme4press_shortcodes.cLoadVals();
    });

    // table shortcode
    $('#t4p-sc-form-table .t4p-insert').live('click', function(e) {
        e.stopPropagation();

        var shortcodeType = $('#t4p_select_shortcode').val();

        if(shortcodeType == 'table') {
            var type = $('#t4p-sc-form-table #t4p_type').val();
            var columns = $('#t4p-sc-form-table #t4p_columns').val();

            var text = '<div class="t4p-table table-' + type + '"><table width="100%"><thead><tr>';            

            for(var i=0;i<columns;i++) {
                text += '<th>Column ' + (i + 1) + '</th>';
            }

            text += '</tr></thead><tbody>';

            for(var i=0;i<columns;i++) {
                text += '<tr>';
                if(columns >= 1) {
                    text += '<td>Item #' + (i + 1) + '</td>';
                }
                if(columns >= 2) {
                    text += '<td>Description</td>';
                }
                if(columns >= 3) {
                    text += '<td>Discount:</td>';
                }
                if(columns >= 4) {
                    text += '<td>$' + (i + 1) + '.00</td>';
                }
                if(columns >= 5) {
                    text += '<td>$ 0.' + (i + 1) + '0</td>';
                }                
                text += '</tr>';
            }

            text += '<tr>';
            
            if(columns >= 1) {
                text += '<td><strong>All Items</strong></td>';
            }
            if(columns >= 2) {
                text += '<td><strong>Description</strong></td>';
            }
            if(columns >= 3) {
                text += '<td><strong>Your Total:</strong></td>';
            }
            if(columns >= 4) {
                text += '<td><strong>$10.00</strong></td>';
            }
            if(columns >= 5) {
                text += '<td><strong>Tax</strong></td>';
            }            
            text += '</tr>';
            text += '</tbody></table></div>';

            if(window.tinyMCE)
            {
                window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, text);
                tb_remove();
            }
        }
    });

    // slider shortcode
    $('#t4p_slider_type').live('change', function(e) {
        e.preventDefault();

        var type = $(this).val();
        if(type == 'video') {
            $(this).parents('ul').find('#t4p_image_content, #t4p_image_url, #t4p_image_target, #t4p_image_lightbox').closest('li').hide();
            $(this).parents('ul').find('#t4p_video_content').closest('li').show();

            $('#_t4p_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
        }

        if(type == 'image') {
            $(this).parents('ul').find('#t4p_image_content, #t4p_image_url, #t4p_image_target, #t4p_image_lightbox').closest('li').show();
            $(this).parents('ul').find('#t4p_video_content').closest('li').hide();

            $('#_t4p_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');   
        }
    });

    $('.t4p-add-video-shortcode').live('click', function(e) {
        e.preventDefault();

        var shortcode = $(this).attr('href');
        var content = $(this).parents('ul').find('#t4p_video_content');
        
        content.val(content.val() + shortcode);
        theme4press_shortcodes.cLoadVals();        
    });

    $('#t4p-popup textarea').live('focus', function() {
        var text = $(this).val();

        if(text == 'Your Content Goes Here') {
            $(this).val('');
        }
    });

    $('.t4p-gallery-button').live('click', function(e) {
	    var gallery_file_frame;

        e.preventDefault();

	    alert('To add images to this post or page for attachments layout, navigate to "Upload Files" tab in media manager and upload new images.');

        gallery_file_frame = wp.media.frames.gallery_file_frame = wp.media({
            title: 'Attach Images to Post/Page',
            button: {
                text: 'Go Back to Shortcode',
            },
            frame: 'post',
            multiple: true  // Set to true to allow multiple files to be selected
        });

	    gallery_file_frame.open();
      
        $('.media-menu a:contains(Insert from URL)').remove();

        $('.media-menu-item:contains("Upload Files")').trigger('click');

        gallery_file_frame.on( 'select', function() {
            $('.media-modal-close').trigger('click');

            theme4press_shortcodes.loadVals();
            theme4press_shortcodes.cLoadVals();
        });
    });
});