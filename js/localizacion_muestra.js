$(document).ready(function(){

    $("#id_muni").click(function() {
        arma_direccion();
    });
    
});

function arma_direccion() {
    var direccion = $("#direccion").val();
    var provincia = $('#id_pcia option:selected').html();
    var ciudad    = $('#id_muni option:selected').html();
    
    if (ciudad == null ) { var ciudad = provincia;}

    var address = direccion+ ', '+ciudad+', '+provincia+ ', Argentina';
    codeAddress(address);
    console.log(address);
}

    var geocoder;
    var map;
    if (lat==null) { var lat = -32.950741;}  
    if (lon==null) { var lon = -60.666499;}  
    
    var markersArray = [];



    function geocodePosition(pos) {
      geocoder.geocode({
        latlng: pos
      }
      );
    }


    function updateMarkerPosition(latLng) {
        asignaLonLat(latLng.lat(),latLng.lng());
    }


    
    function initialize() {
    
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(lat, lon);
        var myOptions = {
          zoom: 15
          , center: latlng
          , mapTypeId: google.maps.MapTypeId.ROADMAP
          
        , backgroundColor: '#ffffff'
        , noClear: false
        , keyboardShortcuts: false
        , disableDoubleClickZoom: false
        , draggable: true
        , scrollwheel: true
        , draggableCursor: 'move'
        , draggingCursor: 'move'
        , navigationControl: true
        , streetViewControl: false

        , mapTypeControl: true
        , mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_MENU
            , position: google.maps.ControlPosition.TOP_LEFT
            , mapTypeIds: [
                google.maps.MapTypeId.SATELLITE,
                google.maps.MapTypeId.ROADMAP
            ]
        }          
          
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        asignaLonLat(lat,lon);
        
        addMarker(latlng);
        
    }


    function addMarker(location) {
        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });
        lon = location.Qa;
        lat = location.Ra;
        asignaLonLat(lon,lat);
        
        markersArray.push(marker);
        
        google.maps.event.addListener(marker, 'drag', function() {
            updateMarkerPosition(marker.getPosition());
        });        
    }

    function deleteOverlays() {
        if (markersArray) {
            for (i in markersArray) {
                markersArray[i].setMap(null);
            }
            markersArray.length = 0;
        }
    }
    
    function codeAddress(address) {
        deleteOverlays();
        var markersArray = [];        
//        var address = $("#txt_direccion").val();
        geocoder.geocode( { 'address': address}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                
                addMarker(results[0].geometry.location);

 
              } else {
                alert("Geocode was not successful for the following reason: " + status);
              }
        });
    }
    
       
    
    function asignaLonLat(lat,lon){
        $("#txt_longitud").val(lon);
        $("#txt_latitud").val(lat);
    }
