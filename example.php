<?php

	require 'http.php';
	use phpish\http;


	# Example 1: Basic GET request
	$response_body = http\request('GET http://httpbin.org/get');
	print_r($response_body);


	# Example 2: GET request with query string
	$response_body = http\request('GET http://httpbin.org/get', array('hello'=>'world', 'foo'=>'bar'));
	print_r($response_body);


	# Example 3: Basic POST request
	# By default the POST payload array is converted to application/x-www-form-urlencoded.
	$response_body = http\request('POST http://httpbin.org/post', array(), array('hello'=>'world', 'foo'=>'bar'));
	print_r($response_body);


	# Example 4: Capturing response headers
	$response_body = http\request('POST http://httpbin.org/post', array(), array('hello'=>'world', 'foo'=>'bar'), $response_headers);
	print_r($response_headers);
	print_r($response_body);


	# Example 5: Passing a custom request header
	# The application/json content-type will automatically convert the POST payload array into a json string.
	$response_body = http\request('POST http://httpbin.org/post', array(), array('hello'=>'world', 'foo'=>'bar'), $response_headers, array('content-type'=>'application/json; charset=utf-8'));
	print_r($response_body);


	# Example 6: Passing an overriden cURL opt
	$response_body = http\request('POST http://httpbin.org/post', array(), array('hello'=>'world', 'foo'=>'bar'), $response_headers, array('content-type'=>'application/json; charset=utf-8'), array(CURLOPT_USERAGENT=>'MY_APP_NAME'));
	print_r($response_body);


	# Example 7: Creating an instance
	# If you're making multiple HTTP calls with the same base URI / request headers / $curl_opts, do this instead:
	$http_client = http\client('http://httpbin.org', array('content-type'=>'application/json; charset=utf-8'), array(CURLOPT_USERAGENT=>'MY_APP_NAME'))
	$response_body = $http_client('POST /post', array(), array('hello'=>'world', 'foo'=>'bar'));
	print_r($response_body);

?>