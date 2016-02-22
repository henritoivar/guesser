<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h1 class="guesser-title">Booom!</h1>
			<h2 class="guesser-subtitle">You lost a <i class="material-icons md-48">favorite</i>!</h2>

			@include('answer.partials.answer-details')
			<div class="padding-tb--md">
				<a class="btn btn--lg btn-primary btn--raised" href="{{ action('QuestionController@showQuestion') }}">Continue</a>
			</div>
		</div>
	</div>
</div>