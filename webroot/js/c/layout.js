$(function () {


    // $('.search-box a').on('click', function (e) {
    //     e.preventDefault();
    //     $(this).tab('show');
    // });

    // $('.search-box a').on('shown.bs.tab', function (e) {
    //     var content_id = $(e.target).attr('href');
    //     $(content_id).find('input').focus();
    // });

    $('.form-search .dropdown-menu').on('click', 'li a', function (e) {
        e.preventDefault();
        $('#btn-search-type').html($(this).text() + '&nbsp;<b class="caret"></b>');
        $('.btn-search span').text($(this).data('placeholder'));
        $('.form-search .form-control').attr('placeholder', $(this).data('placeholder'));
        $('.btn-search-type').attr('data-type', $(this).data('type'));
    });

    $('.form-search .form-control').on('focus', function () {
        $('#btn-search-type').removeClass('btn-unfocus');
    })

    $('.form-search .form-control').on('blur', function () {
        $('#btn-search-type').addClass('btn-unfocus');
    })

    $('.form-search').on('submit', function (e) {
        e.preventDefault();
        var that = $(this),
                input = $(this).find('.form-control');

        that.removeClass('has-error');
        $('#btn-search-type').removeClass('btn-danger');

        if (input.val() !== '') {

        } else {
            that.addClass('has-error');
            $('#btn-search-type').removeClass('btn-unfocus').addClass('btn-danger');
            $('.input-group-btn button:first, .form-search .form-control').addClass('animated shake').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $('.input-group-btn button:first, .form-search .form-control').removeClass('animated shake').one('keydown', function () {
                    $('#btn-search-type').removeClass('btn-danger btn-unfocus');
                    that.removeClass('has-error');
                });
            });
        }
    });

    $('.btn-find').on('click', function () {
        var keyword = $('#keyword').val();
        if (keyword !== '') {
            location.href = baseUrl + '/drugs/index/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });

    $('.btn-outward').on('click', function () {
        var keyword = $('#keyword').val();
        if (keyword !== '') {
            location.href = baseUrl + '/drugs/outward/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
        return false;
    });

    $('#keywordForm').on('submit', function () {
        var keyword = $('#keyword').val();
        if (keyword !== '') {
            location.href = baseUrl + 'drugs/index/' + encodeURIComponent(keyword);
        } else {
            alert('您尚未輸入關鍵字！');
        }
    });
});