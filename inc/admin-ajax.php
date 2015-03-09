<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Admin_Ajax {

	public function __construct() {
		$this->includes();
		add_action( 'wp_ajax_generate_codes', array( &$this, 'generate_codes' ) );
	}

	/**
	 * include classes
	 */
	public function includes() {
		include_once( 'codes.php' );
	}

	/**
	 * Ajax callback for code generation
	 *
	 * @post amount
	 */
	public function generate_codes() {
		$codeClass = new Codes();
		$amount    = intval( $_POST['amount'] );
		$codes     = $codeClass->generateKeys( $amount );

		echo json_encode( $codes );
		wp_die();
	}

}