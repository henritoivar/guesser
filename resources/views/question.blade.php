@extends('app')

@section('content')
    <!-- result details -->
    <div id="continue-container" class="continue-container" style="display: none">
        <div id="correct-answer-text" style="display: none;">
            <h1>You are crazy smart!</h1>
            <h2>Have a kitten!</h2>
            <h2>You gained a <3</h2>
        </div>
        <div id="incorrect-answer-text" style="display: none">
            <h1>Dang!</h1>
            <h2>You lost a <3</h2>
        </div>
        <div id="answer-details">

        </div>
        <a class="btn btn-link" href="{{ action('QuestionController@showQuestion') }}">Continue</a>
    </div>
    
    <!-- main content -->
    <div class="container guesser">
        <div class="row">
            <div class="col-xs-12">
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
                var submitAnswerBtn = $(this);
                
                // ripple forwards
                submitAnswerBtn.addClass("ripple-forwards");
                // Set loading text
                $('.panel-guesser').attr('answer-content', 'Aaand..');

                var answerId = $(this).data('answer-id');
                guess(answerId, function (response) {

                    console.log(response);

                    // Hide loader
                    $('#loader').hide();

                    if (response.correctAnswer === true) {
                        // Show that answer was correct
                        $('.panel-guesser').attr('answer-content', 'Correct!');
                        $('.panel-guesser').addClass('correct-answer');

                        // Show correct answer text
                        $('#correct-answer-text').show();
                    } else {
                        // Show that answer was incorrect
                        $('.panel-guesser').attr('answer-content', 'Nope!');
                        $('.panel-guesser').addClass('incorrect-answer');

                        // Show incorrect answer text
                        $('#incorrect-answer-text').show();
                    }

                    // Show continue button
                    setTimeout(function() {
                        // $('#continue-container').fadeIn(400);
                    }, 2000);

                    // Add answer details

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