<?php
/**
 * Note Desk Base View with members and methods for all views
 * @package NoteDesk
 * @subpackage Views
 * @author Ivan Polyakov
 * @since 1.0.0
 */

abstract class note_desk_view {


	public function __construct() {
		// MUST be empty
	}

	protected function setup() {

	}

	/**
	 * Register a post meta box for the view
	 *
	 * @since 1.0.0
	 *
	 * @param string   $id            Unique ID for the meta box.
	 * @param string   $title         Title for the meta box.
	 * @param callback $callback      Callback that prints the contents of the post meta box.
	 * @param string   $context       Optional. Context/position of the post meta box (normal, side, additional).
	 * @param string   $priority      Optional. Order of the post meta box for the $context position (high, default, low).
	 * @param bool     $callback_args Optional. Additional data for the callback function (e.g. useful when in different class).
	 */
	protected function add_meta_box( $id, $title,
		$callback, $context = 'normal',
		$priority = 'default', $callback_args = null) {

		add_meta_box($id, $title, $callback, null, $context, $priority, $callback_args);
	}



}