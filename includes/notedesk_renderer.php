<?php

class notedesk_renderer {

    public static function render_full_note($note_data) {
        if(0 == count($note_data))
            return "<div></div>";
        return "<div>" . $note_data['note_title'] . "</div>";
    }


}