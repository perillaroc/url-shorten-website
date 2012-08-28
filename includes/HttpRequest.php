<?php
/** HttpRequest.php 封装HTTP请求
 *	
 *	封装HTTP请求
 */
class HttpRequest
{
	protected $url;
  	protected $requestMethod;
  	protected $requestHeaders;
  	protected $postBody;
  	protected $userAgent;

 	protected $responseHttpCode;
  	protected $responseHeaders;
  	protected $responseBody;	 
	 
	/** 
	 *	构造函数
	 *  @param string $url
	 *  @param string $method
	 *  @param array $headers
	 *  @param array $postBody
	 */
	public function __construct($url, $method , $headers = array(), $postBody = NULL){
		$this->setUrl($url);
		$this->setRequestMethod($method);
		$this->setRequestHeaders($headers);
		$this->setPostBody($postBody); 
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	public function getUrl(){
		return $this->url;
	}
	
	public function setRequestMethod($method){
		$this->requestMethod = $method;
	}
	
	public function getRequestMethod(){
		return $this->requestMethod;
	}
	
	public function getRequestHeaders(){
		return $this->requestHeaders;
	}
	
	public function setRequestHeaders($headers){
		$this->requestHeaders = $headers;
	}
	
	
	public function setPostBody($postBody){
		$this->postBody = $postBody;
	}
	
	public function getPostBody(){
		return $this->postBody;
	}
	
	public function setResponseBody($responseBody){
		$this->responseBody = $responseBody;
	}
	
	public function getResponseBody(){
		return $this->responseBody;
	}
	
	public function getResponseHttpCode(){
		return $this->responseHttpCode;
	}
	
	public function setResponseHttpCode($responseHttpCode){
		$this->responseHttpCode = $responseHttpCode;
	}
	
	public function getResponseHeaders(){
		return $this->responseHeaders;
	}
	
	public function setResponseHeaders($responseHeaders){
		$this->responseHeaders = $responseHeaders;
	}
}
 
/**
 *	新浪和人人的api都没有header
 */
?>