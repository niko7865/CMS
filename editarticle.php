<?php 
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	require_once("functions.php");
	$id = $_POST['id'];
	$action = $_POST['action'];
	$url = $_POST['url'];
	if (isLoggedIn() && isset($id) && isAdmin()) {
	$info = getArticle($id);
	foreach($info as $key) {
echo '
<html>
	<head>
		<title>Add an entry to the database</title>
		<style type="text/css">
			@import url("styles.php");
		</style>
	</head>
	<body>
		<div class="section" id="page">
			<div class="header">
				<h1>Add</h1>
				<h3>Article adder</h3>
			</div>
			<div class="section" id="articles">
				<div class="article">
					<form enctype="multipart/form-data" method="post" action="edit.php">
						<h2 class="alignleft">Category: 
							<select name="cat" id="cat">';
								if ( $key["category"] == "cat" ) {
									echo '<option value="cat" selected>Categories</option>';
								} else {
									echo '<option value="cat">Categories</option>';
								}
								
								if ( $key["category"] == "prc" ) {
									echo '<option value="prc" selected>Purchase</option>';
								} else {
									echo '<option value="prc">Purchase</option>';
								}
								
								if ( $key["category"] == "red" ) {
									echo '<option value="red" selected>Read</option>';
								} else {
									echo '<option value="red">Read</option>';
								}
								
								if ( $key["category"] == "doo" ) {
									echo '<option value="doo" selected>Do</option>';
								} else {
									echo '<option value="doo">Do</option>';
								}
								
								if ( $key["category"] == "rcv" ) {
									echo '<option value="rcv" selected>Recieved</option>';
								} else {
									echo '<option value="rcv">Recieved</option>';
								}
							echo '</select></h2>
						<h2 class="alignright">Desire: 
							<select name="rank" id="rank">';
								switch ($key["desire"]) {
									case 1:
										echo '<option value="1" selected>1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 2:
										echo '<option value="1">1 - Low Desire</option>
										<option selected>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 3:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option selected>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 4:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option selected>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 5:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option selected>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 6:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option selected>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 7:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option selected>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 8:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option selected>8</option>
										<option>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 9:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option selected>9</option>
										<option value="10">10 - High Desire</option>';
										break;
									case 10:
										echo '<option value="1">1 - Low Desire</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>6</option>
										<option>7</option>
										<option>8</option>
										<option>9</option>
										<option value="10" selected>10 - High Desire</option>';
										break;
								}
							echo '</select></h2>
						<div class="clear"></div>
						<br />
						<h2 class="alignleft">
							<input name="web" type="text" id="web" placeholder="URL" value="'.$key["url"].'" />
						</h2>
						<h2 class="alignright">
							<input name="person" type="text" id="person" placeholder="NAME" value="'.$key["articlePerson"].'" />
						</h2>
						<div class="clear"></div>
						<br />
						<h2 class="alignleft">
							<input name="atitle" type="text" id="atitle" placeholder="TITLE" value="'.$key["articleTitle"].'" />
						</h2>
						<h2 class="alignright">
							<input name="price" type="number" id="price" min="0" step="1" value="'.$key["articlePrice"].'" />
						</h2>
						<div class="clear"></div>
						<br />
						<div class="line"></div>
						<div class="articleBody clear">
							<div class="figure">
								Image:<br />
								<img src="getimg.php?img='.$key['id'].'" height="230" alt="'.$key["articleTitle"].'" />
								<br />
								<!--<input type="file" name="imagefile"><br />-->
							</div>
							<p>
								<textarea name="content" id="content" cols="50" rows="10">'.$key["articleContent"].'</textarea>
							</p>
						</div>
						<!--<input type="hidden" name="MAX_FILE_SIZE" value="150000" />-->
						<input type="hidden" name="completed" value="1" />
						<input type="hidden" name="url" value="'.$url.'" />
						<input type="hidden" name="id" value="'.$id.'" />
						<h4 class="alignleft">
							<input type="submit" value="Submit" id="submit"/>
						</h4>
					</form>
					<h4 class="alignright">
						<form enctype="multipart/form-data" action="deletearticle.php?" method="post">
							<input type="hidden" name="id" value="'.$id.'">
							<input type="hidden" name="action" value="delete">
							<input type="hidden" name="url" value="'.$url.'">
							<input type="submit" value="Delete"/>
						</form>
					</h4>
				</div>
			</div>
		</div>
	</body>
</html>';
	}
	} else {
		echo 'sorry please login<br />';
	}
?>
