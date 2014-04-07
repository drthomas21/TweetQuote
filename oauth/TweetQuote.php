<?php
/**
 * @version 1.3
 * @author drthomas
 *
 */
class TweetQuote {
	private $__consumerKey = "--Twitter app's API key--";
	private $__consumerSecret = "--Twitter app's API secret--";
	private $__callbackUrl = null;
	private $__Twitter = array();
	
	/**
	 * 
	 * @param required string $consumerKey
	 * @param required string $consumerSecret
	 * @param string $callbackUrl
	 */
	public function __construct($consumerKey = "", $consumerSecret = "", $callbackUrl = null) {
		session_start();
		require_once(dirname(__FILE__)."/twitteroauth.php");
		require_once(dirname(__FILE__)."/MessageLogger.php");
		
		$this->__consumerKey = $consumerKey;		
		$this->__consumerSecret = $consumerSecret;
		
		if($callbackUrl == null) {
			$this->__callbackUrl = "";
		} else {
			$this->__callbackUrl = $callbackUrl;
		}
		$this->__Twitter = array();
	}
	
	/**
	 * 
	 * @param array $token
	 * @return boolean
	 */
	private function storeToken($token) {
		$bool = true;
		$storedTokens = $this->getToken();
		if($storedTokens && array_key_exists($token['screen_name'],$storedTokens)){
			$storedTokens[$token['screen_name']]['oauth_token'] = $token['oauth_token'];
			$storedTokens[$token['screen_name']]['oauth_token_secret'] = $token['oauth_token_secret'];
			$content = "";
			foreach($storedTokens as $screenName => $token){
				$content .= "[{$screenName}]\r\noauth_token = {$token['oauth_token']}\r\noauth_token_secret = {$token['oauth_token_secret']}\r\n";
			}
			
			$_bool = @file_put_contents(dirname(__FILE__)."/conf.ini", $content);
			if(!$_bool === false) {
				$bool = $_bool;
			}
		} else {
			$content = "[{$token['screen_name']}]\r\noauth_token = {$token['oauth_token']}\r\noauth_token_secret = {$token['oauth_token_secret']}\r\n";
			$_bool = @file_put_contents(dirname(__FILE__)."/conf.ini", $content,FILE_APPEND);
			if($_bool === false) {
				$bool = $_bool;
			}
		}
		return $bool;		
	}
	
	private function getToken() {
		return @parse_ini_file(dirname(__FILE__)."/conf.ini",true);
	}
	
	/**
	 * Use this function to set the callback url
	 * @param string $url
	 */
	public function setCallbackUrl($url = "") {
		$this->__callbackUrl = $url;
	}
	
	/**
	 * Use this function to authorize the app and have the user to allow this app access to the user's account
	 * @param boolean $boolRedirect - automatically redirect the user to the Twitter's app authorization page
	 * @return string
	 */
	public function authorizeApp($boolRedirect = true) {
		MessageLogger::logMessage("Connecting to TwitterOAuth using ConsumerKey: {$this->__consumerKey}");
		$connection = new TwitterOAuth($this->__consumerKey, $this->__consumerSecret);
		
		MessageLogger::logMessage("Requesting token with callback url: {$this->__callbackUrl}");
		$tempCred = $connection->getRequestToken($this->__callbackUrl);
		$_SESSION['oauth_token'] = $tempCred['oauth_token'];
		$_SESSION['oauth_token_secret'] = $tempCred['oauth_token_secret'];
		if(defined('DEBUG') && DEBUG == true) {
			echo "<strong>Temporary Credentials</strong>: ";
			var_dump($tempCred);
			echo "<br />";
		}
				
		MessageLogger::logMessage("Getting Twitter's authorization url");
		$redirectUrl = $connection->getAuthorizeURL($tempCred);
		if(defined('DEBUG') && DEBUG == true) {
			echo "<strong>Twitter Authentication URL</strong>: ";
			echo "<br />";
		}
		
		if(!$boolRedirect) {
			return $redirectUrl;
		} else {
			if(!empty($redirectUrl) && isset($tempCred['oauth_token'])) {
				MessageLogger::logMessage("Redirecting url to Twitter's aurhorization url: {$redirectUrl}");
				header("Location: {$redirectUrl}");
			} else {
				MessageLogger::logMessage("Failed to authorize the app's credentials, please check app settings");
				header("Location: {$this->__callbackUrl}?message=".urlencode("Failed to authorize the app's credentials, please check app settings"));
			}
		}

		return "";
	}
	
	/**
	 * Use this function to verify that the OAuth token is correct. This function will also store the token.
	 * @param string $oauthVerifier
	 * @return bool
	 */
	public function authorizeOAuthToken($oauthVerifier = "") {
		if(!isset($_SESSION['oauth_token']) || empty($_SESSION['oauth_token'])) {
			MessageLogger::logMessage("The OAuth Token is not set.");
			var_dump($_SESSION['oauth_token']);
			return false;
		}
		
		if(empty($oauthVerifier)) {
			MessageLogger::logMessage("The OAuth Verifier is not set.");
			return false;
		}
		
		$connection = new TwitterOAuth($this->__consumerKey, $this->__consumerSecret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
		$_SESSION['tokenCred'] = $connection->getAccessToken($oauthVerifier);
		if(defined('DEBUG') && DEBUG == true) {
			echo "<strong>OAuth Token Credentials</strong>: ";
			var_dump($_SESSION['tokenCred']);
			echo "<br />";
		}
		if(!$this->storeToken($_SESSION['tokenCred'])) {
			MessageLogger::logMessage("Failed to store token");
			return false;
		}
	}
	
	/**
	 * Use this function to see if there are tokens stored in the conf.ini file
	 * @return boolean
	 */
	public function hasStoredOAuthToken() {
		$_SESSION['tokenCred'] = $this->getToken();
		if(defined('DEBUG') && DEBUG == true) {
			echo "<strong>Stored Token Credentials</strong>: ";
			var_dump($_SESSION['tokenCred']);
			echo "<br />";
		}
		if(isset($_SESSION['tokenCred']) && $_SESSION['tokenCred']) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Use this function to connect to the users' accounts
	 */
	public function buildTwitterConnection() {
		if(!isset($_SESSION['tokenCred']) || !is_array($_SESSION['tokenCred'])) {
			MessageLogger::logMessage("The OAuth Token Credentials are not set.");
			return;
		}
	
		foreach($_SESSION['tokenCred'] as $twitterUser => $tokenCred){
			$this->__Twitter[$twitterUser] = new TwitterOAuth($this->__consumerKey, $this->__consumerSecret, $tokenCred['oauth_token'], $tokenCred['oauth_token_secret']);
		}
		
		if(defined('DEBUG') && DEBUG == true) {
			echo "<strong>Twitter Connection</strong>: ";
			var_dump($this->__Twitter);
			echo "<br />";
		}
	}
	
	/**
	 * Use this function to tweet to the users' accounts
	 * @param string $message
	 */
	public function sendTweet($message = "", $twitterUser = "") {
		$arrTweetStatus = array();
		if(!empty($twitterUser)) {
			if(array_key_exists($twitterUser, $this->__Twitter)) {
				$arrTweetStatus[] = $this->__Twitter[$twitterUser]->post('statuses/update', array('status' => $message));
			} else {
				MessageLogger::logMessage("Twitter user: {$twitterUser} does not have any credentials stored");
			}
		} else {
			foreach($this->__Twitter as $TwitterConnection) {
				$arrTweetStatus[] = $TwitterConnection->post('statuses/update', array('status' => $message));
			}
		}
		if(!empty($arrTweetStatus)) {
			foreach($arrTweetStatus as $Tweet) {
				if(isset($Tweet->errors) && count($Tweet->errors) > 0) {
					foreach($Tweet->errors as $Error) {
						MessageLogger::logMessage("Error Code {$Error->code}: {$Error->message}");
					}                        		
				} else {
						MessageLogger::logMessage("Successfully Posted Message on {$Tweet->user->screen_name}'s account");
				}
			}
		}

		if(defined('DEBUG') && DEBUG == true) {
			echo "<strong>Tweet Statuses</strong>: ";
			var_dump($arrTweetStatus);
			echo "<br />";
		}
		
		return $arrTweetStatus;
	}
}
