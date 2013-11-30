<?php
define('DEBUG',true);
require_once('oauth/TweetQuote.php');

$Instance = new TweetQuote();
if($Instance->hasStoredOAuthToken()) {
	$Instance->buildTwitterConnection();
	if($_GET['tweet']) {
		$Instance->sendTweet($_GET['tweet']);
	}
} else {
	$redirectUrl = $Instance->authorizeApp(true);
}

include_once(dirname(__FILE__)."/index.inc");
?>