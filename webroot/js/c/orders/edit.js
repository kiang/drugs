$(function () {
    $('input#OrderOrderDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('input#OrderNoteDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $('input#OrderPoint').autocomplete({
        source: baseUrl + 'api/points/auto',
        change: function (event, ui) {
            $('input#OrderPointId').val('');
        },
        select: function (event, ui) {
            event.preventDefault();
            $(this).val(ui.item.name);
            $('input#OrderPointId').val(ui.item.value);
            $('input#OrderPhone').val(ui.item.phone);
            $('input#OrderAddress').val(ui.item.city + ui.item.town + ui.item.address);
        }
    });
});