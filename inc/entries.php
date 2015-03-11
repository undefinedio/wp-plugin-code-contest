<?
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Entries {

	public function __construct() {

	}

	/**
	 * Save entry to database
	 *
	 * @param $name
	 * @param $surname
	 * @param $email
	 * @param $key
	 */
	public function saveEntry( $name, $surname, $email, $key ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "code_contest";
		$wpdb->update(
			$table_name,
			array(
				'email' => sanitize_text_field( $email ),
				'name'  => sanitize_text_field( $name ) . " " . sanitize_text_field( $surname )
			),
			array(
				'code' => sanitize_text_field( $key )
			)
		);
	}
}