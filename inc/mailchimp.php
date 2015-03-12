<? namespace Undefined\CodeContest;
use Drewm\MailChimp;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class MailChimpHandler {

	private $mailChimp;
	private $options;

	public function __construct() {
		$this->options = get_option( 'cc_options' );
		if ( $this->options['mailchimp_api_key'] ) {
			$this->mailChimp = new MailChimp( $this->options['mailchimp_api_key'] );
		}
	}

	/**
	 * Subscribe user to mailchimp list
	 *
	 * @param $name
	 * @param $surname
	 * @param $email
	 */
	public function subscribe( $name, $surname, $email ) {
		if ( $this->options['mailchimp_api_key'] && $this->options['mailchimp_list_id'] ) {
			$this->mailChimp->call( 'lists/subscribe', array(
				'id'                => $this->options['mailchimp_list_id'],
				'email'             => array( 'email' => $email ),
				'merge_vars'        => array( 'FNAME' => $name, 'LNAME' => $surname ),
				'double_optin'      => false,
				'update_existing'   => true,
				'replace_interests' => false,
				'send_welcome'      => false,
			) );
		}
	}
}