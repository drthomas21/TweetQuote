<?php
	if($_GET['oauth_verifier']) {
		$Instance->authorizeOAuthToken($_GET['oauth_verifier']);
		header("Location: /?message=Successfully+added+Twitter+account");
	} elseif($_GET['message']) {
		echo $_GET['message'];
	}
?>
