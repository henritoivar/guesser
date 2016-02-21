<h1>Game over!!</h1>
You scored: {{ $score }}

@include('answer-details')

<a class="btn btn-link" href="{{ action('LocationController@showLocationChoice') }}">Try again</a>