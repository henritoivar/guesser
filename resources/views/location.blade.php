@extends('app')

@section('content')
    <div class="container text-center">
        <div class="row">
            <div class="col-xs-12 padding-tb--lg">
                <h1 class="text-primary padding-tb--md">So you think you know your neighbourhood?</h1>
                <h3 class="guesser-subtitle">Let's find out!</h3>
            </div>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
            <form action="{{ action('LocationController@setLocation') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="latitude">
                <input type="hidden" name="longitude">
                <div class="input-group input-group-lg">
                    <input id="googleAutocomplete" class="form-control" placeholder="Type to find your location..."
                           type="text">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Start</button>
                </span>
                </div><!-- /input-group -->
            </form>
        </div>
    </div>


    @section('scripts')
        @parent
        <!-- Google Maps API -->
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key={{ config('google.key') }}&libraries=places"></script>

        <script>
            (function () {
                var autoComplete;

                $(document).ready(function () {
                    var autoCompleteInputEl = document.getElementById('googleAutocomplete');

                    autoComplete = new google.maps.places.Autocomplete(
                            autoCompleteInputEl,
                            {
                                types: ['geocode']
                            }
                    );

                    // Set location when selected from autocomplete
                    autoComplete.addListener('place_changed', setLocation);

                    // On enter press, dont submit form otherwise the location might not be set in time
                    google.maps.event.addDomListener(autoCompleteInputEl, 'keydown', function (e) {
                        if (e.keyCode == 13) {
                            e.preventDefault();
                        }
                    });

                    autofillLocation();
                });

                function setLocation(e) {
                    var place = autoComplete.getPlace();
                    $('input[name=latitude]').val(place.geometry.location.lat());
                    $('input[name=longitude]').val(place.geometry.location.lng());
                }

                function autofillLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {

                            // Fill in the lng and lat paramaters
                            $('input[name=latitude]').val(position.coords.latitude);
                            $('input[name=longitude]').val(position.coords.longitude);

                            // Fill in the address bar
                            getAddressFromGeolocation(position);

                            // Bias the location
                            biasLocation(position);
                        });
                    }
                }

                function getAddressFromGeolocation(position) {
                    var geocoder = new google.maps.Geocoder();

                    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    geocoder.geocode({
                        latLng: latlng
                    }, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            if (results[1]) {

                                // Fill in the address in the address bar
                                $('#googleAutocomplete').val(results[1].formatted_address);

                                // autoComplete.set('place', results[1].place_id);
                            } else {
                                console.log('No results found');
                            }
                        } else {
                            console.log('Geocoder failed due to: ' + status);
                        }
                    });
                }

                function biasLocation(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Also bias the loction search to current location
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autoComplete.setBounds(circle.getBounds());
                }
            })();
        </script>
    @stop
@endsection