<? namespace Undefined\CodeContest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class CodeValidator {
	use CodeTrait;

	/**
	 * Check if the $key is an correct code
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function checkKey($key) {
		// divide key in seed and random generated code
		$pieces = explode("-", strtolower($key));

		//check the amount of pieces
		if(count($pieces) != 2) {
			return false;
		}

		// regenerate code with seed and see if the two codes are the same
		return $pieces[1] == $this->getRandomWithSeed($pieces[0], 4) ? true : false;
	}

	/**
	 * Check if the key is valid, invalid or already used
	 *
	 * @param $key
	 *
	 * @return string
	 */
	public function isCodeValid($key) {
		if( !$this->checkKey($key) ){
			return 'invalid';
		}else{
			return (!$this->checkIfKeyIsUsed($key)) ? 'used' : 'valid';
		}
	}

	/**
	 * Check if the key is already used
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	private function checkIfKeyIsUsed($key) {
		global $wpdb;
		$table_name      = $wpdb->prefix . "code_contest";

		return ($wpdb->get_results( 'SELECT * FROM '.$table_name.' WHERE code = "'.sanitize_text_field(strtoupper($key)).'" AND name = "" ', OBJECT )) ?  true : false;
	}

	/**
	 * Check the database if the code is unique
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	public function isKeyUnique($key) {
		global $wpdb;
		$table_name      = $wpdb->prefix . "code_contest";

		return ($wpdb->get_results( 'SELECT * FROM '.$table_name.' WHERE code = "'.sanitize_text_field(strtoupper($key)).'"', OBJECT )) ? true: false;
	}
}