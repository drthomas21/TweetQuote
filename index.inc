<html>
	<head>
	</head>
	<body>
		<h1>Self-Tweets: TweetQuote</h1>
		<?php if(isset($redirectUrl)): ?>
		<p>We need you to authorize this app to post tweets to your profile. Please visit this url to continue: <a href="<?php echo $redirectUrl; ?>"><?php echo $redirectUrl; ?></a></p>
		<?php else:?>
		<form>
			<p>Type a tweet to test: <input type="text" name="tweet" /><input type='submit' value='Tweet!' /></p>
		</form>
		<?php endif;?>
	</body>
</html>