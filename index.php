<?php
date_default_timezone_set('America/Los_Angeles');

require_once('config.php');
require_once('oauth/TweetQuote.php');
$Instance = new TweetQuote($consumerKey,$consumerSecret);
$Instance->setCallbackUrl("http://{$_SERVER['SERVER_NAME']}/callback");
$action = "";

if($_SERVER['REQUEST_URI'] != "/" && stripos($_SERVER['REQUEST_URI'],"/?tweet") === false && stripos($_SERVER['REQUEST_URI'],"/?message") === false && stripos($_SERVER['REQUEST_URI'],"/?error") === false) {
	$request = preg_replace("/\?.+/","",strtolower($_SERVER['REQUEST_URI']));
	$action = preg_replace("/[^a-z\-]/", "", $request);
	if(file_exists(dirname(__FILE__)."/view/{$action}.inc")) {
		$file = (dirname(__FILE__)."/view/{$action}.inc");
	} else {
		$file = (dirname(__FILE__)."/view/404.inc");
	}
} else {
	if($Instance->hasStoredOAuthToken()) {
		$Instance->buildTwitterConnection();
		if(isset($_GET['tweet'] && $_GET['tweet']) {
			$arrTweets = $Instance->sendTweet($_GET['tweet']);
		}
	} 
	$file = (dirname(__FILE__)."/view/index.inc");
}
include_once dirname(__FILE__).'/view/header.inc';
include_once $file;
include_once dirname(__FILE__).'/view/footer.inc';
?>
