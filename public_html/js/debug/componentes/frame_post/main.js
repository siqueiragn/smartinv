/**
 * 
 * @param {type} data
 * @param {type} url
 * @param {type} target
 * @returns {null}
 */
function postToIframe(data, url, target) {
    $('body').append('<form action="' + url + '" style="display:none" method="post" target="' + target + '" id="postToIframe"></form>');

    if (data) {
        $.each(data, function (n, v) {
            $('#postToIframe').append('<input type="hidden" name="' + n + '" value="' + v + '" />');
        });
    }
    $('#postToIframe').submit().remove();
}

/**
 * Método que executa a requisição
 * 
 * @param {type} param
 */
$(document).ready(function () {
    $('h2').hide('slow');
    postToIframe(_Frame.data, _Frame.url, _Frame.target);

    var altura = $(window).height() - 51;//Menu padrão bootstrap
    $("#" + _Frame.target).height(altura);
    $("#" + _Frame.target).width('100%');
    console.log(altura);
    console.log("#" + _Frame.target);

});
