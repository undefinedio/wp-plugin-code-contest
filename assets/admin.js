jQuery(document).ready(function ($) {

    $('#js-entries').DataTable();
    /**
     * Form handler to generate new codes
     */
    (function () {
        $('#js-submit').on('click', function submitCodeGen() {
            var $result = $('#js-result');
            var data = {
                'action': 'cc-generateCodes',
                'amount': $('.js-amount').val()
            };

            $.post(ajaxurl, data, function (response) {
                $result.html('');
                response = JSON.parse(response);
                for (var i = 0; i < response.length; i++) {
                    var obj = response[i];
                    $result.append(obj + "\n")
                }
            });
        });
    })();

    /**
     * Wordpress media uploader initializer
     */
    (function () {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;

        $('.cc_admin .js-media-button').click(function (e) {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            var id = button.attr('id').replace('_button', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                    $("#" + id).val(attachment.url);
                    $('#' + id + '_preview').attr('src', attachment.url);
                } else {
                    return _orig_send_attachment.apply(this, [props, attachment]);
                }
            };
            wp.media.editor.open(button);
            return false;
        });
    })();
});

