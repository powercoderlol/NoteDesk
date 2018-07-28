<?php


class class_note_desk_admin_controller  {

	protected static $instance = NULL;

	private $pages;

	private $admin_page_name    = 'Note Desk';
	private $slug               = 'notedesk';
	private $icon               = 'dashicons-format-aside';


	public static function get_instance() {
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}


	public function __construct() {


	}

	private function initialize_pages() {
		$this->pages = array(
			'list'  =>  array(
						'visible'       => 'true',
						'page_title'    => 'All Desks',
			),
			'about' => array(
						'visible'       => 'true',
						'page_title'    => 'About',
			),
		);
	}

	public function add_admin_menu_entry() {

		$show_admin_page_callback = array($this, 'show_admin_page');

		$this->initialize_pages();

		add_menu_page($this->admin_page_name, $this->admin_page_name
			, 'manage_options', $this->slug
			, $show_admin_page_callback
			, $this->icon
		);



		foreach($this->pages as $page => $properties ) {
			if(!$properties['visible'])
				continue;
			$current_slug = ( 'list' !== $page ? $this->slug . '_' . $page : $this->slug );
			add_submenu_page($this->slug, $properties['page_title'], $properties['page_title']
				,'manage_options', $current_slug
				, $show_admin_page_callback
			);

		}


	}

	public function show_admin_page() {
		?>
			<?php _e('Test.'); ?>
		<?php
	}


}
