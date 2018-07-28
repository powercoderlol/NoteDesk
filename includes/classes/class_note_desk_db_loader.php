<?php
/**
 * Note class for database interactions using $wpdb
 * @package NoteDesk
 * @author Ivan Polyakov
 * @since 1.0.0
 */

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


class note_desk_db_loader {

	/**
	 * Current instance of db loader
	 *
	 * @since 1.0.0
	 */
	protected static $instance = NULL;

	/**
	 * Class member to access wpdb class
	 *
	 * @var wpdb
	 * @since 1.0.0
	 */
	private $wpdb;


	/**
	 * Note Desk plugins tables prefix
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $tables_prefix;



	/**
	 * Map of Note Desk plugin tables
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $tables_array = array();


	private $charset_collate;


	public static function get_instance() {
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}

	/**
	 * Initialize wpdb instance as class member
	 * Initialize strings to properly access to DB
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables_prefix = $this->wpdb->prefix . "note_desk_";

		$this->tables_array['desks'] = $this->tables_prefix . "desks";
		$this->tables_array['notes'] = $this->tables_prefix . "notes";

		$this->charset_collate = $this->wpdb->get_charset_collate();
	}


	/**
	 * Create necessary tables to store notes and tables
	 * for future archive
	 *
	 * @since 1.0.0
	 */
	public function create_tables() {
		$this->create_desks_table();
		$this->create_notes_table();
	}

	/**
	 * Delete all created tables for plugin
	 *
	 * @since 1.0.0
	 */
	//TODO: ARCHIVATION FUNCTION
	public function delete_tables() {
		foreach($this->tables_array as $key => $value) {
			$this->wpdb->query( 'DROP TABLE IF EXISTS ' . $this->tables_array[ $key ] );
		}
	}

	/**
	 * Crete wp_note_desk_notes table
	 *
	 * @since 1.0.0
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
	/**
	 * Crete wp_note_desk_desks table
	 *
	 * @since 1.0.0
	 */
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