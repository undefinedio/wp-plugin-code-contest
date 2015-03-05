<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Admin_Pages {

	private $codes = null;

	public function __construct() {
		$this->includes();

		add_action( 'admin_menu', array( &$this, 'add_admin_pages' ) );
	}

	/**
	 * include classes
	 */
	public function includes() {
		include_once( 'codes.php' );
	}

	/**
	 * Inject admin menu
	 */
	public function add_admin_pages() {
		add_menu_page( 'Code Contest', 'Code Contest', 'manage_options', 'code_contest', array(
			&$this,
			'show_admin_template'
		) );

		add_submenu_page( 'code_contest', 'View Entries', 'View Entries', 'manage_options', 'code_contest_entries', array(
			&$this,
			'show_entries_template'
		) );

		add_submenu_page( 'code_contest', 'Generate Codes', 'Generate Codes', 'manage_options', 'code_contest_generate', array(
			&$this,
			'code_contest_generate'
		) );
	}

	/**
	 * Include admin template
	 */
	public function show_admin_template() {
		include( sprintf( "%s/templates/admin.php", dirname( dirname( __FILE__ ) ) ) );
	}

	/**
	 * Include entries template
	 */
	public function show_entries_template() {
		include( sprintf( "%s/templates/entries.php", dirname( dirname( __FILE__ ) ) ) );
	}

	/**
	 * Include code generation template
	 */
	public function code_contest_generate() {
		$this->codes = new Codes();
		include( sprintf( "%s/templates/generate.php", dirname( dirname( __FILE__ ) ) ) );
	}

}