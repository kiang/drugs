$(function () {
    $('a.btn-find-drug').click(function () {
        $('form#form-find-outward').trigger('submit');
        return false;
    });
    $('form#form-find-outward').submit(function () {
        var keyword = $('input#drugKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'drugs/outward/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });
});