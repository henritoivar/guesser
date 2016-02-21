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
                        <img width="{{ $correct['width_c'] }}" height="{{ $correct['height_c'] }}" class="img-responsive" src="{{ $correct['url_c'] }}" alt="">
                    </div>
                    <div class="panel-footer">
                        @foreach($options as $option)
                            <button data-answer-id="{{ $option['id'] }}" class="btn btn-link display-b relative ripple submit-answer">{{ $option['letter'] }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- map card -->
            <div class="col-xs-7">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        @include('map')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script>
        $(document).ready(function () {

            // Guess answer
            $('.submit-answer').click(function () {
                var answerId = $(this).data('answer-id');
                guess(answerId, function (response) {
                    if(response.correctAnswer === true) {
                        // Show that answer was correct
                        console.log('correct!')
                        // Show answer details
                    }else{
                        // Show that answer was incorrect
                        console.log('wrong!');
                    }

                    // Reload the page/ get next guess
                    document.location.reload();
                });
            });
        });

        function guess(answerId, callback){
            $.post('{{ action('API\AnswerController@guess') }}', {
                answerId: answerId
            }, callback);
        }
    </script>

@endsection