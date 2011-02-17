<?php 
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
	require_once("functions.php");
	if (isset($_GET['cat'])) { $page = "index.php?cat=".$_GET['cat']; }
	elseif (isset($_GET['prs'])) { $page = "index.php?prs=".$_GET['prs']; }
	else { $page = "index.php"; }
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
		<title>Niko's Wishlist!</title>     
		<style type="text/css">
			@import url("styles.php");
		</style>
		<!--[if IE]>
			<style type="text/css">
				.clear {
					zoom: 1;
					display: block;
				}
			</style> 
		<![endif]-->
	</head>
	<body>
		<div class="section" id="page">
			<div class="header"> <!-- Defining the header section of the page with the appropriate tag -->
				<h1><a href="?">Niko's</a></h1>
				<h3><a href="?">Awesome Wishlist</a></h3>     
				<div class="nav2 clear"> <!-- The nav link semantically marks your main site navigation -->
					<ul>
						<li><a href="?">Home</a></li>
						<?php displayNav(); ?>
					</ul>
				</div>
			</div>
			<div class="section" id="articles">
				<?php
					$cat = $_GET['cat'];
					$prs = $_GET['prs'];
					if(isset($cat) || isset($prs)) { displayArticles($cat,$prs);}
					else{ displayCategories();}
				?>
			</div>
			<div class="footer"> <!-- Marking the footer section -->
			<?php if ($_COOKIE["session"] != ''){ echo '<a href="logout.php" class="by">Logout</a>';
			} else { echo '<a href="login.php" class="by">Login</a>'; }?>
				<p>Copyright 2010/2011 - Niko Manos</p> <!-- Change the copyright notice -->
			</div>
		</div>
	</body>
</html>
