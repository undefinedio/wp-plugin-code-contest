<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Shortcode_Ajax {

	private $codeclass = '';
	private $entryClass = '';
	private $options = '';

	public function __construct() {
		$this->includes();

		$this->options = get_option( 'cc_options' );

		add_action( 'wp_ajax_cc-checkcode', array( &$this, 'check_code' ) );
		add_action( 'wp_ajax_cc-fillform', array( &$this, 'enter_contest' ) );
		add_action( 'wp_head', array( &$this, 'add_ajax_library' ) );
	}

	/**
	 * include classes
	 */
	public function includes() {
		include_once( 'codes.php' );
		include_once( 'entries.php' );
		$this->codeclass  = new Codes();
		$this->entryClass = new Entries();
	}

	/**
	 * API endpoint to check if valid key
	 */
	public function check_code() {
		$key   = $_POST['key'];
		$check = $this->codeclass->isCodeValide( $key );

		echo $check;
		wp_die();
	}

	/**
	 * API endpoint to enter form data
	 */
	public function enter_contest() {
		$key = $_POST['key'];
		if ( $this->codeclass->isCodeValide( $key ) == "valid" ) {
			$this->entryClass->saveEntry( $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['key'] );
			echo "success";
		} else {
			echo "failed";
		}
		wp_die();
	}

	/**
	 * Adds the WordPress Ajax Library to the frontend.
	 */
	public function add_ajax_library() {
		$html = '<script type="text/javascript">';
		$html .= 'window.codeContest = {};';
		$html .= 'window.codeContest.ajaxUrl = "' . admin_url( 'admin-ajax.php' ) . '";';
		$html .= 'window.codeContest.currentUrl = "http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '";';
		$html .= 'window.codeContest.FBShare_title = "' . $this->options["share_title"] . '";';
		$html .= 'window.codeContest.FBShare_copy = "' . $this->options["share_copy"] . '";';
		$html .= 'window.codeContest.FBShare_image = "' . $this->options["share_image"] . '";';
		$html .= '</script>';

		echo $html;
	}

}