@extends('app')

@section('content')
    <div class="container-fluid guesser">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center guesser-title">Where is it?</h1>
            </div>
            <!-- image card -->
            <div class="col-xs-5">
                <!-- image container -->
                <div class="panel panel-default panel-guesser relative">
                    <div class="panel-body no-padding">
                        <img class="img-responsive" src="{{ $correct['url_z'] }}" alt="">
                    </div>
                    <div class="panel-footer">
                        @foreach($options as $option)
                            <button class="btn btn-link display-b relative ripple">{{ $option['letter'] }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- map card -->
            <div class="col-xs-7">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        <div id="map-canvas" style="height: 600px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <!-- Our GMaps implementation -->
    <script>
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

            console.log(locations);

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

    </script>
@endsection