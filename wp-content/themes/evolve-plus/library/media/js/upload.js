jQuery(document).ready(function($){
    if($('.evolve_upload_button').length >= 1) {
        window.evolve_uploadfield = '';

        $('.evolve_upload_button').live('click', function() {
            window.evolve_uploadfield = $('.upload_field', $(this).parent());
            tb_show('Upload', 'media-upload.php?type=image&TB_iframe=true', false);

            return false;
        });

        window.evolve_send_to_editor_backup = window.send_to_editor;
        window.send_to_editor = function(html) {
            if(window.evolve_uploadfield) {
                if($('img', html).length >= 1) {
                    var image_url = $('img', html).attr('src');
                } else {
                    var image_url = $($(html)[0]).attr('href');
                }
                $(window.evolve_uploadfield).val(image_url);
                window.evolve_uploadfield = '';
                
                tb_remove();
            } else {
                window.evolve_send_to_editor_backup(html);
            }
        }
    }
});