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
                        <img class="img-responsive lazy" src="{{ $correct['url_z'] }}" alt="">
                    </div>
                    <div class="panel-footer text-right">
                        @foreach($options as $option)
                            <button class="btn btn-link btn-choice relative">{{ $option['letter'] }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- map card -->
            <div class="col-xs-7">
            	<div class="panel panel-default">
            		<div class="panel-body no-padding">
            			maps go here
            		</div>
            	</div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('lib/jquery/dist/jquery.js') }}"></script>
    <!-- Lazy images -->
    <script src="{{ asset('lib/jquery_lazyload/jquery.lazyload.js') }}"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <!-- Our GMaps implementation -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            initMap();
            
            $("img.lazy").lazyload({
                effect : "fadeIn"
            });
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