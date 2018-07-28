<?php
/**
 * Note Desk Main Class
 * @package NoteDesk
 * @author Ivan Polyakov
 * @since 1.0.0
 */

//dp loader
require_once NOTEDESK_ABSPATH . 'includes/classes/class_note_desk_db_loader.php';
//entities
require_once NOTEDESK_ABSPATH . 'includes/note_desk_controller.php';
require_once NOTEDESK_ABSPATH . 'includes/note_desk_view.php';
require_once NOTEDESK_ABSPATH . 'includes/note_desk_model.php';
//views
require_once NOTEDESK_ABSPATH . 'includes/views/note_desk_about_view.php';
require_once NOTEDESK_ABSPATH . 'includes/views/note_desk_list_view.php';
//controllers
require_once NOTEDESK_ABSPATH . 'includes/controllers/class_note_desk_admin_controller.php';

class note_desk {

	protected static $instance = NULL;

	private $db_loader;
	private $frontend_admin_controller;

	public static function get_instance() {
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}

	public function __construct() {

	}

	public function init() {

		$this->db_loader = note_desk_db_loader::get_instance();
		$this->db_loader->create_tables();

		$this->frontend_admin_controller = class_note_desk_admin_controller::get_instance();
		add_action('admin_menu', array($this->frontend_admin_controller, 'add_admin_menu_entry'));

	}



}