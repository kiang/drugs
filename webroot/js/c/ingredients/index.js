$(function () {
    $('a.btn-find-ingredient').click(function () {
        var keyword = $('input#ingredientKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'ingredients/index/' + encodeURIComponent(keyword);
        }
        return false;
    });
});