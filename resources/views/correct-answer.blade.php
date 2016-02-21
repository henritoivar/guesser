<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h1 class="guesser-title">Booom-shaka-laka!!!</h1>
			<h2 class="guesser-subtitle">Here is some coffee for you!<i class="material-icons">local_cafe</i> You gained a <i class="material-icons md-48">favorite</i>!</h2>

			@include('answer-details')

			<a class="btn btn-lg btn-primary btn--raised" href="{{ action('QuestionController@showQuestion') }}">Continue</a>
		</div>
	</div>
</div>