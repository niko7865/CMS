<?php
	require_once("functions.php");
	$type = $_POST['type'];
	$action = $_POST['action'];
	if ($type == 'article') {
		if ($action == 'add') {
			$conn = connect();
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
			$aID = mysql_insert_id();
			closeconnection($conn);
			header("Location: http://".$_SERVER['HTTP_HOST']."/?cat=".$cat."#article".$aID);
		} elseif ($action == 'edit') {
			$conn = connect();
			$id = $_POST['id'];
			$cat = mysql_real_escape_string($_POST['cat']);
			$web = mysql_real_escape_string($_POST['web']);
			$rank = mysql_real_escape_string($_POST['rank']);
			$atitle = mysql_real_escape_string($_POST['atitle']);
			$price = mysql_real_escape_string($_POST['price']);
			$personid = mysql_real_escape_string($_POST['personid']);
			$person = mysql_real_escape_string($_POST['person']);
			$text = mysql_real_escape_string($_POST['content']);
			$editTime = time();
			mysql_query("UPDATE articles SET category='$cat',url='$web',desire='$rank',articleTitle='$atitle',articlePrice='$price',articlePersonID='$personid',articlePerson='$person',articleContent='$text',editTime='$editTime' WHERE id='$id'");
			echo "<script type='text/javascript'> alert('Article Updated'); </script>";
			closeconnection($conn);
			header("Location: http://".$_SERVER['HTTP_HOST']."/?cat=".$cat."#article".$id);
		} elseif ($action == 'delete') {
			$conn = connect();
			$id = $_POST['id'];
			$info = getArticle($id);
			foreach ($info as $key) {
				$cat = $key['category'];
			}
			mysql_query("DELETE FROM articles WHERE id='$id'");
			closeconnection($conn);
			header("Location: http://".$_SERVER['HTTP_HOST']."/?cat=".$cat."#article".$id);
		} elseif ($action == 'rcv') {
			$conn = connect();
			$id = $_POST['id'];
			mysql_query("UPDATE articles SET category='rcv' WHERE id='$id'");
			closeconnection($conn);
			header("Location: http://".$_SERVER['HTTP_HOST']."/?cat=rcv#article".$id);
		}
	} elseif ($type == 'comment') {
		if ($action == 'add') {
			$conn = connect();
			$articleID = mysql_real_escape_string($_POST['articleID']);
			$content = mysql_real_escape_string($_POST['content']);
			$userID = userID();
			$addtime = time();
			mysql_query("INSERT INTO comments (cArticleID,cText,cAuthor,cDate) 
				VALUES ('$articleID','$content','$userID','$addtime')");
			$info = getArticle($articleID);
			foreach ($info as $key) {
				$cat = $key['category'];
			}
			closeconnection($conn);
			header("Location: http://".$_SERVER['HTTP_HOST']."/?cat=".$cat."#article".$articleID);
		} elseif ($action == 'edit') {
			$conn = connect();
			$id = $_POST['id'];
			$articleID = mysql_real_escape_string($_POST['articleID']);
			$content = mysql_real_escape_string($_POST['content']);
			mysql_query("UPDATE comments SET cText='$content' WHERE cID='$id'");
			$info = getArticle($articleID);
			foreach ($info as $key) {
				$cat = $key['category'];
			}
			closeconnection($conn);
			header("Location: http://".$_SERVER['HTTP_HOST']."/cat=".$cat."#article".$articleID);
		} elseif ($action == 'delete') {
			$conn = connect();
			$id = $_POST['id'];
			$articleID = $_POST['articleID'];
			mysql_query("DELETE FROM comments WHERE cID='$id'");
			$info = getArticle($articleID);
			foreach ($info as $key) {
				$cat = $key['category'];
			}
			closeconnection();
			header("Location: http://".$_SERVER['HTTP_HOST']."/?cat=".$cat."#article".$articleID);
		}
	}
?>
