<?php
/**
  notes db loader
 */

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

//global $wpdb;

class note_desk_db_loader {

	// class for database interactions in Wordpress way
	private $wpdb;

	private $tables_prefix;
	private $tables_array = array();


	private $charset_collate;

	// initialise wpdb instance
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables_prefix = $this->wpdb->prefix . "note_desk_";

		$this->tables_array['desks'] = $this->tables_prefix . "desks";
		$this->tables_array['notes'] = $this->tables_prefix . "notes";

		$this->charset_collate = $this->wpdb->get_charset_collate();
	}

	public function create_tables() {
		$this->create_desks_table();
		$this->create_notes_table();
	}

	public function delete_tables() {
		foreach($this->tables_array as $key => $value) {
			$this->wpdb->query( 'DROP TABLE IF EXISTS ' . $this->tables_array[ $key ] );
		}
	}


	public function archive_database() {
		//TODO: ADD ARCHIVATION MECHANISM: json, csv, xls
	}


	public function load_desk_by_name( $desk_name ) {

		$desks_table_name = $this->tables_array['desks'];
		$notes_table_name = $this->tables_array['notes'];

		$desk_id = $this->wpdb->get_results("SELECT desk_id FROM $desks_table_name WHERE desk_title = $desk_name");
		$notes = $this->wpdb->get_results("SELECT * FROM $notes_table_name WHERE desk_id = $desk_id");

		return $notes;
	}

	public function load_desk_by_id( $id ) {

		$notes_table_name = $this->tables_array['notes'];
		$notes = $this->wpdb->get_results("SELECT * FROM $notes_table_name WHERE desk_id = $id");

		return $notes;
	}

	/*
	private function load_desk_( $id ) {

	}
	*/

	private function create_notes_table() {

		$table_name = $this->tables_array['notes'];

		$sql = "CREATE TABLE IF NOT EXISTS $table_name ( 
		note_id int(11) NOT NULL AUTO_INCREMENT,
		note_title varchar(500) NOT NULL,
		note_content LONGTEXT NOT NULL,
		note_category CHAR(50) NOT NULL DEFAULT '0',
		create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		change_date DATETIME NULL DEFAULT NULL,
		desk_id int(11) NULL,
		PRIMARY KEY  (note_id)
		) $this->charset_collate;";

		dbDelta( $sql );
	}

	private function create_desks_table() {

		$table_name = $this->tables_array['desks'];

		$sql = "CREATE TABLE IF NOT EXISTS $table_name ( 
		desk_id int(11) NOT NULL AUTO_INCREMENT,
		desk_title VARCHAR(50) NOT NULL,
		PRIMARY KEY  (desk_id)
		) $this->charset_collate;";

		dbDelta( $sql );
	}


}