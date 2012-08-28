<?php
/**
 *	shorturl.php 短网址
 *	@author Windroc@BIT
 */
 
$currentService = array("百度(url.cn)","谷歌(goo.gl)","bitly(bit.ly)");
$noticeString = implode("、",$currentService);
 
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="includes/css/jquery-ui/ui-lightness/jquery-ui-1.8.18.custom.css" />
 	<link rel="stylesheet" href="includes/css/shorturl.css" />
	<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="includes/js/jquery/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="includes/js/shorturl.js"></script>
	<title>短网址</title>
<?php
include("includes/header.php");
generateHeader();
?>
</head>
<?php
flush();
?>
<body>

<div id="wrapped">
    
    <div id="header">
    	<h1>短网址</h1>
    </div>
    <!-- header 结束-->
  	
    <div id="main">
    <div class="content accordion" id="shorten_url">
    	<h3><a href="#">生成短网址</a></h3>
        <div class="input_box">
           <form action="" method="get" enctype="application/x-www-form-urlencoded" name="shorten_form" id="shorten_form">
              <p>
              <input type="text" name="longurl" class="url_input" id="longurl" />
              <input type="button" name="getShortUrl" id="getShortUrl" value="生成短网址" />
              </p>
              <p>
              <input type="radio" name="service_provider" value="Baidu" checked="checked" />
              百度 
              <input type="radio" name="service_provider" value="Google" />
              谷歌 
              <!--<input type="radio" name="service_provider" value="Tencent" />
              腾讯 -->
              <input type="radio" name="service_provider" value="Bitly" />
              Bitly
              </p>
          </form>
          <div class="result_box">&nbsp;</div>
        </div>   
    </div> <!-- content -->
	<div class="content accordion" id= "expand_url">
    	<h3><a href="#">解释短网址</a></h3>
        <div class="input_box">
            <form action="" method="get" enctype="application/x-www-form-urlencoded" name="expand_form" id="expand_form">
              <input type="text" name="shorturl" id="shorturl" class="url_input"/>
              <input type="button" name="expandShortUrl" id="expandShortUrl" value="解释短网址" />
            </form>
            <div class="notice ui-state-highlight">目前只支持<?php echo $noticeString; ?>的短网址解析。</div>
            <div class="result_box">&nbsp;</div>
        </div>
    </div> <!-- content #expand_url -->
    <div class="content" id="infrom_dialog">
      <div id="inform" title="提示"></div>
    </div> <!-- content #inform_dialog -->
    </div><!-- main -->
<?php
	include("includes/footer.php");
?>