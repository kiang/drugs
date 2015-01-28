$(function () {
    $('#relatedDrug').tagit({
        fieldName: 'data[Drug][]',
        autocomplete: {
            source: baseUrl + 'api/drugs/auto'
        },
        onTagClicked: function (event, ui) {
            event.preventDefault();
            window.open(baseUrl + 'drugs/view/' + ui.tagLabel);
        }
    });
    $('#relatedIngredient').tagit({
        fieldName: 'data[Ingredient][]',
        autocomplete: {
            source: baseUrl + 'api/ingredients/auto'
        },
        onTagClicked: function (event, ui) {
            event.preventDefault();
            window.open(baseUrl + 'ingredients/view/' + ui.tagLabel);
        }
    });
    $('#relatedPoint').tagit({
        fieldName: 'data[Point][]',
        autocomplete: {
            source: baseUrl + 'api/points/auto'
        },
        onTagClicked: function (event, ui) {
            event.preventDefault();
            window.open(baseUrl + 'points/view/' + ui.tagLabel);
        }
    });
});