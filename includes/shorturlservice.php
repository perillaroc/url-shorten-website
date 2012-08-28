<?php
/**
 *	shortUrlService.php
 */
 
require_once("HttpRequest.php");
require_once("CurlIO.php");


interface IShortUrlService{
	
	function getShortUrl($longurl);
	
	function expandShortUrl($shorturl);
	
}

/**
 *	BaiduShortUrlService 
 *	完成
 */
class BaiduShortUrlService implements IShortUrlService{
	
	private $shortenUrl = "http://dwz.cn/create.php";
	
	private $expandUrl = "http://dwz.cn/query.php";
	
	private $io;
	
	private $lastResponse = NULL;
	
	private $serviceProvider = "baidu";
	
	public function __construct(){
		 $this->io = new CurlIO();
	}
	
	function getShortUrl($url){
		$postBody = array("url"=>$url);
		$method = "POST";
		$headers = array();
		$request = new HttpRequest($this->shortenUrl, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if($decodedResponse["status"]!=0){
			return json_encode(array("error"=>$decodedResponse["err_msg"]));
			//return '{"error":"error"}';
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$decodedResponse["tinyurl"],"longurl"=>$decodedResponse["longurl"]));
			//return $request->getResponseBody();
		}
	}
	
	function expandShortUrl($shorturl){
		$postBody = array("tinyurl"=>$shorturl);
		$method = "POST";
		$headers = array();
		$request = new HttpRequest($this->expandUrl, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if($decodedResponse["status"]!=0){
			return json_encode(array("error"=>$decodedResponse["err_msg"]));
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$shorturl,"longurl"=>$decodedResponse["longurl"]));
		}
	}
}

/**
 *	SinaShortUrlService 
 *	未完成！需要授权
 */
class SinaShortUrlService implements IShortUrlService{
	
	private $shortenUrl ='https://api.weibo.com/2/short_url/shorten.json';
	
	private $expandUrl = "https://api.weibo.com/2/short_url/expand.json";
	
	private $io;
	
	private $lastResponse = NULL;
	
	private $serviceProvider = "sina";
	
	private $appkey = "2331856475";
	
	public function __construct(){
		 $this->io = new CurlIO();
	}
	
	/**
	 *
	 */
	function getShortUrl($shorturl){
		$url_query = array("source"=>$this->appkey,"url_long"=>urlencode($shorturl));
		$url = $this->shortenUrl."?".http_build_query($url_query);
		$method = "GET";
		$headers = array();
//			'Content-type'=>'application/json',
//			'Content-Length'=>0
//			);
		$postBody = NULL;
		$request = new HttpRequest($url, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		//var_dump($decodedResponse);
		if(array_key_exists("error",$decodedResponse)){
			return json_encode(array("error"=>$decodedResponse["error"],"err_code"=>$decodedResponse["error_code"]));
			//return '{"error":"error"}';
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$decodedResponse["urls"][0]["url_short"],"longurl"=>$decodedResponse["urls"][0]["url_long"]));
			//return $request->getResponseBody();
		}
	}
	
	function expandShortUrl($url){
		
//		$method = "GET";
//		$headers = array();
//		$postBody = array();
//		$request = new HttpRequest($this->expandUrl, $method , $headers, $postBody );
//		$response = $this->io->makeRequest($request);
//		// 检查错误
//		$decodedResponse = json_decode($request->getResponseBody(),true);
//		if(array_key_exists("error",$decodedResponse)){
//			//return json_encode(array("error"=>$decodedResponse["err_msg"]));
//			return '{"error":"error"}';
//		} else {
//			// 若无错误
//			return json_encode(array("shorturl"=>$decodedResponse["url_short"],"longurl"=>$decodedResponse["url_long"]));
//		}
		return '{"error":"unfinished","err_msg":"service is not completed."}';
	}
}
/**
 *	GoogleShortUrlService
 *	谷歌短网址服务
 *	完成！
 */
class GoogleShortUrlService implements IShortUrlService{
	
	private $shortenUrl = "https://www.googleapis.com/urlshortener/v1/url"; // POST
	
	private $expandUrl = "https://www.googleapis.com/urlshortener/v1/url"; // GET
	
	private $additionParams = array("key"=>"AIzaSyB6SElUvD7iZdnL4nlbmWj0MK-cyr89a8U");
	
	private $io;
	
	private $lastResponse = NULL;
	
	private $serviceProvider = "google";
	
	public function __construct(){
		 $this->io = new CurlIO();
	}
	
	function getShortUrl($url){
		$postBody = json_encode(array_merge(array("longUrl"=>$url),$this->additionParams));
		$method = "POST";
		$headers = array(
			'Content-Type'=>'application/json',
			//'Content-Length'=>strlen($postBody)
		);
		$request = new HttpRequest($this->shortenUrl, $method , $headers, $postBody);
		$response = $this->io->makeRequest($request);
		// 检查错误
		//echo $request->getResponseBody();
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if(array_key_exists("error",$decodedResponse)){
			return json_encode(array("error"=>"error"));
			//return '{"error":"error"}';
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$decodedResponse["id"],"longurl"=>$decodedResponse["longUrl"]));
			//return $request->getResponseBody();
		}
	}
	
	function expandShortUrl($shorturl){
		//$url_query = array_merge(array("shortUrl"=>$shorturl),$this->additionParams);
		$url = $this->expandUrl."?key=".$this->additionParams["key"]."&shortUrl=".$shorturl;
		$method = "GET";
		$headers = array();
		$postBody = NULL;
		$request = new HttpRequest($url, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if(array_key_exists("error",$decodedResponse)){
			return json_encode(array("error"=>"error"));
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$decodedResponse["id"],"longurl"=>$decodedResponse["longUrl"]));
		}
	}
}

/**
 *	TencentShortUrlService
 *	腾讯短网址服务
 *	@author Windroc
 */
class TencentShortUrlService implements IShortUrlService{
	
	private $shortenUrl = "http://open.t.qq.com/api/other/url_converge"; // GET
	
	private $expandUrl = "http://dwz.cn/query.php";
	
	private $io;
	
	private $lastResponse = NULL;
	
	private $serviceProvider = "tencent";
	
	private $serviceDomain = "http://url.cn/";
	
	public function __construct(){
		 $this->io = new CurlIO();
	}
	
	function getShortUrl($longurl){
		$url = $this->shortenUrl."?"."format=json&url=".$longurl;
		$method = "GET";
		$headers = array();
		$postBody = NULL;
		
		$request = new HttpRequest($url, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if($decodedResponse["errcode"]!=0){
			return json_encode(array("error"=>$decodedResponse["msg"],"errcode"=>$decodedResponse["errcode"]));
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$this->serviceDomain.$decodedResponse["data"]["url"],"longurl"=>$longurl));
		}
	}
	
	/** 
	 *	解释短网址，需要鉴权信息，oauth或openid&openkey标准参数
	 *	http://wiki.open.t.qq.com/index.php/%E5%85%B6%E4%BB%96/%E7%9F%ADurl%E5%8F%98%E9%95%BFurl
	 */
	function expandShortUrl($shorturl){
//		$url_query = array("url"=>$shorturl); // 需要提取后缀
//		$method = "GET";
//		$headers = array();
//		$postBody = NULL;
//		$request = new HttpRequest($this->expandUrl, $method , $headers, $postBody );
//		$response = $this->io->makeRequest($request);
//		// 检查错误
//		$decodedResponse = json_decode($request->getResponseBody(),true);
//		if($decodedResponse["errcode"]!=0){
//			return json_encode(array("error"=>$decodedResponse["msg"],"errcode"=>$decodedResponse["code"]));
//		} else {
//			// 若无错误
//			return json_encode(array("shorturl"=>$shorturl,"longurl"=>$decodedResponse["longurl"]));
//		}
		return '{"error":"unfinished","err_msg":"service is not completed."}';
	}
}

/**
 *	BitlyShrotUrlService Bitly短网址服务
 */
class BitlyShortUrlService implements IShortUrlService{
	private $shortenUrl = "https://api-ssl.bitly.com/v3/shorten"; // GET
	
	private $expandUrl = "https://api-ssl.bitly.com/v3/expand"; // GET
	
	private $format = "json";
	
	private $io;
	
	private $lastResponse = NULL;
	
	private $serviceProvider = "bitly";
	
	private $serviceDomain = "http://bit.ly/";
	
	private $additionParams = array("login"=>"perillaroc","apiKey"=>"R_aedf3c85680d016a3e9f2cf6e2e71560","format"=>"json");
	
	public function __construct(){
		 $this->io = new CurlIO();
	}
	
	function getShortUrl($longurl){
		$url_query = array_merge($this->additionParams,array("longUrl"=>$longurl));
		$url = $this->shortenUrl."?".http_build_query($url_query);
		//echo $url;
		$method = "GET";
		$headers = array();
		$postBody = NULL;
		
		$request = new HttpRequest($url, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if(!isset($decodedResponse["data"]["hash"])){
			// 错误
			return json_encode(array("error"=>"error"));
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$decodedResponse["data"]["url"],"longurl"=>$longurl));
		}
	}
	
	function expandShortUrl($shorturl){
		$url_query = array_merge($this->additionParams,array("shortUrl"=>$shorturl));
		$url = $this->expandUrl."?".http_build_query($url_query);
		//echo $url;
		$method = "GET";
		$headers = array();
		$postBody = NULL;
		
		$request = new HttpRequest($url, $method , $headers, $postBody );
		$response = $this->io->makeRequest($request);
		// 检查错误
		$decodedResponse = json_decode($request->getResponseBody(),true);
		if(!isset($decodedResponse["data"]["expand"][0]["long_url"])){
			// 错误
			return json_encode(array("error"=>"error"));
		} else {
			// 若无错误
			return json_encode(array("shorturl"=>$decodedResponse["data"]["expand"][0]["short_url"],"longurl"=>$decodedResponse["data"]["expand"][0]["long_url"]));
		}
	}
}

function returnError(){
	json_encode(array('error'=>'missing param'));
}

/**
 *	getServiceClassName
 * 	从短网址推断类名
 *  @param string $url 网址
 *	@return mix 正确则返回string，错误则返回FALSE。 
 *				
 */
function getServiceClassName($url){
	$servicePattern = array("Baidu"=>"/^http\:\/\/dwz\.cn\/(.)*$/",
							"Google"=>"/^http\:\/\/goo\.gl\/(.)*$/",
							"Bitly"=>"/^http\:\/\/bit\.ly\/(.)*$/"/*,
							"Tencent"=>"/^http\:\/\/url\.cn\/(.)*$/"*/);
	foreach($servicePattern as $serviceName => $pattern){
		if(preg_match($pattern,$url)){
			return $serviceName;
		}
	}
	return FALSE;
}

/**
 *	该处的filter过滤网址需要http部分，而google的短网址可以不用前缀。
 */
if(isset($_GET['longurl']) && filter_var($_GET['longurl'],FILTER_VALIDATE_URL)){
	// 生成短网址
	$className = $_GET["service_provider"]."ShortUrlService";
	$client = new $className();
	echo $client->getShortUrl($_GET['longurl']);
} elseif(isset($_GET['shorturl']) && filter_var($_GET['shorturl'],FILTER_VALIDATE_URL)){
	// 解释短网址
	// 需要分析网址，判断输入何种短网址，则构造那个api的对象
	$className =  getServiceClassName($_GET['shorturl'])."ShortUrlService";
	if($className){
		$client = new $className();
		echo $client->expandShortUrl($_GET['shorturl']);
	} else {
		echo json_encode(array( 'error' => '不支持解析该网址'));
	}
} else {
	echo json_encode(array( 'error' => '请输入正确的网址参数'));
}

?>
