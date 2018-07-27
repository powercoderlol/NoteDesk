<?php
/**
 *  Main class of note_desk plugin
 */

require_once plugin_dir_path(__FILE__) . 'class_note_desk_db_loader.php';

class note_desk {

	protected static $instance = NULL;

	private $db_loader;

	public static function get_instance() {
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}

	public function __construct() {
		$this->db_loader = new note_desk_db_loader();
	}

	public function init() {
		$this->db_loader->create_tables();
	}

}