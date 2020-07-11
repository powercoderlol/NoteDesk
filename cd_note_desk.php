<?php

/**
 * Note Desk plugin bootstrap file
 *
 * @link            http://vk.com/coderlol
 * @since           1.0.0
 * @package         Note Desk
 *
 *
 * @wordpress-plugin
 * Plugin Name:     Note Desk
 * Plugin URI:      https://twitter.com/coderlol1
 * Description:     Implementation of note desk with custom style stickers
 * Version:         1.0.0
 * Author:          Ivan Polyakov
 * Author URI:      https://twitter.com/coderlol1
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     notedesk
 * Domain Path:     /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


/**
 * Note Desk plugin ABSPATH
 * All includes have entry here
 *
 */
if(!defined('CD_NOTEDESK_ABSPATH')) {
    define('CD_NOTEDESK_ABSPATH', plugin_dir_path(__FILE__));
}

/**
 * Currently notdesk version.
 * Using SemVer https://semver.org
 */
define( 'CD_NOTEDESK_VERSION', '1.0.0' );




function activate_notedesk() {
    require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_activation_manager.php';
    notedesk_activation_manager::activate()
;}

function deactivate_notedesk() {
    require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_activation_manager.php';
    notedesk_activation_manager::deactivate();
}

function uninstall_notedesk() {
    require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_activation_manager.php';
    notedesk_activation_manager::uninstall();
}


register_activation_hook(__FILE__, 'activate_notedesk');
register_deactivation_hook(__FILE__, 'deactivate_notedesk');
register_uninstall_hook(__FILE__, 'uninstall_notedesk');



/**
 * Core plugin class
 */
require_once plugin_dir_path(__FILE__) . 'includes/class_notedesk.php';


function run_notedesk() {
    if(class_exists('notedesk')) {
        $plugin = new notedesk();
    }
}

run_notedesk();
