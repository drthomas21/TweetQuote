<?php
require_once('oauth/TweetQuote.php');

$Instance = new TweetQuote("q1MmvKYnuHG6Vs1fxDIUVg","hlnVhSuXf1Ju9tdij061Wdt8TGqqrNCQBYHdUt7CF5Y");
$redirectUrl = $Instance->authorizeApp(true);