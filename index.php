<?php
require_once('oauth/TweetQuote.php');

/*$Instance = new TweetQuote();
if($Instance->hasStoredOAuthToken()) {
	$Instance->buildTwitterConnection();
	if($_GET['tweet']) {
		$Instance->sendTweet($_GET['tweet']);
	}
} else {
	$redirectUrl = $Instance->authorizeApp(true);
}*/


if($_SERVER['REQUEST_URI'] != "/") {
	$request = strtolower($_SERVER['REQUEST_URI']);
	$action = preg_replace("/[^a-z]/", "", $request);
	if(file_exists(dirname(__FILE__)."/view/{$action}.inc")) {
		$file = (dirname(__FILE__)."/view/{$action}.inc");
	} else {
		$file = (dirname(__FILE__)."/view/404.inc");
	}
} else {
	$file = (dirname(__FILE__)."/view/index.inc");
}
include_once dirname(__FILE__).'/view/header.inc';
include_once $file;
include_once dirname(__FILE__).'/view/footer.inc';
?>