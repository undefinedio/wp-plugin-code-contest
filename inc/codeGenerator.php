<? namespace Undefined\CodeContest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class CodeGenerator {
	use CodeTrait;

	private $validator;

	public function __construct() {
		$this->validator = new CodeValidator();
	}

	/**
	 * Generate a full serial
	 *
	 * @return string
	 */
	public function getSerial() {

		do {
			$seed   = $this->generateRandomCode();
			$random = $this->getRandomWithSeed( $seed );
			$key    = strtoupper( $seed . "-" . $random );
		} while ( $this->validator->isKeyUnique( $key ) );

		$this->saveKey( $key );

		return $key;
	}

	/**
	 * Save key to database
	 *
	 * @param $key
	 */
	private function saveKey( $key ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "code_contest";
		$wpdb->insert(
			$table_name,
			array( 'code' => sanitize_text_field( $key ) )
		);
	}

	/**
	 * Generate a set of serial keys`
	 *
	 * @param int $amount
	 *
	 * @return array
	 */
	public function generateKeys( $amount = 100 ) {
		$i    = 1;
		$keys = [ ];
		while ( $i <= $amount ) {
			array_push( $keys, $this->getSerial() );
			$i ++;
		}

		return $keys;
	}
}