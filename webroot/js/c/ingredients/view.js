$(function () {
    var q = $('#ingredient-event-wrapper').attr('data-query'),
        d = new Date(),
        dateFrom = (d.getFullYear() - 1) + '-' + (d.getMonth() + 1) + '-' + d.getDay(),
        dateTo = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDay();

    $.ajax({
        url: 'https://api.fda.gov/drug/event.json?api_key=J2OUrWyFQMIJxJ25cgrbxUF7CQDdn6WIq9eLa2Qs&search=' + q + '+AND+[' + dateFrom + '+TO+' + dateTo + ']&count=patient.reaction.reactionmeddrapt.exact',
        type: 'get',
        beforeSend: function() {

        },
        success: function(data) {
            var footerString = '',
                itemList = '',
                countTotal = 0;

            $.each(data.results, function (i, v) {
                countTotal += v.count;
                itemList += 
                    '<div class="col-xs-12 col-md-6">' + 
                        '<a href="http://www.nlm.nih.gov/cgi/mesh/2015/MB_cgi?exact=Find+Exact+Term&field=all&term=' + encodeURI(v.term) + '">' + 
                            v.term + 
                        '</a>' + 
                        '<small> (' + v.count + ')</small>' + 
                    '</div>';
            });
            $('#ingredient-event-list').html(itemList);
            footerString += '最後更新於 ' + data.meta.last_updated;
            footerString += '<br>免責聲明：' + data.meta.disclaimer;
            footerString += '<br><a href="' + data.meta.license + '" target="_blank">使用許可</a>';
            $('#ingredient-event-wrapper .content-footer').append(footerString);
            $('#ingredient-event-statistic').html('(' + dateFrom + ' ~ ' + dateTo + '，總計：' + countTotal + ')');
            $('#ingredient-event-wrapper').show().addClass('animated zoomInDown');
        }
    });

    $('.btn-read-more').on('click', function() {
        $(this).parents('.full-content').css('height', 'auto').end().parents('.full-content-mask').hide();
    });
});