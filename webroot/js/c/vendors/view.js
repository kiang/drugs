$(document).on('click', '.map-toggle-btn', function (e) {
    e.preventDefault();
    $('.vendor-address-wrapper').html('<div class="vendor-address" style="margin: 0 auto; width: 85%; height: 20em;">');
    var geocoder = new google.maps.Geocoder(),
        mapOptions = {
            zoom: 14
        },
        map = new google.maps.Map(document.getElementsByClassName('vendor-address')[0], mapOptions);

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
            } else {
                $('.vendor-address').remove();
                $('.vendor-address-wrapper').append('<div class="alert alert-danger animated flash"><button type="button" class="close fui-cross" data-dismiss="alert"></button><strong><span class="fui-cross text-danger"></span>&nbsp;噢，無法顯示地圖</strong></div>');
            }
        });
    }
});