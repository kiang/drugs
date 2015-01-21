// Finds the status of a id'd checkbox, and sets all children to the same status
function cascade (elem) {
    id = elem.id.replace(/\//g, '\\/');
    val = $('#' + id).attr('checked');
    $('input[id^=' + id + ']').attr('checked', val);
}
