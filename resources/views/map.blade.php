<div id="map-canvas" style="height: 600px"></div>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

<!-- Our GMaps implementation -->
<script>
    (function(){
        google.maps.event.addDomListener(window, "load", initMap);

        function initMap() {
            // Random latLng, broke otherwise
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var mapOptions = {
                zoom: 13,
                center: latlng,
                minZoom: 3,
                streetViewControl: false,
                //zoomControl: false,
                panControl: false
            };

            var locations = {!! $options->toJson() !!};

            // Create map
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            // Add markers
            var markers = createMarkers(locations, map);

            // Fit map to markers
            fitMarkersToViewBounds(markers, map);
        }

        function createMarkers(locations, map) {
            var markers = [];

            for (var prop in locations) {
                if (locations.hasOwnProperty(prop)) {
                    var location = locations[prop];
                    // Create marker
                    var marker = new google.maps.Marker({
                        map: map,
                        icon: {
                            url: 'http://maps.google.com/mapfiles/marker' + location.letter + '.png'
                        },
                        position: new google.maps.LatLng(location.latitude, location.longitude)
                    });

                    markers.push(marker);
                }
            }

            return markers;
        }

        function fitMarkersToViewBounds(markers, map) {
            var bounds = new google.maps.LatLngBounds();

            for (var i = 0; i < markers.length; i++) {
                bounds.extend(markers[i].getPosition());
            }

            map.fitBounds(bounds);
        }
    })();

</script>