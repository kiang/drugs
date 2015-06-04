$(function () {
    var q = $('div#ingredientEventBox').attr('data-query');
    var d = new Date();
    var dateFrom = (d.getFullYear() - 1) + '-' + (d.getMonth() + 1) + '-' + d.getDay();
    var dateTo = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDay();
    $.getJSON('https://api.fda.gov/drug/event.json?api_key=J2OUrWyFQMIJxJ25cgrbxUF7CQDdn6WIq9eLa2Qs&search=' + q + '+AND+[' + dateFrom + '+TO+' + dateTo + ']&count=patient.reaction.reactionmeddrapt.exact', {}, function (data) {
        if (typeof data.error === 'undefined') {
            var listObj = $('ul#ingredientEventList');
            var boxObj = $('div#ingredientEventBox');
            var footerString = '';
            var countTotal = 0;
            $.each(data.results, function (i, v) {
                countTotal += v.count;
                var link = $('<a target="_blank" />').attr('href', 'http://www.nlm.nih.gov/cgi/mesh/2015/MB_cgi?exact=Find+Exact+Term&field=all&term=' + encodeURI(v.term)).html(v.term + ' (' + v.count + ')')
                $('<li class="col-xs-2" />').html(link).appendTo(listObj);
            });
            footerString += 'updated: ' + data.meta.last_updated;
            footerString += ' / disclaimer: ' + data.meta.disclaimer;
            footerString += ' / <a href="' + data.meta.license + '" target="_blank">license</a>';
            $('.box-footer', boxObj).append(footerString);
            $('.box-header h4', boxObj).append(' ( ' + dateFrom + ' ~ ' + dateTo + ', Total: ' + countTotal + ' ) ');
            boxObj.show();
        }
    });
});