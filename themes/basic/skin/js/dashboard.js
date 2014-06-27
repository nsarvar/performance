$(function () {
    $('.btn-delete').bind("click", function () {
        if (confirm('Are you sure delete the item?')) {
            document.location.href = $(this).attr('action');
        }
        return false;
    });
    $('.selectpicker').selectpicker();

    $('.nav-tabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })

    $('.info_block').click(function (e) {
        $('#' + $(this).attr('data-src')).slideToggle();
    })
});