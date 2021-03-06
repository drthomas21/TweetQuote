<h2>Self-Tweets: TweetQuote - v1.2</h2>
<p>
	PHP library for sending tweets to a specific or multiple accounts. <br />
	View the project on <a href="https://github.com/drthomas21/TweetQuote">GitHub</a>.
	Also, visit the <a href="/">Example Page</a>.
</p>
<h2>Flow Overview For Normal Automation</h2>
<ol>
	<li>Retreive stored client credentials and token credentials.</li>
	<li>Verify client credentials and token credentials.</li>
	<li>Retreive message to tweet onto clients' profiles.</li>
	<li>Tweet the message onto clients' profiles.</li>
	<li>Log successful and failed tweets.</li>
</ol>
<h2>Notes</h2>
<p>1) The Tweet Quote library requires a Twitter Developer account and
	needs a consumer key, consumer secret and permission level of "Read,
	write, and direct messages".</p>
<p>
	2) Clients that did not give the app authorization to be used, should
	go to <strong>signup.php</strong> and allow the app access to their
	accounts. Once the user gives the app permission to access their
	account, Twitter will redirect the user to <strong>callback.php</strong>.
	If you would like to change where the callback url is, then you can do
	this within your <strong>signup.php</strong>:<br />
</p>
<pre>
<code>&lt;?php
$Instance = new TweetQuote();
$Instance-&gt;setCallbackUrl("http:&#47;&#47;yourwebsite.com&#47;somecallbackurl");
$Instance-&gt;authorizeApp();
?&gt;</code>
    </pre>
<p>
	3) <strong>callback.php</strong> expects to receive a response from
	Twitter with an OAuth Verification. With the OAuth Verification, the
	app can store the user's credentials and will have direct access to the
	user's account information.
</p>
<p>
	4) <strong>index.php</strong> is set to recieve the message that should
	be posted on each stored Twitter account
</p>
<p>Each page (index.php, callback.php, signup.php) are not a requirement
	for the library to work, however, they show how each different page
	interacts with the same library</p>
