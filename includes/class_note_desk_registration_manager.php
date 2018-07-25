<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Poliakov
 * Date: 21.07.2018
 * Time: 13:20
 */

require_once plugin_dir_path(__FILE__) . '\class_note_desk_db_loader.php';

class note_desk_registration_manager {

	public static function activate() {
		$db_loader = new note_desk_db_loader();
		$db_loader->create_tables();
	}

	public static function deactivate() {
		$db_loader = new note_desk_db_loader();
		$db_loader->delete_tables();
	}
}