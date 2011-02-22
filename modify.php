<?php
	require_once("functions.php");
	$type = $_GET['t'];
	$action = $_GET['a'];
	$url = $_POST['url'];
	if ($type == 'a') {
		if ($action == 'a') {
			if (isAdmin()) {
				include 'private/addarticle.php';
			} else {
				siteLogin("")
			}
		} elseif ($action == 'e') {

		}
	} elseif ($type == 'c') {
		if ($action == 'a') {

		} elseif ($action == 'e') {

		}
	}
?>
