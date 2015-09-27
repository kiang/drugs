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
        $('.btn-search-type, .form-search .form-control').data('type', $(this).data('type'));
        $('.search-helper-text .alert').hide();
        $('.search-helper-text .alert[data-type="' + $(this).data('type') + '"]').show().addClass('animated flipInX');
        $('.form-search .form-control').trigger('focus');
        $('html, body').animate({ scrollTop: '0px'});
    });

    $('.form-search .form-control').on('focus', function () {
        $('.btn-search-type.desktop').removeClass('btn-unfocus');
        var type = $(this).data('type');
        $('.search-helper-text .alert[data-type="' + type + '"]').show().addClass('animated flipInX');
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
    });

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

});