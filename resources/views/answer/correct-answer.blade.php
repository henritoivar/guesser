<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h1 class="guesser-title">Booom-shaka-laka!!!</h1>
			<h2 class="guesser-subtitle">You gained a <i class="material-icons md-48">favorite</i>!</h2>
			<h4>Here is some <i class="material-icons md-48">local_cafe</i> for you! </h4>

			@include('answer.partials.answer-details')
			<div class="padding-tb--md">
				<a class="btn btn--lg btn-primary btn--raised" href="{{ action('QuestionController@showQuestion') }}">Continue</a>
			</div>
		</div>
	</div>
</div>