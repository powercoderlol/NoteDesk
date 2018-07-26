<?php
/**
 * Created by PhpStorm.
 * User: Ivan.Poliakov
 * Date: 26.07.2018
 * Time: 21:07
 */

class note_desk_note {

	private $id;
	private $title;
	private $content;
	private $category;
	private $create_date;
	private $change_date;
	private $desk_id;

	public function __construct(array $initial_data) {
		$this->id          = $initial_data['note_id'];
		$this->title       = $initial_data['note_title'];
		$this->content     = $initial_data['note_content'];
		$this->category    = $initial_data['note_category'];
		$this->create_date = $initial_data['create_date'];
		$this->change_date = $initial_data['change_date'];
		$this->desk_id     = $initial_data['desk_id'];
	}

}