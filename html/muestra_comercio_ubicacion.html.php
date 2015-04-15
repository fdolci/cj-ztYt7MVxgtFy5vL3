<?php 
  $lat = $_GET['latitud'];
  $lon = $_GET['longitud'];
?>
<body style='margin:0px;'>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>

   <script>
      var map;
      var infowindow;

      function initialize() {
        var pyrmont = new google.maps.LatLng('<?php echo $lat;?>', '<?php echo $lon;?>');

        map = new google.maps.Map(document.getElementById('map_canvas'), {
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          center: pyrmont,
          zoom: 15
        });


        infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        //service.nearbySearch(request, callback);
        // service.nearbySearch(request1, callback);
        //service.nearbySearch(request2, callback);

        var marker = new google.maps.Marker({
                position: pyrmont, 
                map: map
        });

      }

      function callback(results, status) {
        
        if (status == google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {

            createMarker(results[i],icono);
          }
        }
      }

      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.types+' <br>\n' +place.name);
          
          infowindow.open(map, this);
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);

    </script>

<div id="map_canvas" style="width:340px; height:400px;position:absolute;"></div>
</body>