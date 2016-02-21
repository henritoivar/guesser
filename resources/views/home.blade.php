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
@endsection