<?php 
ob_start ("ob_gzhandler");
header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 * 2 ;
$ExpStr = "Expires: " . 
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);
?>
*{
	/* Universal reset: */
	margin:0;
	padding:0;
}

body{
	/* Setting the default text color, size, page background and a font stack: */
	font-size:0.825em;
	color:#000000;
	background-color:#cfcfcf;
	font-family:Arial, Helvetica, sans-serif;
}

/* Hyperlink Styles: */

a, a:visited {
	color:#000000;
	text-decoration:none;
	outline:none;
}

a:hover{
	color:#000000;
	text-decoration:none;
}

a img{
	border:none;
}

/* Headings: */

h1,h2,h3,h4{
	font-family:"Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
	text-shadow:0 1px 1px black;
}

h1{
	/* The logo text */
	font-size:3.5em;
	padding:0.5em 0 0;
	text-transform:uppercase;
}

h3{
	/* The slogan text */
	font-family:forte,"Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
	font-size:2em;
	font-weight:normal;
	margin:0 0 1em;
}

h2{
	font-size:2.2em;
	font-weight:normal;
	letter-spacing:0.01em;
	text-transform:uppercase;
}

h4{
	font-size:0.7em;
	text-shadow:none;
	color:#878787;
}

.alignleft{
	float:left;
}

.alignright{
	float:right;
}
.rel{
	position:relative;
}
p{
	line-height:1.5em;
	padding-bottom:1em;
}

.line{
	/* The dividing line: */
	height:1px;
	background-color:#cfcfcf;
	margin:1em 0;
	overflow:hidden;
}

div.article .line{
	/* The dividing line inside of the article is darker: */
	background-color:#15242a;
	border-bottom-color:#204656;
	margin:1.3em 0;
}

div.footer .line{
	margin:2em 0;
}

div.nav{
	background:url(gradient_light.jpg) repeat-x 50% 50% #f8f8f8;
	padding:0 5px;
	position:absolute;
	right:0;
	top:4em;
	
	border:1px solid #FCFCFC;

	-moz-box-shadow:0 1px 1px #333333;
	-webkit-box-shadow:0 1px 1px #333333;
	box-shadow:0 1px 1px #333333;
}

div.nav2{
	background:url(gradient_light.jpg) repeat-x 50% 50% #f8f8f8;
	padding:0 5px;
	position:absolute;
	right:0;
	top:4em;
	
	border:1px solid #FCFCFC;

	-moz-box-shadow:0 1px 1px #333333;
	-webkit-box-shadow:0 1px 1px #333333;
	box-shadow:0 1px 1px #333333;
}
/* The clearfix hack to clear the floats: */

.clear:after{
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}

/* The navigation styling: */

div.nav ul li{
	display:inline;
}

div.nav ul li a,
div.nav ul li a:visited{
	color:#565656;
	display:block;
	float:left;
	font-size:1.25em;
	font-weight:bold;
	margin:5px 2px;
	padding:7px 10px 4px;
	text-shadow:0 1px 1px white;
	text-transform:uppercase;
}

div.nav ul li a:hover{
	text-decoration:none;
	background-color:#f0f0f0;
}

div.nav, div.article, div.nav ul li a, div.figure{
	/* Applying CSS3 rounded corners: */
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
}

/* The navigation2 styling: */

div.nav2 ul li{
	display:inline;
}

div.nav2 ul li a,
div.nav2 ul li a:visited{
	color:#565656;
	display:block;
	float:left;
	font-size:1.25em;
	font-weight:bold;
	margin:5px 2px;
	padding:7px 10px 4px;
	text-shadow:0 1px 1px white;
	text-transform:uppercase;
}

div.nav2 ul li a:hover{
	text-decoration:none;
	background-color:#f0f0f0;
}

div.nav2, div.nav2 ul li a{
	/* Applying CSS3 rounded corners: */
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	border-radius:10px;
}


/* Article styles: */

#page{
	width:700px;
	margin:0 auto;
	position:relative;
}

div.article{
	background-color:#ffffff;
	margin:3em 0;
	padding:20px;
	text-shadow:0 1px 0 #cfcfcf;
	-moz-box-shadow:0 0 5px #696969;
	-webkit-box-shadow:0 0 5px #696969;
	box-shadow:0 0 5px #696969;
}

div.article:hover{
}

div.figure{text-shadow:none;
/*	border:3px solid #142830;*/
	float:right;
/*	height:230px;
	margin-left:15px;
	overflow:hidden;
	width:230px;*/
}

/* Footer styling: */

div.footer{
	margin-bottom:30px;
	text-align:center;
	font-size:0.825em;
}


div.footer p{
	margin-bottom:-2.5em;
	position:relative;
}

div.footer a,div.footer a:visited{
	display:block;
	padding:2px 4px;
	z-index:100;
	position:relative;
}

div.footer a:hover{
	text-decoration:none;
}

div.footer a.by{
	float:left;

}

div.footer a.up{
	float:right;
}

div.log {
	width:300px;
	float:left;
}

div.reg {
	width:300px;
	float:right;
}

div.cen {
	text-align:center;
}

div.block {
	padding:0.5em 0 0;
	margin-left: auto;
	margin-right: auto;
	width: 8em;
}