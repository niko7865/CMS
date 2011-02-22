<?php
	require_once("functions.php");
	require_once("userfunc.php");
	$conn = connect();
	if (isAdmin()){
		if ($_REQUEST[completed] == 1) {
			$cat = mysql_real_escape_string($_POST['cat']);
			$web = mysql_real_escape_string($_POST['web']);
			$rank = mysql_real_escape_string($_POST['rank']);
			$atitle = mysql_real_escape_string($_POST['atitle']);
			$price = mysql_real_escape_string($_POST['price']);
			$personid = mysql_real_escape_string($_POST['personid']);
			$person = mysql_real_escape_string($_POST['person']);
			$text = mysql_real_escape_string($_POST['content']);
			$addtime = time();
			move_uploaded_file($_FILES['imagefile']['tmp_name'],"private/latest.img");
			$instr = fopen("private/latest.img","rb");
			$image = addslashes(fread($instr,filesize("private/latest.img")));
			if (strlen($image) < 149999) {
				mysql_query ("INSERT INTO articles (category,url,desire,articleTitle,articlePrice,articlePersonID,articlePerson,articleContent,addDate,articleImage) 
					VALUES ('$cat','$web','$rank','$atitle','$price','$personid','$person','$text','$addtime','$image')");
			} else {
				$errmsg = "Too large!";
			}
			$imagefile = "private/latest.img";
			unlink($imagefile);
			closeconnection($conn);
		}
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
						<form enctype="multipart/form-data" method="post">
						<h2 class="alignleft">Category: 
						<select name="cat" id="cat">
							<option>cat</option>
							<option>prc</option>
							<option>red</option>
							<option>doo</option>
							<option>rcv</option>
						</select></h2>
						<h2 class="alignright">Desire: 
						<select name="rank" id="rank">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
						</select></h2>
						<div class="clear"></div>
						<br />
						<h2 class="alignleft"><input name="web" type="text" id="web" placeholder="URL" /></h2>
						<h2 class="alignright"><input name="person" type="text" id="person" placeholder="NAME" /></h2>
						<div class="clear"></div>
						<br />
						<h2 class="alignleft"><input name="atitle" type="text" id="atitle" placeholder="TITLE" /></h2>
						<h2 class="alignright"><input name="price" type="number" id="price" min="0" step="1" value="0" /></h2>
						<div class="clear"></div>
						<br />
						<div class="line"></div>
						<div class="articleBody clear">
							<div class="figure">
								Image:<br />
								<input type="file" name="imagefile"><br />
							</div>
							<p>
								<textarea name="content" id="content" cols="50" rows="10"></textarea>
							</p>
						</div>
						<input type="hidden" name="MAX_FILE_SIZE" value="150000" />
						<input type="hidden" name="completed" value="1" />
						<h2 class="alignright"><input type="submit" value="Submit" /></h2>
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>';
	} else {
		siteLogin("add.php");
	}
?>
