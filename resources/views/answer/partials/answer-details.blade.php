
@if(isset($details['title']['_content']))
    <h4>This picture is titled <span class="text-primary">"{{ $details['title']['_content'] }}"</span></h4>
@endif

<h4 class="padding-tb--md">
    It was taken
    @if(isset($details['dates']['taken']))
        <strong>{{ $details['dates']['takenDate']->diffForHumans() }}</strong> on {{ $details['dates']['takenDate']->toFormattedDateString() }}
    @endif
    by
    @if(isset($details['owner']['iconUrl']))
       <img src="{{ $details['owner']['iconUrl'] }}" class="img-circle">
    @endif

    {{ $details['owner']['realname'] }}

    @if(isset($details['owner']['location']))
        from <strong>{{ $details['owner']['location'] }}</strong>
    @endif
    and has been viewed <strong>{{ $details['views'] }}</strong> times</h4>

@if(isset($details['location']['neighbourhood']['_content']))
    <h4>The hood is <strong>{{ $details['location']['neighbourhood']['_content'] }} ;)</strong></h4>
@endif

