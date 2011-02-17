<?php

function siteLogin($url) {
	if ($_REQUEST[login] == 1) {
		$conn = connect();

		$myusername = addslashes($_POST['myusername']);
		$mypassword = passEncrypt($_POST['mypassword']);
		$sql = "SELECT * FROM users WHERE userName='$myusername'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		closeconnection($conn);
		if ($mypassword == $row['userPass']) {
			/* sets the cookie with a name that of the user, value of the users rank,
			expire of two hours, path of everything, single domain, non-secure, httponly */
			setcookie("session",$row['userRank'],time()+7200);
			header("Location: $url");
		} else {
			echo 'Incorrect!';
		}
	}
	if ($_REQUEST[register] == 1) {
		$conn = connect();

		$myusername = addslashes($_POST['myusername']);
		$sql = "SELECT * FROM users WHERE userName='$myusername'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)==0) {
			if ($_POST['mypassword'] == $_POST['mypassword2']) {
				$myrank = 1;
				$myemail = addslashes($_POST['myemail']);
				$mypassword = passEncrypt($_POST['mypassword']);
				mysql_query("INSERT INTO users (userName,userEmail,userPass,userRank)
					VALUES ('$myusername','$myemail','$mypassword','$myrank')");
				setcookie("session","1",time()+7200);
				echo 'USER ADDED';
			} else {
				echo 'Error Passwords do not match!';
			}
		} else {
			echo 'USER EXISTS';
		}


	}
		echo '
		<!DOCTYPE HTML>
		<html>
		<head>
		<style type="text/css">@import url("styles.php");</style>
		</head>
		<body>
		<div class="section" id="page">
		<div class="header">
		<h1>Niko\'s</h1>
		<h3>Awesome Wishlist</h3>
		</div>
		<div class="section" id="articles">
		<div class="article">
		<div class="articleBody">
		<div class="log">
		<form name="login" method="post">
		<div class="cen"><strong>Login </strong></div><br />
		<div class="block">Username:<br />
		<input name="myusername" type="text" id="myusername"><br />
		Password:<br />
		<input name="mypassword" type="password" id="mypassword"><br /><br />
		<input type="hidden" name="login" value="1">
		<input type="submit" name="Submit" value="Login">
		</form>
		</div>
		</div>
		<div class="reg">
		<form name="register" method="post">
		<div class="cen"><strong>Register</strong></div>
		<div class="block">Username:<br />
		<input name="myusername" type="text" id="myusername"><br />
		Email:<br />
		<input name="myemail" type="email" id="myemail"><br />
		Password:<br />
		<input name="mypassword" type="password" id="mypassword"><br />
		Verify Password:<br />
		<input name="mypassword2" type="password" id="mypassword2"><br />
		<input type="hidden" name="register" value="1">
		<br />
		<input type="submit" name="Submit" value="Register">
		</form>
		</div>
		</div>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		</div>
		</div>
		</div>
		</body>
		</html>';
}
function passEncrypt($string) {
	// Create a salt
	$salt = md5($string."=-29awop97q1_@$%(@$+)^%!@#GD");

	// Hash string
	$hash = sha1($salt.$string.$salt);

	return $hash;
}

?>