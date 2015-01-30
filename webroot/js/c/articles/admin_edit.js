$(function () {
    $('#relatedDrug').tagit({
        fieldName: 'data[Drug][]',
        autocomplete: {
            source: baseUrl + 'api/drugs/auto'
        },
        onTagClicked: function (event, ui) {
            event.preventDefault();
            window.open(baseUrl + 'drugs/view/' + $('input', ui.tag).val());
        }
    });
    $('#relatedIngredient').tagit({
        fieldName: 'data[Ingredient][]',
        autocomplete: {
            source: baseUrl + 'api/ingredients/auto'
        },
        onTagClicked: function (event, ui) {
            event.preventDefault();
            window.open(baseUrl + 'ingredients/view/' + $('input', ui.tag).val());
        }
    });
    $('#relatedPoint').tagit({
        fieldName: 'data[Point][]',
        autocomplete: {
            source: baseUrl + 'api/points/auto'
        },
        onTagClicked: function (event, ui) {
            event.preventDefault();
            window.open(baseUrl + 'points/view/' + $('input', ui.tag).val());
        }
    });
    $('input#ArticleDatePublished').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});