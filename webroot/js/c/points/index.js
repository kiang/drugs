$(function () {
    $('a.btn-find-point').click(function () {
        $('form#form-find-point').trigger('submit');
        return false;
    });
    $('form#form-find-point').submit(function () {
        var keyword = $('input#pointKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'points/index/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });
});