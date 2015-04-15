    function arma_direccion() {
        var direccion = $("#direccion").val();
        var localidad = $('#ciudad_id option:selected').html();
        var provincia = $('#provincia_id option:selected').html();
        var pais      = $("#pais").val();
            
        var address = direccion+ ', '+localidad+', '+provincia+ ', '+ pais;
        codeAddress(address);
    //    console.log(address);
    }

    var geocoder;
    var map;
    if (lat==null) { var lat = -32.950741;}  
    if (lon==null) { var lon = -60.666499;}  
    
    var markersArray = [];



    function geocodePosition(pos) {
//      console.log(pos);
      geocoder.geocode({
        latlng: pos
      });
//       console.log(geocoder);
    }


    function updateMarkerPosition(latLng) {
//       console.log(latlng.lat());
        asignaLonLat(latLng.lat(),latLng.lng());
    }


    
    function initialize(lat,lon) {
//        console.log(lat,lon);
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
        
        addMarker(latlng,lat,lon);
        
    }


    function addMarker(location,lat,lon) {
        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true
        });
//        console.log(location.lat());
        lat = location.lat();
        lon = location.lng();
        asignaLonLat(lat,lon);
 //        console.log(location);
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
 //       console.log(address);
        deleteOverlays();
        var markersArray = [];        

        geocoder.geocode( { 'address': address}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                
                addMarker(results[0].geometry.location);

 
              } else {
                var localidad = $('#localidad option:selected').html();
                var provincia = $("#provincia").val();
                var pais    = $("#pais").val();
                var address = localidad+', '+provincia+ ', '+ pais;
                codeAddress(address);
                //alert("Para geolocalizar su alojamiento, debe ingresar la dirección y localidad");
              }
        });
    }
    
       
    
    function asignaLonLat(lat,lon){
//        console.log(lat,lon);
        $("#txt_longitud").val(lon);
        $("#txt_latitud").val(lat);
      
    }
