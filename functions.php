<?php

//Function to start connection to the database.
function connect() {
	$conn = mysql_connect('niko.db','niko7865','QwPoASlk2$');
	if (!$conn) die('Error connecting to server!');
		mysql_select_db('christmas', $conn) or die('Error selecting database');
	return $conn;
}

//Function to close all connections to the database
function closeconnection($conn) {
	mysql_close($conn);
}
function getArticle($id) {
	$conn = connect();
	$sql = "SELECT * FROM articles WHERE id='$id'";
	$result = mysql_query($sql);
	if ($result) {
		$row = mysql_fetch_assoc($result);
		$articleinfo[] = $row;
	}
	return $articleinfo;
	closeconnection($conn);
}
function displayArticles($type,$name) {
	$conn = connect(); //start connection

	if($name){
		$sql = "SELECT * FROM articles WHERE articlePersonID='$name' ORDER BY addDate DESC";
		$result = mysql_query($sql);
		if($result) {
			while($row=mysql_fetch_array($result)) {
				$title = htmlspecialchars($row[imageTitle]);
				$bytes = $row[articleImage];
				echo '<div class="article">
					<h2 class="alignleft"><a href="'.$row['url'].'" target="_blank">'.$row["articleTitle"].'</a></h2>
					<h2 class="alignright"><a href="?prs='.$row['articlePersonID'].'">'.$row["articlePerson"].'</a></h2>
					<div style="clear: both;"></div>
					<div class="line"></div>
					<div class="articleBody clear">
						<div class="figure"><img src="getimg.php?img='.$row['id'].'" height="230" alt="'.$row["articleTitle"].'" /></div>
						<p>'.$row['articleContent'].'</p>
						</div>
					<h4 class="alignleft">Added '.distanceOfTimeInWords($row['addDate']).' ago.</h4>';
					canModify($row['id'],"index.php?prs=".$name);
			}
		}
	}
	elseif($type == 'rcv'){
		$sql = "SELECT * FROM articles WHERE category='$type' ORDER BY addDate DESC";
		$result = mysql_query($sql);
		if($result) {
			while($row=mysql_fetch_array($result)) {
				$title = htmlspecialchars($row[imageTitle]);
				$bytes = $row[articleImage];
				echo '<div class="article">
					<h2 class="alignleft"><a href="'.$row['url'].'" target="_blank">'.$row["articleTitle"].'</a></h2>
					<h2 class="alignright"><a href="?prs='.$row['articlePersonID'].'">'.$row["articlePerson"].'</a></h2>
					<div style="clear: both;"></div>
					<div class="line"></div>
					<div class="articleBody clear">
						<div class="figure"><img src="getimg.php?img='.$row['id'].'" height="230" alt="'.$row["articleTitle"].'" /></div>
						<p>'.$row['articleContent'].'</p>
						</div>
					<h4 class="alignleft">Added '.distanceOfTimeInWords($row['addDate']).' ago.</h4>';
					canModify($row['id'],"index.php?cat=rcv");
			}
		}
	}
	else{
		for( $des = 10; $des >= 0; $des -= 1){	
			$sql = "SELECT * FROM articles WHERE category='$type' AND desire='$des' ORDER BY articlePrice ASC";
			$result = mysql_query($sql);
			if($result) {
				while($row=mysql_fetch_array($result)) {
					$title = htmlspecialchars($row[imageTitle]);
					$bytes = $row[articleImage];
					echo '<a href="'.$row['url'].'" target="_blank">
					<div class="article" id="article'.$row['id'].'">
						<h2 class="alignleft">'.$row["articleTitle"].'</h2>
						<h2 class="alignright">';
						if($type == 'red'){
							echo $row["articlePrice"].' Pages';
						}
						elseif($row["articlePrice"] == 0){
							echo 'FREE';
						}
						else{
							echo '$'.$row["articlePrice"].'';
						}
						echo '</h2>
						<div style="clear: both;"></div>
						<div class="line"></div>
						<div class="articleBody clear">
							<div class="figure"><img src="getimg.php?img='.$row['id'].'" height="230" alt="'.$row["articleTitle"].'" /></div>
							<p>'.$row['articleContent'].'</p>
							</div>
							<h4 class="alignleft">Added '.distanceOfTimeInWords($row['addDate']).' ago.</h4>';
						canModify($row['id'],"index.php?cat=".$type);	
				}
			}
		}
	}
	closeconnection($conn);
}
function displayCategories() {
	$conn = connect(); //start connection
	
	$sql = "SELECT * FROM articles WHERE category='cat' ORDER BY id ASC";
	$result = mysql_query($sql);

	if($result) {
		while($row=mysql_fetch_array($result)) {
        		$title = htmlspecialchars($row[imageTitle]);
			$bytes = $row[articleImage];
			echo '<a href="'.$row['url'].'">
			<div class="article" id="article'.$row['id'].'">
			<h2 class="alignleft">'.$row["articleTitle"].'</h2>
			<div style="clear: both;"></div><div class="line"></div><div class="articleBody clear"><div class="figure">
			<img src="getimg.php?img='.$row['id'].'" height="230" alt="'.$row["articleTitle"].'" /></div>
			<p>'.$row['articleContent'].'</p>
			</div>';
			canModify($row['id'],"index.php");	
		}
	}
	closeconnection($conn);
}
function displayNav() {
	$conn = connect(); //start connection
	
	$sql = "SELECT * FROM articles WHERE category='cat' ORDER BY id ASC";
	$result = mysql_query($sql);

	if($result) {
		while($row=mysql_fetch_array($result)) {
			echo '<li><a href="'.$row[url].'">'.$row[articleTitle].'</a></li>
			';	
		}
	}
	closeconnection($conn);
}
function canModify($id,$url) {
	if (isAdmin()) {
		echo '</a><br /><h4 class="alignleft">
		<form enctype="multipart/form-data" action="editarticle.php?" method="post">
			<input type="hidden" name="id" value="'.$id.'">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="url" value="'.$url.'">
			<input type="submit" value="Edit"/>
		</form></h4>
		<h4 class="alignright">
		<form enctype="multipart/form-data" action="deletearticle.php?" method="post">
			<input type="hidden" name="id" value="'.$id.'">
			<input type="hidden" name="action" value="delete">
			<input type="hidden" name="url" value="'.$url.'">
			<input type="submit" value="Delete"/>
		</form></h4></div>';
	} else { echo '</div></a>'; }
}
function articleEdit() {
	echo 'Edited Article';
}
function articleDelete($id) {
	$conn = connect();
	$sql = "DELETE FROM articles WHERE id='$id'";
	if(mysql_query($sql)) {
		echo "<script type='text/javascript'> alert('Article Deleted'); </script>";
	}
	closeconnection($conn);
}
function isAdmin() {
	return ($_COOKIE["session"] == '0') ? '1' : '0';
}
function isloggedin() {
	if ($_COOKIE["session"] == '0' || $_COOKIE["session"] == '1') {
		return '1';
	} else {
		return '0';
	}
}
function distanceOfTimeInWords($fromTime, $toTime = 0, $showLessThanAMinute = false) {
	$distanceInSeconds = round(abs(time() - $fromTime));
	$distanceInMinutes = round($distanceInSeconds / 60);

	if ( $distanceInMinutes <= 1 ) {
		if ( !$showLessThanAMinute ) {
			return ($distanceInMinutes == 0) ? 'less than a minute' : '1 minute';
		} else {
			if ( $distanceInSeconds < 5 ) {
				return 'less than 5 seconds';
			}
			if ( $distanceInSeconds < 10 ) {
				return 'less than 10 seconds';
			}
			if ( $distanceInSeconds < 20 ) {
				return 'less than 20 seconds';
			}
			if ( $distanceInSeconds < 40 ) {
				return 'about half a minute';
			}
			if ( $distanceInSeconds < 60 ) {
				return 'less than a minute';
			}
			return '1 minute';
		}
	}
	if ( $distanceInMinutes < 45 ) {
		return $distanceInMinutes . ' minutes';
	}
	if ( $distanceInMinutes < 90 ) {
		return 'about 1 hour';
	}
	if ( $distanceInMinutes < 1440 ) {
		return 'about ' . round(floatval($distanceInMinutes) / 60.0) . ' hours';
	}
	if ( $distanceInMinutes < 2880 ) {
		return '1 day';
	}
	if ( $distanceInMinutes < 43200 ) {
		return 'about ' . round(floatval($distanceInMinutes) / 1440) . ' days';
	}
	if ( $distanceInMinutes < 86400 ) {
		return 'about 1 month';
	}
	if ( $distanceInMinutes < 525600 ) {
		return round(floatval($distanceInMinutes) / 43200) . ' months';
	}
	if ( $distanceInMinutes < 1051199 ) {
		return 'about 1 year';
	}

	return 'over ' . round(floatval($distanceInMinutes) / 525600) . ' years';
}
function editbyid($id) {
	$conn = connect();
	if ($_REQUEST[completed] == 1) {
		echo "<script type='text/javascript'> alert('Article Updated'); </script>";
		$cat = mysql_real_escape_string($_POST['cat']);
		$web = mysql_real_escape_string($_POST['web']);
		$rank = mysql_real_escape_string($_POST['rank']);
		$atitle = mysql_real_escape_string($_POST['atitle']);
		$price = mysql_real_escape_string($_POST['price']);
		$personid = mysql_real_escape_string($_POST['personid']);
		$person = mysql_real_escape_string($_POST['person']);
		$text = mysql_real_escape_string($_POST['content']);
		$editTime = time();
		mysql_query("UPDATE articles SET category='$cat',url='$web',desire='$rank',
			articleTitle='$atitle',articlePrice='$price',articlePersonID='$personid',
			articlePerson='$person',articleContent='$text',editTime='$editTime' WHERE id = '$id'");
		closeconnection($conn);
	}
	$info = getArticle($id);
	foreach($info as $key) {
		require("edit.html");
	}
}
?>
