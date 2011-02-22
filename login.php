<?php
	require_once("functions.php");
	require_once("userfunc.php");
	if (isLoggedIn()){
		echo 'You are already logged in!';
		header("refresh: 5; url=index.php");
	} else {
		siteLogin("index.php");
	}
?>
