<?php
require_once('config.php');
require_once('oauth/TweetQuote.php');

$Instance = new TweetQuote($consumerKey,$consumerSecret);
if($_GET['oauth_verifier']) {
	$Instance->authorizeOAuthToken($_GET['oauth_verifier']);
	header("Location: /");
} elseif($_GET['message']) {
	if($_GET['message'] == 1) {
		echo "Failed to authorizing the app's credentials";
	}
}