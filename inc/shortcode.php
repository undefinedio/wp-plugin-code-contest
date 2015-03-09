<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Shortcode {

	public function __construct() {
		add_shortcode( 'code-contest', array( &$this, 'code_contest_shortcode' ) );
	}

	/**
	 * include classes
	 */
	public function includes() {

	}

	/**
	 * Ajax callback for code generation
	 *
	 * @post amount
	 */
	public function code_contest_shortcode( $atts ) {
		$options = get_option( 'cc_options' );
//		$atts    = shortcode_atts( array(
//			'image' => ''
//		), $atts, 'bartag' );

		var_dump( $options );

		//return "foo = {$atts['foo']}";
	}

	private function fetch_template() {

	}

}