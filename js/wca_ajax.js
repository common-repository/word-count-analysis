jQuery(document).ready(function ($) {
    jQuery('#calc').click(function (e) {

        const _lang = $('#countries').val();
        var data = {
            action: 'calculation',
            lang: _lang
        }
        $('#loading').show();
        $('#logo_svg').hide();
        //$('#calc').prop("disabled", true)
        // Prevent the default behavior for the link
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: data,
            success: function (data) {
                console.log(data);
                $('#loading').hide();
                $('#logo_svg').show();
                location.reload();
            },
            error: function (xhr, textStatus, error) {
                $('#loading').hide();
                $('#logo_svg').show();
                $('#calc').prop("disabled", false)
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        });
        //e.preventDefault();
    });
    jQuery('#re-calc').click(function (e) {
        const _lang = $('#countries').val();
        var data = {
            action: 'calculation',
            lang: _lang
        }
        $('#loading').show();
        $('#logo_svg').hide();
        //$('#calc').prop("disabled", true)
        // Prevent the default behavior for the link
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: data,
            success: function (data) {
                console.log(data);
                $('#loading').hide();
                $('#logo_svg').show();
                location.reload();
            },
            error: function (xhr, textStatus, error) {
                $('#loading').hide();
                $('#logo_svg').show();
                $('#calc').prop("disabled", false)
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        });
        //e.preventDefault();
    });

});
