<?php

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class notedesk_db_loader {

	private static $nd_prefix = 'note_desk_';
	private static $tables_list = ['desks', 'notes'];


	public static function create_tables() {
		self::create_desks_table();
		self::create_notes_table();

	}


	private static function create_desks_table() {
		global $wpdb;

		$desks_table_name = $wpdb->prefix . self::$nd_prefix . 'desks';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $desks_table_name ( 
		desk_id int(11) NOT NULL AUTO_INCREMENT,
		desk_title VARCHAR(50) NOT NULL,
		PRIMARY KEY  (desk_id)
		) $charset_collate;";

		dbDelta( $sql );
	}

	private static function create_notes_table() {
		global $wpdb;

		$notes_table_name = $wpdb->prefix . self::$nd_prefix . 'notes';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $notes_table_name ( 
		note_id int(11) NOT NULL AUTO_INCREMENT,
		note_title varchar(500) NOT NULL,
		note_content LONGTEXT NOT NULL,
		note_category CHAR(50) NOT NULL DEFAULT '0',
		create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		change_date DATETIME NULL DEFAULT NULL,
		desk_id int(11) NULL,
		PRIMARY KEY  (note_id)
		) $charset_collate;";

		dbDelta( $sql );

	}

	public static function delete_tables() {
		global $wpdb;
		foreach(self::$tables_list as $table_name) {
			$nd_table_name = $wpdb->prefix . self::$nd_prefix . $table_name;
			$wpdb->query( 'DROP TABLE IF EXISTS ' . $nd_table_name );
		}
	}


}