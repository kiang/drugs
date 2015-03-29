$(function () {
    if (point.latitude && point.longitude) {
        var pointLatLng = new google.maps.LatLng(point.latitude, point.longitude);
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: pointLatLng,
            scaleControl: true,
            navigationControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: pointLatLng,
            map: map,
            title: point.name
        });
    }
});