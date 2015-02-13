$(function () {
    $('a.btn-find-ingredient').click(function () {
        $('form#form-find-ingredient').trigger('submit');
        return false;
    });
    $('form#form-find-ingredient').submit(function () {
        var keyword = $('input#ingredientKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'ingredients/index/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });
});