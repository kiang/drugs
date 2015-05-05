$(function () {
    $('a.btn-find-drug').click(function () {
        $('form#form-find-drug').trigger('submit');
        return false;
    });
    $('form#form-find-drug').submit(function () {
        var keyword = $('input#drugKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'drugs/index/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });
});