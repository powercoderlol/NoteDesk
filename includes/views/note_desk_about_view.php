<?php
/**
 * About Note Desk View
 *
 * @package NoteDesk
 * @author Ivan Polyakov
 * @since 1.0.0
 */

class note_desk_about_view extends note_desk_view {

	public function setup() {
		parent::setup();
		$this->add_meta_box('plugin_purpose', 'Plugin Purpose', array($this, 'print_plugin_purpose'), 'normal');
	}

	public function print_plugin_purpose( array $data, array $box) {
		?>
		<p>
			<?php _e('Implementation of announcement with stickers.'); ?>
			<?php _e('You can customize style of each new sticker and reuse it.'); ?>
			<?php _e('It\'s fucking awesome, I suppose!'); ?>
		</p>

		<?php
	}



}