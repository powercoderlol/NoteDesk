<?php
/*
Plugin Name: CoderlolDesk
Plugin URI: http://vk.com/coderlol
Description: Implementation of information desk
Version: 1.0
Author: coderlol
Author URI: http://vk.com/coderlol
*/

define('NOTEDESK_ABSPATH', plugin_dir_path(__FILE__) );


function coderlol_add_admin_pages() {
	//Add a new submenu under Options
	add_menu_page('Note Desk','Note Desk','manage_options','commondesk','','dashicons-format-aside');
	add_submenu_page('commondesk','Create a Note','Create a Note','manage_options','commondesk', 'coderlol_option_subpage_0');
	add_submenu_page('commondesk', 'Change a Note', 'Change a Note', 'manage_options', 'commondesk_change_note', 'coderlol_option_subpage_2');
	add_submenu_page('commondesk','Desk Settings','Settings','manage_options','commondesk_settings','coderlol_option_subpage_1');
	//add_submenu_page('commondesk', 'Change a Note', 'Change a Note', 'manage_options', 'commondesk_change_note', 'coderlol_option_subpage_2');
}

/* OPTIONS PAGE EVENTS
****************************************************************/

function coderlol_option_subpage_0() {

	global $wpdb;
	global $post;
	global $note_desk_template;
	global $preview;
	$preview = 'false';
	$table_notes = $wpdb->prefix . "coderlol_notes";

	$coderlol_note_color = "#";



/**

PREVIEW BUTTON EVENT BEGIN

*/
	if ( isset($_POST['coderlol_preview_note_btn']) )
	{

		$preview = 'true';
		//$coderlol_note_color = "#";
		$coderlol_title = stripslashes($_POST['coderlol_title']);
		$coderlol_content = stripslashes($_POST['coderlol_content']);
		$coderlol_category = $_POST['coderlol_category'];
		$coderlol_color = $coderlol_note_color.$_POST['coderlol_note_color'];
		$coderlol_color_transfer = $_POST['coderlol_note_color'];
		$coderlol_font_size = $_POST['coderlol_note_fontsize'];
		$coderlol_note_rotation = $_POST['coderlol_note_rotation'];
		$coderlol_grad = $_POST['grad'];
		if ($coderlol_grad == 'on') { $coderlol_grad='1'; } else { $coderlol_grad = '0'; }
		$coderlol_grad_color = $coderlol_note_color.$_POST['coderlol_note_color_grad'];
		$coderlol_grad_position = $_POST['coderlol_grad_position'];

		if ($coderlol_category == 'Прочее') {
			$coderlol_category = '0';
		}
		else {
			$coderlol_category = '1';
		}


		$note_atts = array(
			"title" => $coderlol_title,
			"content" => $coderlol_content,
			"category" => $coderlol_category,
			"color" => $coderlol_color,
			"font_size" => $coderlol_font_size,
			"note_rotation" => $coderlol_note_rotation,
			"grad" => $coderlol_grad,
			"grad_color" => $coderlol_grad_color,
			"grad_position" => $coderlol_grad_position,
			"update_date" => ''
		);


		$curr_date_object = new DateTime();
		//$curent_date = $curr_date_object->format('d.m.Y');

		echo generate_note_preview($note_atts, $curr_date_object);

		coderlol_ui_subpage_0($coderlol_title, $coderlol_content, $coderlol_category, $coderlol_color_transfer, $coderlol_font_size, $coderlol_note_rotation, $coderlol_grad, $coderlol_grad_color, $coderlol_grad_position, '0');



	}
/**

PREVIEW BUTTON EVENT END

*/

	if ( isset($_POST['coderlol_create_note_btn']) )
	{

		$coderlol_title = stripslashes($_POST['coderlol_title']);
		$coderlol_content = stripslashes($_POST['coderlol_content']);
		$coderlol_category = $_POST['coderlol_category'];
		$coderlol_color = $coderlol_note_color.$_POST['coderlol_note_color'];
		$coderlol_font_size = $_POST['coderlol_note_fontsize'];
		$coderlol_note_rotation = $_POST['coderlol_note_rotation'];
		$coderlol_grad = $_POST['grad'];
		if ($coderlol_grad == 'on') { $coderlol_grad='1'; } else { $coderlol_grad = '0'; }
		$coderlol_grad_color = $coderlol_note_color.$_POST['coderlol_note_color_grad'];
		$coderlol_grad_position = $_POST['coderlol_grad_position'];

		if ($coderlol_category == 'Прочее') {
			$coderlol_category = '0';
		}
		else {
			$coderlol_category = '1';
		}

		//echo $coderlol_content;


		$wpdb->insert
					(
						$table_notes,
						array('title' => $coderlol_title, 'content' => $coderlol_content, 'date' => current_time('mysql'), 'category' => $coderlol_category, 'color' => $coderlol_color, 'fontSize' => $coderlol_font_size, 'rotation' => $coderlol_note_rotation, 'grad' => $coderlol_grad, 'gradColor' => $coderlol_grad_color, 'gradPosition' => $coderlol_grad_position )
					);

		$note_desk_template = create_note_desk_template();
		$fp = fopen( NOTEDESK_ABSPATH . 'template.html','w+');
		$test = fwrite($fp, $note_desk_template);

		//if ($test) echo 'success create new note<br>';
		//else echo 'failed create new note<br>';
		fclose($fp);


		//echo $note_desk_template;
		//note_desk_publishing($template);
		/*$fp = fopen('js/template.html', 'r');
		if ($fp)
		{
			while(!feof($fp))
			{
				$mytext = fgets($fp, 999);
				echo $mytext;
			}
		}
		else echo 'fail';
		fclose($fp);*/


	}

	$note_desk_template = create_note_desk_template();
	$fp = fopen( NOTEDESK_ABSPATH . 'template.html','w+');
	$test = fwrite($fp, $note_desk_template);

	//if ($test) echo 'success load database<br>';
	//else echo 'failed load database<br>';
	fclose($fp);


	if ($preview == 'false' ) { coderlol_ui_subpage_0('','','','FF9999','20', '', '', '0', '', '0'); }

		

}


function coderlol_option_subpage_1() 
{
	if ( isset($_POST['coderlol_desk_settings_btn']) )
	{
		$coderlol_desk_title_var = $_POST['coderlol_desk_title'];
		$coderlol_desk_title_image = $_POST['logo_url_title_bg'];
		$coderlol_desk_image = $_POST['logo_url_desk_bg'];
		$coderlol_desk_title_color = $_POST['coderlol_desk_title_color'];
		$coderlol_desk_color = $_POST['coderlol_desk_color'];
		$coderlol_note_title_height = $_POST['coderlol_note_title_height'];
		$coderlol_desk_title_grad_position = $_POST['coderlol_desk_title_grad_position'];
		$coderlol_desk_grad_position = $_POST['coderlol_desk_grad_position'];
		$coderlol_desk_title_color_grad = $_POST['coderlol_desk_title_color_grad'];
		$coderlol_desk_color_grad = $_POST['coderlol_desk_color_grad'];

		$coderlol_desk_grad = $_POST['grad_desk'];
		if ($coderlol_desk_grad == 'on') { $coderlol_desk_grad='1'; } else { $coderlol_desk_grad = '0'; }
		$coderlol_desk_title_grad = $_POST['grad_desk_title'];
		if ($coderlol_desk_title_grad == 'on') { $coderlol_desk_title_grad='1'; } else { $coderlol_desk_title_grad = '0'; }



		update_option('coderlol_desk_title', $coderlol_desk_title_var);
		update_option('coderlol_desk_title_image', $coderlol_desk_title_image);
		update_option('coderlol_desk_image', $coderlol_desk_image);
		update_option('coderlol_desk_title_color', $coderlol_desk_title_color);
		update_option('coderlol_desk_color', $coderlol_desk_color);
		update_option('coderlol_note_title_height', $coderlol_note_title_height);

		update_option('coderlol_desk_title_grad_position', $coderlol_desk_title_grad_position);
		update_option('coderlol_desk_grad_position', $coderlol_desk_grad_position);
		update_option('coderlol_desk_title_color_grad', $coderlol_desk_title_color_grad);
		update_option('coderlol_desk_color_grad', $coderlol_desk_color_grad);

		update_option('grad_desk', $coderlol_desk_grad);
		update_option('grad_desk_title', $coderlol_desk_title_grad);


		$note_desk_template = create_note_desk_template();
		$fp = fopen( NOTEDESK_ABSPATH . 'template.html','w+');
		$test = fwrite($fp, $note_desk_template);

	}

	coderlol_ui_subpage_1();

	
}

function coderlol_option_subpage_2()
{
	global $note_id;


/**

SUBPAGE 2 PREVIEW
*/

	


	if( isset($_POST['coderlol_delete_note_btn_embadded']) )
	{

		global $wpdb;

		$table_notes = $wpdb->prefix . "coderlol_notes";

		$delete_note_id = get_option('coderlol_last_mod_id');

		$sql = "DELETE FROM ".$table_notes." WHERE id=".$delete_note_id;

		$wpdb->query($sql);

	}

	if( isset($_POST['coderlol_delete_note_btn']) )
	{
		global $wpdb;

		$table_notes = $wpdb->prefix . "coderlol_notes";

		$delete_note_id = $_POST['coderlol_get_note'];

		$sql = "DELETE FROM ".$table_notes." WHERE id=".$delete_note_id;

		$wpdb->query($sql);

	}

	if( isset($_POST['coderlol_update_note_btn']) )
	{
		global $wpdb;
		$search_data = $_POST['coderlol_get_note'];
		$table_notes = $wpdb->prefix . "coderlol_notes";
		//$result = mysql_query("SELECT id, title, content, color, fontSize, category, rotation, grad, gradColor, gradPosition FROM ".$table_notes." WHERE id=".$search_data);
		$result = $wpdb->get_results("SELECT id, title, content, color, fontSize, category, rotation, grad, gradColor, gradPosition FROM ".$table_notes." WHERE id=".$search_data);


		foreach( $result as $row ) {
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$title = $row->title;
			$content = $row->content;
			$color = $row->color;
			$font = $row->fontSize;
			$rotation = $row->rotation;
			$category = $row->category;
			$note_id = $row->id;
			$grad = $row->grad;
			$color_grad = $row->gradColor;
			$grad_position = $row->gradPosition;
		} 

		update_option('coderlol_last_mod_id', $note_id);

		coderlol_ui_subpage_0($title, $content, $category, $color, $font, $rotation, $grad, $color_grad, $grad_position, '1');



	}
	elseif ( isset($_POST['coderlol_preview_note_btn']) )
	{

		global $wpdb;
		$table_notes = $wpdb->prefix . "coderlol_notes";

		//$result = mysql_query("SELECT updateDate FROM ".$table_notes." WHERE id=".$search_data);

		$current_note_id = get_option('coderlol_last_mod_id');

		//$sql = "SELECT date FROM ".$table_notes." WHERE id=".$note_id;
		//$result = mysql_query("SELECT `date`, updateDate FROM ".$table_notes." WHERE id=".$current_note_id);
		$result = $wpdb->get_results("SELECT `date`, updateDate FROM ".$table_notes." WHERE id=".$current_note_id);

		foreach( $result as $row ) {
		//while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
			$current_note_date_string = $row->date;
			$current_note_update_string = $row->updateDate;
			//echo $current_note_date_string;
			$current_note_date_parsed = date_parse_from_format("Y-m-d", $current_note_date_string);
			$current_note_update_parsed = date_parse_from_format("Y-m-d", $current_note_update_string);
			//print_r($current_note_date_parsed);
		} 


		$coderlol_note_color = '#';
		$preview = 'true';
		//$coderlol_note_color = "#";
		$coderlol_title = stripslashes($_POST['coderlol_title']);
		$coderlol_content = stripslashes($_POST['coderlol_content']);
		$coderlol_category = $_POST['coderlol_category'];
		$coderlol_color = $coderlol_note_color.$_POST['coderlol_note_color'];
		$coderlol_color_transfer = $_POST['coderlol_note_color'];
		$coderlol_font_size = $_POST['coderlol_note_fontsize'];
		$coderlol_note_rotation = $_POST['coderlol_note_rotation'];
		$coderlol_grad = $_POST['grad'];
		if ($coderlol_grad == 'on') { $coderlol_grad='1'; } else { $coderlol_grad = '0'; }
		$coderlol_grad_color = $coderlol_note_color.$_POST['coderlol_note_color_grad'];
		$coderlol_grad_position = $_POST['coderlol_grad_position'];

		if ($coderlol_category == 'Прочее') {
			$coderlol_category = '0';
		}
		else {
			$coderlol_category = '1';
		}

		if ($current_note_update_string != null)
		{
			$curr_update_object = new DateTime();
			$curr_update_object->setDate($current_note_update_parsed['year'], $current_note_update_parsed['month'], $current_note_update_parsed['day']);
			$current_update = $curr_update_object->format('d.m.Y');
		}
		else
		{
			$current_update = '';
		}

		$note_atts = array(
			"title" => $coderlol_title,
			"content" => $coderlol_content,
			"category" => $coderlol_category,
			"color" => $coderlol_color,
			"font_size" => $coderlol_font_size,
			"note_rotation" => $coderlol_note_rotation,
			"grad" => $coderlol_grad,
			"grad_color" => $coderlol_grad_color,
			"grad_position" => $coderlol_grad_position,
			"update_date" => $current_update
		);


		$curr_date_object = new DateTime();
		$curr_date_object->setDate($current_note_date_parsed['year'], $current_note_date_parsed['month'], $current_note_date_parsed['day']);
		$curent_date = $curr_date_object->format('d.m.Y');
		//echo $current_date;

		//echo $current_date;

		echo generate_note_preview($note_atts, $curr_date_object);

		coderlol_ui_subpage_0($coderlol_title, $coderlol_content, $coderlol_category, $coderlol_color_transfer, $coderlol_font_size, $coderlol_note_rotation, $coderlol_grad, $coderlol_grad_color, $coderlol_grad_position, '1');

	}
	else 
	{
		codrlol_ui_subpage_2();

	}


	if ( isset($_POST['coderlol_create_note_btn']) )
	{

		global $wpdb;
		$table_notes = $wpdb->prefix . "coderlol_notes";

		$coderlol_note_color = '#';

		$coderlol_title = stripslashes($_POST['coderlol_title']);
		$coderlol_content = stripslashes($_POST['coderlol_content']);
		$coderlol_category = $_POST['coderlol_category'];
		$coderlol_color = $coderlol_note_color.$_POST['coderlol_note_color'];
		$coderlol_font_size = $_POST['coderlol_note_fontsize'];
		$coderlol_note_rotation = $_POST['coderlol_note_rotation'];
		$coderlol_grad = $_POST['grad'];
		if ($coderlol_grad == 'on') { $coderlol_grad='1'; } else { $coderlol_grad = '0'; }
		$coderlol_grad_color = $coderlol_note_color.$_POST['coderlol_note_color_grad'];
		$coderlol_grad_position = $_POST['coderlol_grad_position'];

		if ($coderlol_category == 'Прочее') {
			$coderlol_category = '0';
		}
		else {
			$coderlol_category = '1';
		}

		$note_id = get_option('coderlol_last_mod_id');

		$wpdb->update
					(
						$table_notes,
						array('title' => $coderlol_title, 'content' => $coderlol_content, 'category' => $coderlol_category, 'updateDate' => current_time('mysql'), 'color' => $coderlol_color, 'fontSize' => $coderlol_font_size, 'rotation' => $coderlol_note_rotation, 'grad' => $coderlol_grad, 'gradColor' => $coderlol_grad_color, 'gradPosition' => $coderlol_grad_position ),
						array ( 'ID' => $note_id)
					);

		$note_desk_template = create_note_desk_template();
		$fp = fopen( NOTEDESK_ABSPATH . 'template.html','w+');
		$test = fwrite($fp, $note_desk_template);
		
	}


}


/*****************************************************************/

/* CREATE UI FOR MAIN ADMIN PAGE
/* TinyMCE editor settings
****************************************************************/
/*******************************************************SETTINGS PAGE FOR CREATE NOTE***********************************/
/**

UI SUBPAGE CREATE NOTE
*/
function coderlol_ui_subpage_0($title, $text, $category, $color, $font, $rotation, $grad, $grad_color, $grad_position, $update)
{
$settings = array ('convert_urls' => true, 'relative_urls' => false, 'remove_script_host' => false, 'document_base_url' => 'base_path()');
$editor_id = 'coderlol_content';
if ($update == '1')
{
	$action = '?page=commondesk_change_note&updated=true';
	$formaction = '?page=commondesk_change_note&preview=true';
}
elseif ($update == '2')
{
	//reserved
}
elseif ($update == '0')
{
	$action = '?page=commondesk&created=true';
	$formaction = '?page=commondesk&preview=true';
}
?>
	<h2>Create a Note</h2>
	<p>Автор плагина: <a href="https://www.vk.com/coderlol">Поляков Иван</a>
	<div id='coderlol_commondesk_subpage_0'>
	<form id='coderlol-create-note' name="coderlol_create_note" method="post" action='<?php echo $action ?>' >

		<label><h3>Шорткод:</h3></label>
			<p>					
				<input  type='text' class='coderlol-note-text' disabled value='[coderlol_desk /]'>
			</p>
		<label><h3>Заголовок:</h3></label>
			<p>					
				<textarea id='coderlol_title' name='coderlol_title' type='text' class='coderlol-note-text-title'><?php echo $title ?></textarea>
			</p>
		<label><h3>Текст:</h3></label>
			<div style="width: 70%">
			<?php 	/*<p>					
					<textarea id='coderlol_content' name='coderlol_content' type='text' class='coderlol-note-textarea'></textarea>
					</p>*/
					$content = $text;
					wp_editor( $content, $editor_id, $settings);
			?>
			</div>
		<label><h3>Категория:</h3></label>
			<p>
    			<select id='coderlol_category' name='coderlol_category' class='coderlol-note-select-btn'>
      				<option value='Важное' <?php if ($category=='1') echo 'selected' ?> >Важное</option>
      				<option value='Прочее' <?php if ($category=='0') echo 'selected' ?> >Прочее</option>
    			</select>
    		</p>
    	<label><h3>Цвет:</h3></label>
    		<p>
    			<input id='coderlol_note_color' name='coderlol_note_color' class='jscolor' style='width: 50%' value=<?php echo "'".$color."'" ?>>
    			<input id='coderlol_note_color_grad' name='coderlol_note_color_grad' class='jscolor' value=<?php echo "'".$grad_color."'" ?> >
    			<select id='coderlol_grad_position' name='coderlol_grad_position' type='text' style='visibility: hidden; position: absolute;' >
    				<option value="to top" <?php if ($grad_position=="to top") echo 'selected' ?> >Снизу вверх</option>
    				<option value="to left" <?php if ($grad_position=="to left") echo 'selected' ?> >Справа налево</option>
    				<option value="to bottom" <?php if ($grad_position=="to bottom") echo 'selected' ?> >Сверху вниз</option>
    				<option value="to right" <?php if ($grad_position=="to right") echo 'selected' ?> >Слева направо</option>
    				<option value="to top left" <?php if ($grad_position=="to top left") echo 'selected' ?> >От правого нижнего угла к левому верхнему</option>
    				<option value="to top right" <?php if ($grad_position=="to top right") echo 'selected' ?> >От левого нижнего угла к правому верхнему</option>
    				<option value="to bottom left" <?php if ($grad_position=="to bottom left") echo 'selected' ?> >От правого верхнего угла к левому нижнему</option>
    				<option value="to bottom right" <?php if ($grad_position=="to bottom right") echo 'selected' ?> >От левого верхнего угла к правому нижнему</option>
    			</select>
    		</p>
    		<p>
    			<input id='grad' name='grad' type="checkbox" <?php if ($grad=='1') echo "checked"; ?> >
    			Градиент
    		</p>
    		<p id='grad_ops'></p>
    	<label><h3>Размер шрифта:</h3></label>
    		<p>
    			<input id='coderlol_note_fontsize' type='number' name='coderlol_note_fontsize' min='20' max='25' value=<?php echo "'".$font."'" ?> class='coderlol-note-text'>
    		</p>
    	<label><h3>Наклон:</h3></label>
    		<p>
    			<select id='coderlol_note_rotation' name='coderlol_note_rotation' type='text' class='coderlol-note-select-btn' >
    				<option value='0' <?php if ($rotation=='0') echo 'selected' ?> >Влево</option>
    				<option value='1' <?php if ($rotation=='1') echo 'selected' ?> >Вправо</option>
    				<option value='2' <?php if ($rotation=='2') echo 'selected' ?> >Нет</option>
    			</select>
    		</p>
			<p>
				<input id='coderlol_create_note_btn' name='coderlol_create_note_btn' type='submit' class='coderlol-create-note-btn' value='Сохранить заметку'>
			</p>
			<p>
				<input id='coderlol_preview_note_btn' name='coderlol_preview_note_btn' type='submit' class='coderlol-preview-note-btn' value='Предпросмотр заметки' formaction='<?php echo $formaction ?>'>
			</p>
	</form>

	</div>
	<!-- <p><h3>Предпросмотр доски объявлений:</h3></p>
	<div id='coderlol-note-desk-container-preview'></div> -->
<?php
	if ($update != '0')
	{
		coderlol_ui_subpage_2_1_embadded();
	}
}
/*******************************************************SETTINGS PAGE FOR DESK SETTINGS***********************************/

function coderlol_ui_subpage_1()
{
	$coderlol_desk_title_var = get_option('coderlol_desk_title');
	$coderlol_desk_title_image = get_option('coderlol_desk_title_image');
	$coderlol_desk_image = get_option('coderlol_desk_image');
	$coderlol_desk_title_color = get_option('coderlol_desk_title_color');
	$coderlol_desk_color = get_option('coderlol_desk_color');
	$coderlol_note_title_height = get_option('coderlol_note_title_height');
	$coderlol_desk_title_grad_position = get_option('coderlol_desk_title_grad_position');
	$coderlol_desk_grad_position = get_option('coderlol_desk_grad_position');
	$coderlol_desk_title_color_grad = get_option('coderlol_desk_title_color_grad');
	$coderlol_desk_color_grad = get_option('coderlol_desk_color_grad');
	$coderlol_desk_grad = get_option('grad_desk');
	$coderlol_desk_title_grad = get_option('grad_desk_title');

?>
	<h2>Desk Settings</h2>
	<p>Автор плагина: <a href='https://www.vk.com/coderlol'>Поляков Иван</a>
	<form name="coderlol_settings" method="post" action="?page=commondesk_settings&amp;desk_updated=true">
		<label><h3>Заголовок Доски:</h3></label>
			<p>					
				<input value=<?php echo "'".$coderlol_desk_title_var."'" ?> id='coderlol_desk_title' name='coderlol_desk_title' style='width: 100%;' type='text'>
			</p>
		<label><h3>Фоновое изображение заголовка доски:</h3></label>
		<label><h4>Текущее изображение: </h4></label>
		<p id="current_title_image">
		<?php
			if ($coderlol_desk_title_image != null)
				{ echo "<img src='".$coderlol_desk_title_image."' style='max-width: 250px; max-height: 250px;'> "; }
			else 
				{ echo "НЕТ ИЗОБРАЖЕНИЯ"; }

		?> 
		</p>
			<div>
				<!-- <input value="" id='coderlol_desk_title_bg' name='coderlol_desk_title_bg' type='text' class='coderlol-note-text'> -->
				<input type="text" id='logo_url_title_bg' name='logo_url_title_bg' style='width: 100%; margin-bottom: 10px;' value=<?php echo "'".$coderlol_desk_title_image."'" ?> >
				<input value='Выбрать изображение или загрузить новое' id='upload_image' type='button' class='button button-primary upload-btn'>
				<label><h4>Или укажите цвет: </h4></label>
				<input id='coderlol_desk_title_color' name='coderlol_desk_title_color' class='jscolor' style='width: 50%' value=<?php echo "'".$coderlol_desk_title_color."'" ?>>
				<input id='coderlol_desk_title_color_grad' name='coderlol_desk_title_color_grad' class='jscolor' value=<?php echo "'".$coderlol_desk_title_color_grad."'" ?> >
    			<p>
    				<select id='coderlol_desk_title_grad_position' name='coderlol_desk_title_grad_position' type='text' style='visibility: hidden; position: absolute;' >
    					<option value="to top" <?php if ($coderlol_desk_title_grad_position=="to top") echo 'selected' ?> >Снизу вверх</option>
    					<option value="to left" <?php if ($coderlol_desk_title_grad_position=="to left") echo 'selected' ?> >Справа налево</option>
    					<option value="to bottom" <?php if ($coderlol_desk_title_grad_position=="to bottom") echo 'selected' ?> >Сверху вниз</option>
    					<option value="to right" <?php if ($coderlol_desk_title_grad_position=="to right") echo 'selected' ?> >Слева направо</option>
    					<option value="to top left" <?php if ($coderlol_desk_title_grad_position=="to top left") echo 'selected' ?> >От правого нижнего угла к левому верхнему</option>
    					<option value="to top right" <?php if ($coderlol_desk_title_grad_position=="to top right") echo 'selected' ?> >От левого нижнего угла к правому верхнему</option>
    					<option value="to bottom left" <?php if ($coderlol_desk_title_grad_position=="to bottom left") echo 'selected' ?> >От правого верхнего угла к левому нижнему</option>
    					<option value="to bottom right" <?php if ($coderlol_desk_title_grad_position=="to bottom right") echo 'selected' ?> >От левого верхнего угла к правому нижнему</option>
    				</select>
    			</p>
    			<p>
    				<input id='grad_desk_title' name='grad_desk_title' type="checkbox" <?php if ($coderlol_desk_title_grad=='1') echo "checked"; ?> >
    				Градиент
    			</p>
				<label><h4>Укажите высоту блока заголовка (по умолчанию: 75px):</h4></label>
				<input id='coderlol_note_title_height' type='number' name='coderlol_note_title_height' min='75' value=<?php echo "'".$coderlol_note_title_height."'" ?> class='coderlol-note-text'>
			</div>

		<label><h3>Фоновое изображение контента доски:</h3></label>
		<label><h4>Текущее изображение: </h4></label>
		<p id="current_desk_image">
		<?php
			if ($coderlol_desk_image != null)
				{ echo "<img src='".$coderlol_desk_image."' style='max-width: 250px; max-height: 250px;'> "; }
			else 
				{ echo "НЕТ ИЗОБРАЖЕНИЯ"; }

			?> 
		</p>
			<div>
				<!-- <input value="" id='coderlol_desk_bg' name='coderlol_desk_bg' type='text' class='coderlol-note-text'> -->				
				<input type="text" id='logo_url_desk_bg' name='logo_url_desk_bg' style='width: 100%; margin-bottom: 10px;' value=<?php echo "'".$coderlol_desk_image."'" ?> >
				<input value='Выбрать изображение или загрузить новое' id='upload_image' type='button' class='button button-primary upload-btn'>
				<label><h4>Или укажите цвет: </h4></label>
				<input id='coderlol_desk_color' name='coderlol_desk_color' class='jscolor' style='width: 50%' value=<?php echo "'".$coderlol_desk_color."'" ?>>
				<input id='coderlol_desk_color_grad' name='coderlol_desk_color_grad' class='jscolor' value=<?php echo "'".$coderlol_desk_color_grad."'" ?> >
				<p>
    			<select id='coderlol_desk_grad_position' name='coderlol_desk_grad_position' type='text' style='visibility: hidden; position: absolute;' >
    				<option value="to top" <?php if ($coderlol_desk_grad_position=="to top") echo 'selected' ?> >Снизу вверх</option>
    				<option value="to left" <?php if ($coderlol_desk_grad_position=="to left") echo 'selected' ?> >Справа налево</option>
    				<option value="to bottom" <?php if ($coderlol_desk_grad_position=="to bottom") echo 'selected' ?> >Сверху вниз</option>
    				<option value="to right" <?php if ($coderlol_desk_grad_position=="to right") echo 'selected' ?> >Слева направо</option>
    				<option value="to top left" <?php if ($coderlol_desk_grad_position=="to top left") echo 'selected' ?> >От правого нижнего угла к левому верхнему</option>
    				<option value="to top right" <?php if ($coderlol_desk_grad_position=="to top right") echo 'selected' ?> >От левого нижнего угла к правому верхнему</option>
    				<option value="to bottom left" <?php if ($coderlol_desk_grad_position=="to bottom left") echo 'selected' ?> >От правого верхнего угла к левому нижнему</option>
    				<option value="to bottom right" <?php if ($coderlol_desk_grad_position=="to bottom right") echo 'selected' ?> >От левого верхнего угла к правому нижнему</option>
    			</select>
    			</p>
    			<p>
    			<input id='grad_desk' name='grad_desk' type="checkbox" <?php if ($coderlol_desk_grad=='1') echo "checked"; ?> >
    			Градиент
    			</p>
			</div>
			<div>
				<input id='coderlol_desk_settings_btn' name='coderlol_desk_settings_btn' type='submit' class='coderlol-setting-up-btn' value='Сохранить настройки доски'>
			</div>
	</form>
<?php	
}




/*******************************************************SETTINGS PAGE FOR CHANGING NOTE***********************************/
function codrlol_ui_subpage_2()
{
	$settings = array ('convert_urls' => true, 'relative_urls' => false, 'remove_script_host' => false, 'document_base_url' => 'base_path()');
	$editor_id = 'coderlol_content';
	global $wpdb;
	$table_notes = $wpdb->prefix . "coderlol_notes";
	//$result = mysql_query("SELECT title FROM wp_coderlol_notes");
	//$result = mysql_query("SELECT id, title, date FROM ".$table_notes." ORDER BY id DESC");
	$result = $wpdb->get_results("SELECT id, title, date FROM ".$table_notes." ORDER BY id DESC")


	
?>
	<h2>Change a Note</h2>
	<p>Автор плагина: <a href="https://www.vk.com/coderlol">Поляков Иван</a>
	<div id='coderlol_commondesk_subpage_0'>
	<form id='coderlol_update_note' name='coderlol_update_note' method='post' action='?page=commondesk_change_note'>
		<label><h3>Выберите заметку по заголовку:</h3></label>
		<p>
		<select id='coderlol_get_note' name='coderlol_get_note' type='text' class='coderlol-note-select-btn-settings' size="3">
			<?php
				/*
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

					$note_title_value = $row['title']." ".date("d.m.Y", strtotime($row['date']));
					
					//echo $note_title_value;
					echo("<option value='".$row['id']."'>".$note_title_value."</option>");
				}
				*/
				foreach( $result as $row )
				{
					$note_title_value = $row->title." ".date("d.m.Y", strtotime($row->date));
					echo("<option value='".$row->id."'>".$note_title_value."</option>");
				}
			?>
		</select>
		</p>
		<p>
			<input id='coderlol_update_note_btn' name='coderlol_update_note_btn' type='submit' class='coderlol-create-note-btn' value='Изменить заметку'>
		</p>
		<p>
			<input id='coderlol_delete_note_btn' name='coderlol_delete_note_btn' type='submit' class='coderlol-delete-note-btn' value='Удалить заметку' formaction='?page=commondesk_change_note&deleted=true'>
		</p>
	</form> 
	
	</div>
<?php
	//coderlol_ui_subpage_2_1();
}


function coderlol_ui_subpage_2_1_embadded()
{
?>
	<form method='post' action='?page=commondesk_change_note&deleted=true'>
		<p>
			<input id='coderlol_delete_note_btn' name='coderlol_delete_note_btn_embadded' type='submit' class='coderlol-delete-note-btn' value='Удалить заметку'>
		</p>
	</form>
<?php
}

/***********************************************************************************/

function create_note_desk_template()
{
	global $wpdb;





	$coderlol_box_title = get_option('coderlol_desk_title');
	$coderlol_desk_title_image = get_option('coderlol_desk_title_image');
	$coderlol_desk_image = get_option('coderlol_desk_image');
	$coderlol_desk_title_color = "#".get_option('coderlol_desk_title_color');
	$coderlol_desk_color = "#".get_option('coderlol_desk_color');
	$coderlol_note_title_height = get_option('coderlol_note_title_height');
	$coderlol_desk_title_grad_position = get_option('coderlol_desk_title_grad_position');
	$coderlol_desk_grad_position = get_option('coderlol_desk_grad_position');
	$coderlol_desk_title_color_grad = "#".get_option('coderlol_desk_title_color_grad');
	$coderlol_desk_color_grad = "#".get_option('coderlol_desk_color_grad');
	$coderlol_desk_grad = get_option('grad_desk');
	$coderlol_desk_title_grad = get_option('grad_desk_title');

	$curr_title_style = "";
	$curr_desk_style = "";


/************************************STYLE FOR TITLE FROM SETTINGS**************************/
	if ($coderlol_desk_title_image == null)
	{
		$curr_title_style = "background-color: ".$coderlol_desk_title_color."; ";
	}
	else 
	{
		$curr_title_style = "background-image: url(".$coderlol_desk_title_image."); ";
	}


	if($coderlol_desk_title_grad != '0')
	{
		$curr_title_style = "background: linear-gradient(".$coderlol_desk_title_grad_position.", ".$coderlol_desk_title_color.", ".$coderlol_desk_title_color_grad."); ";
	}

	$curr_title_style = $curr_title_style."height: ".$coderlol_note_title_height."px; ";

/************************************STYLE FOR DESK CONTENT FROM SETTINGS********************/

	if ($coderlol_desk_image == null)
	{
		$curr_desk_style = "background-color: ".$coderlol_desk_color.";";
	}
	else 
	{
		$curr_desk_style = "background-image: url(".$coderlol_desk_image.");";
	}


	if($coderlol_desk_grad != '0')
	{
		$curr_desk_style = "background: linear-gradient(".$coderlol_desk_grad_position.", ".$coderlol_desk_color.", ".$coderlol_desk_color_grad."); ";
	}


/************************************GENERATOR*********************************************/

	$template = $temp.'<div class="coderlol-note-box"><div class="coderlol-note-box-title" style="'.$curr_title_style.'"><div class="coderlol-new-title-box">' . $coderlol_box_title . '</div></div><div class="coderlol-note-box-content" style="'.$curr_desk_style.'">';


	$table_notes = $wpdb->prefix . "coderlol_notes";

	/**
	markers pattern common category
	*/

	$notes = $wpdb->get_results("SELECT id, title, content, category, color, fontSize, rotation, grad, gradColor, gradPosition, date, updateDate,  CASE WHEN (date > updateDate) THEN date WHEN ISNULL(updateDate) THEN date ELSE updateDate END AS mainDate FROM ".$table_notes." ORDER BY 
		mainDate DESC");


	$next_counter = 2;



	//$template = $template . "<div class='coderlol-common-category'>";

	foreach ($notes as $item)
	{

		if($next_counter == 2)
		{
			$template = $template . "<div class='coderlol-common-category'>";
			$template = $template . generate_note($item);
			$next_counter = 1;
		}
		else
		{
			$template = $template . generate_note($item);
			$template = $template . '</div>';
			$next_counter = 2;
		}
	}
	

	$template = $template. '</div></div>';

	/**
	for category - 0
	*---------------------------------------------------------------*/

	/*
	$notes = $wpdb->get_results("SELECT * FROM ".$table_notes." WHERE category='1' ORDER BY id DESC");

	$template = $template . "<div class='coderlol-category-column-first'><label class='coderlol-category-title coderlol-left-title'>Самое важное</label>";


	foreach ($notes as $item)
	{
		//$current_note = generate_note($item);
		$template = $template . generate_note($item);
		/*$notes_date = strtotime($item->date);
		$formated_notes_date = date("d.m.y", $notes_date);
		$template = $template . "<p><label>Номер заметки: ".$item->id."</label></p><p><label>Заголовок: ".$item->title."</label></p><p><label>Текст: ".$item->content."</p></label><p><label>Дата: ".$formated_notes_date."</p></label><br>";
		
	}
	

	$template = $template . '</div>';

	*/

	/**
	for category - 1
	*---------------------------------------------------------------*/
	/*
	$notes = $wpdb->get_results("SELECT * FROM ".$table_notes." WHERE category='0' ORDER BY id DESC");

	$template = $template . "<div class='coderlol-category-column-queue'><label class='coderlol-category-title coderlol-right-title'>Объявления</label>";

	foreach ($notes as $item)
	{
		$template = $template . generate_note($item);
	}

	$template = $template . '</div>';
	

	$template = $template.'</div></div>';
	*/

	/*$notes = $wpdb->get_results("SELECT * FROM ".$table_notes." WHERE category='0' ORDER BY id DESC");

	foreach ($notes as $item)
	{
		$temp = $item->content;
		echo $temp;
	}	

	$tamplate = $tamplate.$temp;
	*/

	$template = do_shortcode($template);

	return $template;

}

function generate_note($item)
{

	$atts = array (
		'current_title' => $item->title,
		'current_content' => $item->content,
		'current_date' => date("d.m.y", strtotime($item->date))
	);

	if ($item->rotation == '1')
	{
		$rotation = 'transform: rotate(1deg);';
	}
	elseif ($item->rotation == '0')
	{
		$rotation = 'transform: rotate(-1deg);';
	}
	else 
	{
		$rotation = 'transform: rotate(0deg);';
	}


	$curr_date = new DateTime();
	$note_date = new DateTime(date("Y-m-d", strtotime($item->date)));
	//echo $curr_date->format('Y-m-d\TH:i:s.u');
	$interval = $note_date->diff($curr_date);
	

	/**
		NEW MARKER
	*/
	if ($interval->days < 7) 
	{
		$new_marker = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: rgba(14, 206, 91, 0.76);">НОВОЕ</label>';
	}
	else
	{
		$new_marker ='';
	}
	/**
		CATEGORY MARKER
	*/
	if($item->category == '1')
	{
		$important_marker = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: rgba(255, 0, 0, 0.95);">ВАЖНОЕ</label>';
	}
	else
	{
		$important_marker = '';
	}
	/**
		UPDATE DATE MARKER
	*/
	if($item->updateDate != null)
	{
		$update_date = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: rgb(6, 212, 202);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="margin-right: 5px;"></i>'.date("d.m.Y", strtotime($item->updateDate)).'</label>';
	}
	else
	{
		$update_date = '';
	}


	if ($item->grad == '1')
	{
		$curr_color_style = "background: linear-gradient(".$item->gradPosition.", ".$item->color.", ".$item->gradColor.");";
	}
	else
	{
		$curr_color_style = "background-color: ".$item->color.";";
	}

	$date_marker = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: #D0C2C2; margin-left: 0px !important;">'.date("d.m.Y", strtotime($item->date)).'</label>';

	$current_note_content = str_replace(array("\r\n", "\r", "\n"), "<br />", $item->content);
	$current_note_title = str_replace(array("\r\n", "\r", "\n"), "<br />", $item->title);

	return '<div class="coderlol-note-outer"><div class="coderlol-note" style="'.$rotation.'"><div class="coderlol-note-inner" style="'.$curr_color_style.'"><label class="coderlol-note-title" style="font-size: '.$item->fontSize.'px;">'.$current_note_title.'</label><br><hr noshade size="1"></hr><div class="coderlol-note-inner-content" style="font-size: '.$item->fontSize.'px;">'.$current_note_content.'</div><br><div style="overflow: hidden; display: block;">'.$date_marker . $update_date . $important_marker . $new_marker . '</div></div></div></div>';

}

/**

GENERATE NOTE PREVIEW BEGIN

*/



function generate_note_preview($note_atts, $date)
{

	$curr_date_object = new DateTime();
	$note_date_object = $date;
	$note_date_string = $note_date_object->format("d.m.Y");


	if ($note_atts['note_rotation'] == '1')
	{
		$rotation = 'transform: rotate(1deg); ';
	}
	elseif ($note_atts['note_rotation'] == '0')
	{
		$rotation = 'transform: rotate(-1deg); ';
	}
	else 
	{
		$rotation = 'transform: rotate(0deg); ';
	}




	//$note_date = new DateTime();
	//echo $curr_date->format('Y-m-d\TH:i:s.u');
	$interval = $note_date_object->diff($curr_date_object);
	
	if ($interval->days < 7) 
	{
		$new_marker = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: #00FF66;">НОВОЕ</label>';
	}
	else
	{
		$new_marker ='';
	}

	/**
		CATEGORY MARKER
	*/
	if($note_atts['category'] == '1')
	{
		$important_marker = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: rgba(255, 0, 0, 0.95);">ВАЖНОЕ</label>';
	}
	else
	{
		$important_marker = '';
	}
	/**
		UPDATE DATE MARKER
	*/
	if($note_atts['update_date'] != null)
	{
		$update_date = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: rgb(6, 212, 202);"><i class="fa fa-pencil-square-o" aria-hidden="true" style="margin-right: 5px;"></i>'.$note_atts['update_date'].'</label>';
	}
	else
	{
		$update_date = '';
	}

	if ($note_atts['grad'] == '1')
	{
		$curr_color_style = "background: linear-gradient(".$note_atts['grad_position'].", ".$note_atts['color'].", ".$note_atts['grad_color'].");";
	}
	else
	{
		$curr_color_style = "background-color: ".$note_atts['color'].";";
	}


	$date_marker = '<label id="coderlol-date-label" class="coderlol-label" style="background-color: #D0C2C2; margin-left: 0px !important;">'.date("d.m.Y", strtotime($note_date_string)).'</label>';

	$current_note_content = str_replace(array("\r\n", "\r", "\n"), "<br />", $note_atts['content']);
	$current_note_title = str_replace(array("\r\n", "\r", "\n"), "<br />", $note_atts['title']);

	$preview_template = '<div class="coderlol-note-outer" style="width: 35%"><div class="coderlol-note" style="'.$rotation.'"><div class="coderlol-note-inner" style="'.$curr_color_style.'"><label class="coderlol-note-title" style="font-size: '.$note_atts['font_size'].'px;">'.$current_note_title.'</label><br><hr noshade size="1"></hr><div class="coderlol-note-inner-content" style="font-size: '.$note_atts['font_size'].'px;">'.$current_note_content.'</div><br><div style="overflow: hidden; display: block;">'.$date_marker . $update_date . $important_marker . $new_marker . '</div></div></div></div>';

	$preview_template = do_shortcode($preview_template);

	return $preview_template;

}





/**

GENERATE NOTE PREVIEW END

*/

function note_desk_publishing($template_data)
{

	$my_id = 1775;
	$post_id_1775 = get_post($my_id);
	$my_content = $post_id_1775->post_content;
	$my_content = $my_content." ".$template_data;
	
	$my_post = array(
		'ID' => $my_id,
		'post_title' => $post_id_1775->post_title,
		'post_content' => $my_content,
	);

	wp_update_post($my_post);

}

/***************************SHORTCODE FOR DESK***************************/
function coderlol_desk( $atts, $content = null ) {
	//$template = create_note_desk_template();

	return create_note_desk_template();
}
/***************************SHORTCODE FOR DESK***************************/

function coderlol_install() {	

	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$table_notes = $wpdb->prefix . 'coderlol_notes';

	$sql =
	"
		CREATE TABLE IF NOT EXISTS " .$table_notes. " (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(500) NOT NULL,
			`content` LONGTEXT NOT NULL,
			`date` DATETIME NOT NULL,
			`category` CHAR(50) NOT NULL DEFAULT '0',
			`color` VARCHAR(50) NOT NULL DEFAULT '#FFFFFF',
			`fontSize` CHAR(50) NOT NULL DEFAULT '20',
			`rotation` CHAR(50) NOT NULL DEFAULT '1',
			`grad` CHAR(50) NOT NULL DEFAULT '0',
			`gradColor` CHAR(50) NOT NULL DEFAULT '#FFFFFF',
			`gradPosition` CHAR(50) NOT NULL DEFAULT 'none',
			`updateDate` DATETIME NULL DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	";

	dbDelta($sql);
	

	add_option('coderlol_desk_title','Доска объявлений');
	add_option('coderlol_desk_title_image','');
	add_option('coderlol_desk_image','');
	add_option('coderlol_desk_title_color', 'FFFFFF');
	add_option('coderlol_desk_color', 'FFFFFF');
	add_option('coderlol_note_title_height', '75');

	add_option('coderlol_last_mod_id', '');

	add_option('coderlol_content','Не задано');

	add_option('grad_desk_title', '0');
	add_option('grad_desk', '0');

	add_option('coderlol_desk_title_grad_position', 'to top');
	add_option('coderlol_desk_grad_position', 'to top');

	add_option('coderlol_desk_title_color_grad', 'FFFFFF');
	add_option('coderlol_desk_color_grad', 'FFFFFF');


	$my_id = 1775;
	$post_id_1775 = get_post($my_id);
	$my_content = $post_id_1775->post_content;
	$my_content = " <div id='coderlol-note-desk-container'></div>".$my_content;
	
	$my_post = array(
		'ID' => $my_id,
		'post_title' => $post_id_1775->post_title,
		'post_content' => $my_content,
	);

	//wp_update_post($my_post);

}

function coderlol_uninstall() {

	global $wpdb;

	$table_notes = $wpdb->prefix . 'coderlol_notes';

	$sql = 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'coderlol_notes';

	//$wpdb->query($sql);

	/*
	delete_option('coderlol_desk_title');
	delete_option('coderlol_content');
	delete_option('coderlol_desk_title_image');
	delete_option('coderlol_desk_image');
	delete_option('coderlol_desk_title_color');
	delete_option('coderlol_desk_color');
	delete_option('coderlol_note_title_height');

	delete_option('coderlol_last_mod_id');
	
	remove_shortcode('coderlol_desk');
	*/
}

function register_coderlol_admin_styles_scripts() {

	/*STYLES*/
	wp_register_style( 'unique-test-plugin-style-admin', plugin_dir_url(__FILE__) .'css/note_desk.css' );
	wp_enqueue_style( 'unique-test-plugin-style-admin' );

	wp_enqueue_style('thickbox');
	/*SCRIPTS*/
	wp_register_script('unique-test-plugin-script-admin', plugin_dir_url(__FILE__) .'js/note_desk_admin.js' );
	wp_enqueue_script( 'unique-test-plugin-script-admin', array('jquery'));

	wp_register_script('jscolor', plugin_dir_url(__FILE__) .'js/jscolor.js' );
	wp_enqueue_script( 'jscolor');

	wp_register_script('my_query', plugin_dir_url(__FILE__) . 'js/my_query.js');
	//wp_enqueue_script( 'ajax-script', plugins_url( '/js/my_query.js', __FILE__ ), array('jquery') );
	wp_localize_script( 'ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );

	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');

}

function register_coderlol_styles_scripts() {

	/*STYLES*/
	wp_register_style( 'unique-test-plugin-style', plugin_dir_url(__FILE__) .'css/note_desk.css' );
	wp_enqueue_style( 'unique-test-plugin-style' );
	/*SCRIPTS*/
	wp_register_script('unique-test-plugin-script', plugin_dir_url(__FILE__) .'js/note_desk.js' );
	wp_enqueue_script( 'unique-test-plugin-script', array('jquery'));
}



function desk_publish()
{
	//fix publish function
	//follow wordpress pattern - use shortcodes
	die();
}

function my_action_callback() {
	global $wpdb;
	$whatever = intval( $_POST['whatever'] );
    echo $whatever;
	wp_die();
}

function success_creating_note() {
	if( isset($_GET['created']) ) 
	{
		if($_GET['created'] == 'true' ) 
		{
	?>
			<div class="notice notice-success is-dismissible">
				<p><h2>ЗАМЕТКА УСПЕШНО СОЗДАНА</h2></p>
			</div>
	<?php
		} else {

		}
	}
}

function success_updating_note() {
	if( isset($_GET['updated']) ) 
	{
		if($_GET['updated'] == 'true' ) 
		{
	?>
			<div class="notice notice-info is-dismissible">
				<p><h2>ЗАМЕТКА УСПЕШНО ОБНОВЛЕНА</h2></p>
			</div>
	<?php
		} else {

		}
	}

	if( isset($_GET['desk_updated']) ) 
	{
		if($_GET['desk_updated'] == 'true' ) 
		{
	?>
			<div class="notice notice-info is-dismissible">
				<p><h2>НАСТРОЙКИ ДОСКИ УСПЕШНО ОБНОВЛЕНЫ</h2></p>
			</div>
	<?php
		} else {

		}
	}

	if( isset($_GET['preview']) ) 
	{
		if($_GET['preview'] == 'true' ) 
		{
	?>
			<div class="notice notice-info is-dismissible">
				<p><h2>ПРЕДПРОСМОТР</h2></p>
			</div>
	<?php
		} else {

		}
	}

}

function success_deleting_note() {
	if( isset($_GET['deleted']) ) 
	{
		if($_GET['deleted'] == 'true' ) 
		{
	?>
			<div class="notice notice-error is-dismissible">
				<p><h2>ЗАМЕТКА УСПЕШНО УДАЛЕНА</h2></p>
			</div>
	<?php
		} else {

		}
	}
}

/*
function coderlol_do_shortcode( $content, $ignore_html = false ) {
    global $shortcode_tags;
 
    if ( false === strpos( $content, '[' ) ) {
        return $content;
    }
 
    if (empty($shortcode_tags) || !is_array($shortcode_tags))
        return $content;
 
    // Find all registered tag names in $content.
    preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
    $tagnames = array_intersect( array_keys( $shortcode_tags ), $matches[1] );
 
    if ( empty( $tagnames ) ) {
        return $content;
    }
 
    $content = do_shortcodes_in_html_tags( $content, $ignore_html, $tagnames );
 
    $pattern = get_shortcode_regex( $tagnames );
    $content = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $content );
 
    // Always restore square braces so we don't break things like <!--[if IE ]>
    $content = unescape_invalid_shortcodes( $content );
 
    return $content;
}
*/

register_activation_hook(__FILE__, 'coderlol_install');
register_deactivation_hook(__FILE__,'coderlol_uninstall');

//add_action('wp_ajax_desk_publish', 'desk_publish');
add_action('wp_enqueue_scripts', 'register_coderlol_styles_scripts');
add_action('admin_enqueue_scripts','register_coderlol_admin_styles_scripts');
add_action('admin_menu', 'coderlol_add_admin_pages');
add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_checkbox_grad', 'checkbox_grad');


add_action('admin_notices','success_creating_note');
add_action('admin_notices','success_deleting_note');
add_action('admin_notices','success_updating_note');

add_filter( 'the_content', 'do_shortcode', 11);

add_shortcode( 'coderlol_desk', 'coderlol_desk');


?>