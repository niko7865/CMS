<?php 
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	require_once("functions.php");
	$id = $_POST['id'];
	$url = $_POST['url'];
	$type = $_POST['type'];
	if (isLoggedIn()) {
		$info = getArticle($id);
		foreach($info as $key) {
			echo '
<html>
	<head>
		<title>Add a comment</title>
		<style type="text/css">
			@import url("styles.php");
		</style>
	</head>
	<body>
	<div class="section" id="page">
		<div class="header">
			<h1>Add</h1>
			<h3>Comment Adder</h3>
		</div>
		<div class="section" id="articles">
			<div class="article" id="article'.$id.'">
					<h2 class="alignleft">
						'.$key["articleTitle"].'
					</h2>
				<h2 class="alignright">';
					if($key["articlePrice"] == 0){
						echo 'FREE';
					}
					else{
						echo '$'.$key["articlePrice"].'';
					}
				echo '</h2>
				<div style="clear: both;"></div>
				<div class="line"></div>
				<div class="articleBody clear">
					<div class="figure">
						<img src="getimg.php?img='.$id.'" height="230" alt="'.$key["articleTitle"].'" />
					</div>
					<p>
						'.$key['articleContent'].'
					</p>
				</div>
				<h4 class="alignleft">Added '.distanceOfTimeInWords($key['addDate']).' ago.</h4>
				<div class="line"></div>
				Add Comment:
				<form enctype="multipart/form-data" action="modify.php" method="post">
					<input type="hidden" name="type" value="comment">
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="url" value="'.$url.'">
					<input type="hidden" name="articleID" value="'.$id.'">
					<textarea name="content" id="content" cols="80" rows="4"></textarea>
					<br /><br />
					<h4 class="alignright"><input type="submit" value="Submit"/></h4>
					<br />
				</form>';
				displayComments($id,0);
			echo '</div>
		</div>
	</div>
	</body>
</html>';
		}
	} else {
		echo 'sorry please login<br />';
	}
?>
