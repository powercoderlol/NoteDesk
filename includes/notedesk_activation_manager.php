<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Poliakov
 * Date: 30.07.2018
 * Time: 22:45
 */



class notedesk_activation_manager {

    public static function activate() {
        // create database tables
        require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_db_loader.php';
        notedesk_db_loader::create_tables();
    }


    public static function deactivate() {

    }

    public static function uninstall() {
        //TODO: archivation tool
        require_once CD_NOTEDESK_ABSPATH . 'includes/notedesk_db_loader.php';
        notedesk_db_loader::delete_tables();
    }
}
