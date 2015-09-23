jQuery.fn.selectText = function() {
    var doc = document,
        element = this[0],
        range, selection;

    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }
};

$(function () {

    $('.search-box .dropdown-menu').on('click', 'li a', function (e) {
        e.preventDefault();
        $('.btn-search-type').html($(this).text() + '&nbsp;<b class="caret"></b>');
        $('.btn-search span').text($(this).data('placeholder'));
        $('.form-search .form-control').attr('placeholder', $(this).data('placeholder'));
        $('.btn-search-type').data('type', $(this).data('type'));
        switch ($(this).data('type')) {
        case 'drug':
            $('.search-helper-text .alert').hide();
            $('.search-helper-text .alert[data-type="drug"]').show().addClass('animated flipInX');
            break;
        case 'outward':
            $('.search-helper-text .alert').hide();
            $('.search-helper-text .alert[data-type="outward"]').show().addClass('animated flipInX');
            break;
        default:
            $('.search-helper-text .alert').hide();
            break;
        }
    });

    $('.form-search .form-control').on('focus', function () {
        $('.btn-search-type.desktop').removeClass('btn-unfocus');
        $('.search-helper-text').show().addClass('animated flipInX');
    });

    $('.form-search .form-control').on('blur', function () {
        $('.btn-search-type.desktop').addClass('btn-unfocus');
    });

    $('.form-search').on('submit', function (e) {
        e.preventDefault();
        var that = $(this),
            input = that.find('.form-control'),
            inputVal = input.val();

        that.removeClass('has-error');
        $('.btn-search-type.desktop').removeClass('btn-danger');

        if (inputVal !== '') {
            switch($('.btn-search-type').data('type')) {
                case 'drug':
                case 'license':
                    location.href = baseUrl + 'drugs/index/' + encodeURIComponent(inputVal);
                    break;
                case 'outward':
                    location.href = baseUrl + 'drugs/outward/' + encodeURIComponent(inputVal);
                    break;
                case 'ingredient':
                    location.href = baseUrl + 'ingredients/index/' + encodeURIComponent(inputVal);
                    break;
                case 'vendor':
                    location.href = baseUrl + 'vendors/index/' + encodeURIComponent(inputVal);
                    break;
                case 'point':
                    location.href = baseUrl + 'points/index/' + encodeURIComponent(inputVal);
                    break;
            }
        } else {
            var form_control = $('.input-group-btn button:first, .form-search .form-control');
            that.addClass('has-error');
            $('.btn-search-type.desktop').removeClass('btn-unfocus').addClass('btn-danger');
            form_control.addClass('animated shake').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                form_control.removeClass('animated shake').one('keydown', function () {
                    $('.btn-search-type.desktop').removeClass('btn-danger btn-unfocus');
                    that.removeClass('has-error');
                });
            });
        }
    });

    $('.btn-to-top').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: '0px'}, 700);
    })

    $('.zoom').zoom();

    $('.article-share-link').on('click', function (e) {
        e.preventDefault();
        var target = $(this).data('pane');
        $(target).show().addClass('animated bounceInRight').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $(target).removeClass('animated bounceInRight');
        });
    });

    $('.article-permalink a').on('mouseenter', function () {
        $(this).selectText();
    });

    $(document).on('click', '.map-toggle-btn', function (e) {
        e.preventDefault();
        $('.vendor-address-wrapper').html('<div id="vendor-address" style="margin: 0 auto; width: 85%; height: 20em;">');
        var geocoder = new google.maps.Geocoder(),
            mapOptions = {
                zoom: 14
            },
            map = new google.maps.Map(document.getElementById('vendor-address'), mapOptions);

        if (geocoder) {
            geocoder.geocode({'address': verdor_address}, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (status !== google.maps.GeocoderStatus.ZERO_RESULTS) {
                        map.setCenter(results[0].geometry.location);

                        var infowindow = new google.maps.InfoWindow(
                            {
                                content: verdor_address,
                                map: map,
                                position: results[0].geometry.location
                            }
                        );

                    } else {
                        $('.vendor-address').remove();
                        $('.vendor-address-wrapper').append('<div class="alert alert-danger animated flash"><button type="button" class="close fui-cross" data-dismiss="alert"></button><strong><span class="fui-cross text-danger"></span>&nbsp;噢，無法顯示地圖</strong></div>');
                    }
                }
            });
        }
        $('.map-toggle-btn').remove();
    });
});