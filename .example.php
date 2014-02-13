<?php

	require 'http.php';
	use phpish\http;

	// TODO: Example of response_headers when multiple headers of the same name are returned (e.g., Link)
	//       This is waiting on https://github.com/kennethreitz/httpbin/issues/125
	//       Use this answer http://stackoverflow.com/a/8171667


	try
	{

		echo "Example 1: Basic GET request\n";
		$response_body = http\request('GET http://httpbin.org/get');
		print_r($response_body);


		echo "\nExample 2: GET request with query string\n";
		$response_body = http\request('GET http://httpbin.org/get', array('hello'=>'world', 'foo'=>'bar'));
		print_r($response_body);


		echo "\nExample 3: Basic POST request\n";
		# By default the POST payload array is converted to application/x-www-form-urlencoded.
		$response_body = http\request('POST http://httpbin.org/post', array(), array('hello'=>'world', 'foo'=>'bar'));
		print_r($response_body);


		echo "\nExample 4: Capturing response headers\n";
		$response_body = http\request('POST http://httpbin.org/post', array(), array('hello'=>'world', 'foo'=>'bar'), $response_headers);
		print_r($response_body);
		print_r($response_headers);


		echo "\nExample 5: Passing a custom request header (Content-Type)\n";
		# The application/json content-type will automatically convert the POST payload array into a json string.
		$response_body = http\request
		(
			'POST http://httpbin.org/post',
			array(),
			array('hello'=>'world', 'foo'=>'bar'),
			$response_headers,
			array('content-type'=>'application/json; charset=utf-8')
		);
		print_r($response_body);


		echo "\nExample 6: Passing an overriden cURL opt (User-Agent)\n";
		$response_body = http\request
		(
			'POST http://httpbin.org/post',
			array(),
			array('hello'=>'world', 'foo'=>'bar'),
			$response_headers,
			array('content-type'=>'application/json; charset=utf-8'),
			array(CURLOPT_USERAGENT=>'MY_APP_NAME')
		);
		print_r($response_body);


		echo "\nExample 7: Creating an instance\n";
		# If you're making multiple HTTP calls with the same base URI / request headers / $curl_opts, do this instead:
		$http_client = http\client('http://httpbin.org', array('content-type'=>'application/json; charset=utf-8'), array(CURLOPT_USERAGENT=>'MY_APP_NAME'));
		$response_body = $http_client('POST /post', array(), array('hello'=>'world', 'foo'=>'bar'));
		print_r($response_body);


		# Raise ResponseException for Example 8
		$response_body = http\request('GET http://httpbin.org/status/500');

	}
	catch (http\Exception $e) # Catch generic exception (see below for catching specific exceptions)
	{
		echo "\nExample 8: Catch http\Exception\n";
		echo $e;
	}


	echo "\nExample 9: Catch http\ResponseException\n";
	try
	{
		$response_body = http\request('GET http://httpbin.org/status/404');

	}
	catch (http\ResponseException $e) # HTTP response status code was >= 400
	{
		echo $e;
	}


	echo "\nExample 10: Catch http\CurlException\n";
	try
	{
		$response_body = http\request('GET http://404.httpbin.org/');
	}
	catch (http\CurlException $e) # cURL error
	{
		echo $e;
	}

?>