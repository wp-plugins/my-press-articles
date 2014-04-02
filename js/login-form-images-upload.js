jQuery(document).ready(function() {

    var formfield = '';
	var imgurl ='';
 
	jQuery('#upload_login_header_image_button, #upload_login_form_image_button, #upload_login_bg_image_button').click(function() {

        formfield = jQuery(this).prev('input');                
 		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
	});

                
	window.send_to_editor = function(html) {
 		imgurl = jQuery('img', html).attr('src');
 		formfield.val(imgurl);
        tb_remove();
                        
	}
                
});