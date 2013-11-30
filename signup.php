<?php
require_once('config.php');
require_once('oauth/TweetQuote.php');

$Instance = new TweetQuote($consumerKey,$consumerSecret);
$redirectUrl = $Instance->authorizeApp(true);