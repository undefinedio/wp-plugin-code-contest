jQuery(document).ready(function ($) {
    /**
     * Variables injected through Wordpress php in footer (shortcode-ajax.php)
     */
    var currentUrl = window.codeContest.currentUrl;
    var ajaxUrl = window.codeContest.ajaxUrl;
    var FBShareCopy = window.codeContest.FBShare_copy;
    var FBShareTitle = window.codeContest.FBShare_title;
    var FBShareImage = window.codeContest.FBShare_image;

    /**
     * Form handler to check if code is correct
     */
    (function () {
        $('#js-code-form').submit(function (e) {
            e.preventDefault();
            $error = $('.js-error');
            $error.html('&nbsp;');

            var code = $('.js-code-input').val();
            var data = {
                'action': 'cc-checkcode',
                'key': code
            };

            $.post(ajaxUrl, data, function (response) {
                if (response === "used") {
                    $error.html('De code is al eens gebruikt, probeer een andere code.');
                } else if (response === "valid") {
                    $('#js-code-input').val(code);
                    switchPage('form');
                } else {
                    $error.html('De code klopt niet. Probeer opnieuw.');
                }
            });
        });
    })();

    /**
     * Form handler for user details
     */
    (function () {
        var $form = $('#js-form');
        var $accept = $('.js-checkbox-accept');

        $form.submit(function (e) {
            e.preventDefault();

            var $error = $('.js-error-form');
            $error.html('&nbsp;');

            var data = {
                'action': 'cc-fillform',
                'key': $('#js-code-input').val(),
                'name': $form.find('#name').val(),
                'email': $form.find('#email').val(),
                'surname': $form.find('#surname').val(),
                'newsletter': $('.js-checkbox-mailing').is(':checked')
            };

            if(!$accept.is(':checked')){
                $error.html('je moet de voorwaarden accepteren.');
            }else if (!validateForm('#js-form .required')) {
                $error.html('Niet alle velden zijn correct ingevuld.');
            } else {
                $.post(ajaxUrl, data, function (response) {
                    if (response == "success") {
                        switchPage('thanks');
                    } else {
                        $error.html('Oh nee! Er is precies iets mis gegaan. Probeer het later nog eens.');
                    }
                });
            }
        });
    })();

    /**
     * Share action handler
     */
    (function () {
        $('.js-share-fb').on('click', function () {
            FB.ui(
                {
                    method: 'feed',
                    name: FBShareTitle,
                    link: currentUrl,
                    picture: FBShareImage,
                    description: FBShareCopy,
                    message: ''
                });
        });
    })();

    /**
     * Utility functions
     */
    function validateForm(element) {
        var _return = true;
        $(element).each(function () {
            if ($(this).val() == '') {
                _return = false;
            }
        });
        return _return;
    }

    function switchPage(page) {
        $('.cc-wrapper section').removeClass('active');
        $(".cc-wrapper ." + page).addClass('active');
    }
});
