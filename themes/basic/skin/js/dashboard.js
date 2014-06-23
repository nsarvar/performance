$(function () {
    $('.btn-delete').bind("click", function () {
        if (confirm('Are you sure delete the item?')) {
            document.location.href = $(this).attr('action');
        }
        return false;
    })
});