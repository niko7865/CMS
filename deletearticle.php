<?php 
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	require_once("functions.php");
	$id = $_POST['id'];
	$action = $_POST['action'];
	$url = $_POST['url'];
	if (isLoggedIn() && isset($id) && isAdmin()) {
		articleDelete($id);
		echo 'url: '.$url;
		header("Location: $url");
	} else {
		echo 'sorry please login<br />';
	}
?>
