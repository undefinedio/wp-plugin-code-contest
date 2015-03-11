<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Shortcode {

	public function __construct() {
		add_shortcode( 'code-contest', array( &$this, 'code_contest_shortcode' ) );
	}

	/**
	 * Add shortcode logic
	 *
	 * @param $atts Default parameters from Wordpress
	 */
	public function code_contest_shortcode( $atts ) {
		$options = get_option( 'cc_options' );

		include( $this->fetch_template() );
	}

	/**
	 * See if the default template is needed or if there is a custom template in theme folder
	 *
	 * @return string path to template
	 */
	private function fetch_template() {
		$file = get_stylesheet_directory() . '/code-contest/shortcode.php';

		// check if file exists in theme folder else take default shortcode template
		return ( file_exists( $file ) ) ? $file : sprintf( "%s/templates/shortcode.php", dirname( dirname( __FILE__ ) ) );
	}

}