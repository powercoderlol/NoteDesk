jQuery(document).ready(function($) {

	var checked = jQuery('#grad').attr("checked");
	
	


	if (checked=='checked')
	{

				jQuery('#coderlol_note_color_grad').css('visibility', '');
				jQuery('#coderlol_note_color_grad').css('width', '50%');
				jQuery('#coderlol_grad_position').css('visibility', '');
				jQuery('#coderlol_grad_position').css('width', '50%');
				jQuery('#coderlol_grad_position').css('position', 'inherit');
	}
	else
	{

				jQuery('#coderlol_note_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_note_color_grad').css('width', '0%');
				jQuery('#coderlol_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_grad_position').css('width', '0%');	
				jQuery('#coderlol_grad_position').css('position', 'absolute');		
	}




	var checked_desk_title = jQuery('#grad_desk_title').attr("checked");

	if (checked_desk_title=='checked')
	{

				jQuery('#coderlol_desk_title_color_grad').css('visibility', '');
				jQuery('#coderlol_desk_title_color_grad').css('width', '50%');
				jQuery('#coderlol_desk_title_grad_position').css('visibility', '');
				jQuery('#coderlol_desk_title_grad_position').css('width', '50%');
				jQuery('#coderlol_desk_title_grad_position').css('position', 'inherit');
	}
	else
	{
				jQuery('#coderlol_desk_title_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_desk_title_color_grad').css('width', '0%');
				jQuery('#coderlol_desk_title_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_desk_title_grad_position').css('width', '0%');	
				jQuery('#coderlol_desk_title_grad_position').css('position', 'absolute');		
	}

	var checked_desk = jQuery('#grad_desk').attr("checked");

	if (checked_desk=='checked')
	{

				jQuery('#coderlol_desk_color_grad').css('visibility', '');
				jQuery('#coderlol_desk_color_grad').css('width', '50%');
				jQuery('#coderlol_desk_grad_position').css('visibility', '');
				jQuery('#coderlol_desk_grad_position').css('width', '50%');
				jQuery('#coderlol_desk_grad_position').css('position', 'inherit');
	}
	else
	{
				jQuery('#coderlol_desk_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_desk_color_grad').css('width', '0%');
				jQuery('#coderlol_desk_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_desk_grad_position').css('width', '0%');	
				jQuery('#coderlol_desk_grad_position').css('position', 'absolute');	
	}












	var current_uploadID = '';


	jQuery('.upload-btn').click(function() {

		current_uploadID = jQuery(this).prev('input');

		formfield = jQuery('#upload_image').attr('name');	

		tb_show('Загрузка фонового изображения', 'media-upload.php?type=image&TB_iframe=true&post_id=0', false);

		window.send_to_editor = function(html) {
			var image_url = jQuery('img',html).attr('src');
			current_uploadID.val(image_url);
			if ( current_uploadID.attr('id') == 'logo_url_title_bg' )
				{
					jQuery('#current_title_image').html( function() {
						return '<img src=' + image_url + ' style="max-width: 250px; max-height: 250px;">';
					});
				}
			else if (current_uploadID.attr('id') == 'logo_url_desk_bg' )
				{
					jQuery('#current_desk_image').html( function() {
						return '<img src=' + image_url + ' style="max-width: 250px; max-height: 250px;">';
					});
				}
    		tb_remove();
		}

		return false;

	});

	/*window.send_to_editor = function(html) {
		var image_url = jQuery('img',html).attr('src');
		current_uploadID.val(image_url);
    	tb_remove();
	}*/

	

	
	jQuery('#coderlol_category').change(function() {
		var note_category = jQuery('#coderlol_category').val();
		var setDefaultColor = confirm('Установить цвета по умолчанию?');
		if (setDefaultColor)
		{
			if (note_category == 'Важное')
			{
				jQuery('#coderlol_note_color').val('FF9999');
				jQuery('#coderlol_note_color_grad').val('FFCCCC');
				jQuery('#coderlol_note_color').css('background-color', '#FF9999');
				jQuery('#coderlol_note_color_grad').css('background-color', '#FFCCCC');
			} 
			else
			{
				jQuery('#coderlol_note_color').val('99CC99');
				jQuery('#coderlol_note_color_grad').val('CCFFCC');
				jQuery('#coderlol_note_color').css('background-color', '#99CC99');
				jQuery('#coderlol_note_color_grad').css('background-color', '#CCFFCC');
			}
		}
	});



	jQuery('#grad').change( function () {

			

			var visible = jQuery('#coderlol_note_color_grad').css('visibility');
			if (visible=='hidden')
			{
				jQuery('#coderlol_note_color_grad').css('visibility', '');
				jQuery('#coderlol_note_color_grad').css('width', '50%');
				jQuery('#coderlol_grad_position').css('visibility', '');
				jQuery('#coderlol_grad_position').css('width', '50%');
				jQuery('#coderlol_grad_position').css('position', 'inherit');

			}
			else
			{	
				jQuery('#coderlol_note_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_note_color_grad').css('width', '0%');
				jQuery('#coderlol_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_grad_position').css('width', '0%');	
				jQuery('#coderlol_grad_position').css('position', 'absolute');			
			}




	});


	jQuery('#grad_desk_title').change( function () {

			var visible = jQuery('#coderlol_desk_title_color_grad').css('visibility');
			if (visible=='hidden')
			{
				jQuery('#coderlol_desk_title_color_grad').css('visibility', '');
				jQuery('#coderlol_desk_title_color_grad').css('width', '50%');
				jQuery('#coderlol_desk_title_grad_position').css('visibility', '');
				jQuery('#coderlol_desk_title_grad_position').css('width', '50%');
				jQuery('#coderlol_desk_title_grad_position').css('position', 'inherit');

			}
			else
			{	
				jQuery('#coderlol_desk_title_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_desk_title_color_grad').css('width', '0%');
				jQuery('#coderlol_desk_title_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_desk_title_grad_position').css('width', '0%');	
				jQuery('#coderlol_desk_title_grad_position').css('position', 'absolute');			
			}




	});

	jQuery('#grad_desk').change( function () {

			var visible = jQuery('#coderlol_desk_color_grad').css('visibility');
			if (visible=='hidden')
			{
				jQuery('#coderlol_desk_color_grad').css('visibility', '');
				jQuery('#coderlol_desk_color_grad').css('width', '50%');
				jQuery('#coderlol_desk_grad_position').css('visibility', '');
				jQuery('#coderlol_desk_grad_position').css('width', '50%');
				jQuery('#coderlol_desk_grad_position').css('position', 'inherit');

			}
			else
			{	
				jQuery('#coderlol_desk_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_desk_color_grad').css('width', '0%');
				jQuery('#coderlol_desk_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_desk_grad_position').css('width', '0%');	
				jQuery('#coderlol_desk_grad_position').css('position', 'absolute');			
			}




	});





});