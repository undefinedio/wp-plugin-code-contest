<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Admin_Pages {
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;
	private $codes = null;

	public function __construct() {
		$this->includes();

		add_action( 'admin_menu', array( &$this, 'add_admin_pages' ) );
		add_action( 'admin_init', array( &$this, 'register_settings' ) );
	}

	public function register_settings() {
		// Register the settings with Validation callback
		register_setting(
			'cc_options',
			'cc_options'
		);

		// Add settings section
		add_settings_section(
			'cc_page',
			'Code contest opties',
			array(
				&$this,
				'print_section_info'
			),
			'code_contest' );

		add_settings_field(
			'image', // ID
			'Image', // Title
			array( $this, 'image_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'fb_page', // ID
			'Je Facebook pagina URL', // Title
			array( $this, 'fb_page_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'intro_title', // ID
			'Titel intro pagina', // Title
			array( $this, 'intro_title_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'intro_copy', // ID
			'Tekst intro pagina', // Title
			array( $this, 'intro_copy_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'form_title', // ID
			'Titel formulier pagina', // Title
			array( $this, 'form_title_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'form_copy', // ID
			'Tekst formulier pagina', // Title
			array( $this, 'form_copy_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'bedankt_title', // ID
			'Titel bedankt pagina', // Title
			array( $this, 'bedankt_title_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);

		add_settings_field(
			'bedankt_copy', // ID
			'Tekst bedankt pagina', // Title
			array( $this, 'bedankt_copy_callback' ), // Callback
			'code_contest', // Page
			'cc_page' // Section
		);
	}

	/**
	 * Print the Section text
	 */
	public function print_section_info() {
		echo '<p>Pas de opties hier aan:</p>';
	}

	public function fb_page_callback() {
		$this->template_input_field( 'fb_page' );
	}

	public function intro_title_callback() {
		$this->template_input_field( 'intro_title' );
	}

	public function intro_copy_callback() {
		$this->template_textarea_field( 'intro_copy' );
	}

	public function form_title_callback() {
		$this->template_input_field( 'form_title' );
	}

	public function form_copy_callback() {
		$this->template_textarea_field( 'form_copy' );
	}

	public function bedankt_title_callback() {
		$this->template_input_field( 'bedankt_title' );
	}

	public function bedankt_copy_callback() {
		$this->template_textarea_field( 'bedankt_copy' );
	}

	public function image_callback() {
		printf(
			'<input id="image" name="cc_options[image]" type="text" value="%1$s"/>
			<input id="image_button" class="js-media-button button" name="image_button" type="button" value="Upload"/><br>
			<img class="js-image-preview image-preview" src="%1$s" alt="Image preview"/>',
			isset( $this->options['image'] ) ? esc_attr( $this->options['image'] ) : ''
		);
	}

	/**
	 * Render a default input field as option input
	 *
	 * @param $field
	 */
	private function template_input_field( $field ) {
		printf(
			"<input type='text' id='$field' name='cc_options[$field]'  class='full-width' value='%s'/>",
			isset( $this->options[ $field ] ) ? esc_attr( $this->options[ $field ] ) : ''
		);
	}

	/**
	 * Render a default textarea as option input
	 *
	 * @param $field
	 */
	private function template_textarea_field( $field ) {
		printf(
			"<textarea type='text' id='$field' name='cc_options[$field]'  class='full-width '>%s</textarea>",
			isset( $this->options[ $field ] ) ? esc_attr( $this->options[ $field ] ) : ''
		);
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
		include( sprintf( "%s/templates/generate.php", dirname( dirname( __FILE__ ) ) ) );
	}

}