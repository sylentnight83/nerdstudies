tinymce.PluginManager.add('t4p_button', function(ed, url) {
    ed.addCommand("t4pPopup", function ( a, params )
    {
        var popup = 'shortcode-generator';

        if(typeof params != 'undefined' && params.identifier) {
            popup = params.identifier;
        }
        
        // load thickbox
        tb_show("Theme4Press Shortcodes", ajaxurl + "?action=t4p_shortcodes_popup&popup=" + popup + "&width=" + 800);

        jQuery('#TB_window').hide();
                
    });

    // Add a button that opens a window
    ed.addButton('t4p_button', {
        text: '',
        icon: true,
        image: t4pShortcodes.plugin_folder + '/tinymce/images/icon.png',
        cmd: 't4pPopup'
    });
});