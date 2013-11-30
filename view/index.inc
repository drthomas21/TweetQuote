<div class="col-xs-12">
	<h1>TweetQuote</h1>
</div>
<?php 
if(isset($arrTweets)){
	foreach ($arrTweets as $Tweet) {
		if(isset($Tweet->errors) && count($Tweet->errors) > 0) {
			$message = array();
			foreach($Tweet->errors as $Error) {
				$message[] = "Error Code {$Error->code}: {$Error->message}";
			}
			echo "<div class='alert alert-danger'>".implode(". ",$message)."</div>";
		} else {
			echo "<div class='alert alert-success'>Successfully Posted Message on {$Tweet->user->screen_name}'s account</div>";
		}
	}	
} ?>
<div class="col-xs-12">
	<p>
		View the <a href="readme">ReadMe Page</a> to read more details
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