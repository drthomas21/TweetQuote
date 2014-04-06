<?php
	if($_GET['oauth_verifier']) {
		if($Instance->authorizeOAuthToken($_GET['oauth_verifier'])) {
			header("Location: /?message=Successfully+added+Twitter+account");
		} else {
			header("Location: /?error=Failed+to+add+Twitter+account");
		}
	} elseif($_GET['message']) {
		echo $_GET['message'];
	}
?>
