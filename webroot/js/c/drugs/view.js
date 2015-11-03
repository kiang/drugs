$('.zoom').zoom();

(function () {
    $('a.imgZoomSwitch').click(function () {
        $('img#imgZoomBlock').attr('src', $(this).attr('data-orig'));
        return false;
    });
    var i = 0;

    Chart.defaults.global.responsive = true;
    Chart.defaults.global.scaleFontSize = 16;
    Chart.defaults.global.tooltipTemplate = '<%if (label){%><%=label%>: <%}%>新台幣 <%= value %> 元';

    for (var record in prices) {
        ++i;
        var price_record = prices[record].price,
                date_record = prices[record].date;
        chart_wrapper = document.createElement('div'),
                chart_child = document.createElement('canvas'),
                chart_title = document.createElement('h6'),
                chart_parent = document.getElementById('drug-price-charts');

        chart_wrapper.setAttribute('class', 'chart-wrapper');
        chart_title.innerHTML = record + '&nbsp;的價格紀錄';
        chart_title.setAttribute('style', 'text-align: center');
        chart_child.setAttribute('id', 'drug-price-chart-' + i);
        chart_wrapper.appendChild(chart_title);
        chart_wrapper.appendChild(chart_child);
        chart_parent.appendChild(chart_wrapper);

        if (price_record.length <= 1) {
            price_record.push(price_record[price_record.length - 1]);
            date_record.push(date_record[date_record.length - 1]);
        }
        var ctx = document.getElementById('drug-price-chart-' + i).getContext('2d'),
                data = {
                    labels: date_record.reverse(),
                    datasets: [
                        {
                            fillColor: 'rgba(151,187,205,0.2)',
                            strokeColor: 'rgba(151,187,205,1)',
                            pointColor: 'rgba(151,187,205,1)',
                            pointStrokeColor: '#fff',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(151,187,205,1)',
                            data: price_record.reverse()
                        }
                    ]
                },
        price_chart = new Chart(ctx).Line(data);
    }
})();