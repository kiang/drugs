$(function () {
    $('a.btn-find-vendor').click(function () {
        var keyword = $('input#vendorKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'vendors/index/' + encodeURIComponent(keyword);
        }
        return false;
    });
});