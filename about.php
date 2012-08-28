<?php 
/**
 *	about.php
 *	@author Windroc
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="includes/css/jquery-ui/ui-lightness/jquery-ui-1.8.18.custom.css" />
 	<link rel="stylesheet" href="includes/css/shorturl.css" />
	<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="includes/js/jquery/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="includes/js/shorturl.js"></script>
	<title>关于本站</title>
<?php
	include("includes/header.php");
	generateHeader();
?>
</head>

<body>
<div id="wrapped">
    
    <div id="header">
    	<h1>关于本站</h1>
    </div> <!-- header -->
  	
    <div id="main">
    <div class="content">
    <p>windroc</p>
    <p>2012.03.23</p>
    <p>国内网站中新浪提供短网址服务，但api调用需要审核应用一直没成功，腾讯短网址解析需要鉴权信息。所以，能解析的短网址不包括这两个网站。</p>
    <p><a href="index.php">返回首页</a></p>
    </div>
    </div> <!-- main -->
    
<?php
	include("includes/footer.php");
?>