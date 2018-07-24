<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Poliakov
 * Date: 21.07.2018
 * Time: 13:21
 */

require_once plugin_dir_path(__FILE__) . '\class_note_desk_db_loader.php';

class note_desk_deactivator {

	public static function deactivate() {
		$db_loader = new note_desk_db_loader();
		$db_loader->delete_tables();
	}
}