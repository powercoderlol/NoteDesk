<?php
/**
  notes db loader
 */

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

global $wpdb;

class note_desk_db_loader {

	// class for database interactions in Wordpress way
	private $wpdb;
	private $tables_list = array('note_desk_desks', 'note_desk_notes');

	// initialise wpdb instance
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	public function create_tables() {
		$this->create_desks_table();
		$this->create_notes_table();
	}

	public function delete_tables() {

	}

	public function archive_database() {

	}

	private function create_desks_table() {

		$desks_table_name = $this->wpdb->prefix . "note_desk_desks";

		$charset_collate = $this->wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $desks_table_name ( 
		id int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(500) NOT NULL,
		`content` LONGTEXT NOT NULL,
		`date` DATETIME NOT NULL,
		`category` CHAR(50) NOT NULL DEFAULT '0',
		`color` VARCHAR(50) NOT NULL DEFAULT '#FFFFFF',
		`font_size` CHAR(50) NOT NULL DEFAULT '20',
		`rotation` CHAR(50) NOT NULL DEFAULT '1',
		`grad` CHAR(50) NOT NULL DEFAULT '0',
		`grad_color` CHAR(50) NOT NULL DEFAULT '#FFFFFF',
		`grad_position` CHAR(50) NOT NULL DEFAULT 'none',
		`update_date` DATETIME NULL DEFAULT NULL,
		PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta( $sql );

	}

	private function create_notes_table() {

	}





}