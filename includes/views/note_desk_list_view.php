<?php
/**
 * Main Admin Note Desk View
 *
 * @package NoteDesk
 * @author Ivan Polyakov
 * @since 1.0.0
 */

class note_desk_list_view extends note_desk_view {

	public function setup() {
		parent::setup();
		$this->add_meta_box('Test', 'Test', array($this, 'test'), 'normal');
	}

	public function test( array $data, array $box) {
		?>
			<p>
				<?php _e('Test.'); ?>
			</p>
		<?php
	}
}