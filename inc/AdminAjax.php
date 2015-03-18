<? namespace Undefined\CodeContest;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class AdminAjax
{

    public function __construct()
    {
        add_action('wp_ajax_cc-generateCodes', [&$this, 'generateCodes']);
    }

    /**
     * Ajax callback for code generation
     *
     * @post amount
     */
    public function generateCodes()
    {
        $codeClass = new CodeGenerator();
        $amount = intval($_POST['amount']);
        $codes = $codeClass->generateKeys($amount);

        echo json_encode($codes);
        wp_die();
    }
}