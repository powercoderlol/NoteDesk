<?php

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class notedesk_db_loader {

       private static $nd_prefix = 'cd_note_desk_';
       private static $tables_list = ['desks', 'notes'];

       public static function load_one_note(int $note_id) {
              global $wpdb;
              $notes_table_name = $wpdb->prefix . self::$nd_prefix . 'notes';
              $load_note_sql = 'SELECT note_title, short_description, note_content, note_category, create_date, update_date FROM ' . $notes_table_name . ' WHERE note_id='. $note_id .";";
              $result = $wpdb->get_row($sql, ARRAY_A);
              if(null == $result)
                     $result = [];
              return $result;
       }

       public static function load_desk(int $desk_id) {
              // Select all notes where desk_id == $desk_id
       }

       public static function create_tables() {
              self::create_notedesk_tables();
       }

       private static function create_notedesk_tables() {
              global $wpdb;
              $charset_collate = $wpdb->get_charset_collate();

              $desks_table_name = $wpdb->prefix . self::$nd_prefix . 'desks';
              $notes_table_name = $wpdb->prefix . self::$nd_prefix . 'notes';

              $sql_tables = "CREATE TABLE IF NOT EXISTS $desks_table_name ( 
                     desk_id INT(11) NOT NULL AUTO_INCREMENT,
                     desk_title VARCHAR(255) NULL,
                     PRIMARY KEY (desk_id)
              ) $charset_collate;";


              $sql_notes = "CREATE TABLE IF NOT EXISTS $notes_table_name ( 
                     note_id INT(11) NOT NULL AUTO_INCREMENT,
                     note_title VARCHAR(255) NULL,
                     short_description TEXT NULL,
                     note_content LONGTEXT NULL,
                     note_category INT(11) NOT NULL DEFAULT 0,
                     create_date DATETIME NOT NULL,
                     update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                     desk_id int(11) NOT NULL,
                     PRIMARY KEY (note_id)
              ) $charset_collate;";

              dbDelta( $sql_tables );
              dbDelta( $sql_notes );
       }

       public static function delete_tables() {
              global $wpdb;
              foreach(self::$tables_list as $table_name) {
                     $nd_table_name = $wpdb->prefix . self::$nd_prefix . $table_name;
                     $wpdb->query( 'DROP TABLE IF EXISTS ' . $nd_table_name );
              }
       }
}
