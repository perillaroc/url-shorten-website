// shorturl_bootstrap.js
// 2012.08.29 windroc@BIT
$(document).ready(function(){
	$('.modal').on('show', function() {
      $(this).css({
        'margin-top': function () {
           return -($(this).height() / 2);
        }
      });
    });
	
	// 获取短网址
	$('#getShortUrl').click(function(){
		$('#shorten_url .result_box').html("<div class=\"alert\">正在获取...</div>");
		$longurl = $('#longurl').val();
		if(!$longurl){
			$('#inform-body').html("<div class=\"alert alert-error\">网址不能为空，请输入网址。</div>");
			$('#infrom_dialog').modal("show");
			$('#shorten_url .result_box').html("");
			return false;
		}
		$serviceProvider = $('#shorten_form input:radio:checked').val();
		$url = "includes/shorturlservice.php";
		$data = { longurl: $longurl, service_provider: $serviceProvider};
		$.getJSON($url,$data,function(data){
			// 判断结果
			if(typeof data["error"] == "undefined"){
				$('#shorten_url .result_box').html("<div class=\"alert alert-success\">"+data["shorturl"]+"</div>");
			} else {
				// 出错
				$('#shorten_url .result_box').html("<div class=\"alert alert-error\">解析错误，请输入有效的网址</div>");
				$('#inform-body').html("<div class=\"alert alert-error\">"+data["error"]+"</div>");
			    $('#infrom_dialog').modal("show");
			}
		});
		return false;
	});
	
	// 解释短网址
	$('#expandShortUrl').click(function(){
		$('#expand_url .result_box').html("<div class=\"alert\">正在获取...</div>");
		$shorturl = $('#shorturl').val();
		if(!$shorturl){
			$('#inform-body').html("<div class=\"alert alert-error\">网址不能为空，请输入网址。</div>");
			$('#infrom_dialog').modal("show");
			$('#expand_url .result_box').html("");
			return false;
		}
		$url = "includes/shorturlservice.php";
		$data = { shorturl: $shorturl};
		$.getJSON($url,$data,function(data){
			// 判断结果
			if(typeof data["error"] == "undefined"){
				$('#expand_url .result_box').html("<div class=\"alert alert-success\">"+data["longurl"]+"</div>");
			} else {
				// 出错
				$('#expand_url .result_box').html("<div class=\"alert alert-error\">解析错误，请输入有效的网址</div>");
				$('#inform-body').html("<div class=\"alert alert-error\">"+data["error"]+"</div>");
			    $('#infrom_dialog').modal("show");
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
