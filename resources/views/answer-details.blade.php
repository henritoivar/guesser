@if($answerCorrect)
    <h1>You are crazy smart!</h1>
    <h2>Have a kitten!</h2>
    <h2>You gained a <3</h2>
@else
    <h1>Dang!</h1>
    <h2>You lost a <3</h2>
@endif

@if(isset($details['title']['_content']))
    <h3>This picture is titled <span class="success">"{{ $details['title']['_content'] }}"</span></h3>
@endif

<h3>
    It was taken
    @if(isset($details['dates']['taken']))
        {{ $details['dates']['takenDate']->diffForHumans() }} on {{ $details['dates']['takenDate']->toFormattedDateString() }}
    @endif
    by
    @if(isset($details['owner']['iconUrl']))
       <img src="{{ $details['owner']['iconUrl'] }}" class="circle">
    @endif

    {{ $details['owner']['realname'] }}

    @if(isset($details['owner']['location']))
        from {{ $details['owner']['location'] }}
    @endif
    and has been viewed {{ $details['views'] }} times</h3>

@if(isset($details['location']['neighbourhood']['_content']))
    <h3>The hood is {{ $details['location']['neighbourhood']['_content'] }} ;)</h3>
@endif

