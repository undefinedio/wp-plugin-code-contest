<?
namespace Undefined\CodeContest;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class ShortcodeAjax
{

    private $codeValidator = '';
    private $entryClass = '';
    private $mailchimpClass = '';
    private $options = '';

    public function __construct()
    {
        $this->includes();

        $this->options = get_option('cc_options');

        add_action('wp_ajax_cc-checkcode', [&$this, 'checkCode']);
        add_action('wp_ajax_cc-fillform', [&$this, 'enterContest']);
        add_action('wp_head', [&$this, 'addAjaxLibrary']);
    }

    /**
     * include classes
     */
    public function includes()
    {
        $this->codeValidator = new CodeValidator();
        $this->entryClass = new Entries();
        $this->mailchimpClass = new MailChimpHandler();
    }

    /**
     * API endpoint to check if valid key
     */
    public function checkCode()
    {
        $key = $_POST['key'];
        $check = $this->codeValidator->isCodeValid($key);

        echo $check;
        wp_die();
    }

    /**
     * API endpoint to enter form data
     */
    public function enterContest()
    {
        $key = $_POST['key'];

        if ($_POST['newsletter'] == 'true') {
            $this->mailchimpClass->subscribe($_POST['name'], $_POST['surname'], $_POST['email']);
        }

        if ($this->codeValidator->isCodeValid($key) == "valid") {
            $this->entryClass->saveEntry($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['key']);
            echo "success";
        } else {
            echo "failed";
        }

        wp_die();
    }

    /**
     * Adds the WordPress Ajax Library to the frontend.
     */
    public function addAjaxLibrary()
    {
        $html = '<script type="text/javascript">';
        $html .= 'window.codeContest = {};';
        $html .= 'window.codeContest.ajaxUrl = "' . admin_url('admin-ajax.php') . '";';
        $html .= 'window.codeContest.currentUrl = "http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '";';
        $html .= 'window.codeContest.FBShare_title = "' . $this->options["share_title"] . '";';
        $html .= 'window.codeContest.FBShare_copy = "' . $this->options["share_copy"] . '";';
        $html .= 'window.codeContest.FBShare_image = "' . $this->options["share_image"] . '";';
        $html .= '</script>';

        echo $html;
    }
}