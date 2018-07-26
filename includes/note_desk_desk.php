]<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Poliakov
 * Date: 26.07.2018
 * Time: 21:32
 */

require_once plugin_dir_path(__FILE__) . '\note_desk_note.php';

class note_desk_desk {

	private $id;
	private $title;

	public function __construct(array $initial_data) {
		$this->id    = $initial_data['desk_id'];
		$this->title = $initial_data['desk_title'];
	}

}