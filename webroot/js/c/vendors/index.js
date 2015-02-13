$(function () {
    $('a.btn-find-vendor').click(function () {
        $('form#form-find-vendor').trigger('submit');
        return false;
    });
    $('form#form-find-vendor').submit(function () {
        var keyword = $('input#vendorKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'vendors/index/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });
});