$(function () {
    $('input.acoPermitted').click(function () {
        if ($('#p' + this.name).size() > 0) {
            $('#p' + this.name).remove();
        } else {
            var itemValue = '+';
            if (!this.checked) {
                itemValue = '-';
            }
            $('#permissionStack').append('<li id="p' + this.name + '">' +
                    itemValue + this.name.replace('___', '/') +
                    '<input type="hidden" name="' + this.name + '" value="' + itemValue + '">' +
                    '</li>');
        }
    });
    $('.acoController').click(function () {
        var controllerChecked = this.checked;
        $('div#' + this.name.replace('ctrl', 'sub') + ' input.acoPermitted').each(function () {
            if (this.checked != controllerChecked) {
                this.click();
            }
        });
    });
});