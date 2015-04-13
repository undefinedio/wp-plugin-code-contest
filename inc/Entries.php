<?
namespace Undefined\CodeContest;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Entries
{

    /**
     * Save entry to database
     *
     * @param $name
     * @param $surname
     * @param $email
     * @param $key
     * @param $tiebreaker
     */
    public function saveEntry($name, $surname, $email, $key, $tiebreaker)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "code_contest";
        $wpdb->update(
            $table_name,
            [
                'email'      => sanitize_text_field($email),
                'tiebreaker' => sanitize_text_field($tiebreaker),
                'name'       => sanitize_text_field($name) . " " . sanitize_text_field($surname)
            ],
            [
                'code' => sanitize_text_field($key)
            ]
        );
    }

    /**
     * Return all entries
     *
     * @return mixed
     */
    public function getAllEntries()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "code_contest";

        return $wpdb->get_results('SELECT * FROM ' . $table_name . ' WHERE  name != "" ', OBJECT);
    }
}