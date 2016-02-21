@extends('app')

@section('content')
<div class="container guesser">
	<div class="row">
		<div class="col-xs-12">
			<h1 class="text-center guesser-title">Where is it?</h1>
			<!-- image container -->
			<div class="panel panel-default panel-guesser relative">
			  <div class="panel-body no-padding">
			    <img class="img-responsive" src="http://michaeldaviddesign.com/themes/escape/files/stacks_image_85.jpg" alt="">
			  </div>
			  <div class="panel-footer">
			  	<button class="btn btn-link display-b relative ripple">Option A</button>
			  	<button class="btn btn-link display-b relative">Option B</button>
			  	<button class="btn btn-link display-b relative">Option C</button>
			  	<button class="btn btn-link display-b relative">Option D</button>
			  </div>
			</div>

		</div>
	</div>
</div>
@endsection