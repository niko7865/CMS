<?php
		require_once("functions.php");
		$id = $_POST['id'];
		$loc = $$_POST['url'];
		$conn = connect();
		$cat = mysql_real_escape_string($_POST['cat']);
		$web = mysql_real_escape_string($_POST['web']);
		$rank = mysql_real_escape_string($_POST['rank']);
		$atitle = mysql_real_escape_string($_POST['atitle']);
		$price = mysql_real_escape_string($_POST['price']);
		$personid = mysql_real_escape_string($_POST['personid']);
		$person = mysql_real_escape_string($_POST['person']);
		$text = mysql_real_escape_string($_POST['content']);
		$editTime = time();
		$sql = "UPDATE articles SET category='$cat',url='$web',desire='$rank',articleTitle='$atitle',articlePrice='$price',articlePersonID='$personid',articlePerson='$person',articleContent='$text',editTime='$editTime' WHERE id='$id'";
		if(mysql_query($sql)) {
			echo "<script type='text/javascript'> alert('Article Updated'); </script>";
			header("Location: $loc");
		}
		closeconnection($conn);
?>
