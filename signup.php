<?php
require_once('oauth/TweetQuote.php');

$Instance = new TweetQuote();
$redirectUrl = $Instance->authorizeApp(true);