@extends('app')

@section('content')
    <div class="container guesser">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center guesser-title">Where is it?</h1>
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
        </div>
    </div>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <!-- Our GMaps implementation -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            initMap();
        });

        function initMap(){
            var mapOptions = {
                zoom: 13,
                minZoom: 3,
                streetViewControl: false,
                zoomControl: false,
                panControl: false
            };

            // Create map
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        }
    </script>
@endsection