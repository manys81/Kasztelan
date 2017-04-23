window.initMap = function() {
    var lat=jQuery(".marker").data("lat");
    var lng=jQuery(".marker").data("lng");
    var uluru = {lat: lat, lng: lng};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: uluru,
        scrollwheel: false
    });

    var markerIcon = {
        path: 'M 160,0 C 71.634,0 0,71.634 0,160 0,320 160,512 160,512 160,512 320,320 320,160 320,71.634 248.365,0 160,0 z m 0,256 c -53.02,0 -96,-42.98 -96,-96 0,-53.02 42.98,-96 96,-96 53.02,0 96,42.98 96,96 0,53.02 -42.98,96 -96,96 z',
        fillColor: '#004899',
        fillOpacity: 1,
        scale: 0.10,
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(160, 512)
    };

    var marker = new google.maps.Marker({
        position: uluru,
        map: map,
        icon: markerIcon
    });

    // utworzenie i wstawienie dymka z opisem markera po kliku na nim
    var infoText = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h4 id="firstHeading" class="firstHeading">Kasztelan Rozprza</h4>'+
        '<div id="bodyContent">'+
        '<p>ul. Sportowa 12A <br>Rozprza 97-340 <br>Polska </p>'+
        '</div>'+
        '</div>';

    var infowindow = new google.maps.InfoWindow({
        content: infoText
    });
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
    });
}
jQuery(document).ready(function(){
    initMap();
});