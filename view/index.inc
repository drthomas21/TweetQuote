<div class="col-xs-12">
	<h1>TweetQuote</h1>
</div>
<div class="col-xs-12">
	<p>
		View the <a href="readme.html">ReadMe Page</a> to read more details
		about this project
	</p>
	<p>
		If you would like to test this project, <a href="signup.php">Add your
		test Twitter Account Here</a> (and remember, do only your test
		Twitter Account and not your personal account, any one will be able
		to tweet to whatever account you have posted)
	</p>
</div>
<div class="col-xs-12">
	<?php if(isset($redirectUrl)): ?>
	<p>
		We need you to authorize this app to post tweets to your profile.
		Please visit this url to continue: <a
			href="<?php echo $redirectUrl; ?>"><?php echo $redirectUrl; ?> </a>
	</p>
	<?php else:?>
	<form>
		<p>Type a tweet to test:</p>
		<div class="col-xs-12">
			<textarea rows="3" class="form-control" name="tweet"></textarea>
		</div>
		<div class="col-xs-12 clearfix">&nbsp;</div>
		<div class="col-xs-12 clearfix">
			<button type="submit" class="btn btn-primary">Tweet!</button>
		</div>
	</form>
	<?php endif;?>
</div>