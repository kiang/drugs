$(function () {
    var q = $('div#ingredientEventBox').attr('data-query');
    $.getJSON('https://api.fda.gov/drug/event?api_key=J2OUrWyFQMIJxJ25cgrbxUF7CQDdn6WIq9eLa2Qs&search=' + q + '&count=patient.reaction.reactionmeddrapt.exact&limit=24', {}, function (data) {
        if (typeof data.error === 'undefined') {
            var listObj = $('ul#ingredientEventList');
            var boxObj = $('div#ingredientEventBox');
            var footerString = '';
            $.each(data.results, function (i, v) {
                $('<li class="col-xs-2" />').html(v.term + ' (' + v.count + ')').appendTo(listObj);
            });
            footerString += 'updated: ' + data.meta.last_updated;
            footerString += ' / disclaimer: ' + data.meta.disclaimer;
            footerString += ' / <a href="' + data.meta.license + '" target="_blank">license</a>';
            $('.box-footer', boxObj).append(footerString);
            boxObj.show();
        }
    });
});