@extends('app')

@section('content')
    <div class="container guesser">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center guesser-title">Where is it?</h1>
            </div>
            <!-- image card -->
            <div class="col-xs-5">
                <!-- image container -->
                <div class="panel panel-default panel-guesser relative">
                    <div class="panel-body no-padding">
                        <img width="{{ $correct['width_c'] }}" height="{{ $correct['height_c'] }}" class="img-responsive lazy" src="{{ $correct['url_c'] }}" alt="">
                    </div>
                    <div id="options" class="panel-footer no-padding relative float-fix">
                        <div id="continue-container" class="continue-container" style="display: none">
                            <div id="answer-details" style="display: none;">
                                this picture was taken with a banana!
                            </div>
                            <a class="btn btn-link" href="{{ action('QuestionController@showQuestion') }}">Continue</a>
                        </div>
                        @foreach($options as $option)
                            <button data-answer-id="{{ $option['id'] }}" class="btn btn-link btn-choice relative submit-answer">{{ $option['letter'] }}</button>
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

                    <div id="loader" style="display: none;">
                        loading ...
                    </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('lib/jquery/dist/jquery.js') }}"></script>

    <!-- Lazy images -->
    <script src="{{ asset('lib/jquery_lazyload/jquery.lazyload.js') }}"></script>

    <script>
        // load lazy images
        $("img.lazy").lazyload({
            effect : "fadeIn"
        });
        
        $(document).ready(function () {
            // Guess answer
            $('.submit-answer').click(function () {
                $(this).addClass("ripple");

                // Show loader
                $('#loader').show();

                var answerId = $(this).data('answer-id');
                guess(answerId, function (response) {

                    // Hide loader
                    $('#loader').hide();

                    // Hide the options
                    // $('#options').hide();

                    if(response.correctAnswer === true) {
                        // Show that answer was correct
                        $('.panel-guesser').addClass('correct-answer');

                        // Show answer details
                        $('#answer-details').show();
                    }else{
                        // Show that answer was incorrect
                        $('.panel-guesser').addClass('incorrect-answer');
                    }

                    // Show continue button
                    $('#continue-container').fadeIn(400);
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