<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Poliakov
 * Date: 30.07.2018
 * Time: 22:43
 */

class notedesk {
    public function __construct() {
        //self::$instance = $this;
    }

    //private static $instance;
    //public static function get_instance() {
    //    return self::$instance;
    //}


    // Render functions
    public function render_desk(int $desk_id) {
    }

    private function get_full_note(int $note_id) {
        require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_db_loader.php';
        require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_renderer.php';
        $note_data = notedesk_db_loader::load_one_note($note_id);
        $rendered_data = notedesk_renderer::render_full_note($note_data);
        return $rendered_data;
    }

    private function get_short_note(int $note_id) {
    }

    private function note_details_shortcode($atts) {
        //extract(shortcode_atts(array(
        //    'id' => 1,
        //), $atts));
        //$rendered = $this->get_full_note($id);
        // TODO: do_shortcode for internal usage
        //return $rendered;
        return '<div></div>';
    }

    private function activate_admin_assets() {
        wp_enqueue_style('notedesk_style', CD_NOTEDESK_ABSPATH . 'assets/css/style.css', false, NULL, 'all');
        //wp_enqueue_script( 'notedesk_script', CD_NOTEDESK_ABSPATH . 'assets/js/notedesk.js', false, NULL, 'all');
    }

    private function activate_scripts() {
    }

    // Activation hooks function
    public function activate() {
        $this->activate_admin_assets();
        // register_shortcodes
        add_shortcode('note-details', array($this, 'note_details_shortcode'));
    }
}
