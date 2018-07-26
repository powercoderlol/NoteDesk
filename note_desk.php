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

// runs during plugin activation
function activate_note_desk() {
	require_once plugin_dir_path(__FILE__) . 'includes\class_note_desk_registration_manager.php';
	note_desk_registration_manager::activate();
}

function deactivate_note_desk() {
	require_once plugin_dir_path(__FILE__) . 'includes\class_note_desk_registration_manager.php';
	//require_once plugin_dir_path(__FILE__) . 'includes\class_note_desk_deactivator.php';
	note_desk_registration_manager::deactivate();
}

register_activation_hook(__FILE__, 'activate_note_desk');
register_deactivation_hook(__FILE__, 'deactivate_note_desk');


require plugin_dir_path(__FILE__) . 'includes/class_note_desk.php';

include 'includes/class_note_desk_db_loader.php';

new note_desk();



