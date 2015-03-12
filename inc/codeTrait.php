<? namespace Undefined\CodeContest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

trait CodeTrait {
	/**
	 * Get a random key generated
	 *
	 * @param $length
	 *
	 * @return string
	 */
	function generateRandomCode($length = 4) {
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
	function getRandomWithSeed($seed, $length = 4) {
		return substr(md5(base_convert(md5($seed), 16, 10)) , $length * -1);
	}
}