$(function () {
    if (point.latitude && point.longitude) {
        var pointLatLng = new google.maps.LatLng(point.latitude, point.longitude),
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: pointLatLng,
                scaleControl: true,
                navigationControl: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }),
            infowindow = new google.maps.InfoWindow(
                {
                    content: address,
                    map: map,
                    position: pointLatLng
                }
            );
    }
});