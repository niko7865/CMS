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
				echo '<div class="article">
					<h2 class="alignleft"><a href="'.$row['url'].'" target="_blank">'.$row["articleTitle"].'</a></h2>
					<h2 class="alignright"><a href="?prs='.$row['articlePersonID'].'">'.$row["articlePerson"].'</a></h2>
					<div style="clear: both;"></div>
					<div class="line"></div>
					<div class="articleBody clear">
						<a href="'.$row['url'].'" target="_blank">
						<div class="figure"><img src="getimg.php?img='.$row['id'].'" height="230" alt="'.$row["articleTitle"].'" /></div>
						</a>
						<p>'.$row['articleContent'].'</p>
						</div>
					<h4 class="alignleft">Added '.distanceOfTimeInWords($row['addDate']).' ago.</h4>';
					canModify($row['id'],"index.php?prs=".$name);
					displayComments($row['id']);
					echo '</div></div>';
			}
		}
	}
	elseif($type == 'rcv'){
		$sql = "SELECT * FROM articles WHERE category='$type' ORDER BY addDate DESC";
		$result = mysql_query($sql);
		if($result) {
			while($row=mysql_fetch_array($result)) {
				echo '<div class="article" id="article'.$row['id'].'">
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
					displayComments($row['id']);
					echo '</div></div>';
			}
		}
	}
	else{
		for( $des = 10; $des >= 0; $des -= 1){	
			$sql = "SELECT * FROM articles WHERE category='$type' AND desire='$des' ORDER BY articlePrice ASC";
			$result = mysql_query($sql);
			if($result) {
				while($row=mysql_fetch_array($result)) {
					echo '
					<div class="article" id="article'.$row['id'].'">
						<a href="'.$row['url'].'" target="_blank">
							<h2 class="alignleft">
								'.$row["articleTitle"].'
							</h2>
						</a>
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
							<a href="'.$row['url'].'" target="_blank">
								<div class="figure">
									<img src="getimg.php?img='.$row['id'].'" height="230" alt="'.$row["articleTitle"].'" />
								</div>
							</a>
							<p>
								'.$row['articleContent'].'
							</p>
						</div>
						<h4 class="alignleft">Added '.distanceOfTimeInWords($row['addDate']).' ago.</h4>';
						canModify($row['id'],"index.php?cat=".$type);
						canComment($row['id'],"index.php?cat=".$type."#article".$row['id']);
						displayComments($row['id'],"index.php?cat=".$type);
					echo '</div>';
				}
			}
		}
	}
	closeconnection($conn);
}
function displayCategories() {
	$catConn = connect(); //start connection
	
	$catSql = "SELECT * FROM articles WHERE category='cat' ORDER BY id ASC";
	$catResult = mysql_query($catSql);

	if($catResult) {
		while($catRow=mysql_fetch_array($catResult)) {
			echo '<a href="'.$catRow['url'].'">
			<div class="article" id="article'.$catRow['id'].'">
			<h2 class="alignleft">'.$catRow["articleTitle"].'</h2>
			<div style="clear: both;"></div><div class="line"></div><div class="articleBody clear"><div class="figure">
			<img src="getimg.php?img='.$catRow['id'].'" height="230" alt="'.$catRow["articleTitle"].'" /></div>
			<p>'.$catRow['articleContent'].'</p>
			</div>';
			canModify($catRow['id'],"index.php");
			echo '</div></a>';	
		}
	}
	closeconnection($catConn);
}
function displayNav() {
	$navConn = connect(); //start connection
	
	$navSql = "SELECT * FROM articles WHERE category='cat' ORDER BY id ASC";
	$navResult = mysql_query($navSql);

	if($navResult) {
		while($navRow=mysql_fetch_array($navResult)) {
			echo '<li><a href="'.$navRow[url].'">'.$navRow[articleTitle].'</a></li>
			';	
		}
	}
	closeconnection($navConn);
}
function displayComments($id,$url) {
	$comConn = connect();

	$comSql = "SELECT * FROM comments WHERE cArticleID='$id' ORDER BY cID DESC";
	$comResult = mysql_query($comSql);
	if (mysql_num_rows($comResult) != 0){
		echo '<div class="line"></div>';
		while($comRow = mysql_fetch_array($comResult)){
			echo '
				<h5 class="alignleft">
					'.userName($comRow['cAuthor']).'
				</h5>
				<h6 class="alignright">
					'.distanceOfTimeInWords($comRow['cDate']).' ago
				</h6>
				<div class="commentBody clear">
					<br />
					<p>
						'.$comRow['cText'].'
					</p>';
					if ($url != '0') {
						comModify($comRow['id'],$url);
					}
				echo '</div>';
			}
	}
}
function canModify($id,$url) {
	if (isAdmin()) {
		echo '</a><br /><h4 class="alignleft">
		<form enctype="multipart/form-data" action="modify.php?t=a&a=e&i='.$id.'" method="post">
			<input type="hidden" name="url" value="'.$url.'">
			<input type="submit" value="Edit"/>
		</form></h4>
		<h4 class="alignright">
		<form enctype="multipart/form-data" action="commit.php" method="post">
			<input type="hidden" name="type" value="article">
			<input type="hidden" name="action" value="rcv">
			<input type="hidden" name="id" value="'.$id.'">
			<input type="hidden" name="url" value="?cat=rcv#article'.$id.'">
			<input type="submit" value="Recieved"/>
		</form></h4>';
	}
}
function canComment($id,$url) {
	if (isLoggedIn()) {
		echo '<h4 class="alignright">
		<form enctype="multipart/form-data" action="modify.php?t=c&a=a&i='.$id.'" method="post">
			<input type="hidden" name="type" value="comment">
			<input type="hidden" name="action" value="add">
			<input type="hidden" name="id" value="'.$id.'">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="url" value="'.$url.'">
			<input type="submit" value="Comment"/>
		</form></h4>';
	}
	echo '<br />';
}
function comModify($id,$url) {
	if (isAdmin()) {
		echo '<h4 class="alignleft">
		<form enctype="multipart/form-data" action="modify.php" method="post">
			<input type="hidden" name="type" value="comment">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="id" value="'.$id.'">
			<input type="hidden" name="action" value="edit">
			<input type="hidden" name="url" value="'.$url.'">
			<input type="submit" value="Edit"/>
		</form></h4><br />';
	}
}
function isAdmin() {
	return ($_COOKIE["session"] == '0') ? '1' : '0';
}
function isLoggedIn() {
	if (($_COOKIE["session"] == '0' || $_COOKIE["session"] == '1') && userID() != '0') {
		return '1'; //true
	} else {
		return '0'; //false
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
	$editConn = connect();
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
		closeconnection($editConn);
	}
	$info = getArticle($id);
	foreach($info as $key) {
		require("edit.html");
	}
}
function userID() {
	return $_COOKIE["userid"];
}
function userName($userID) {
	$conn = connect();
	$sql = "SELECT * FROM users WHERE id='$userID'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	return $row['userName'];
}
function isOwner() {
	return 0;
}
?>
