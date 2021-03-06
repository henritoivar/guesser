<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <h1 class="guesser-title">Game over!!</h1>
            <h2 class="guesser-subtitle">You scored: {{ $score }}!</h2>

            @include('answer.partials.answer-details')
            <div class="padding-tb--md">
                <a class="btn btn--lg btn-primary btn--raised"
                   href="{{ action('LocationController@showLocationChoice') }}">Try again</a>
            </div>
        </div>
    </div>
</div>