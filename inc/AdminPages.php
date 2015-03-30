<?
namespace Undefined\CodeContest;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class AdminPages
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    public $entries;

    public function __construct()
    {
        $this->entries = new Entries();
        add_action('admin_menu', [&$this, 'addAdminPages']);
        add_action('admin_init', [&$this, 'registerSettings']);
    }

    public function registerSettings()
    {
        // Register the settings with Validation callback
        register_setting(
            'cc_options',
            'cc_options'
        );

        // Add settings section
        add_settings_section(
            'cc_page',
            'Code contest opties',
            [
                &$this,
                'printSectionInfo'
            ],
            'code_contest');

        add_settings_field(
            'image', // ID
            'Image', // Title
            [$this, 'imageCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'intro_title', // ID
            'Titel intro pagina', // Title
            [$this, 'introTitleCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'intro_copy', // ID
            'Tekst intro pagina', // Title
            [$this, 'introCopyCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'form_title', // ID
            'Titel formulier pagina', // Title
            [$this, 'formTitleCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'form_copy', // ID
            'Tekst formulier pagina', // Title
            [$this, 'formCopyCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'bedankt_title', // ID
            'Titel bedankt pagina', // Title
            [$this, 'bedanktTitleCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'bedankt_copy', // ID
            'Tekst bedankt pagina', // Title
            [$this, 'bedanktCopyCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'share_title', // ID
            'Facebook Share titel', // Title
            [$this, 'shareTitleCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'share_copy', // ID
            'Facebook Share tekst', // Title
            [$this, 'shareCopyCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'share_image', // ID
            'Facebook Share  Image', // Title
            [$this, 'shareImageCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'conditions', // ID
            'Conditions upload', // Title
            [$this, 'conditionsCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'dev_title', // ID
            '<h2>Opties enkel voor developers</h2>', // Title
            [$this, 'devTitleCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'fb_page', // ID
            'Facebook page URL', // Title
            [$this, 'fbPageCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'fb_app_id', // ID
            'facebook App ID', // Title
            [$this, 'fbIdCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'mailchimp_api_key', // ID
            'Mailchimp API key', // Title
            [$this, 'mailchimpApiKeyCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );

        add_settings_field(
            'mailchimp_list_id', // ID
            'Mailchimp list ID', // Title
            [$this, 'mailchimpListIdCallback'], // Callback
            'code_contest', // Page
            'cc_page' // Section
        );
    }

    /**
     * Print the Section text
     */
    public function printSectionInfo()
    {
        echo '<p>Pas de opties hier aan:</p>';
    }

    public function devTitleCallback()
    {
        echo '<p>Deze opties zijn enkel voor developers. Niet aanpassen als je niet weet wat deze beteken.</p>';
    }

    public function fbPageCallback()
    {
        $this->templateInputField('fb_page');
    }

    public function mailchimpApiKeyCallback()
    {
        $this->templateInputField('mailchimp_api_key');
    }

    public function mailchimpListIdCallback()
    {
        $this->templateInputField('mailchimp_list_id');
    }

    public function shareTitleCallback()
    {
        $this->templateInputField('share_title');
    }

    public function shareCopyCallback()
    {
        $this->templateTextareaField('share_copy');
    }

    public function fbIdCallback()
    {
        $this->templateInputField('fb_app_id');
    }

    public function introTitleCallback()
    {
        $this->templateInputField('intro_title');
    }

    public function introCopyCallback()
    {
        $this->templateTextareaField('intro_copy');
    }

    public function formTitleCallback()
    {
        $this->templateInputField('form_title');
    }

    public function formCopyCallback()
    {
        $this->templateTextareaField('form_copy');
    }

    public function bedanktTitleCallback()
    {
        $this->templateInputField('bedankt_title');
    }

    public function bedanktCopyCallback()
    {
        $this->templateTextareaField('bedankt_copy');
    }

    public function imageCallback()
    {
        $this->uploadImageField('image');
    }

    public function shareImageCallback()
    {
        $this->uploadImageField('share_image');
    }

    public function conditionsCallback()
    {
        $this->uploadPdfField('conditions');
    }

    public function uploadImageField($field)
    {
        printf(
            "<input id='$field' name='cc_options[$field]' type='text' value='%1\$s'/>
			<input id='" . $field . "_button' class='js-media-button button' name='" . $field . "_button' type='button' value='Upload'/>
			<br>
			<img id='" . $field . "_preview' class='js-image-preview image-preview'  src='%1\$s' alt='Image preview'/>",
            isset($this->options[ $field ]) ? esc_attr($this->options[ $field ]) : ''
        );
    }


    public function uploadPdfField($field)
    {
        printf(
            "<input id='$field' name='cc_options[$field]' type='text' value='%1\$s'/>
			<input id='" . $field . "_button' class='js-media-button button' name='" . $field . "_button' type='button' value='Upload'/>
			<br>
			<a target='_blank' id='" . $field . "_preview' href='%1\$s'>Download</a>",
            isset($this->options[ $field ]) ? esc_attr($this->options[ $field ]) : ''
        );
    }

    /**
     * Render a default input field as option input
     *
     * @param $field
     */
    private function templateInputField($field)
    {
        printf(
            "<input type='text' id='$field' name='cc_options[$field]'  class='full-width' value='%s'/>",
            isset($this->options[ $field ]) ? esc_attr($this->options[ $field ]) : ''
        );
    }

    /**
     * Render a default textarea as option input
     *
     * @param $field
     */
    private function templateTextareaField($field)
    {
        printf(
            "<textarea type='text' id='$field' name='cc_options[$field]'  class='full-width '>%s</textarea>",
            isset($this->options[ $field ]) ? esc_attr($this->options[ $field ]) : ''
        );
    }

    /**
     * Inject admin menu
     */
    public function addAdminPages()
    {
        add_menu_page('Code Contest', 'Code Contest', 'manage_options', 'code_contest', [
            &$this,
            'showAdminTemplate'
        ]);

        add_submenu_page('code_contest', 'View Entries', 'View Entries', 'manage_options', 'code_contest_entries', [
            &$this,
            'showEntriesTemplate'
        ]);

        add_submenu_page('code_contest', 'Generate Codes', 'Generate Codes', 'manage_options', 'codeContestGenerate', [
            &$this,
            'codeContestGenerate'
        ]);
    }

    /**
     * Include admin template
     */
    public function showAdminTemplate()
    {
        include(sprintf("%s/templates/admin.php", dirname(dirname(__FILE__))));
    }

    /**
     * Include entries template
     */
    public function showEntriesTemplate()
    {
        $entries = $this->entries->getAllEntries();
        include(sprintf("%s/templates/Entries.php", dirname(dirname(__FILE__))));
    }

    /**
     * Include code generation template
     */
    public function codeContestGenerate()
    {
        include(sprintf("%s/templates/generate.php", dirname(dirname(__FILE__))));
    }
}