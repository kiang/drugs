$(function () {
    $('a.btn-find-point').click(function () {
        var keyword = $('input#pointKeyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'points/index/' + encodeURIComponent(keyword);
        }
        return false;
    });
});