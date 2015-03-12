<? namespace Undefined\CodeContest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Admin_Ajax {

	public function __construct() {
		add_action( 'wp_ajax_cc-generate_codes', array( &$this, 'generate_codes' ) );
	}

	/**
	 * Ajax callback for code generation
	 *
	 * @post amount
	 */
	public function generate_codes() {
		$codeClass = new CodeGenerator();
		$amount    = intval( $_POST['amount'] );
		$codes     = $codeClass->generateKeys( $amount );

		echo json_encode( $codes );
		wp_die();
	}
}