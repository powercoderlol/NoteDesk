<?php

/**
 *
 * @package     Note Desk
 * @since       0.0.1
 *
 * Plugin Name: Note Desk
 * Plugin URI: http://vk.com/coderlol
 * Description: Implementation of information desk
 * Version: 0.0.1
 * Author: coderlol
 * Author URI: http://vk.com/coderlol
*/

/**
 * https://semver.org
 */
define( 'NOTE_DESK_VERSION', '0.0.1' );

if ( ! defined( 'NOTEDESK_ABSPATH' ) ) {
	define( 'NOTEDESK_ABSPATH', plugin_dir_path( __FILE__ ) );
}

require_once NOTEDESK_ABSPATH . 'includes/class_note_desk.php';

add_action("plugins_loaded",
	array(note_desk::get_instance(), "init"));



