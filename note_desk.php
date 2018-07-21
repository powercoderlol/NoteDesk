<?php

/**
 *
 * @package     Note Desk
 * @since       0.0.1
 *
 * Plugin Name: CoderlolDesk
 * Plugin URI: http://vk.com/coderlol
 * Description: Implementation of information desk
 * Version: 0.0.1
 * Author: coderlol
 * Author URI: http://vk.com/coderlol
*/

/**
 * https://semver.org
 */
define( 'PLUGIN_NAME_VERSION', '0.0.1' );

// runs during plugin activation
function activate_note_desk() {
	require_once plugin_dir_path(__FILE__) . 'includes\class_note_desk_activator.php';
}

function deactivate_note_desk() {
	require_once plugin_dir_path(__FILE__) . 'includes\class_note_desk_deactivator.php';
}

register_activation_hook(__FILE__, 'activate_note_desk');
register_deactivation_hook(__FILE__, 'deactivate_note_desk');


require plugin_dir_path(__FILE__) . 'includes/class_note_desk.php';

include 'includes/class_notes_db_loader.php';




