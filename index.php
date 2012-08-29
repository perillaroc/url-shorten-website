<?php
/**
 *	shorturl.php a simple short url website
 *	@author Windroc@BIT
 */
$currentService = array("百度(url.cn)","谷歌(goo.gl)","bitly(bit.ly)");
$noticeString = implode("、",$currentService);

// web ui style implemented by cookie
define("DEFAULT_UI_STYLE","bootstrap"); # default ui style
if($_GET['ui-style'])
{
	setcookie("ui-style",$_GET['ui-style'],time()+36000);
	$ui_style = $_GET['ui-style'];
}else if($_COOKIE['ui-style'])
	$ui_style = $_COOKIE['ui-style'];
else
{
	setcookie("ui-style",DEFAULT_UI_STYLE,time()+36000);
	$ui_style = DEFAULT_UI_STYLE;
}
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
<?php
if($ui_style == "jquery-ui")
{
?>
    <link rel="stylesheet" href="includes/css/jquery-ui/ui-lightness/jquery-ui-1.8.18.custom.css" />
 	<link rel="stylesheet" href="includes/css/shorturl_common.css" />
    <script type="text/javascript" src="includes/js/jquery/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="includes/js/shorturl.js"></script>
<?php
}
else
{
?>
	<link rel="stylesheet" type="text/css" href="http://lib.sinaapp.com/js/bootstrap/2.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/shorturl_bootstrap.css" />
	<script type="text/javascript" src="http://lib.sinaapp.com/js/bootstrap/2.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="includes/js/shorturl_bootstrap.js"></script>
<?php
}
?>
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
<div id="wrapped" class="row span10 offset1">
    <div id="header">
    	<h1>短网址</h1>
    </div>
    <!-- header 结束-->
  	
    <div id="main">
    <div class="content accordion accordion-group" id="shorten_url">
    	<h3 class="accordion-heading"><a class="accordion-toggle collapsed" href="#" 
             data-toggle="collapse" data-target="#shorten_url_input_box">生成短网址</a>
        </h3>
        <div class="input_box accordion-body collapse in" id="shorten_url_input_box">
          <div class="accordion-inner">
             <form action="" method="get" enctype="application/x-www-form-urlencoded" name="shorten_form" id="shorten_form">
                <div class="input-append">
                <input type="text" name="longurl" class="url_input span5" id="longurl" placeholder="请输入网址..." />
                <input type="button" class="btn" name="getShortUrl" id="getShortUrl" value="生成短网址" data-toggle="modal" data-target="#infrom_dialog"/>
                </div>
                <div>
                <input type="radio" name="service_provider" value="Baidu" checked="checked" />
                百度 
                <input type="radio" name="service_provider" value="Google" />
                谷歌 
                <input type="radio" name="service_provider" value="Bitly" />
                Bitly
                </div>
            </form>
            <div class="result_box">&nbsp;</div>
          </div> <!-- accordion-inner" -->
        </div>   
    </div> <!-- content -->
	<div class="content accordion accordion-group" id= "expand_url">
    	<h3 class="accordion-heading"><a class="accordion-toggle collapsed" href="#" data-toggle="collapse" data-target="#expand_url_input_box">解释短网址</a></h3>
        <div class="input_box accordion-body collapse in" id="expand_url_input_box">
          <div class="accordion-inner">
            <form action="" method="get" enctype="application/x-www-form-urlencoded" name="expand_form" id="expand_form">
              <div class="input-append">
              <input type="text" name="shorturl" id="shorturl" class="url_input span5" placeholder="请输入网址..."/>
              <input type="button" class="btn" name="expandShortUrl" id="expandShortUrl" value="解释短网址" data-toggle="modal" data-target="#infrom_dialog"//>
              </div>
            </form>
            <div class="notice ui-state-highlight alert alert-info">
                   目前只支持<?php echo $noticeString; ?>的短网址解析。
            </div>
            <div class="result_box">&nbsp;</div>
          </div> <!-- div#accordion-inner -->
        </div>
    </div> <!-- content #expand_url -->
    <div class="content modal hide" id="infrom_dialog" tabindex="-1" role="dialog" 
           aria-labelledby="inform" aria-hidden="true">
<?php
if($ui_style == "jquery-ui"){
?>
      <div id="inform" title="提示"></div>
<?php }
else {
?>
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         <h3 id="inform">提示</h3>
      </div>
      <div class="modal-body" id="inform-body">
      </div>
      <div class="modal-footer">
         <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">确定</button>
      </div>
<?php
} ?>
    </div> <!-- content #inform_dialog -->
    	<div class="content style-switcher" id="ui-style-switcher">
        	<p> 界面风格: 
              <a class="ui-style-item" href="?ui-style=jquery-ui">jquery-ui</a> 
              <a class="ui-style-item" href="?ui-style=booststrap">bootstrap</a> 
            </p>
        </div>
    </div><!-- main -->
<?php
	include("includes/footer.php");
?>