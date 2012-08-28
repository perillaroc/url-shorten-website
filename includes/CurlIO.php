<?php
/**	CurlIO.php HTTP IO类
 *  
 *	用cURL库模拟HTTP IO类
 */
 
class IOException extends Exception{
	
}
 
class CurlIO
{
	const CONNECTION_ESTABLISHED = "HTTP/1.0 200 Connection established\r\n\r\n";
  	const FORM_URLENCODED = 'application/x-www-form-urlencoded';
	
	public function makeRequest(HttpRequest $request){
		// 初始化一个 cURL 对象
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $request->getUrl());
		switch($request->getRequestMethod()){
			case 'POST':
				curl_setopt($curl, CURLOPT_POST, 1);
			break;
		}
		if($request->getPostBody()){
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getPostBody());
		}
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  // SSL验证
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		
		$requestHeaders = $request->getRequestHeaders();
		if ($requestHeaders && is_array($requestHeaders)) {
			$parsed = array();
			foreach ($requestHeaders as $k => $v) {
				$parsed[] = "$k: $v";
			}
			curl_setopt($curl, CURLOPT_HTTPHEADER, $parsed);
		}
		
		$respData = curl_exec($curl);
		
		// TODO: 分离header和body
		
		$respHttpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$respHeaderSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$curlErrorNum = curl_errno($curl);
		$curlError = curl_error($curl);
		
		curl_close($curl);
		
		if ($curlErrorNum != CURLE_OK) {
			//$request->setResponseBody('{"error":"CURL_ERROR","errornum":'.$curlErrorNum.'}');
			throw new IOException("HTTP Error: ($respHttpCode) -- $curlError");
			// TODO: 此处应该抛出异常 IOException
		}
		else{
			// TODO: 应该处理响应的header和body
//			list($responseHeaders, $responseBody) =
//          		$this->parseHttpResponseBody($respData, $respHeaderSize);
//			$request->setResponseHttpCode($respHttpCode);
//   			$request->setResponseHeaders($responseHeaders);
//    		$request->setResponseBody($responseBody);
			$request->setResponseBody($respData);
		}
		return $request;
	}
	
	public function parseHttpResponseBody($respData, $headerSize) {
		if (stripos($respData, self::CONNECTION_ESTABLISHED) !== false) {
		  $respData = str_ireplace(self::CONNECTION_ESTABLISHED, '', $respData);
		}
	
		$responseBody = substr($respData, $headerSize);
		$responseHeaderLines = explode("\r\n", substr($respData, 0, $headerSize));
		//echo "<p>".var_dump($responseHeaderLines)."</p>";
		$responseHeaders  = array();
	
		foreach ($responseHeaderLines as $headerLine) {
		  if ($headerLine && strpos($headerLine, ':') !== false) {
			list($header, $value) = explode(': ', $headerLine, 2);
			$header = strtolower($header);
			if (isset($responseHeaders[$header])) {
			  $responseHeaders[$header] .= "\n" . $value;
			} else {
			  $responseHeaders[$header] = $value;
			}
		  }
		}
		return array($responseHeaders, $responseBody);
  	}
}
/**
 *	google api 中有异常类，在curlIO中处理HTTP响应code，抛出相应的异常
 */
 
?>