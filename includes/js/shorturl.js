// JavaScript Document
// shorturl.js

$(document).ready(function(){
	$('.accordion').accordion({
		collapsible: true
	});
	$('.accordion:first').accordion("option",{
		fillspace:true
	});
	$('input:button,input:submit').button();
	
	// 获取短网址
	$('#getShortUrl').click(function(){
		$longurl = $('#longurl').val();
		if(!$longurl){
			$('#inform').html("<p>网址不能为空，请输入网址。</p>");
			$('#inform').dialog("open");
			return false;
		}
		$('#shorten_url .result_box').html("");
		$serviceProvider = $('#shorten_form input:radio:checked').val();
		$url = "includes/shorturlservice.php";
		$data = { longurl: $longurl, service_provider: $serviceProvider};
		$.getJSON($url,$data,function(data){
			// 判断结果
			if(typeof data["error"] == "undefined"){
				$('#shorten_url .result_box').html(data["shorturl"]);
			} else {
				// 出错
				$('#shorten_url .result_box').html("<p>解析错误，请输入有效的网址</p>");
				$('#inform').html("<p>"+data["error"]+"</p>");
				$('#inform').dialog("open");
			}
		});
		return false;
	});
	
	// 解释短网址
	$('#expandShortUrl').click(function(){
		$shorturl = $('#shorturl').val();
		if(!$shorturl){
			$('#inform').html("<p>网址不能为空，请输入网址。</p>");
			$('#inform').dialog("open");
			return false;
		}
		$('#expand_url .result_box').html("");
		$url = "includes/shorturlservice.php";
		$data = { shorturl: $shorturl};
		$.getJSON($url,$data,function(data){
			// 判断结果
			if(typeof data["error"] == "undefined"){
				$('#expand_url .result_box').html(data["longurl"]);
			} else {
				// 出错
				$('#expand_url .result_box').html("<p>解析错误，请输入有效的网址</p>");
				$('#inform').html("<p>"+data["error"]+"</p>");
				$('#inform').dialog("open");
			}
		});
		return false;
	});
});

$(document).ready(function(){
	$('#inform').dialog({
		autoOpen: false,
		buttons: {
			"确定": function() { 
				$(this).dialog("close"); 
				$('#inform').html("<p>网址不能为空，请输入网址。</p>");
			}, 
		}
	});
});
