@extends('app')

@section('content')
    <div class="container guesser">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1 class="guesser-title">Where is it?</h1>
                <div class="points">
                    <h3><strong>3</strong> <i class="material-icons md-48">favorite</i></h3>
                    <h3><strong>0</strong> <i class="material-icons md-48">attach_money</i></h3>
                </div>
            </div>
            <!-- image card -->
            <div class="col-xs-5">
                <!-- image container -->
                <div class="panel panel-default panel-guesser relative">
                    <div class="panel-body no-padding">
                        <img width="{{ $correct['width_c'] }}" height="{{ $correct['height_c'] }}"
                             class="img-responsive lazy" src="{{ $correct['url_c'] }}" alt="">
                    </div>
                    <div id="options" class="panel-footer no-padding relative float-fix">
                        <div id="continue-container" class="continue-container" style="display: none">
                            <div id="answer-details" style="display: none;">
                                <h1>You are crazy smart!</h1>
                            </div>
                            <a class="btn btn-link" href="{{ action('QuestionController@showQuestion') }}">Continue</a>
                        </div>
                        @foreach($options as $option)
                            <button data-answer-id="{{ $option['id'] }}"
                                    class="btn btn-link btn-choice relative submit-answer">{{ $option['letter'] }}</button>
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

    <!-- Lazy images -->
    <script src="{{ asset('lib/jquery_lazyload/jquery.lazyload.js') }}"></script>

    <script>
        // load lazy images
        $("img.lazy").lazyload({
            effect: "fadeIn"
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

                    // Show continue button
                    $('#continue-container').fadeIn(400);

                    if (response.correctAnswer === true) {
                        // Show that answer was correct
                        $('.panel-guesser').addClass('correct-answer');

                        // Show answer details
                        $('#answer-details').show();
                    } else {
                        // Show that answer was incorrect
                        $('.panel-guesser').addClass('incorrect-answer');
                    }
                });
            });
        });

        function guess(answerId, callback) {
            $.post('{{ action('API\AnswerController@guess') }}', {
                answerId: answerId
            }, callback);
        }
    </script>

@endsection