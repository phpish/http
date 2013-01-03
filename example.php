<?php

	require 'http.php';
	use phpish\http;


	# Example 1

	$response_headers = array();
	$response_body = http\request(
		'POST https://api.github.com/gists',
		NULL,
		array(
			'description'=>'test gist',
			'public'=>true,
			'files'=>array(
				'42.txt'=>array('content'=>'The Answer to the Ultimate Question of Life, the Universe, and Everything')
			)
		),
		array('content-type'=>'application/json; charset=utf-8'),
		$response_headers,
		array(CURLOPT_USERAGENT=>'MY_APP_NAME')
	);

	print_r($response_headers);
	print_r($response_body);




	# Example 2

	$http_client = http\client('https://api.github.com', array(CURLOPT_USERAGENT=>'MY_APP_NAME'));
	$response_body = $http_client('GET /gists/public', array('page'=>1, 'per_page'=>5));

	print_r($response_body);


?>