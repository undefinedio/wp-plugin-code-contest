<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Codes {

	public function __construct() {

		echo $this->getSerial();
	}

	/**
	 * Get a random key generated
	 *
	 * @param $length
	 *
	 * @return string
	 */
	private function generateRandomCode($length = 4) {
		return substr(md5(microtime()),rand(0,26),$length);
	}

	/**
	 * Get a random key generated with a seed
	 *
	 * @param $seed
	 * @param $length
	 *
	 * @return string
	 */
	private function getRandomWithSeed($seed, $length = 4) {
		return substr(md5(base_convert(md5($seed), 16, 10)) , $length * -1);
	}

	/**
	 * Generate a full serial
	 *
	 * @return string
	 */
	public function getSerial() {
		do {
			$seed = $this->generateRandomCode();
			$random = $this->getRandomWithSeed($seed);
			$key = strtoupper($seed."-".$random);
		} while ($this->isKeyUnique($key));

		$this->saveKey($key);
		return $key;
	}

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
		// regenerate code with seed and see if the two codes are the same
		return $pieces[1] == $this->getRandomWithSeed($pieces[0], 4) ? true : false;
	}

	/**
	 * Check the database if the code is unique
	 *
	 * @param $key
	 *
	 * @return bool
	 */
	private function isKeyUnique($key){
		global $wpdb;
		$table_name      = $wpdb->prefix . "code_contest";
		if($wpdb->get_results( 'SELECT * FROM '.$table_name.' WHERE code = "'.strtoupper($key).'"', OBJECT )){
			return true;
		}else{
			return false;
		}
	}

	private function saveKey($key){
		global $wpdb;
		$table_name      = $wpdb->prefix . "code_contest";
		$wpdb->insert(
			$table_name,
			array('code' => $key	)
		);
	}


}